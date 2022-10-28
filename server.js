const express = require('express');
const { message } = require('laravel-mix/src/Log');
const dotenv = require('dotenv');
const e = require('express');
const { indexOf } = require('lodash');
const app = express();
const axios = require('axios');
const server = require('http').createServer(app);
const io = require('socket.io')(server, {
    cors: { origin: "*" }
});
dotenv.config();
var users = [];
var rooms = [];
var current_turn_position = [];
var next_turn_position = [];
var carddeck = [];
var timeout = [];
var pos = [];
var turn = [];
var is_next_turn = false;
var stage = [];
var legionTemp = [];
var characters = [];
// var stage_list = ['prepare','decide','draw','play','drop','end'];
var turn_count = [];
const apiURL = process.env.API_URL;
const MAX_WAITING = 35000;

function next_turn(code){
    console.log('next');
    current_turn_position[code] = next_turn_position[code];
    turn[code] = pos[code].indexOf(next_turn_position[code]);
    console.log('current '+current_turn_position[code]);
    io.in(code).emit('next turn',current_turn_position[code]);
    turn_count[code]++;
    next_turn_position[code] = pos[code][((turn[code]+1) % pos[code].length)];
    stage[code] = 'prepare';
    next_stage(code);
}

function next_stage(code){
    switch (stage[code]) {
        case 'prepare':
            io.in(code).emit('change stage',{ position: current_turn_position[code] , stage: stage[code]});
            is_next_turn = false;
            // triggerTimeout(code,is_next_turn);
            stage[code] = 'decide';
            break;

        case 'decide':
            io.in(code).emit('change stage',{ position: current_turn_position[code] , stage: stage[code]});
            // triggerTimeout(code,is_next_turn);
            stage[code] = 'draw';
            break;

        case 'draw':
            io.in(code).emit('change stage',{ position: current_turn_position[code] , stage: stage[code]});
            // triggerTimeout(code,is_next_turn);
            stage[code] = 'play';
            break;

        case 'play':
            io.in(code).emit('change stage',{ position: current_turn_position[code] , stage: stage[code]});
            // triggerTimeout(code,is_next_turn);
            stage[code] = 'drop';
            break;

        case 'drop':
            io.in(code).emit('change stage',{ position: current_turn_position[code] , stage: stage[code]});
            // triggerTimeout(code,is_next_turn);
            stage[code] = 'end';
            break;

        case 'end':
            io.in(code).emit('change stage',{ position: current_turn_position[code] , stage: stage[code]});
            is_next_turn = true;
            // triggerTimeout(code,is_next_turn);
            stage[code] = 'prepare';
            break;
    }
    }

function triggerTimeout(code,next){
    if(next){
        timeout[code] = setTimeout(()=>{next_turn(code);},MAX_WAITING);
    }else{
        timeout[code] = setTimeout(()=>{next_stage(code);},MAX_WAITING);
    }
}

function playerDead(code,player){
    if(rooms.find(r => r.code == code)){
        let room = rooms.find(r => r.code == code);
        if(room.players.filter(p =>p.dead == false && p.leaved == false).length == 1){
            let winners = room.players.filter(p =>p.dead == false && p.leaved == false);
            winners.forEach(win => {
                io.to(win.sid).emit('you win');
            });
        }else if(player.role == 'king'){
            console.log(room.players);
            let winners = room.players.filter(p =>p.dead == false && p.leaved == false).filter(p => p.role == 'villager');
            let losers = room.players.filter(p =>p.dead == false && p.leaved == false).filter(p => p.role != 'villager');
            winners.forEach(win => {
                io.to(win.sid).emit('you win');
            });
            losers.forEach(los => {
                io.to(los.sid).emit('you lose');
            });
        }else if(room.players.filter(p =>p.dead == false && p.leaved == false).filter(p => p.role == 'villager' || p.role == 'noble').length == 0){
            let winners = room.players.filter(p =>p.dead == false && p.leaved == false).filter(p => p.role == 'king' || p.role == 'knight');
            winners.forEach(win => {
                io.to(win.sid).emit('you win');
            });
        }else{
            pos[room.code] = pos[room.code].filter(p => p != player.position);
            if(next_turn_position[room.code] == player.position){
                next_turn_position[code] = pos[code][((turn[code]+1) % pos[code].length)];
            }
            if(current_turn_position[room.code] == player.position){
                console.log('do');
                resetTimeout(room.code);
                next_turn(room.code);
            }
        }
    }
}
function resetTimeout(code){
   if(typeof timeout[code] == 'object'){
     clearTimeout(timeout[code]);
   }
}

