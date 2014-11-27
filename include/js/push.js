$(document).ready(function () {
    //create a new WebSocket object.
    var wsUri = "ws://localhost:9000/push/server.php";
    websocket = new WebSocket(wsUri);

    websocket.onopen = function (ev) { // A l'ouverture de la connexion
        $('#message_box').append("<div class=\"system_msg\">Connecté!</div>"); // Notification
    }

    // Récupère l'évènement appuie sur ENTER
    $('#message').keypress(function (e) {
        if (e.keyCode == 13) {
            $("#send-btn").click();
        }
    });

    // Au clique sur envoyer
    $('#send-btn').click(function () {
        var mymessage = $('#message').val(); // Récupère le message
        var myname = $('#name').val(); // Récupère le nom

        if (myname == "") { // Si Nom vide
            alert("Veuillez saisir un Nom");
            return;
        }
        if (mymessage == "") { // Si message vide
            alert("Veuillez entrer un message");
            return;
        }

        // Préparation des données en JSON
        var msg = {
            message: mymessage,
            name: myname,
            color: $('#color').val()
        };
        // Convert
        websocket.send(JSON.stringify(msg));
    });

    // A la reception d'un message
    websocket.onmessage = function (ev) {
        var msg = JSON.parse(ev.data); // Envoi des données JSON
        var type = msg.type; // Type du message
        var umsg = msg.message; // Texte du message
        var uname = msg.name; // Nom de l'utilisateur
        var ucolor = msg.color; // Couleur du message

        // Type de message : Utilisateur
        if (type == 'usermsg')
        {
            $('#message_box').append("<div><span class=\"user_name\" style=\"color:#" + ucolor + "\">" + uname + "</span> : <span class=\"user_message\">" + umsg + "</span></div>");
        }
        if (type == 'system') {
            $('#message_box').append("<div class=\"system_msg\">" + umsg + "</div>");
        }

        $('#message').val(''); // Vide le champ message
    };

    // Gestion des erreurs
    websocket.onerror = function (ev) {
        $('#message_box').append("<div class=\"system_error\">Erreur - " + ev.data + " - Le serveur est-il lancé ?</div>");
    };
    // A la fermeture
    websocket.onclose = function (ev) {
        $('#message_box').append("<div class=\"system_msg\">Connection Closed</div>");
    };
});