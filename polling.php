<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="HandheldFriendly" content="true">
        <meta name="MobileOptimized" content="320">  
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <style>
            /* Body  */
            body {
                width: 100%;
                font-family: 'Ubuntu';
                background-color: #f5fffb;
                font-size: 14px;
            }

            /* Conteneur du site */
            #container {
                width: 80%;
                margin: 10px auto;
                background-color: white;
                border: 1px solid lightgrey;

            }

            /* Header */
            #header {
                min-height: 50px;
                padding-top: 10px;
                border-bottom: 1px solid lightgrey;
            }

            #header h1 {
                margin: 0px;
                text-align: center;
                font-size: 22px;
            }

            #header h2 {
                margin: 0px;
                text-align: center;
                font-size: 14px;
                font-weight: normal;
            }

            #content {
                padding: 0px 10px;
            }

            #menu {
                text-align: center;
                padding: 0px 10px;
                margin: 10px 0px;
            }

            #menu ul li {
                display: inline;
                margin-left: 50px;
            }

            #menu ul li a {
                padding: 10px;
                display: inline-block;
                text-decoration: none;
                font-weight: bold;
                color: white;
                background-color: #b2bab7;
            }

            #menu ul li a:hover {
                color: black;
                background-color: #9da5a2;
            }

            #menu ul li a.active {
                color: black;
                background-color: #9da5a2;
            }

            /* Footer */
            #footer {
                min-height: 50px;
                line-height: 50px;
                text-align: center;
            }

            .chat_wrapper {
                margin-right: auto;
                margin-left: auto;
                background: #b2bab7;
                border: 1px solid #999999;
                padding: 10px;
                font-size: 12px;
            }
            .chat_wrapper .message_box {
                background: #FFFFFF;
                height: 150px;
                overflow: auto;
                padding: 10px;
                border: 1px solid #999999;
            }
            .chat_wrapper .panel input{
                padding: 2px 2px 2px 5px;
            }
            .system_msg{color: #BDBDBD;font-style: italic;}
            .user_name{font-weight:bold;}
            .user_message{color: #88B6E0;}


            #titre-h2 {
                font-size: 20px;
                border-bottom: 1px solid black;
                margin-bottom: 10px;
            }

            .message_box {

            }

        </style>
        <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
        <title>EastChat - Polling</title>
    </head>
    <body>
        <!-- Conteneur du site -->
        <section id="container">
            <nav id="menu">
                <ul>
                    <li><a href="polling.php" title="Polling" >Polling</a></li>
                </ul>
            </nav>
            <!-- Contenu de la page -->
            <article id="content" role="main">

                <h2 id="titre-h2">Mode : Polling</h2>
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
                    Cette méthode a été réalisée grâce aux l'API jQuery et NodeJs.
                </p>

                <div class="chat_wrapper">
                    <div class="message_box" id="message_box"></div>
                    <div class="panel">
                        <input type="text" name="name" id="name" placeholder="Votre nom" maxlength="10" style="width:20%"  />
                        <input type="text" name="message" id="message" placeholder="Message" maxlength="80" style="width:68%" />
                        <button id="send-btn">Envoyer</button>
                    </div>
                </div>
            </article>
        </section>

        <script>
            // Client code
            var counter = 0;
            var poll = function () {
                $.getJSON('/poll/' + counter, function (response) {
                    counter = response.count;
                    var elem = $('#message_box');
                    elem.text(elem.text() + response.append + "\n");
                    poll();
                });
            }
            poll();

            // Au clique sur envoyer
            $('#send-btn').click(function () {
                var mymessage = $('#message').val(); // Récupère le message
                var myname = $('#name').val(); // Récupère le nom

                $.ajax({
                    url: "/msg/" + mymessage
                }).done(function () {
                    $(this).addClass("done");
                });
            });


            setInterval(function () {
                $.ajax({
                    url: "/poll",
                }).done(function () {
                    $(this).addClass("done");
                });
            }, 10000);



        </script>    
    </body>
</html>

