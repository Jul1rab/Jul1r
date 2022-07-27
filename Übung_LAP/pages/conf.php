<?php
/*
 * Julian Rabmer, 18.05.2022
 * Verbindung zur DB immobilien */
try{
    $server = 'localhost:3307';
    $db = 'immobilien';
    $user = 'root';
    $pwd = '';
    $con = new PDO('mysql:host='.$server.';dbname='.$db.';charset=utf8', $user, $pwd);

    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
    echo $e->getCode().': '.$e->getMessage().'<br>';
}
