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
var timeout = [];
var pos = [];
var banquet_pos = [];
var banquet_cards = [];
var aoe_pos = [];
var waitingComa = [];
var aoeTrickType = [];
var turn = [];
var is_next_turn = [];
var stage = [];
var legionTemp = [];
var characters = [];
// var stage_list = ['prepare','decide','draw','play','drop','end'];
var turn_count = [];
const apiURL = process.env.API_URL;
const MAX_WAITING = 35000;

function clear_code(code){
    io.in(code).socketsLeave(code);
    delete current_turn_position[code];
    delete  next_turn_position[code];
    delete  timeout[code];
    delete  pos[code];
    delete  turn[code];
    delete  is_next_turn[code];
    delete  stage[code];
    delete  legionTemp[code];
    delete  characters[code];
    delete  turn_count[code];
}

function next_turn(code){
    current_turn_position[code] = next_turn_position[code];
    turn[code] = pos[code].indexOf(next_turn_position[code]);
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
            is_next_turn[code] = false;
            // triggerTimeout(code,is_next_turn[code]);
            stage[code] = 'decide';
            break;

        case 'decide':
            io.in(code).emit('change stage',{ position: current_turn_position[code] , stage: stage[code]});
            // triggerTimeout(code,is_next_turn[code]);
            stage[code] = 'draw';
            break;

        case 'draw':
            io.in(code).emit('change stage',{ position: current_turn_position[code] , stage: stage[code]});
            // triggerTimeout(code,is_next_turn[code]);
            stage[code] = 'play';
            break;

        case 'play':
            io.in(code).emit('change stage',{ position: current_turn_position[code] , stage: stage[code]});
            // triggerTimeout(code,is_next_turn[code]);
            stage[code] = 'drop';
            break;

        case 'drop':
            io.in(code).emit('change stage',{ position: current_turn_position[code] , stage: stage[code]});
            // triggerTimeout(code,is_next_turn[code]);
            stage[code] = 'end';
            break;

        case 'end':
            io.in(code).emit('change stage',{ position: current_turn_position[code] , stage: stage[code]});
            is_next_turn[code] = true;
            // triggerTimeout(code,is_next_turn[code]);
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

async function playerDead(code,player){
    io.in(code).emit('player died',{position: player.position, role: player.role});
    if(rooms.some(r => r.code == code)){
        let room = rooms.find(r => r.code == code);
        if(room.players.filter(p =>p.leaved == false).length == 1){
            let winners = room.players.filter(p =>p.dead == false && p.leaved == false);
            winners.forEach(win => {
                io.to(win.sid).emit('you win');
            });
            let res = await axios.put(apiURL+'roomEnd',{ roomcode: code});
            io.in(code).socketsLeave(code);
            clear_code(code);
            rooms = rooms.filter(r => r.code != code);
        }else if(player.role == 'king'){
            let winners = room.players.filter(p => p.leaved == false).filter(p => p.role == 'villager');
            let losers = room.players.filter(p => p.leaved == false).filter(p => p.role != 'villager');
            winners.forEach(win => {
                io.to(win.sid).emit('you win');
            });
            losers.forEach(los => {
                io.to(los.sid).emit('you lose');
            });
            let res = await axios.put(apiURL+'roomEnd',{ roomcode: code});
            io.in(code).socketsLeave(code);
            clear_code(code);
            rooms = rooms.filter(r => r.code != code);
        }else if(room.players.filter(p =>p.dead == false).filter(p => p.role == 'villager' || p.role == 'noble').length == 0){
            let winners = room.players.filter(p =>p.leaved == false).filter(p => p.role == 'king' || p.role == 'knight');
            let losers = room.players.filter(p => p.leaved == false).filter(p => p.role == 'villager' || p.role == 'noble');
            winners.forEach(win => {
                io.to(win.sid).emit('you win');
            });
            losers.forEach(los => {
                io.to(los.sid).emit('you lose');
            });
            let res = await axios.put(apiURL+'roomEnd',{ roomcode: code});
            io.in(code).socketsLeave(code);
            clear_code(code);
            rooms = rooms.filter(r => r.code != code);
        }else if(room.players.filter(p =>p.dead == false).length == 1){
            let winners = room.players.filter(p =>p.dead == false);
            let losers = room.players.filter(p => p.dead == true);
            winners.forEach(win => {
                io.to(win.sid).emit('you win');
            });
            losers.forEach(los => {
                io.to(los.sid).emit('you lose');
            });
            let res = await axios.put(apiURL+'roomEnd',{ roomcode: code});
            io.in(code).socketsLeave(code);
            clear_code(code);
            rooms = rooms.filter(r => r.code != code);
        }else{
            pos[room.code] = pos[room.code].filter(p => p != player.position);
            if(player.in_hand){
                console.log('have in_hand');
                let ihc = [];
                player.in_hand.forEach(card => {
                    ihc.push(card.id);
                });
                let res = await axios.put(apiURL+'dropCard',{ roomcode: room.code , cards: ihc});
            }
            if(next_turn_position[room.code] == player.position){
                next_turn_position[code] = pos[code][((turn[code]+1) % pos[code].length)];
            }
            if(current_turn_position[room.code] == player.position){
                resetTimeout(room.code);
                next_turn(room.code);
            }
            if(player.char_selected == false){
                if(room.players.filter(p => p.leaved == false).filter(p => p.char_selected == false).length == 0){
                    let res = await axios.post(apiURL+'storeGameData',{ room: room , turn_count: turn_count[code]});
                    io.in(code).emit('ready to start',pos[code]);
                    setTimeout(()=>{next_turn(code);},5000);
                }
            }
        }
    }
}

async function playerLeave(room,sid){
    if(room != undefined){
        if(room.is_started){
            if(room.players.filter(p => p.leaved == false).length == 1){
                resetTimeout(room.code);
                clear_code(room.code);
                rooms = rooms.filter(r => r.code != room.code);
                let res = await axios.put(apiURL+'roomEnd',{ roomcode: room.code});
            }else{
                let player = room.players.find(p => p.sid == sid);
                player.leaved = true;
                player.dead = true;
                io.to(room.code).emit('player leave',player);
                if(room.host == sid){
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
            room.players = room.players.filter(p => p.sid != sid);
            if(room.players.length != 0){
                if(room.host == sid){
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
        if(rooms.some(r => r.code == data.code)){
            let room = rooms.find(r => r.code == data.code);
            if(room.players.some(p => p.sid == socket.id)){
                let me = room.players.find(p => p.sid == socket.id);
                if(me.position == current_turn_position[data.code]){
                    if(is_next_turn[data.code]){
                        resetTimeout(data.code);
                        next_turn(data.code);
                    }else{
                        resetTimeout(data.code);
                        next_stage(data.code);
                    }
                }
            }

        }

    });
    await socket.on('trigger others effect',(data) => {
        if(rooms.some(r => r.code == data.code)){
            let room = rooms.find(r => r.code == data.code);
            if(room.players.some(p => p.sid == socket.id) && room.players.some(p => p.position == data.position)){
            let me = room.players.find(p => p.sid == socket.id);
            let target = room.players.find(p => p.position == data.position);
            io.to(target.sid).emit('trigger special effect',{ target: me });
            }
        }
    });
    await socket.on('use steal trick',(data) => {
        if(rooms.some(r => r.code == data.code)){
            let room = rooms.find(r => r.code == data.code);
            if(room.players.some(p => p.position == data.target)){
                let target = room.players.find(p => p.position == data.target);
                socket.emit('set steal cards',{ cards: target.in_hand });
            }
        }
    });
    await socket.on('steal other card',(data) => {
        if(rooms.some(r => r.code == data.code)){
            let room = rooms.find(r => r.code == data.code);
            if(room.players.some(p => p.sid == socket.id) && room.players.some(p => p.position == data.target)){
                let me = room.players.find(p => p.sid == socket.id);
                let target = room.players.find(p => p.position == data.target);
                io.to(target.sid).emit('card stolen trick',{ position: me.position, type: data.type, card: data.card});
                if(data.type == 'hand'){
                    me.in_hand.push(target.in_hand.find(ih => ih.id == data.card.id));
                    target.in_hand = target.in_hand.filter(c => c.id != data.card.id);
                    io.in(data.code).emit('update inhand',{ position: target.position, card_num: target.in_hand.length});
                }else{
                    switch(data.type){
                        case 'weapon':
                            me.in_hand.push(target.weapon);
                            target.weapon = null;
                            break;
                        case 'armor':
                            me.in_hand.push(target.armor);
                            target.armor = null;
                            break;
                        case 'mount1':
                            me.in_hand.push(target.mount1);
                            target.mount1 = null;
                            break;
                        case 'mount2':
                            me.in_hand.push(target.mount2);
                            target.mount2 = null;
                            break;
                    }
                    io.in(data.code).emit('other drop equipment',{position: target.position, type: data.type});
                }
                socket.emit('get card from others',{cards: [data.card]});
                io.in(data.code).emit('update inhand',{ position: me.position, card_num: me.in_hand.length});
            }
        }
    });

    await socket.on('clear table',(data) => {
        io.in(data.code).emit('clear table cards',{position: data.position});
    });
    await socket.on('special effect end',(data) => {
        if(rooms.some(r => r.code == data.code) && rooms.find(r => r.code == data.code).players.some(p => p.position == current_turn_position[data.code])){
            let playing = rooms.find(r => r.code == data.code).players.find(p => p.position == current_turn_position[data.code]);
            io.to(playing.sid).emit('next queue');
        }
    });
    await socket.on('martin effect',(data) => {
        if(rooms.some(r => r.code == data.code) && rooms.find(r => r.code == data.code).players.some(p => p.position == current_turn_position[data.code])){
            let playing = rooms.find(r => r.code == data.code).players.find(p => p.position == current_turn_position[data.code]);
            io.to(playing.sid).emit('draw num adjust',{ num: -1});
        }
    });
    await socket.on('merguin effect',(data) => {
        if(rooms.some(r => r.code == data.code) && rooms.find(r => r.code == data.code).players.some(p => p.position == current_turn_position[data.code])){
            let playing = rooms.find(r => r.code == data.code).players.find(p => p.position == current_turn_position[data.code]);
            io.to(playing.sid).emit('set decision result',{ card: data.card});
        }
    });
    await socket.on('update inhand card',(data) => {
        if(rooms.some(r => r.code == data.code) && rooms.find(r => r.code == data.code).players.some(p => p.sid == socket.id)){
            let me = rooms.find(r => r.code == data.code).players.find(p => p.sid == socket.id);
            me.in_hand = data.hand;
            io.in(data.code).emit('update inhand',{ position: me.position, card_num: me.in_hand.length});
        }
    });
    await socket.on('change equipment',(data) => {
        if(rooms.some(r => r.code == data.code) && rooms.find(r => r.code == data.code).players.some(p => p.sid == socket.id)){
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
            socket.to(data.code).emit('change equipment image',{ position: me.position, card: data.card, type: type});
        }
    });
    await socket.on('use defense',(data) => {
        if(rooms.some(r => r.code == data.code)){
            let l = legionTemp[data.code];
            let room = rooms.find(r => r.code == data.code);
            if(room.players.some(p => p.sid == socket.id) && room.players.some(p => p.position == current_turn_position[data.code])){
                let me = room.players.find(p => p.sid == socket.id);
                let playing = room.players.find(p => p.position == current_turn_position[data.code]);
                let legion = false;
                if(data.canDef){
                    io.to(playing.sid).emit('attack fail');
                }else{
                    if(me.character.char_name == "legioncommander" && me.role == 'king'){
                        legion = true;
                    }
                    io.to(playing.sid).emit('attack success',{ legion: legion, target: me.position });
                    socket.emit('damaged',{damage: data.damage , legion: l});
                }
                legionTemp[data.code] = false;
            }
        }
    });
    await socket.on('use attack', (data) => {
        if(rooms.some(r => r.code == data.code)){
            legionTemp[data.code] = data.legion;
            let room = rooms.find(r => r.code == data.code);
            if(room.players.some(p => p.sid == socket.id) && room.players.some(p => p.position == data.target)){
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
            }
        }
    });
    await socket.on('force attack', (data) => {
        if(rooms.some(r => r.code == data.code) && rooms.find(r => r.code == data.code).players.some(p => p.position == data.target)){
            let target = rooms.find(r => r.code == data.code).players.find(p => p.position == data.target);
            io.to(target.sid).emit('damaged',{damage: data.damage , legion: data.legion});
        }
    });

    await socket.on('set decision card', (data) => {
            io.in(data.code).emit('add decision card',{position: data.target, card: data.card});
    });
    await socket.on('decision card done', (data) => {
        io.in(data.code).emit('remove decision card',{position: data.position, card: data.card});
    });
    await socket.on('russianroulette next', (data) => {
        io.in(data.code).emit('russianroulette pass',{position: data.position, target: next_turn_position[data.code] , card: data.card});
    });
    await socket.on('use teatime trick', (data) => {
        io.in(data.code).emit('teatime heal',{position: data.position});
    });
    await socket.on('use callcenter', (data) => {
        if(rooms.some(r => r.code == data.code) && rooms.find(r => r.code == data.code).players.some(p => p.position == data.target)){
            let target = rooms.find(r => r.code == data.code).players.find(p => p.position == data.target);
            io.to(target.sid).emit('callcenter drop',{ position: data.position });
        }
    });
    await socket.on('drop equipment', (data) => {
        io.in(data.code).emit('other drop equipment',{position: data.position, type: data.type});
    });
    await socket.on('callcenter drop done', (data) => {
        if(rooms.some(r => r.code == data.code) && rooms.find(r => r.code == data.code).players.some(p => p.position == current_turn_position[data.code])){
            let playing = rooms.find(r => r.code == data.code).players.find(p => p.position == current_turn_position[data.code]);
            io.to(playing.sid).emit('callcenter done');
        }
    });
    await socket.on('use banquet trick', async (data) => {
        if(rooms.some(r => r.code == data.code) && rooms.find(r => r.code == data.code).players.some(p => p.position == data.position)){
            let x = [];
            for (let i = 0; i < 6; i++) {
                if(data.position+i <= 6){
                    x.push(data.position+i);
                }else{
                    x.push((data.position+i)%6);
                }
            }
            banquet_pos[data.code] = [];
            x.forEach(p => {
                if(pos[data.code].includes(p)){
                    banquet_pos[data.code].push(p);
                }
            });
            let num = pos[data.code].length;
            let res = await axios.get(apiURL+'drawCard',{ params: { roomcode: data.code, num: num}});
            let cards = res.data;
            cards.forEach(c => {
                c.selected = false;
                c.owner = 0;
            });
            banquet_cards[data.code] = cards;
            io.in(data.code).emit('set banquet card',{cards: cards , position: data.position});
        }
    });
    await socket.on('banquet select', (data) => {
        if(rooms.some(r => r.code == data.code)){
            if(banquet_pos[data.code][0] == data.position){
                banquet_cards[data.code].find(c => c.id == data.cid).owner = data.position;
                banquet_pos[data.code] = banquet_pos[data.code].filter(bp => bp != data.position);
                if(banquet_pos[data.code].length > 0){
                    io.in(data.code).emit('banquet next',{position: banquet_pos[data.code][0] , selected_pos: data.position , cid: data.cid});
                }else{
                    io.in(data.code).emit('banquet done',{cards: banquet_cards[data.code]});
                    banquet_cards[data.code] = [];
                    banquet_pos[data.code] = [];
                }
            }
        }
    });

    await socket.on('legion drop done', (data) => {
        if(rooms.some(r => r.code == data.code) && rooms.find(r => r.code == data.code).players.some(p => p.position == current_turn_position[data.code])){
            let playing = rooms.find(r => r.code == data.code).players.find(p => p.position == current_turn_position[data.code]);
            io.to(playing.sid).emit('legion dropped');
        }
    });
    await socket.on('update hp', (data) => {
        if(rooms.some(r => r.code == data.code)){
            let room = rooms.find(r => r.code == data.code);
            if(room.players.some(p => p.sid == socket.id)){
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
            }
        }

    });
    await socket.on('rescue coma', (data) => {
        if(rooms.some(r => r.code == data.code) && rooms.find(r => r.code == data.code).players.some(p => p.position == data.target)){
            let target = rooms.find(r => r.code == data.code).players.find(p => p.position == data.target);
            if(target.remain_hp == 0){
                target.remain_hp += 1;
                socket.to(data.code).emit('coma rescued',{position: target.position});
                io.in(data.code).emit('update remain hp',{ position: target.position, hp: target.remain_hp});
                if(waitingComa[data.code] != undefined && waitingComa[data.code]){
                    waitingComa[data.code] = false;
                    if(aoe_pos[data.code].length > 0){
                        io.in(data.code).emit('aoe trick next',{position: aoe_pos[data.code][0],type: aoeTrickType[data.code]});
                    }else{
                        io.in(data.code).emit('aoe trick done',{type: aoeTrickType[data.code]});
                        aoe_pos[data.code] = [];
                        waitingComa[data.code] = false;
                        delete aoeTrickType[data.code];
                    }
                }
            }
        }
    });
    await socket.on('ignore coma', (data) => {
        if(rooms.some(r => r.code == data.code) && rooms.find(r => r.code == data.code).players.some(p => p.position == data.target)){
            let target = rooms.find(r => r.code == data.code).players.find(p => p.position == data.target);
            target.coma -= 1;
            if(target.coma == 0){
                target.dead = true;
                io.to(target.sid).emit('you died');
                console.log(waitingComa[data.code]);
                if(waitingComa[data.code] != undefined && waitingComa[data.code]){
                    console.log('do');
                    waitingComa[data.code] = false;
                    if(aoe_pos[data.code].length > 0){
                        io.in(data.code).emit('aoe trick next',{position: aoe_pos[data.code][0],type: aoeTrickType[data.code]});
                    }else{
                        io.in(data.code).emit('aoe trick done',{type: aoeTrickType[data.code]});
                        aoe_pos[data.code] = [];
                        waitingComa[data.code] = false;
                        delete aoeTrickType[data.code];
                    }
                }
                playerDead(data.code,target);
            }
        }
    });
    await socket.on('no hand card', (data) => {
        if(rooms.some(r => r.code == data.code) && rooms.find(r => r.code == data.code).players.some(p => p.position == current_turn_position[data.code])){
            let playing = rooms.find(r => r.code == data.code).players.find(p => p.position == current_turn_position[data.code]);
            io.to(playing.sid).emit('target no handcard');
        }
    });
    await socket.on('use aoe trick', async (data) => {
        if(rooms.some(r => r.code == data.code) && rooms.find(r => r.code == data.code).players.some(p => p.position == data.position)){
            let x = [];
            for (let i = 0; i < 6; i++) {
                if(data.position+i <= 6){
                    x.push(data.position+i);
                }else{
                    x.push((data.position+i)%6);
                }
            }
            aoe_pos[data.code] = [];
            x.forEach(p => {
                if(pos[data.code].includes(p) && p != data.position){
                    aoe_pos[data.code].push(p);
                }
            });
            io.in(data.code).emit('aoe trick next',{position: aoe_pos[data.code][0], type: data.type});
        }
    });
    await socket.on('counter aoe trick', async (data) => {
        if(data.canCounter){
            io.in(data.code).emit('other countered',{position: data.position, success: true});
            aoe_pos[data.code] = aoe_pos
            [data.code].filter(bp => bp != data.position);
            if(aoe_pos[data.code].length > 0){
                io.in(data.code).emit('aoe trick next',{position: aoe_pos[data.code][0],type: data.type});
            }else{
                io.in(data.code).emit('aoe trick done',{position: aoe_pos[data.code][0],type: data.type});
                aoe_pos[data.code] = [];
                waitingComa[data.code] = false;
                delete aoeTrickType[data.code];
            }
        }else{
            io.in(data.code).emit('other countered',{position: data.position , success: false});
            if(rooms.some(r => r.code == data.code) && rooms.find(r => r.code == data.code).players.some(p => p.position == data.position)){
                let room = rooms.find(r => r.code == data.code);
                let me = room.players.find(p => p.position == data.position);
                me.remain_hp -= 1;
                io.in(data.code).emit('update remainhp aoe',{ position: me.position, hp: me.remain_hp});
                aoe_pos[data.code] = aoe_pos[data.code].filter(ap => ap != data.position);
                if(me.remain_hp == 0){
                    me.coma = room.players.filter(p =>p.dead == false && p.leaved == false).length-1;
                    socket.emit('coma');
                    room.players.filter(p =>p.dead == false && p.leaved == false && p.sid != socket.id).forEach(player => {
                        io.to(player.sid).emit('rescue coma',{ position: me.position });
                    })
                    waitingComa[data.code] = true;
                    aoeTrickType[data.code] = data.type;
                }else{
                    if(aoe_pos[data.code].length > 0){
                        io.in(data.code).emit('aoe trick next',{position: aoe_pos[data.code][0],type: data.type});
                    }else{
                        io.in(data.code).emit('aoe trick done',{type: data.type});
                        aoe_pos[data.code] = [];
                        waitingComa[data.code] = false;
                        delete aoeTrickType[data.code];
                    }
                }
            }

        }
    });

    await socket.on('steal other player card',(data) => {
        if(rooms.some(r => r.code == data.code)){
            let room = rooms.find(r => r.code == data.code);
            if(room.players.some(p => p.sid == socket.id)){
                let me = room.players.find(p => p.sid == socket.id);
                let stealedCards = [];
                data.selected.forEach(sl => {
                    if(room.players.some(p => p.uuid == sl.uuid)){
                        let target = room.players.find(p => p.uuid == sl.uuid);
                        let card = [target.in_hand[sl.index]];
                        stealedCards.push(card[0]);
                        me.in_hand.push(card[0]);
                        target.in_hand = target.in_hand.filter(c => c.id != card[0].id);
                        io.to(target.sid).emit('card stolen',{ position: me.position, cards: card});
                        io.in(data.code).emit('update inhand',{ position: target.position, card_num: target.in_hand.length});
                    }
                });
                socket.emit('get card from others',{cards: stealedCards});
                io.in(data.code).emit('update inhand',{ position: me.position, card_num: me.in_hand.length});
            }
        }
    });

    await socket.on('start game', async (data) => {
        const res_char = await axios.get(apiURL+'getCharacter');
        let nChar = res_char.data.normal;
        let lChar = res_char.data.leader;
        let room = rooms.find(r => r.code == data.code);
        if(room.players.filter(p => p.position == 0).length > 0){
            socket.emit('player not select pos');
        }else if(room.players.filter(p => p.position != 0).length < 4){
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
                value.uuid = users.find(u => u.id == value.sid).uuid;
                pos[data.code].push(value.position) ;
            });
            pos[data.code].sort((a, b) => a - b);
            room.players.forEach(p => {
                const king = players.find(rp => rp.role == 'king');
                const me = players.find(rp => rp.sid == p.sid);
                io.to(p.sid).emit('assign roles',{king: king,me: me});
            });
            next_turn_position[data.code] = players.find(rp => rp.role == 'king').position;
            current_turn_position[room.code] = next_turn_position[data.code];
            turn[data.code] = pos[data.code].indexOf(next_turn_position[data.code]);
            turn_count[data.code] = 0;
            is_next_turn[data.code] = false;
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
        let char = me.pools.filter(pool => pool.id != data.cid);
        char.forEach(c => {
            characters[data.code].push(c);
        });
        io.in(data.code).emit('set player character',{position: me.position, character: me.character, remain_hp: me.remain_hp});
        socket.emit('waiting other select character');
        let nChar = characters[data.code];
        let charnum = 4;
        room.players.forEach(p => {
            if(p.role != 'king'){
                p.char_selected = false;
                let normalChar = [];
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
        if(rooms.some(r => r.code == data.code)){
            let room = rooms.find(r => r.code == data.code);
            if(room.players.some(p => p.sid == socket.id)){
                let me = room.players.find(p => p.sid == socket.id);
                me.character = me.pools.find(pool => pool.id == data.cid);
                me.char_selected = true;
                me.remain_hp = me.character.hp + me.extra_hp;
                delete me.pools;
                io.in(data.code).emit('set player character',{position: me.position, character: me.character, remain_hp: me.remain_hp});
                if(room.players.filter(p => p.leaved == false).filter(p => p.char_selected == false).length != 0){
                    socket.emit('waiting other select character');
                }else{
                    let res =  await axios.post(apiURL+'storeGameData',{ room: room , turn_count: turn_count[data.code]});
                    io.in(data.code).emit('ready to start',pos[data.code]);
                    setTimeout(()=>{next_turn(data.code);},5000);
                }
            }
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

        if(users.find(u => u.id == socket.id)){
            if(users.find(u => u.id == socket.id).room != ''){
                if(rooms.some(r => r.code == users.find(u => u.id == socket.id).room)){
                    let room = rooms.find(r => r.code == users.find(u => u.id == socket.id).room);
                    socket.leave(room.code);
                    playerLeave(room,socket.id);
                }

                // if(room != undefined){
                //     if(room.is_started){
                //         if(room.players.filter(p => p.leaved == false).length == 1){
                //             resetTimeout(room.code);
                //             rooms = rooms.filter(r => r.code != room.code);
                //         }else{
                //             let player = room.players.find(p => p.sid == socket.id);
                //             player.leaved = true;
                //             player.dead = true;

                //             io.to(room.code).emit('player leave',player);
                //             if(room.host == socket.id){
                //                 if(room.host == room.players[0].sid){
                //                     room.host = room.players[1].sid;
                //                 }else{
                //                     room.host = room.players[0].sid;
                //                 }
                //                 io.to(room.code).emit('change host',{host: room.host, players: room.players});
                //             }
                //             playerDead(room.code,player);
                //         }
                //     }else{
                //         room.players = room.players.filter(p => p.sid != socket.id);
                //         if(room.players.length != 0){
                //             if(room.host == socket.id){
                //                 room.host = room.players[0].sid;
                //                 io.to(room.code).emit('change host',{host: room.host, players: room.players});
                //             }
                //             if(rooms.find(r => r.code == room.code)){
                //                 io.to(room.code).emit('assign position',rooms.find(r => r.code == room.code).players);
                //             }
                //         }else{
                //             rooms = rooms.filter(r => r.code != room.code);
                //         }
                //     }
                // }
            }
        }
        users = users.filter(u => u.id != socket.id );

    //    users.splice(users.indexOf(socket),1);
    //    pos>0?pos--:pos=0;
    });
    await socket.on('start', async (data) => {

        let user = users.find(u => u.uuid == data.uuid);
        if(user != null){
            if(user.id == socket.id){
                if(user.room != ''){
                    if(rooms.some(r => r.code == user.room)){
                        let room = rooms.find(r => r.code == users.find(u => u.id == socket.id).room);
                        socket.leave(room.code);
                        playerLeave(room,socket.id);
                    }
                    // if(room.is_started){
                    //     if(room.players.filter(p => p.leaved == false).length == 1){
                    //         resetTimeout(room.code);
                    //         rooms = rooms.filter(r => r.code != room.code);
                    //     }else{
                    //         let player = room.players.find(p => p.sid == socket.id);
                    //         player.leaved = true;
                    //         player.dead = true;
                    //         io.to(room.code).emit('player leave',player);
                    //         if(room.host == socket.id){
                    //             if(room.host == room.players[0].sid){
                    //                 room.host = room.players[1].sid;
                    //             }else{
                    //                 room.host = room.players[0].sid;
                    //             }
                    //             io.to(room.code).emit('change host',{host: room.host, players: room.players});
                    //         }
                    //         playerDead(room.code,player);
                    //     }
                    // }else{
                    //     room.players = room.players.filter(p => p.sid != socket.id);
                    //     if(room.players.length != 0){
                    //         if(room.host == socket.id){
                    //             room.host = room.players[0].sid;
                    //             io.to(room.code).emit('change host',{host: room.host, players: room.players});
                    //         }
                    //         io.to(room.code).emit('assign position',rooms.find(r => r.code == room.code).players);
                    //     }else{
                    //         rooms = rooms.filter(r => r.code != room.code);
                    //     }
                    // }
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
        if(users.some(u => u.id == socket.id)){
            clear_code(data.code);
            io.in(data.code).socketsLeave(data.code);
            socket.join(data.code);
            let user = users.find(u => u.id == socket.id );
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
            room.players.push({sid: socket.id, position: 0, leaved: false, username: user.username });
            rooms.push(room);
            user.room = data.code;
            socket.emit('user checked',{is_created: true, code: data.code});
        }else{
            socket.emit('user checked',{is_created: false});
        }
    });

    await socket.on('draw card', (data) => {
        if(rooms.some(r => r.code == data.code)){
            let room = rooms.find(r => r.code == data.code);
            if(room.players.some(p => p.sid == socket.id)){
                room.players.find(p => p.sid == socket.id).in_hand = data.hand;
            }
        }
    });


    await socket.on('join lobby', (data) => {
        if(users.some(u => u.id == socket.id)){
            if(rooms.some(r => r.code == data.code)){
                let room = rooms.find(r => r.code == data.code);
                let user = users.find(u => u.id == socket.id );
                if(room.players.length == room.max){
                    socket.emit('room full');
                }else{
                    socket.join(data.code);
                    room.players.push({sid: socket.id, position: 0, leaved: false, username: user.username});
                    user.room = data.code;
                    socket.emit('user checked',{is_created: true, code: data.code});
                    socket.emit('assign position',room.players);
                    socket.to(data.code).emit('assign position',room.players);
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
        if(rooms.some(r => r.code == data.code)){
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
        }
        if(users.some(u => u.id == socket.id )){
            users.find(u => u.id == socket.id ).room = '';
            users.find(u => u.id == socket.id ).position = 0;
        }
    });

    //add front
    await socket.on('select position', (data) => {
        if(rooms.some(r => r.code == data.code)){
            let room = rooms.find(r => r.code == data.code);
            if(room.players.some(p => p.sid == socket.id) && users.some(u => u.id == socket.id )){
                room.players.find(p => p.sid == socket.id).position=data.position;
                users.find(u => u.id == socket.id ).position = data.position;
                io.to(data.code).emit('assign position',rooms.find(r => r.code == data.code).players);
            }
        }
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
            let rList = JSON.parse(JSON.stringify(rooms));
            let r = rList.find(room => room.players.some(p => p.sid == socket.id));
            for(let pl of r.players){
                if(users.some(u => u.id == pl.sid)){
                    pl.username = users.find(u => u.id == pl.sid).username;
                }
            }
            r.host == socket.id ? r.is_host = true : r.is_host = false;
            r.sid = socket.id;
            socket.emit('set room', r);
            socket.emit('assign position',r.players);
    });
});
server.listen(3000, () => {
    console.log('Server is running');
});
