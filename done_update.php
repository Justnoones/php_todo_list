<?php
require_once "./template/auth.php";
require_once "./template/db.php";
$auth = new Auth;
$db = new DB;
if (isset($_POST["id"]) && isset($_POST["check"])) {
    $db->updateDone();
} else {
    header("Location: ./index.php");
}