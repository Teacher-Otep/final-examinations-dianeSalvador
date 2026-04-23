<?php
$host = 'localhost'; 
$db   = 'dbstudents';  //change this the name of your data base
$user = 'root';        //
$pass = '';            //
$port = '3306';        //if you used other port change this
$charset = 'utf8mb4';


$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);

} catch (\PDOException $e) {

     die("Connection failed: " . $e->getMessage());
}
?>