io.on('connection', async (socket) => {
    // users.push(socket);
    // socket.on('pass turn',(data) => {
    //     if(rooms.find(r => r.code == data.code ).players.find(p => p.sid == socket.id).position == current_turn_position[data.code]){
    //         resetTimeout(data.code);
    //         next_turn(data.code);
    //         socket.to(data.code).emit('skip');
    //     }
    // })
    await socket.on('end stage',(data) => {
        if(rooms.find(r => r.code == data.code ).players.find(p => p.sid == socket.id).position == current_turn_position[data.code]){
            if(is_next_turn){
                resetTimeout(data.code);
                next_turn(data.code);
            }else{
                resetTimeout(data.code);
                next_stage(data.code);
            }
        }
    });
    await socket.on('trigger others effect',(data) => {
        let room = rooms.find(r => r.code == data.code);
        let me = room.players.find(p => p.sid == socket.id);
        let target = room.players.find(p => p.position == data.position);
        io.to(target.sid).emit('trigger special effect',{ target: me });
    });
    await socket.on('special effect end',(data) => {
        let playing = rooms.find(r => r.code == data.code).players.find(p => p.position == current_turn_position[data.code]);
        io.to(playing.sid).emit('next queue');
    });
    await socket.on('martin effect',(data) => {
        let playing = rooms.find(r => r.code == data.code).players.find(p => p.position == current_turn_position[data.code]);
        io.to(playing.sid).emit('draw num adjust',{ num: -1});
    });
    await socket.on('merguin effect',(data) => {
        let playing = rooms.find(r => r.code == data.code).players.find(p => p.position == current_turn_position[data.code]);
        io.to(playing.sid).emit('set decision result',{ card: data.card});
    });
    await socket.on('update inhand card',(data) => {
        let me = rooms.find(r => r.code == data.code).players.find(p => p.sid == socket.id);
        me.in_hand = data.hand;
        io.in(data.code).emit('update inhand',{ position: me.position, card_num: me.in_hand.length});
    });
    await socket.on('change equipment',(data) => {
        let me = rooms.find(r => r.code == data.code).players.find(p => p.sid == socket.id);
        me.in_hand = me.in_hand.filter(ih => ih.id != data.card.id);
        let card = data.card.info;
        let type = null;
        if(card.type == 'equipment'){
            if(card.equipment_type == 'weapon'){
                me.weapon = data.card
                type = 'weapon';
            }
            else if(card.equipment_type == 'armor'){
                me.armor = data.card
                type = 'armor';
            }
            else if(card.equipment_type == 'mount'){
                if(card.distance == 1){
                    me.mount1 = data.card
                    type = 'mount1';
                    socket.to(data.code).emit('increase enemy distance',{ position: me.position, distance: 1});
                }else{
                    me.mount2 = data.card
                    type = 'mount2';
                }
            }
        }
        io.in(data.code).emit('update inhand',{ position: me.position, card_num: me.in_hand.length});
        socket.to(data.code).emit('change equipment image',{ position: me.position, card: card, type: type});
    });
    await socket.on('use defense',(data) => {
        let l = legionTemp[data.code];
        let room = rooms.find(r => r.code == data.code);
        let me = room.players.find(p => p.sid == socket.id);
        let playing = rooms.find(r => r.code == data.code).players.find(p => p.position == current_turn_position[data.code]);
        let legion = false;
        if(data.canDef){
            io.to(playing.sid).emit('attack fail');
        }else{
            if(me.character.char_name == "legioncommander"){
                legion = true;
            }
            io.to(playing.sid).emit('attack success',{ legion: legion });
            socket.emit('damaged',{damage: data.damage , legion: l});
        }
        legionTemp[data.code] = false;
    });
    await socket.on('use attack', (data) => {
        legionTemp[data.code] = data.legion;
        let room = rooms.find(r => r.code == data.code);
        let me = room.players.find(p => p.sid == socket.id);
        let target = room.players.find(p => p.position == data.target);
        let extra_def = false;
        let ignore_armor = false
        if(me.character.char_name == 'roger'){
            extra_def = true;
        }
        if(me.weapon != null && me.weapon.info.item_name == 'shield_breaker'){
            ignore_armor = true;
        }
        io.to(target.sid).emit('attacked',{damage: data.damage,extra_def: extra_def,ignore_armor: ignore_armor});
    });
    await socket.on('force attack', (data) => {
        let room = rooms.find(r => r.code == data.code);
        let target = room.players.find(p => p.position == data.target);
        io.to(target.sid).emit('damaged',{damage: data.damage , legion: data.legion});
    });
    await socket.on('legion drop done', (data) => {
        let room = rooms.find(r => r.code == data.code);
        let playing = room.players.find(p => p.position == current_turn_position[data.code]);
        io.to(playing.sid).emit('legion dropped');
    });
    await socket.on('update hp', (data) => {
        let room = rooms.find(r => r.code == data.code);
        let me = room.players.find(p => p.sid == socket.id);
        me.remain_hp = data.hp
        socket.to(data.code).emit('update remain hp',{ position: me.position, hp: me.remain_hp});
        if(data.hp == 0){
            me.coma = room.players.filter(p =>p.dead == false && p.leaved == false).length-1;
            socket.emit('coma');
            room.players.filter(p =>p.dead == false && p.leaved == false && p.sid != socket.id).forEach(player => {
                io.to(player.sid).emit('rescue coma',{ position: me.position });
            })
        }
    });
    await socket.on('rescue coma', (data) => {
        let room = rooms.find(r => r.code == data.code);
        let target = room.players.find(p => p.position == data.target);
        target.remain_hp += 1;
        socket.to(data.code).emit('coma rescued',{position: target.position});
        io.in(data.code).emit('update remain hp',{ position: target.position, hp: target.remain_hp});

    });
    await socket.on('ignore coma', (data) => {
        let room = rooms.find(r => r.code == data.code);
        let target = room.players.find(p => p.position == data.target);
        target.coma -= 1;
        if(target.coma == 0){
            target.dead = true;
            io.to(target.sid).emit('you died');
            io.in(data.code).emit('player died',{position: target.position, role: target.role});
            playerDead(data.code,target);
        }
    });
    await socket.on('no hand card', (data) => {
        let room = rooms.find(r => r.code == data.code);
        let playing = room.players.find(p => p.position == current_turn_position[data.code]);
        io.to(playing.sid).emit('target no handcard');
    });

    await socket.on('steal other player card',(data) => {
        let room = rooms.find(r => r.code == data.code);
        let me = room.players.find(p => p.sid == socket.id);
        let stealedCards = [];
        data.selected.forEach(sl => {
            let target = room.players.find(p => p.uuid == sl.uuid);
            let card = [target.in_hand[sl.index]];
            stealedCards.push(card[0]);
            me.in_hand.push(card[0]);
            target.in_hand = target.in_hand.filter(c => c.id != card[0].id);
            io.to(target.sid).emit('card stolen',{ position: me.position, cards: card});
            io.in(data.code).emit('update inhand',{ position: target.position, card_num: target.in_hand.length});
        });
        socket.emit('get card from others',{cards: stealedCards});
        io.in(data.code).emit('update inhand',{ position: me.position, card_num: me.in_hand.length});
    });

    await socket.on('start game', async (data) => {
        const res_char = await axios.get(apiURL+'getCharacter');
        let nChar = res_char.data.normal;
        let lChar = res_char.data.leader;
        let room = rooms.find(r => r.code == data.code);
        if(room.players.filter(p => p.position != 0).length < 4){
            socket.emit('need more player');
        }else{
            io.in(data.code).emit('set player info',{ players: users.filter(u => u.room == data.code)});
            let players = room.players;
            const res_role = await axios.get(apiURL+'getRole',{ params: { player_num: players.length } });
            let roles = res_role.data.roles;
            let shufflerole = roles.slice(0,players.length).sort((a, b) => 0.5 - Math.random());
            pos[data.code] = [];
            players.forEach((value, i) => {
                value.role = shufflerole[i].name;
                value.extra_hp = shufflerole[i].extra_hp;
                value.weapon = null;
                value.armor = null;
                value.mount1 = null;
                value.mount2 = null;
                value.dead = false;
                pos[data.code].push(value.position) ;
            });
            pos[data.code].sort((a, b) => a - b);
            room.players.forEach(p => {
                const king = players.find(rp => rp.role == 'king');
                const me = players.find(rp => rp.sid == p.sid);
                io.to(p.sid).emit('assign roles',{king: king,me: me});
            });
            next_turn_position[data.code] = players.find(rp => rp.role == 'king').position;
            turn[data.code] = pos[data.code].indexOf(next_turn_position[data.code]);
            turn_count[data.code] = 0;
            // setTimeout(()=>{next_turn(data.code);},5000);
            room.is_started = true;
            room.is_end = false;
            const kingNormalChar = nChar[Math.floor(Math.random() * nChar.length)];
            nChar = nChar.filter(c => c != kingNormalChar);
            lChar.push(kingNormalChar);
            characters[data.code] = nChar;
            room.players.find(p => p.role == 'king').pools = lChar;
            setTimeout(()=>{
                room.players.forEach(p => {
                    if(p.role == 'king'){
                        io.to(p.sid).emit('random characters',p.pools);
                    }else{
                        io.to(p.sid).emit('waiting king select',p.pools);
                    }
                });
            },2000);
        }
    });

    await socket.on('king selected', async (data) => {
        let room = rooms.find(r => r.code == data.code);
        let me = room.players.find(p => p.sid == socket.id);
        me.character = me.pools.find(pool => pool.id == data.cid);
        me.char_selected = true;
        me.remain_hp = me.character.hp + me.extra_hp;
        me.uuid = users.find(u => u.id == me.sid).uuid;
        let char = me.pools.filter(pool => pool.id != data.cid);
        char.forEach(c => {
            characters[data.code].push(c);
        });
        io.in(data.code).emit('set player character',{position: me.position, character: me.character, remain_hp: me.remain_hp});
        socket.emit('waiting other select character');
        let nChar = characters[data.code];
        let charnum = 0;
        room.players.length == 6 ? charnum = 3 : charnum = 4;
        room.players.forEach(p => {
            if(p.role != 'king'){
                p.char_selected = false;
                let normalChar = [];
                if(nChar.find(c => c.id == 5) != null){
                    const foxia = nChar.find(c => c.id == 5);
                    normalChar.push(foxia);
                    nChar = nChar.filter(c => c != foxia);
                }else if(nChar.find(c => c.id == 24) != null){
                    const roger = nChar.find(c => c.id == 24);
                    normalChar.push(roger);
                    nChar = nChar.filter(c => c != roger);
                }else if(nChar.find(c => c.id == 18) != null){
                    const bearyl = nChar.find(c => c.id == 18);
                    normalChar.push(bearyl);
                    nChar = nChar.filter(c => c != bearyl);
                }else if(nChar.find(c => c.id == 16) != null){
                    const lucifer = nChar.find(c => c.id == 16);
                    normalChar.push(lucifer);
                    nChar = nChar.filter(c => c != lucifer);
                }else if(nChar.find(c => c.id == 26) != null){
                    const martin = nChar.find(c => c.id == 26);
                    normalChar.push(martin);
                    nChar = nChar.filter(c => c != martin);
                }
                for(let i=0; i<charnum; i++){
                    const randChar = nChar[Math.floor(Math.random() * nChar.length)];
                    normalChar.push(randChar);
                    nChar = nChar.filter(c => c != randChar);
                }
                p.pools = normalChar;
            }
        });
        setTimeout(()=>{
            room.players.forEach(p => {
                if(p.role != 'king'){
                    io.to(p.sid).emit('random characters',p.pools);
                }
            });
        },1000);
    });

    await socket.on('character selected', async (data) => {
        console.log('character selected');
        let room = rooms.find(r => r.code == data.code);
        let me = room.players.find(p => p.sid == socket.id);
        me.character = me.pools.find(pool => pool.id == data.cid);
        me.char_selected = true;
        me.remain_hp = me.character.hp + me.extra_hp;
        me.uuid = users.find(u => u.id == me.sid).uuid;
        delete me.pools;
        io.in(data.code).emit('set player character',{position: me.position, character: me.character, remain_hp: me.remain_hp});
        if(room.players.filter(p => p.leaved == false).filter(p => p.char_selected == false).length != 0){
            socket.emit('waiting other select character');
        }else{
            let carddeck = await axios.post(apiURL+'storeGameData',{ room: room , turn_count: turn_count[data.code]});
            carddeck[data.code] = carddeck;
            io.in(data.code).emit('ready to start',pos[data.code]);
            setTimeout(()=>{next_turn(data.code);},5000);
        }
    });
    await socket.on('give card to others',(data)=> {
        let room = rooms.find(r => r.code == data.code);
        let me = room.players.find(p => p.sid == socket.id);
        let target = room.players.find(p => p.uuid == data.target);
        let cards = [];
        data.cards.forEach(card => {
            let mycard = me.in_hand.find(h => h.id == card);
            cards.push(mycard);
            target.in_hand.push(mycard);
            me.in_hand = me.in_hand.filter(ih => ih.id != card);
        });
        socket.to(target.sid).emit('get card from others',{cards: cards});
        io.in(data.code).emit('update inhand',{ position: me.position, card_num: me.in_hand.length});
        io.in(data.code).emit('update inhand',{ position: target.position, card_num: target.in_hand.length});
    });
    await socket.on('scts',(data) => {
        let me = users.find(u => u.id == socket.id);
        socket.to(data.code).emit('sctc',{username: me.username, message: data.message, position: me.position});
    });
    await socket.on('disconnect', () => {
        console.log('dis');
        if(users.find(u => u.id == socket.id)){
            if(users.find(u => u.id == socket.id).room != ''){
                let room = rooms.find(r => r.players.find(p => p.sid == socket.id));
                if(room.is_started){
                    if(room.players.filter(p => p.leaved == false).length == 1){
                        resetTimeout(room.code);
                        rooms = rooms.filter(r => r.code != room.code);
                    }else{
                        let player = room.players.find(p => p.sid == socket.id);
                        player.leaved = true;
                        player.dead = true;

                        io.to(room.code).emit('player leave',player);
                        if(room.host == socket.id){
                            if(room.host == room.players[0].sid){
                                room.host = room.players[1].sid;
                            }else{
                                room.host = room.players[0].sid;
                            }
                            io.to(room.code).emit('change host',{host: room.host, players: room.players});
                        }
                        playerDead(room.code,player);
                    }
                }else{
                    room.players = room.players.filter(p => p.sid != socket.id);
                    if(room.players.length != 0){
                        if(room.host == socket.id){
                            room.host = room.players[0].sid;
                            io.to(room.code).emit('change host',{host: room.host, players: room.players});
                        }
                        if(rooms.find(r => r.code == room.code)){
                            io.to(room.code).emit('assign position',rooms.find(r => r.code == room.code).players);
                        }
                    }else{
                        rooms = rooms.filter(r => r.code != room.code);
                    }
                }
            }
        }
        users = users.filter(u => u.id != socket.id );

    //    users.splice(users.indexOf(socket),1);
    //    pos>0?pos--:pos=0;
    });
    await socket.on('start', async (data) => {
        console.log('start');
        let user = users.find(u => u.uuid == data.uuid);
        if(user != null){
            if(user.id == socket.id){
                if(user.room != ''){
                    let room = rooms.find(r => r.players.find(p => p.sid == socket.id));
                    socket.leave(room.code);
                    if(room.is_started){
                        if(room.players.filter(p => p.leaved == false).length == 1){
                            resetTimeout(room.code);
                            rooms = rooms.filter(r => r.code != room.code);
                        }else{
                            let player = room.players.find(p => p.sid == socket.id);
                            player.leaved = true;
                            player.dead = true;
                            io.to(room.code).emit('player leave',player);
                            if(room.host == socket.id){
                                if(room.host == room.players[0].sid){
                                    room.host = room.players[1].sid;
                                }else{
                                    room.host = room.players[0].sid;
                                }
                                io.to(room.code).emit('change host',{host: room.host, players: room.players});
                            }
                            playerDead(room.code,player);
                        }
                    }else{
                        room.players = room.players.filter(p => p.sid != socket.id);
                        if(room.players.length != 0){
                            if(room.host == socket.id){
                                room.host = room.players[0].sid;
                                io.to(room.code).emit('change host',{host: room.host, players: room.players});
                            }
                            io.to(room.code).emit('assign position',rooms.find(r => r.code == room.code).players);
                        }else{
                            rooms = rooms.filter(r => r.code != room.code);
                        }
                    }
                    user.room = '';
                    user.position = 0;
                }
            }else{
                socket.emit('already connect');
            }
        }else{
            let user = {
                username: data.username,
                id: socket.id,
                position: 0,
                room: '',
                uuid: data.uuid,
            };
            let ro = rooms.find(r => r.players.find(p => p.sid == socket.id) != undefined);
            if(ro != undefined){
                user.room = ro.code;
            }
            users.push(user);
        }


    });
    await socket.on('create lobby', (data) => {
        let user = users.find(u => u.id == socket.id);
        if(users.find(u => u.id == socket.id)){
            socket.join(data.code);
            const room = {
                code: data.code,
                host: socket.id,
                is_started: false,
                max: data.max_player,
                private: data.private,
                // players: [],
                players: []
            };
            // room.players.push(socket);
            room.players.push({sid: socket.id, position: 0, leaved: false});
            rooms.push(room);
            users.find(u => u.id == socket.id ).room = data.code;
            socket.emit('user checked',{is_created: true, code: data.code});
        }else{
            socket.emit('user checked',{is_created: false});
        }
    });

    await socket.on('draw card', (data) => {
        if(rooms.find(r => r.code = data.code)){
            let room = rooms.find(r => r.code == data.code);
            let me = room.players.find(p => p.sid == socket.id);
            me.in_hand = data.hand;
        }
    });


    await socket.on('join lobby', (data) => {
        if(users.find(u => u.id == socket.id)){
            if(rooms.some(r => r.code == data.code)){
                let room = rooms.find(r => r.code == data.code);
                if(room.players.length == room.max){
                    socket.emit('room full');
                }else{
                    socket.join(data.code);
                    room.players.push({sid: socket.id, position: 0, leaved: false});
                    users.find(u => u.id == socket.id ).room = data.code;
                    socket.emit('user checked',{is_created: true, code: data.code});
                    socket.emit('assign position',room.players);
                }
            }
            else{
                socket.emit('no room',{code: data.code});
            }
        }else{
            socket.emit('user checked',{is_created: false});
        }
    });
    await socket.on('leave lobby', (data) => {
        socket.leave(data.code);
        let room = rooms.find(r => r.code == data.code);
        room.players = room.players.filter(p => p.sid != socket.id);
        if(room.players.length != 0){
            if(room.host == socket.id){
                room.host = room.players[0].sid;
                io.to(room.code).emit('change host',{host: room.host, players: room.players});
            }
            io.to(room.code).emit('assign position',rooms.find(r => r.code == room.code).players);
        }else{
            rooms = rooms.filter(r => r.code != room.code);
        }
        users.find(u => u.id == socket.id ).room = '';
        users.find(u => u.id == socket.id ).position = 0;
    });

    //add front
    await socket.on('select position', (data) => {
        rooms.find(r => r.code == data.code).players.find(p => p.sid == socket.id).position=data.position;
        users.find(u => u.id == socket.id ).position = data.position;
        io.to(data.code).emit('assign position',rooms.find(r => r.code == data.code).players);
    });


    // socket.on('check room exists', (code,callback) => {
    //     if(rooms.includes(rooms.find(r => r.code == code))){
    //         callback(true);
    //     }
    //     else{
    //         callback(false);
    //     }
    // });

    await socket.on('list room', () => {
        socket.emit('set room list', rooms.filter(r => r.private == false).filter(r => r.is_started == false));
    });

    await socket.on('get room info', (data) => {
        if(users.find(u => u.id == socket.id) === undefined){
            if(rooms.includes(rooms.find(r => r.code == data.code))){
                socket.join(data.code);
                rooms.find(r => r.code == data.code).players.push({sid: socket.id, position: 0, leaved: false});
                socket.emit('assign position',rooms.find(r => r.code == data.code).players);
            }else{
                socket.join(data.code);
                const room = {
                    code: data.code,
                    host: socket.id,
                    is_started: false,
                    max: data.max_player,
                    private: data.private,
                    // players: [],
                    players: []
                };
                room.players.push({sid: socket.id, position: 0, leaved: false});
                rooms.push(room);
            }
            let rList = JSON.parse(JSON.stringify(rooms));
            let r = rList.find(room => room.code == data.code);
            if(users.find(u => u.id == pos.sid)){
                for(let pos of r.players){
                    if(pos.sid == socket.id){
                        pos.username = data.username;
                    }else{
                        pos.username = users.find(u => u.id == pos.sid).username;
                    }
                }
            }
            r.host == socket.id ? r.is_host = true : r.is_host = false;
            r.sid = socket.id;
            socket.emit('set room', r);
        }else{
            let rList = JSON.parse(JSON.stringify(rooms));
            let r = rList.find(room => room.code == data.code);
            for(let pos of r.players){
                if(users.find(u => u.id == pos.sid)){
                    pos.username = users.find(u => u.id == pos.sid).username;
                }
            }
            r.host == socket.id ? r.is_host = true : r.is_host = false;
            r.sid = socket.id;
            socket.emit('set room', r);
        }
    });
});
server.listen(3000, () => {
    console.log('Server is running');
});
