<nav id="menu">
    <ul>
        <li><a href="index.php" title="Accueil" <?php if ($page == 'accueil') echo 'class="active"'?>>Accueil</a></li>
        <li><a href="push.php" title="Push" <?php if ($page == 'push') echo 'class="active"'?>>Push</a></li>
        <li><a href="polling.php" title="Polling" <?php if ($page == 'polling') echo 'class="active"'?>>Polling</a></li>
        <li><a href="long-polling.php" title="Long-Polling" <?php if ($page == 'long-polling') echo 'class="active"'?>>Long-Polling</a></li>
    </ul>
</nav>