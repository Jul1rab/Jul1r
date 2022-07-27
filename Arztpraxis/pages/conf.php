<?php
/*
 * Julian Rabmer, 22.06.2022
 * Verbindung zur DB rezept */
try{
    $server = 'localhost:3307';
    $db = 'arztpraxis';
    $user = 'root';
    $pwd = '';
    $con = new PDO('mysql:host='.$server.';dbname='.$db.';charset=utf8', $user, $pwd);

    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
    echo $e->getCode().': '.$e->getMessage().'<br>';
}
