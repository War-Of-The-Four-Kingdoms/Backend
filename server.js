const express = require('express');
const { message } = require('laravel-mix/src/Log');
const jsdom = require('jsdom');
const e = require('express');
const dom = new jsdom.JSDOM("");
const $ = require('jquery')(dom.window)
const app = express();
const server = require('http').createServer(app);
const io = require('socket.io')(server, {
    cors: { origin: "*" }
});
var users = [];
var rooms = [];
var current_turn = [];
var timeout = [];
var pos = [];
const MAX_WAITING = 7000;

// function next_turn(code){
//     if(typeof pos[code] == 'undefined'){
//         pos[code] = 0;
//     }
//     if(typeof current_turn[code] == 'undefined'){
//         current_turn[code] = 0;
//     }
//    pos[code] = current_turn[code]++ % rooms.find(r => r.code == code).positions.length;
//    return rooms.find(r => r.code == code).positions.find(p => p.position == pos[code]).uid;

// }
function next_turn(socket,code){
    if(typeof pos[code] == 'undefined'){
        pos[code] = 1;
    }
    if(typeof current_turn[code] == 'undefined'){
        current_turn[code] = 0;
    }
   pos[code] = (current_turn[code]++ % rooms.find(r => r.code == code).positions.length) + 1;
   let sid = rooms.find(r => r.code == code).positions.find(p => p.position == pos[code]).uid;
//    socket.to(code).emit('other turn',{username: users.find(u => u.room == code && u.position == pos[code]).username});
    if(socket.id == sid){
        socket.emit('your turn');
    }else{
        socket.to(sid).emit('your turn');
    }
   console.log(code , " next turn triggered " , pos[code]);
   triggerTimeout(socket,code);
}

function triggerTimeout(socket,code){
    timeout[code] = setTimeout(()=>{next_turn(socket,code);},MAX_WAITING);
}

function resetTimeout(code){
   if(typeof timeout[code] == 'object'){
     console.log("timeout reset");
     clearTimeout(timeout[code]);
   }
}

