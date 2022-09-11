const express = require('express');

const app = express();

const server = require('http').createServer(app);

const username = "sharkthovenzart"

console.log("Welcome to service " + username + " !");

server.listen(3030, () => {
    console.log('Server is running');
});