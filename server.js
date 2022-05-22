const express = require('express');
const { message } = require('laravel-mix/src/Log');

const app = express();

const server = require('http').createServer(app);

const io = require('socket.io')(server, {
    cors: { origin: "*" }
});

let users = [];
let rooms = [];
io.on('connection', (socket) => {

    socket.on('scts',(data) => {
        console.log(data);
        socket.to(data.code).emit('sctc',{username: users.find(u => u.id === socket.id).username, message: data.message});
    });

    socket.on('disconnect', (socket) => {
        users = users.filter(u => u.id !== socket.io );
    });

    socket.on('start', (username) => {
        const user = {
            username: username,
            id: socket.id
        };
        users.push(user);
    });

    socket.on('create lobby', (data) => {
        socket.join(data.code);
        console.log(socket.id);
        const room = {
            code: data.code,
            host: socket.id,
            max: data.max_player,
            players: []
        };
        room.players.push(users.find(u => u.id === socket.id));
        rooms.push(room);
    });

    socket.on('join lobby', (data) => {
        socket.join(data.code);
        console.log(data.code);
        console.log(rooms);
        console.log(rooms.find(r => r.code == data.code));
        rooms.find(r => r.code === data.code).players.push(users.find(u => u.id === socket.id));
    });

    socket.on('leave lobby', (code) => {
        socket.leave(code);
        rooms.find(r => r.code === code).players.pop(users.find(u => u.id === socket.id));
    });

    socket.on('get room info', () => {
        console.log(socket.id);
        console.log(users);
        socket.emit('set room', rooms.find(room => room.players.includes(users.find(u => u.id === socket.id))));
    });
});


server.listen(3000, () => {
    console.log('Server is running');
});
