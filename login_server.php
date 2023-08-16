<?php
require_once "./template/auth.php";
if (isset($_SESSION["user_id"]) || isset($_COOKIE["user_id"])) {
    header("Location: ./index.php");
}
$auth = new Auth;
$auth->login($_POST);