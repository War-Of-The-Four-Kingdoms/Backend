const express = require('express');
const { message } = require('laravel-mix/src/Log');
const app = express();
const server = require('http').createServer(app);
const io = require('socket.io')(server, {
    cors: { origin: "*" }
});
var users = [];
var rooms = [];
var current_turn = [];
// var timeout = [];
var pos = [];
const MAX_WAITING = 5000;

function next_turn(code){
    if(typeof pos[code] == 'undefined'){
        pos[code] = 0;
    }
    if(typeof current_turn[code] == 'undefined'){
        current_turn[code] = 0;
    }
   pos[code] = current_turn[code]++ % rooms.find(r => r.code == code).positions.length;
   return rooms.find(r => r.code == code).positions.find(p => p.position == pos[code]).uid;

//    let uid = users.find(u => u.room == code && u.position == pos[code]).id;
//    let sk = rooms.find(r => r.code == code).players.find(p => p.id == uid);
//    sk.to(code).emit('otherpos',{username: users.find(u => u.room == code && u.position == pos[code]).username});
//    sk.emit('yourpos');
//    console.log("next turn triggered " , pos[code]);
//    triggerTimeout(code);
}

// function triggerTimeout(code){
//     timeout[code] = setTimeout(()=>{nextpos(code);},MAX_WAITING);
// }

// function resetTimeout(code){
//    if(typeof timeout[code] == 'object'){
//      console.log("timeout reset");
//      clearTimeout(timeout[code]);
//    }
// }

io.on('connection', (socket) => {
    // users.push(socket);
    socket.on('pass turn',(data) => {
        if(typeof pos[data.code] != 'undefined'){
            if(users.find(u => u.room == data.code && u.position == pos[data.code]).id == socket.id){
                // resetTimeout(data.code);
                socket.to(next_turn(data.code)).emit('your turn');
                }
        }
    })
    socket.on('start game', (data) => {
        current_turn[data.code] = data.pm_pos;
        pos[data.code] = 0;
        let sid = next_turn(data.code);
        console.log(sid);
        socket.to(sid).emit('your turn');
    });


    socket.on('scts',(data) => {
        socket.to(data.code).emit('sctc',{username: users.find(u => u.id == socket.id).username, message: data.message});
    });
    socket.on('disconnect', () => {
        // users = users.filter(u => u.id != socket.id );
    //     console.log('A player disconnected');
    //    users.splice(users.indexOf(socket),1);
    //    pos>0?pos--:pos=0;
    //    console.log("A number of players now ",users.length);
    });
    socket.on('start', (username) => {
        const user = {
            username: username,
            id: socket.id,
            position: 0,
            room: ''
        };
        users.push(user);
    });
    socket.on('create lobby', (data) => {
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
    });
    socket.on('join lobby', (data) => {
        socket.join(data.code);
        // rooms.find(r => r.code == data.code).players.push(socket);
        rooms.find(r => r.code == data.code).positions.push({uid: socket.id, position: 0});
        users.find(u => u.id == socket.id ).room = data.code;
    });
    socket.on('leave lobby', (data) => {
        socket.leave(data.code);
        let room = rooms.find(r => r.code == data.code);
        // room.players.pop(socket);
        room.positions.filter(p => p.uid != socket.id);
        users.find(u => u.id == socket.id ).room = '';
        users.find(u => u.id == socket.id ).position = 0;
    });

    //add front
    socket.on('select position', (data) => {
        rooms.find(r => r.code == data.code).positions.find(p => p.uid == socket.id).position=data.position;
        users.find(u => u.id == socket.id ).position = data.position;
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