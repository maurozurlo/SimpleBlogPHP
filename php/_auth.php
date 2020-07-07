<?php
session_start();

if (!isset($_SESSION['state']) || $_SESSION["state"] == false) {
  require "_logout.php";
}
