<?php
$servername = 'mysql-yanishlali.alwaysdata.net';
$dbname = "yanishlali_mission_4";
$username = '220794';
$password = 'fX7Sb4G3e';

try {
    $sql = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
} catch (Exception $e) {
    echo 'Échec lors de la connexion : ' . $e->getMessage();
}
$sql->query('SET NAMES UTF8');
?>