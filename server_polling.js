var wait = require('wait.for');
var express = require('express');
var bodyParser = require('body-parser');

var app = express();

app.use(express.static(__dirname + '/public'));
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({// to support URL-encoded bodies
    extended: true
}));

var messages = [{name: "system", message: "testing"}];

app.post('/post/', function (req, res) {
    console.log(req.body.message);
    var obj_message = {
        name: req.body.name,
        message: req.body.message
    };
    messages.push(obj_message);
    res.send(messages);
});

app.post('/poll/', function (req, res) {
    console.log(req.body.message);
    res.send(messages);
    messages = [];
});

function haltOnTimedout(req, res, next) {

}

app.listen(3000);
