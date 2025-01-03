<?php
/*	DEV */
$ser = "localhost";
$user = "root";
$pass = "";
$port = "3306";


$db = "simple_blog";

$con = new mysqli($ser, $user, $pass, $db, $port) or die("Connection Failed");
