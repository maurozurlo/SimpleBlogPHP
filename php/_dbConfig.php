<?php
/*	DEV */
$ser = "localhost";
$user = "root";
$pass = "root";
$port = "8889";


$db = "2240214_blog";

$con = new mysqli($ser, $user, $pass, $db, $port) or die("Connection Failed");
