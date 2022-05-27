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
    socket.on('disconnect', () => {
        users = users.filter(u => u.id !== socket.id );
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
        const room = {
            code: data.code,
            host: socket.id,
            max: data.max_player,
            private: data.private,
            players: []
        };
        room.players.push(users.find(u => u.id === socket.id));
        rooms.push(room);
    });
    socket.on('join lobby', (data) => {
        socket.join(data.code);
        rooms.find(r => r.code === data.code).players.push(users.find(u => u.id === socket.id));
    });
    socket.on('leave lobby', (data) => {
        socket.leave(data.code);
        rooms.find(r => r.code === data.code).players.pop(users.find(u => u.id === socket.id));
    });

    socket.on('list room', () => {
        socket.emit('set room list', rooms.filter(r => r.private === false));
    });

    socket.on('get room info', () => {
        socket.emit('set room', rooms.find(room => room.players.includes(users.find(u => u.id === socket.id))));
    });
});
server.listen(3000, () => {
    console.log('Server is running');
});