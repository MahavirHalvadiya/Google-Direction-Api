var socket = require('socket.io', {
  allowEIO3: true // false by default
});
var express = require('express');
var app = module.exports = express();
var https = require('https');
var fs = require('fs');
var server = https.createServer({
  key: fs.readFileSync('Your .pem File'),

  cert: fs.readFileSync('Your .crt File'),

  ca: fs.readFileSync('Your .ca-bundle File')
}, app);


var io = socket.listen(server);
var port = process.env.PORT || 5000;

server.listen(port, function () {
  console.log('Server listening at port %d', port);
});


io.on('connection', function (socket) {

  socket.on('track_live_location', function (data) {
    console.log(data);
    io.sockets.emit('track_live_location', {
      order_id: data.order_id,
      lat: data.lat,
      lon: data.lon
    });
  });

});