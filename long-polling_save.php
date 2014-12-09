<!DOCTYPE HTML>
<?php $page = "long-polling"; ?>
<html>
    <head>
        <?php require_once "include/pages/meta.php"; ?>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <title>EastChat - Long-Polling</title>
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
                <h2 id="titre-h2">Mode : Long-Polling</h2>
                <h3>Principe : </h3>
                <p>
                <ul>
                    <li>- Le client envoie une requête au serveur</li>
                    <li>- La page demandée exécute un script Javascript qui requête le serveur</li>
                    <li>- Le serveur ne répond pas immédiatement mais attend que une nouvelle information soit disponible</li>
                    <li>- Quand la nouvelle information est disponible, le serveur répond</li>
                    <li>- Le client reçoit l'information et fait une nouvelle demande au serveur renouvelant le processus</li>
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
                        <button id="send-btn">Envoyer</button>
                    </div>
                </div>

            </article>
            <!-- Footer -->
            <?php require_once "include/pages/footer.php"; ?>
        </section>


        <script type="text/javascript" charset="utf-8">
            function addmsg(type, msg) {
                console.log(msg);
                $("#message_box").append(
                        "<div><span class='user_name' style='color:black'>" + +" : </span>" +
                        "<span class='user_message " + type + "'>" + msg + "</span><div>"
                        );
            }

            // Au clique sur envoyer
            $('#send-btn').click(function () {
                sendMessage();
            });


            function waitForMsg() {

                /* This requests the url "msgsrv.php"
                 When it complete (or errors)*/
                $.ajax({
                    type: "POST",
                    url: "msgsrv.php",
                    timeout: 50000, /* Timeout in ms */
                    success: function (data) {
                        $("#message_box").append(data);
                        setTimeout(
                                waitForMsg, /* Request next message */
                                1000 /* ..after 1 seconds */
                                );
                    }
                });
            }
            ;
            function sendMessage() {
                /* This requests the url "msgsrv.php"
                 When it complete (or errors)*/
                $.ajax({
                    type: "POST",
                    url: "message.php",
                    data: {
                        myname: $("#name").val(),
                        mymessage: $("#message").val()
                    },
                });
            }
            ;

            $(document).ready(function () {
                waitForMsg(); /* Start the inital request */
            });


// Client code
var counter = 0;
var poll = function() {
  $.getJSON('/poll/'+counter, function(response) {
     counter = response.count;
     var elem = $('#output');
     elem.text(elem.text() + response.append);
     poll();
  });
}
poll();

        </script>    
    </body>
</html>

