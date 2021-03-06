<!DOCTYPE HTML>
<?php
// variable pour définir la page en cours
$page = "push";
// Variables nécessaires à la colorisation des écritures sur le chat
$colours = array('007AFF', 'FF7000', 'FF7000', '15E25F', 'CFC700', 'CFC700', 'CF1100', 'CF00BE', 'F00');
$rand = rand(0, count($colours));
$user_colour = $colours[$rand];
?>
<html>
    <head>
        <?php require_once "include/pages/meta.php"; ?>        
        <script src="include/js/jquery-2.0.0.min.js"></script>
        <title>EastChat - Push</title>
    </head>
    <body>
        <!-- Conteneur du site -->
        <section id="container">
            <!-- Header -->
            <?php require_once "include/pages/header.php"; ?>
            <!-- Menu -->
            <?php require_once "include/pages/menu.php"; ?>
            <!-- Contenu de la page -->
            <article id="content" role="main">
                <h2 id="titre-h2">Mode : Push</h2>
                <h3>Principe : </h3>
                <ul>
                    <li>- Le client envoie une requête au serveur</li>
                    <li>- Le serveur traite la demande</li>
                    <li>- Le serveur envoie la réponse au client</li>
                </ul>

                <br/>

                <h3>Outils/API : </h3>
                <p>Cette méthode a été réalisée grâce aux Websocket et à l'API jQuery.</p>

                <br/><a href="server_push.php" title="Lancer le serveur" target="_blank">Lancer le serveur</a><br/><br/>

                <div class="chat_wrapper">
                    <div class="message_box" id="message_box"></div>
                    <div class="panel">
                        <input type="text" name="name" id="name" placeholder="Votre nom" maxlength="10" style="width:20%"  />
                        <input type="text" name="message" id="message" placeholder="Message" maxlength="80" style="width:68%" />
                        <input type="hidden" name="color" id="color" value="<?php echo $user_colour; ?>" />
                        <button id="send-btn">Envoyer</button>
                    </div>
                </div>
            </article>
            <!-- Footer -->
            <?php require_once "include/pages/footer.php"; ?>
        </section>

        <script>
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
        </script>
    </body>
</html>