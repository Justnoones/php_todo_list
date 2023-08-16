<?php

session_start();
session_destroy();
setcookie("user_id", "", time() - 60);
header("Location: ./login.php");
