<?php 
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'alt_kawaii_box';

$connect = mysqli_connect($servername, $username, $password, $dbname);
if (!$connect) {
    die("ошибка подключения" . mysqli_connect_error());
}
return $connect;
?>