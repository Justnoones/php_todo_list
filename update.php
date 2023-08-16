<?php
require_once "./template/auth.php";
require_once "./template/db.php";
$auth = new Auth;
$db = new DB;
if ((!isset($_SESSION["user_id"]) && !strlen($_SESSION["user_id"]) <= 0) || (!isset($_COOKIE["user_id"]) && !strlen($_COOKIE["user_id"]) <= 0)) {
    header("Location: ./login.php");
    return;
}
$db->update($_POST);
