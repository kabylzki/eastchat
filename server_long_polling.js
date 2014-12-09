// appel d'express
var express = require('express');
// Body parser : utile pour la récupération des paramètres d'une requête
var bodyParser = require('body-parser');
// Utilisé pour afficher l'heure du message
require('console-stamp')(console, '[HH:MM:ss]');

// Notre app
var app = express();

// Utilisation du dossier /public utile pour CSS, JS et index.html (entry point)
app.use(express.static(__dirname + '/long_polling'));
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({// to support URL-encoded bodies
    extended: true
}));

// Tableau des messages
var messages = [];

// sur /poll/
// Si le mode  de la requête est post on push alors le message dans le tableau
app.post('/poll/', function (req, res) {
    
    // Récupération de l'heure du message
    var df = require('console-stamp/node_modules/dateformat');
    var time = df(new Date(), 'HH:MM:ss');
    
    if (req.body.mode === "post") {
        // un objet message avec pour id le nombre d'objets déjà présents + 1
        var obj_message = {
            id: messages.length + 1,
            name: req.body.name,
            message: req.body.message,
            color: req.body.color,
            time: time
        };
        // push l'objet dans le tableau
        messages.push(obj_message);
        res.send("ok");
        // Si le mode de la requête est poll on envoi les messages au clients
        // avec un timeout de 10 secondes
    } else if (req.body.mode === "poll") {
        setTimeout(function () {
            res.send(messages);
        }, 10000);
    }
});

// écoute du port 3000
app.listen(3000);
