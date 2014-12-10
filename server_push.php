<?php

$host = 'localhost'; // Hôte
$port = '9000'; // Port utilisé
$null = NULL; // Variable null
// Création de la socket TCP/IP
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
// Option : Port réutilisable
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
// Bind la socket au host
socket_bind($socket, 0, $port);
// Ecoute du port
socket_listen($socket);

// Créer et ajoute une socket d'écoute
$clients = array($socket);

// Boucle (indéfiniment)
while (true) {
    // Gestion des connexions multiples
    $changed = $clients;
    // Récupère les ressources de la socket dans le tableau $changed
    socket_select($changed, $null, $null, 0, 10);

    // Vérifie si il y a une nouvelle socket
    if (in_array($socket, $changed)) {
        $socket_new = socket_accept($socket); // Accepte la socket
        $clients[] = $socket_new; // Ajoute la socket à la liste

        $header = socket_read($socket_new, 1024); // Lecture des données envoyées par la socket
        perform_handshaking($header, $socket_new, $host, $port); // Handshake

        socket_getpeername($socket_new, $ip); // Récupère l'ip de la socket connectée
        // Prépare les données qui seront envoyées au client (implique un encodage) message system
        $response = mask(json_encode(array('type' => 'system', 'message' => $ip . ' est connecté')));
        send_message($response); // Notification à tous les utilisateurs de la nouvelle connexion
        // Supprime la socket traitée
        $found_socket = array_search($socket, $changed);
        unset($changed[$found_socket]);
    }

    // Boucle sur toutes les sockets
    foreach ($changed as $changed_socket) {

        // Vérifie si il y a des données entrantes
        while (socket_recv($changed_socket, $buf, 1024, 0) >= 1) {
            $received_text = unmask($buf); // Décode les données
            $tst_msg = json_decode($received_text); // Décode le JSON
            $user_name = $tst_msg->name; // Nom de l'utilisateur
            $user_message = $tst_msg->message; // Message de l'utilisateur
            $user_color = $tst_msg->color; // Une couleur
            // Prépare les données qui seront envoyées au client (implique un encodage) message utilisateur
            $response_text = mask(json_encode(array('type' => 'usermsg', 'name' => $user_name, 'message' => $user_message, 'color' => $user_color)));
            send_message($response_text); // Envoi
            break 2; // Sort de la boucle
        }

        $buf = @socket_read($changed_socket, 1024, PHP_NORMAL_READ);
        if ($buf === false) { // Vérifie les clients déconnectés
            // remove client for $clients array
            $found_socket = array_search($changed_socket, $clients);
            socket_getpeername($changed_socket, $ip);
            unset($clients[$found_socket]);

            // Notification aux utilisateurs de la déconnexion
            $response = mask(json_encode(array('type' => 'system', 'message' => $ip . ' disconnected')));
            send_message($response);
        }
    }
}
// Ferme la socket d'écoute
socket_close($sock);

// Envoi un message à tous les clients connectés
function send_message($msg) {
    global $clients;
    foreach ($clients as $changed_socket) {
        @socket_write($changed_socket, $msg, strlen($msg));
    }
    return true;
}

// Décode les messages encadrés entrants 
// http://tools.ietf.org/html/rfc6455#section-5.2
function unmask($text) {
    $length = ord($text[1]) & 127;
    if ($length == 126) {
        $masks = substr($text, 4, 4);
        $data = substr($text, 8);
    } elseif ($length == 127) {
        $masks = substr($text, 10, 4);
        $data = substr($text, 14);
    } else {
        $masks = substr($text, 2, 4);
        $data = substr($text, 6);
    }
    $text = "";
    for ($i = 0; $i < strlen($data); ++$i) {
        $text .= $data[$i] ^ $masks[$i % 4];
    }
    return $text;
}

// Encode le message pour le transfert au client
function mask($text) {
    $b1 = 0x80 | (0x1 & 0x0f);
    $length = strlen($text);

    if ($length <= 125)
        $header = pack('CC', $b1, $length);
    elseif ($length > 125 && $length < 65536)
        $header = pack('CCn', $b1, 126, $length);
    elseif ($length >= 65536)
        $header = pack('CCNN', $b1, 127, $length);
    return $header . $text;
}

// Handshake un nouveau client
// Le client (navigateur) envoi ses headers HTTP
function perform_handshaking($receved_header, $client_conn, $host, $port) {
    $headers = array();
    $lines = preg_split("/\r\n/", $receved_header);
    foreach ($lines as $line) {
        $line = chop($line);
        if (preg_match('/\A(\S+): (.*)\z/', $line, $matches)) {
            $headers[$matches[1]] = $matches[2];
        }
    }

    $secKey = $headers['Sec-WebSocket-Key'];
    $secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
    // Handshake les headers
    $upgrade = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
            "Upgrade: websocket\r\n" .
            "Connection: Upgrade\r\n" .
            "WebSocket-Origin: $host\r\n" .
            "WebSocket-Location: ws://$host:$port/push/shout.php\r\n" .
            "Sec-WebSocket-Accept:$secAccept\r\n\r\n";
    socket_write($client_conn, $upgrade, strlen($upgrade));
}
