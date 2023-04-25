<?php
    $sql = 'SELECT titre, date, message, membre.login as expediteur FROM messages, membre WHERE id_expediteur=membre.id AND messages.id="'.$_GET['id_message'].'"';
    ?>