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
var turn = [];
var is_next_turn = false;
var stage = [];
// var stage_list = ['prepare','decide','draw','play','drop','end'];
var turn_count = [];
const apiURL = process.env.API_URL;
const MAX_WAITING = 32000;


function next_turn(code){
    current_turn_position[code] = next_turn_position[code];
    io.in(code).emit('next turn',current_turn_position[code]);
    turn_count[code]++;
    turn[code] = ((turn[code]+1) % pos[code].length);
    next_turn_position[code] = pos[code][turn[code]];
    stage[code] = 'prepare';
    next_stage(code);
}

function next_stage(code){
    switch (stage[code]) {
        case 'prepare':
            io.in(code).emit('change stage',{ position: current_turn_position[code] , stage: stage[code]});
            is_next_turn = false;
            triggerTimeout(code,is_next_turn);
            stage[code] = 'decide';
            break;

        case 'decide':
            io.in(code).emit('change stage',{ position: current_turn_position[code] , stage: stage[code]});
            triggerTimeout(code,is_next_turn);
            stage[code] = 'draw';
            break;

        case 'draw':
            io.in(code).emit('change stage',{ position: current_turn_position[code] , stage: stage[code]});
            triggerTimeout(code,is_next_turn);
            stage[code] = 'play';
            break;

        case 'play':
            io.in(code).emit('change stage',{ position: current_turn_position[code] , stage: stage[code]});
            triggerTimeout(code,is_next_turn);
            stage[code] = 'drop';
            break;

        case 'drop':
            io.in(code).emit('change stage',{ position: current_turn_position[code] , stage: stage[code]});
            triggerTimeout(code,is_next_turn);
            stage[code] = 'end';
            break;

        case 'end':
            io.in(code).emit('change stage',{ position: current_turn_position[code] , stage: stage[code]});
            is_next_turn = true;
            triggerTimeout(code,is_next_turn);
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

function resetTimeout(code){
   if(typeof timeout[code] == 'object'){
     clearTimeout(timeout[code]);
   }
}

io.on('connection', async (socket) => {
    // users.push(socket);
    // socket.on('pass turn',(data) => {
    //     if(rooms.find(r => r.code == data.code ).positions.find(p => p.uid == socket.id).position == current_turn_position[data.code]){
    //         resetTimeout(data.code);
    //         next_turn(data.code);
    //         socket.to(data.code).emit('skip');
    //     }
    // })
    await socket.on('end stage',(data) => {
        if(rooms.find(r => r.code == data.code ).positions.find(p => p.uid == socket.id).position == current_turn_position[data.code]){
            if(is_next_turn){
                resetTimeout(data.code);
                next_turn(data.code);
                socket.to(data.code).emit('skip');
            }else{
                resetTimeout(data.code);
                next_stage(data.code);
                socket.to(data.code).emit('skip');
            }
        }
    })
    await socket.on('start game', async (data) => {
        const res_char = await axios.get(apiURL+'getCharacter');
        let nChar = res_char.data.normal;
        let lChar = res_char.data.leader;
        let room = rooms.find(r => r.code == data.code);
        // if(room.positions.filter(p => p.position != 0).length < 4){
        //     socket.emit('need more player');
        // }else{
            let room_pos = room.positions;
            const res_role = await axios.get(apiURL+'getRole',{ params: { player_num: room_pos.length } });
            let roles = res_role.data.roles;
            console.log(roles);
            let shufflerole = roles.slice(0,room_pos.length).sort((a, b) => 0.5 - Math.random());
            pos[data.code] = [];
            room_pos.forEach((value, i) => {
                value.role = shufflerole[i].name;
                value.extra_hp = shufflerole[i].extra_hp;
                pos[data.code].push(value.position) ;
            });
            pos[data.code].sort((a, b) => a - b);
            room.positions.forEach(p => {
                const king = room_pos.find(rp => rp.role == 'king');
                const me = room_pos.find(rp => rp.uid == p.uid);
                io.to(p.uid).emit('assign roles',{king: king,me: me});
            });
            next_turn_position[data.code] = room_pos.find(rp => rp.role == 'king').position;
            turn[data.code] = pos[data.code].indexOf(next_turn_position[data.code]);
            turn_count[data.code] = 0;
            // setTimeout(()=>{next_turn(data.code);},5000);
            room.is_started = true;
            const kingNormalChar = nChar[Math.floor(Math.random() * nChar.length)];
            nChar = nChar.filter(c => c != kingNormalChar);
            lChar.push(kingNormalChar);
            room.positions.forEach(p => {
                p.char_selected = false;
                if(p.role == 'king'){
                    p.pools = lChar;
                }
                else{
                    let normalChar = [];
                    for(let i=0; i<4; i++){
                        const randChar = nChar[Math.floor(Math.random() * nChar.length)];
                        normalChar.push(randChar);
                        nChar = nChar.filter(c => c != randChar);
                    }
                    p.pools = normalChar;
                }
            });
            setTimeout(()=>{
                room.positions.forEach(p => {
                    io.to(p.uid).emit('random characters',p.pools);
                });
            },5000);
        // }
    });

    await socket.on('character selected', async (data) => {
        let room = rooms.find(r => r.code == data.code);
        let me = room.positions.find(p => p.uid == socket.id);
        me.character = me.pools.find(pool => pool.id == data.cid);
        console.log(me.pools);
        console.log(me.character);
        me.char_selected = true;
        me.remain_hp = me.character.hp + me.extra_hp;
        me.uuid = users.find(u => u.id == me.uid).uuid;
        delete me.pools;
        io.in(data.code).emit('set player character',{position: me.position, character: me.character.image_name, remain_hp: me.remain_hp});
        if(room.positions.filter(p => p.char_selected == false).length != 0){
            socket.emit('waiting other select character');
        }else{
            console.log(room.positions);
            await axios.post(apiURL+'storeGameData',{ room: room , turn_count: turn_count[data.code]});
            io.in(data.code).emit('ready to start');
            setTimeout(()=>{next_turn(data.code);},5000);
        }
    });
    await socket.on('scts',(data) => {
        let me = users.find(u => u.id == socket.id);
        socket.to(data.code).emit('sctc',{username: me.username, message: data.message, position: me.position});
    });
    await socket.on('disconnect', () => {
        if(users.find(u => u.id == socket.id)){
            if(users.find(u => u.id == socket.id).room != ''){
                let room = rooms.find(r => r.positions.find(p => p.uid == socket.id));
                if(room.is_started){
                    if(room.positions.filter(p => p.leaved == false).length == 1){
                        resetTimeout(room.code);
                        rooms.pop(room);
                    }
                    let player = room.positions.find(p => p.uid == socket.id);
                    player.leaved = true;

                    io.to(room.code).emit('player leave',player);
                    if(room.host == socket.id){
                        if(room.host == room.positions[0].uid){
                            room.host = room.positions[1].uid;
                        }else{
                            room.host = room.positions[0].uid;
                        }
                        io.to(room.code).emit('change host',{host: room.host, positions: room.positions});
                    }
                    pos[room.code] = pos[room.code].filter(p => p != player.position);
                    if(turn[room.code] == pos[room.code].length){
                        turn[room.code] = 0;
                    }
                    if(next_turn_position[room.code] == player.position){
                        next_turn_position[room.code] = pos[room.code][turn[room.code]]
                    }
                }else{
                    room.positions = room.positions.filter(p => p.uid != socket.id);
                    if(room.positions.length != 0){
                        if(room.host == socket.id){
                            room.host = room.positions[0].uid;
                            io.to(room.code).emit('change host',{host: room.host, positions: room.positions});
                        }
                        io.to(room.code).emit('assign position',rooms.find(r => r.code == room.code).positions);
                    }else{
                        rooms.pop(room);
                    }
                }
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
                    let room = rooms.find(r => r.positions.find(p => p.uid == socket.id));
                    socket.leave(room.code);
                    if(room.is_started){
                        if(room.positions.filter(p => p.leaved == false).length == 1){
                            resetTimeout(room.code);
                            rooms.pop(room);
                        }
                        let player = room.positions.find(p => p.uid == socket.id);
                        player.leaved = true;
                        io.to(room.code).emit('player leave',player);
                        if(room.host == socket.id){
                            if(room.host == room.positions[0].uid){
                                room.host = room.positions[1].uid;
                            }else{
                                room.host = room.positions[0].uid;
                            }
                            io.to(room.code).emit('change host',{host: room.host, positions: room.positions});
                        }
                        pos[room.code] = pos[room.code].filter(p => p != player.position);
                        if(turn[room.code] == pos[room.code].length){
                            turn[room.code] = 0;
                        }
                        if(next_turn_position[room.code] == player.position){
                            next_turn_position[room.code] = pos[room.code][turn[room.code]];
                        }
                    }else{
                        room.positions = room.positions.filter(p => p.uid != socket.id);
                        if(room.positions.length != 0){
                            if(room.host == socket.id){
                                room.host = room.positions[0].uid;
                                io.to(room.code).emit('change host',{host: room.host, positions: room.positions});
                            }
                            io.to(room.code).emit('assign position',rooms.find(r => r.code == room.code).positions);
                        }else{
                            rooms.pop(room);
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
            let ro = rooms.find(r => r.positions.find(p => p.uid == socket.id) != undefined);
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
                positions: []
            };
            // room.players.push(socket);
            room.positions.push({uid: socket.id, position: 0, leaved: false});
            rooms.push(room);
            users.find(u => u.id == socket.id ).room = data.code;
            socket.emit('user checked',{is_created: true, code: data.code});
        }else{
            socket.emit('user checked',{is_created: false});
        }
    });

    await socket.on('draw card', (data) => {
        let room = rooms.find(r => r.code == data.code);
        let me = room.positions.find(p => p.uid == socket.id);
        me.in_hand = data.hand;
    });

    await socket.on('join lobby', (data) => {
        if(users.find(u => u.id == socket.id)){
            let room = rooms.find(r => r.code == data.code);
            if(room.positions.length == room.max){
                socket.emit('room full');
            }else{
                socket.join(data.code);
                room.positions.push({uid: socket.id, position: 0, leaved: false});
                users.find(u => u.id == socket.id ).room = data.code;
                socket.emit('user checked',{is_created: true, code: data.code});
                socket.emit('assign position',room.positions);
            }

        }else{
            socket.emit('user checked',{is_created: false});
        }
    });
    await socket.on('leave lobby', (data) => {
        socket.leave(data.code);
        let room = rooms.find(r => r.code == data.code);
        // room.players.pop(socket);
        room.positions = room.positions.filter(p => p.uid != socket.id);
        if(room.positions.length != 0){
            if(room.host == socket.id){
                room.host = room.positions[0].uid;
                io.to(room.code).emit('change host',{host: room.host, positions: room.positions});
            }
            io.to(room.code).emit('assign position',rooms.find(r => r.code == room.code).positions);
        }else{
            rooms.pop(room);
        }
        users.find(u => u.id == socket.id ).room = '';
        users.find(u => u.id == socket.id ).position = 0;
    });

    //add front
    await socket.on('select position', (data) => {
        rooms.find(r => r.code == data.code).positions.find(p => p.uid == socket.id).position=data.position;
        users.find(u => u.id == socket.id ).position = data.position;
        io.to(data.code).emit('assign position',rooms.find(r => r.code == data.code).positions);
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
        socket.emit('set room list', rooms.filter(r => r.private == false));
    });

    await socket.on('get room info', (data) => {
        if(users.find(u => u.id == socket.id) === undefined){
            if(rooms.includes(rooms.find(r => r.code == data.code))){
                socket.join(data.code);
                rooms.find(r => r.code == data.code).positions.push({uid: socket.id, position: 0, leaved: false});
                socket.emit('assign position',rooms.find(r => r.code == data.code).positions);
            }else{
                socket.join(data.code);
                const room = {
                    code: data.code,
                    host: socket.id,
                    is_started: false,
                    max: data.max_player,
                    private: data.private,
                    // players: [],
                    positions: []
                };
                room.positions.push({uid: socket.id, position: 0, leaved: false});
                rooms.push(room);
            }
            let rList = JSON.parse(JSON.stringify(rooms));
            let r = rList.find(room => room.code == data.code);
            for(let pos of r.positions){
                if(pos.uid == socket.id){
                    pos.username = data.username;
                }else{
                    pos.username = users.find(u => u.id == pos.uid).username;
                }
            }
            r.host == socket.id ? r.is_host = true : r.is_host = false;
            r.uid = socket.id;
            socket.emit('set room', r);
        }else{
            let rList = JSON.parse(JSON.stringify(rooms));
            let r = rList.find(room => room.code == data.code);
            for(let pos of r.positions){
                pos.username = users.find(u => u.id == pos.uid).username;
            }
            r.host == socket.id ? r.is_host = true : r.is_host = false;
            r.uid = socket.id;
            socket.emit('set room', r);
        }
    });
});
server.listen(3000, () => {
    console.log('Server is running');
});
