<?php
session_start();
require_once "db.php";
class Auth
{

    public function __construct()
    {
        if (isset($_COOKIE["user_id"])) {
            $_SESSION["user_id"] = $_COOKIE["user_id"];
        }
    }
    public function loggedIn()
    {
        if (isset($_COOKIE["user_id"]) || isset($_SESSION["user_id"])) {
            $status = true;
        } else {
            $status = false;
        }
        return $status;
    }

    public function login($data, $status = false)
    {
        if ($status) {
            setcookie("user_id", $data, time() + 60 * 60 * 24 * 30);
            $_SESSION["user_id"] = $data;
            header("Location: ./index.php");
            return;
        }
        $error = true;
        if (!isset($data["email"]) || strlen($data["email"]) <= 0) {
            $_SESSION["login_email_error"] = "Email Is Required.";
            $error = false;
        }

        if (strlen($data["email"]) && (isset($data["email"])) && str_contains("@", $data["email"])) {
            $_SESSION["login_email_error"] = "Email Must Contain @.";
            $error = false;
        }
        if (!isset($data["password"]) || strlen($_POST["password"]) <= 0) {
            $_SESSION["login_password_error"] = "Password Is Required.";
            $error = false;
        }
        $pdo = new DB;
        $sql = "SELECT * FROM `users` WHERE `email` = :email";
        $stmt = $pdo->db->prepare($sql);
        $stmt->execute([
            ":email" => $data["email"],
        ]);
        $user = $stmt->fetch();
        if (!$user) {
            $_SESSION["login_email_error"] = "Invalid Email.";
            $error = false;
        }
        if ($user && !password_verify($data["password"], $user["password"])) {
            $_SESSION["login_password_error"] = "Invalid Password.";
            $_SESSION["old_login_email"] = $data["email"];
            $error = false;
        }
        if (!$error) {
            header("Location: ./login.php");
            return;
        }
        if (password_verify($data["password"], $user["password"]) && $error && isset($data["remember_me"])) {
            setcookie("user_id", $user['id'], time() + 60 * 60 * 24 * 30);
            $_SESSION["user_id"] = $data['user_id'];
            header("Location: ./index.php");
            return;
        } else {
            setcookie("user_id", $user['id']);
            $_SESSION["user_id"] = $data['user_id'];
            header("Location: ./index.php");
            return;
        }
    }
}
