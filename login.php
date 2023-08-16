<?php
require_once "./template/auth.php";
require_once "./template/view.php";
$template = new Template;
$auth = new Auth;
if (isset($_SESSION["user_id"]) || isset($_COOKIE["user_id"])) {
    header("Location: ./index.php");
}
$template->header('Login', ['e9.css', "custom_error2.css"]);
?>

<!-- banner -->
<div class="d-lg-flex d-block">

    <div class="col-lg-6 patent d-none d-lg-block">
        <h1 class="child-1 h2 text-light"><i class="me-2 fas fa-hockey-puck"></i>Lorem Ipsum</h1>
        <h2 class="child-2 h1 text-light fw-bold">Welcome!</h2>
        <h3 class="child-3 h4 text-light">To Our Website</h3>
        <h3 class="child-4 h5 text-light">Lorem Ipsum is simply dummy text of the printing and typesetting industry.
        </h3>
        <div class="child-5 my-3 row w-50 mx-auto">
            <a href="#" class="col"><i class="fab fa-facebook text-white"></i></a>
            <a href="#" class="col"><i class="fab fa-facebook-messenger text-white"></i></a>
            <a href="#" class="col"><i class="fab fa-twitter text-white"></i></a>
            <a href="#" class="col"><i class="fab fa-instagram text-white"></i></a>
            <a href="#" class="col"><i class="fab fa-github text-white"></i></a>
        </div>
        <div class="child-6 w-50 d-grid">
            <a href="#" class="btn btn-outline-light">About Us</a>
        </div>
    </div>
    <div class="mb-5 my-lg-auto"></div>
    <div class="login my-auto mt-lg-5 col-lg-5 col-10 mx-auto" style="min-height: 550px !important;">
        <h2 class="h6 text-light text-center fw-bold my-3 fw-bold">Have an account?</h2>
        <h1 class="h2 text-light text-center">Login</h1>
        <form action="login_server.php" method="POST">
            <div class="row">
                <div class="col-12 mx-3 my-3">
                    <?php if (isset($_SESSION["login_email_error"]) && strlen($_SESSION["login_email_error"]) > 0): ?>
                    <div class="d-block d-lg-inline-block lab error">
                        <label for="email" class="form-label text-white-50 error" style="color: red !important;"><i
                                class="mx-auto m-lg-2 fas fa-envelope error"></i> Email</label>
                    </div>
                    <input type="email" name="email" id="email" class="form-input text-light error"
                        placeholder='<?=$_SESSION["login_email_error"]?>' autocomplete="off" />
                    <?php $_SESSION["login_email_error"] = ""?>
                    <?php elseif (isset($_SESSION["old_login_email"])): ?>
                    <div class="d-block d-lg-inline-block lab">
                        <label for="email" class="form-label text-white-50"><i
                                class="mx-auto m-lg-2 fas fa-envelope"></i> Email</label>
                    </div>
                    <input type="text" name="email" id="email" class="form-input text-light"
                        value="<?=$_SESSION["old_login_email"]?>" placeholder="Enter Your Email Address"
                        autocomplete="off" />
                    <?php $_SESSION["old_login_email"] = ""?>
                    <?php else: ?>
                    <div class="d-block d-lg-inline-block lab">
                        <label for="email" class="form-label text-white-50"><i
                                class="mx-auto m-lg-2 fas fa-envelope"></i> Email</label>
                    </div>
                    <input type="text" name="email" id="email" class="form-input text-light"
                        placeholder="Enter Your Email Address" autocomplete="off" />
                    <?php endif?>
                </div>
                <div class="col-12 mx-3 my-3">
                    <?php if (isset($_SESSION["login_password_error"]) && strlen($_SESSION["login_password_error"]) > 0): ?>
                    <div class="d-block d-lg-inline-block lab error">
                        <label for="password" class=" form-label text-white-50 error" style="color: red !important;"><i
                                class="m-lg-2 fas fa-lock error"></i> Password</label>
                    </div>
                    <input type="password" name="password" id="password" class="form-input text-light error"
                        placeholder="<?=$_SESSION["login_password_error"]?>" />
                    <?php $_SESSION["login_password_error"] = ""?>
                    <?php else: ?>
                    <div class="d-block d-lg-inline-block lab">
                        <label for="password" class=" form-label text-white-50"><i class="m-lg-2 fas fa-lock"></i>
                            Password</label>
                    </div>
                    <input type="password" name="password" id="password" class="form-input text-light"
                        placeholder="Enter Your Password" />
                    <?php endif?>
                </div>
                <divc class="col-8 form-check form-switch ps-1 ms-4">
                    <label for="remember_me" class="form-check-label text-white-50 ms-1">Remember Me</label>
                    <input type="checkbox" name="remember_me" id="remember_me" class="form-check-input mx-1" />
                </divc>
                <div class="col-8 mx-auto my-3 d-grid mb-4">
                    <input type="submit" name="subtn" class="btn btn-outline-light" value="Login" />
                </div>
                <div class="col-10 bor mx-auto"></div>
                <div class="col-12">
                    <h1 class="h3 justify-content-center text-light my-4 d-lg-flex d-none">Create New Account</h1>
                </div>
                <div class="col-12">
                    <div class="d-flex my-lg-2 my-4 justify-content-center anip">
                        <a href="register.php" class="btn btn-outline-light">Register Here</a>
                        <img src="./assets/images/heart.png" alt="heart" width="100px" height="90px"
                            class="heart d-lg-block d-none" />
                    </div>
                    <h2 class="h6 text-light text-center fw-bold mt-3 fw-bold">Don't have an account? <a
                            href="register.php">Sign up</a></h2>
                </div>
            </div>
        </form>
    </div>
</div>

<?php $template->footer()?>