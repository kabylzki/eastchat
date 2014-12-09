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
        <script src="include/js/push.js"></script>
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
                <p>
                <ul>
                    <li>- Le client envoie une requête au serveur</li>
                    <li>- Le serveur traite la demande</li>
                    <li>- Le serveur envoie la réponse au client</li>
                </ul>

                <br/>

                <h3>Outils/API : </h3>
                <p>
                    Cette méthode a été réalisée grâce aux Websocket et à l'API jQuery.
                </p>

                <br/><a href="servers/server_push.php" title="Lancer le serveur" target="_blank">Lancer le serveur</a><br/><br/>

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
    </body>
</html>