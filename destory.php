<?php
require_once "./template/auth.php";
require_once "./template/db.php";
$auth = new Auth;
$db = new DB;
if (isset($_POST["id"])) {
    $db->destory();
} else {
    header("Location: ./index.php");
}