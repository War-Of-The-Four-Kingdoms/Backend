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

    socket.on('scts',(message,code) => {
        socket.to(code).emit('sctc',{username: users.find(u => u.id === socket.id).username, message: message});
    });

    socket.on('disconnect', (socket) => {
        users = users.filter(u => u.id !== socket.io );
    });

    socket.on('start', (username) => {
        const user = {
            username,
            id: socket.id
        };
        users.push(user);
    });

    socket.on('create lobby', (code,max_player) => {
        socket.join(code);
        const room = {
            code: code,
            host: socket.id,
            max: max_player,
            players: []
        };
        room.players.push(users.find(u => u.id === socket.id));
        rooms.push(room);
        socket.emit('redirect', '/lobby');
    });

    socket.on('join lobby', (code) => {
        socket.join(code);
        rooms[code].players.push(users.find(u => u.id === socket.id));
    });

    socket.on('leave lobby', (code) => {
        socket.leave(code);
        rooms[code].players.pop(users.find(u => u.id === socket.id));
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
