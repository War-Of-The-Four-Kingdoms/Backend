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
          <div class="modal my-auto p-0" style="background-color: rgba(0, 0, 0, 0.5)"  id="usernameModal" tabindex="-1" >
            <div class="modal-dialog" style="top: 30%">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="">Username</h5>
                </div>
                <div class="modal-body p-0">
                    <input type="text" class="border-0 w-100 m-0 p-2" id="username" placeholder="enter your username here" required/>
                </div>
                <div class="modal-footer">
                  <button type="button" id="setUsername" class="btn btn-primary">Confirm</button>
                </div>
              </div>
            </div>
          </div>
        <div class="container my-5 d-flex justify-content-between">
            <div class="my-2 d-flex">
                <div class="m-2">
                    <button class="btn btn-md bg-success" id="createLobby">Create Lobby</button>
                </div>
                <div class="m-2">
                    <input type="text" id="code" placeholder="enter code" required/>
                    <button class="btn btn-md bg-info" id="joinLobby">Join Lobby</button>
                </div>
            </div>
            <div class="username_box">
                <input type="text" class="bg-white border-0 display-6 text-end" id="username_show" disabled/>
            </div>
        </div>
        <style>
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.socket.io/4.5.0/socket.io.min.js" integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k" crossorigin="anonymous"></script>

        <script>
            var user = [];
            $(function() {
                $('#usernameModal').show();
                let ip_address = '127.0.0.1';
                let socket_port = '3000';
                let socket = io(ip_address + ':' + socket_port);

                $('#setUsername').on('click', function() {
                    $('#usernameModal').hide();
                    user[username] = $('#username').val();
                    $('#username_show').val('Username: '+user[username]);
                    socket.emit('start', user[username]);
                });

                $('#createLobby').on('click', function() {
                    let code = Math.random().toString(36).slice(2,8).toUpperCase();
                    socket.emit('create lobby', code , 10);
                    window.location.href = '/lobby';
                });

                $('#joinLobby').on('click', function(e) {

                });

            });
        </script>
    </body>
</html>
