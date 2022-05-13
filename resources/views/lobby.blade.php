<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>War of Four Kingdom</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="chat-content">
                    <div class="chatline w-100">
                        <p class="text-center text-light bg-dark">Chitty Chat</p>
                        <span id="show_code"></span>
                    </div>
                </div>
                <div class="chat-section">
                    <div class="chat-box">
                        <div class="chat-input bg-white border" id="chatInput" contenteditable="" >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.socket.io/4.5.0/socket.io.min.js" integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k" crossorigin="anonymous"></script>

        <script>
            var room = [];
            $(function() {
                let ip_address = '127.0.0.1';
                let socket_port = '3000';
                let socket = io(ip_address + ':' + socket_port);
                socket.emit('get room info');

                $('#chatInput').on('keypress', function(e) {
                    let message = $(this).html();
                    if(e.which === 13 && !e.shiftKey){
                        socket.emit('scts', message);
                        $('.chatline').append('<p class="text-end text-success">'+message+'</p>');
                        chatInput.html('');

                        return false;
                    }
                });

                socket.on('sctc', (message) => {
                    $('.chatline').append('<p class="text-right text-primary">'+message+'</p>');
                });
                socket.on('redirect', url => {
                    // redirect to new URL
                    window.location = url;
                });
                socket.on('set room', (room) => {
                    room = room;
                    console.log(room);
                    $('#show_code').html(room.code)
                });

            });
        </script>
    </body>
</html>
