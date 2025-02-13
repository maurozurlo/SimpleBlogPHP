<?php
if (!isset($_SESSION['state']) || $_SESSION["state"] == false) {
  session_start();
  session_unset();
  session_destroy();
  header('Location: /');
}
