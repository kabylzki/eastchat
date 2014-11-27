
(function poll() {
    setTimeout(function () {
        $.ajax({
            url: "servers/server_polling.php",
            success: function (data) {
                $('#message_box').append(data.value);
                //Setup the next poll recursively
                poll();
            }, dataType: "json"});
    }, 5000);
})();


/*
(function refresh() {
    setTimeout(function () {
        $.ajax({
            url: "servers/server_polling.php",
            data: {act: 'refresh'}
        })
            .done(function () {
                refresh();
            });
    }, 5000);
})();*/

function addMessage() {
    $.ajax({
        url: "servers/server_polling.php",
        type: 'POST',
        data: {act: 'add', name: $('#name').val(), message: $('#message').val()}
    });
}
;

$(document).ready(function () {
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

    });
});