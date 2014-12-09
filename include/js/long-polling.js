var http = require('http'),
    url = require('url'),
    fs = require('fs');

var messages = ["testing"];
var clients = [];

http.createServer(function (req, res) {
   res.end("Hello world");
}).listen(8080, 'localhost');
console.log('Server running.');