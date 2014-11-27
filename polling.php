<!DOCTYPE HTML>
<?php
$page = "polling";
// Variables nécessaires à la colorisation des écritures sur le chat
$colours = array('007AFF', 'FF7000', 'FF7000', '15E25F', 'CFC700', 'CFC700', 'CF1100', 'CF00BE', 'F00');
$user_colour = array_rand($colours);
?>
<html>
    <head>
        <?php require_once "include/pages/meta.php"; ?>
        <script src="include/js/jquery-1.10.2.min.js"></script>
        <script src="include/js/polling.js"></script>
        <title>EastChat - Polling</title>
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
                <h2 id="titre-h2">Mode : Polling</h2>
                <h3>Principe : </h3>
                <p>
                <ul>
                    <li>- Le client envoie une requête au serveur</li>
                    <li>- La page demandée exécute un script javascript qui requête le serveur à intervalles réguliers</li>
                    <li>- Le serveur traite chaque demande et envoie la réponse au client</li>
                </ul>

                <br/>

                <h3>Outils/API : </h3>
                <p>
                    Cette méthode a été réalisée grâce à l'API jQuery.
                </p>

                <br/>

                <div class="chat_wrapper">
                    <div class="message_box" id="message_box"></div>
                    <div class="panel">
                        <input type="text" name="name" id="name" placeholder="Votre nom" maxlength="10" style="width:20%"  />
                        <input type="text" name="message" id="message" placeholder="Message" maxlength="80" style="width:60%" />
                        <button id="send-btn" onclick="addMessage()">Envoyer</button>
                    </div>
                </div>
                
<script src="/socket.io/socket.io.js"></script>
<script>
  var socket = io.connect("http://localhost:9000");
  socket.on('sales', function (data) {
    //Update your dashboard gauge
    salesGauge.setValue(data.value);

    socket.emit('profit', { my: 'data' });
  });
</script>
                

            </article>
            <!-- Footer -->
            <?php require_once "include/pages/footer.php"; ?>
        </section>
    </body>
</html>
