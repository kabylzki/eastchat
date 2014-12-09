// appel d'express
var express = require('express');
// Body parser : utile pour la récupération des paramètres d'une requête
var bodyParser = require('body-parser');
// Utilisé pour afficher l'heure du message
require('console-stamp')(console, '[HH:MM:ss]');

// Notre app
var app = express();

// Utilisation du dossier /public utile pour CSS, JS et index.html (entry point)
app.use(express.static(__dirname + '/polling'));
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({// to support URL-encoded bodies
    extended: true
}));

// Tableau des messages
var messages = [];

// sur /post/ On rempli le tableau des messages
app.post('/post/', function (req, res) {
    
    // Récupération de l'heure du message
    var df = require('console-stamp/node_modules/dateformat');
    var time = df(new Date(), 'HH:MM:ss');
    
    // un objet message avec pour id le nombre d'objets déjà présents + 1
    var obj_message = {
        id: messages.length + 1,
        name: req.body.name,
        message: req.body.message,
        color: req.body.color,
        time: time
    };
    // pushl'objet dans le tableau
    messages.push(obj_message);
    // Retourne le tableau
    res.send(messages);
});

// sur /poll/
// Si last_id est égale à l'id du dernier message du tableau "nothing to pull"
// Si non on renvoi le tableau des messages
app.post('/poll/', function (req, res) {
    if (req.body.last_id == messages.length ) {
        res.send("nothing to pull");
    } else {
        res.send(messages);
    }
});

// écoute du port 3000
app.listen(3000);