io.on('connection', (socket) => {
    // users.push(socket);
    socket.on('pass turn',(data) => {
        if(typeof pos[data.code] != 'undefined'){
            if(users.find(u => u.room == data.code && u.position == pos[data.code]).id == socket.id){
                resetTimeout(data.code);
                next_turn(socket,data.code);
                // socket.to(next_turn(data.code)).emit('your turn');
                }
        }
    })
    socket.on('start game', (data) => {
        let room_pos = rooms.find(r => r.code == data.code).positions;
        let roles = $.get('getRole',{'player_num': room_pos.length});
        let shufflerole = roles.sort((a, b) => 0.5 - Math.random());
        console.log(shufflerole);
        room_pos.forEach((value, i) => {
            value.role = shufflerole[i];
        });
        io.in(data.code).emit('assign roles',room_pos);
        current_turn[data.code] = room_pos.find(rp => rp.role == 'king').position;
        pos[data.code] = 1;
        console.log(room_pos);
        setTimeout(()=>{next_turn(socket,data.code);},5000);
        // let sid = next_turn(socket,data.code);
        // console.log(sid);
        // socket.to(sid).emit('your turn');
    });


    socket.on('scts',(data) => {
        socket.to(data.code).emit('sctc',{username: users.find(u => u.id == socket.id).username, message: data.message});
    });
    socket.on('disconnect', () => {
        if(users.find(u => u.id == socket.id)){
            if(users.find(u => u.id == socket.id).room != ''){
                console.log('do');
                let room = rooms.find(r => r.positions.find(p => p.uid == socket.id));
                console.log(room);
                room.positions = room.positions.filter(p => p.uid != socket.id);
                console.log(room);
                if(room.host == socket.id && room.positions.length != 0){
                    room.host = room.positions[0].uid;
                    io.to(room.code).emit('change host',room.host);
                }
                console.log(room);
                io.to(room.code).emit('assign position',rooms.find(r => r.code == room.code).positions);
            }
        }
        users = users.filter(u => u.id != socket.id );

    //     console.log('A player disconnected');
    //    users.splice(users.indexOf(socket),1);
    //    pos>0?pos--:pos=0;
    //    console.log("A number of players now ",users.length);
    });
    socket.on('start', (data) => {
        let user = users.find(u => u.uuid == data.uuid);
        if(user != null){
            if(user.id == socket.id){
                if(user.room != ''){
                    let room = rooms.find(r => r.positions.find(p => p.uid == socket.id));
                    socket.leave(room.code);
                    room.positions = room.positions.filter(p => p.uid != socket.id);
                    if(room.host == socket.id && room.positions.length != 0){
                        room.host = room.positions[0].uid;
                        io.to(room.code).emit('change host',room.host);
                    }
                    io.to(room.code).emit('assign position',rooms.find(r => r.code == room.code).positions);
                    user.room = '';
                    user.position = 0;
                }
            }else{
                socket.emit('already connect');
            }
        }else{
            const user = {
                username: data.username,
                id: socket.id,
                position: 0,
                room: '',
                uuid: data.uuid,
            };
            users.push(user);
        }


    });
    socket.on('create lobby', (data) => {
        let user = users.find(u => u.id == socket.id);
        if(users.find(u => u.id == socket.id)){
            socket.join(data.code);
            const room = {
                code: data.code,
                host: socket.id,
                max: data.max_player,
                // private: data.private,
                // players: [],
                positions: []
            };
            // room.players.push(socket);
            room.positions.push({uid: socket.id, position: 0});
            rooms.push(room);
            users.find(u => u.id == socket.id ).room = data.code;
            socket.emit('user checked',{is_created: true, code: data.code});
        }else{
            socket.emit('user checked',{is_created: false});
        }

    });
    socket.on('join lobby', (data) => {
        if(users.find(u => u.id == socket.id)){
            socket.join(data.code);
            rooms.find(r => r.code == data.code).positions.push({uid: socket.id, position: 0});
            users.find(u => u.id == socket.id ).room = data.code;
            socket.emit('assign position',rooms.find(r => r.code == data.code).positions);
            socket.emit('user checked',{is_created: true, code: data.code});
        }else{

            socket.emit('user checked',{is_created: false});
        }
    });
    socket.on('leave lobby', (data) => {
        socket.leave(data.code);
        let room = rooms.find(r => r.code == data.code);
        // room.players.pop(socket);
        room.positions = room.positions.filter(p => p.uid != socket.id);
        if(room.host == socket.id && room.positions.length != 0){
            room.host = room.positions[0].uid;
            io.to(room.code).emit('change host',room.host);
        }
        users.find(u => u.id == socket.id ).room = '';
        users.find(u => u.id == socket.id ).position = 0;
    });

    //add front
    socket.on('select position', (data) => {
        rooms.find(r => r.code == data.code).positions.find(p => p.uid == socket.id).position=data.position;
        users.find(u => u.id == socket.id ).position = data.position;
        io.to(data.code).emit('assign position',rooms.find(r => r.code == data.code).positions);
    });

    socket.on('check room exists', (code,callback) => {
        if(rooms.includes(rooms.find(r => r.code == code))){
            callback(true);
        }
        else{
            callback(false);
        }
    });

    socket.on('list room', () => {
        socket.emit('set room list', rooms.filter(r => r.private == false));
    });

    socket.on('get room info', () => {
        let rList = rooms.map(a => ({...a}));
        let r = rList.find(room => room.code == users.find(u => u.id == socket.id).room);
        // delete r.players;
        for(let pos of r.positions){
            pos.username = users.find(u => u.id == pos.uid).username;
        }
        r.host == socket.id ? r.is_host = true : r.is_host = false;
        r.uid = socket.id;
        socket.emit('set room', r);
    });
});
server.listen(3000, () => {
    console.log('Server is running');
});
