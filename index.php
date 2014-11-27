<!DOCTYPE HTML>
<?php $page = "accueil"; ?>
<html>
    <head>
        <?php require_once "include/pages/meta.php"; ?>
        <title>EastChat</title>
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
                <h2 id="titre-h2">Accueil</h2>
                <p>
                    Bienvenue sur EastChat ! Par le biais de ce site vous pourrez échanger des messages dans 3 modes différents.
                </p>
            </article>
            <!-- Footer -->
            <?php require_once "include/pages/footer.php"; ?>
        </section>
    </body>
</html>