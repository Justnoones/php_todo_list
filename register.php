<?php
require_once "./template/auth.php";
require_once "./template/view.php";
$template = new Template();
$template->header('Register', ['registerss.css', 'custom_error.css']);
if (isset($_SESSION["user_id"]) || isset($_COOKIE["user_id"])) {
    header("Location: ./index.php");
}
?>
<div class="w-100 mx-auto d-flex">

    <div class="d-flex justify-content-center">
        <div class="col-lg-8">
            <div class="card-body">
                <h1 class="h2 fw-bold mb-5 text-white text-center">Register Now</h1>
                <form action="./register_server.php" method="POST">
                    <div class="row mx-auto">
                        <div class="col-12 my-2">
                            <div class="input-group">
                                <?=$template->input("name", "text", "Name")?>
                            </div>
                        </div>
                        <div class="col-12 my-2">
                            <div class="input-group">
                                <?=$template->input("email", "email", "Email Address")?>
                            </div>
                        </div>
                        <div class="col-12 my-2">
                            <div class="input-group">
                                <?=$template->input("password", "password", "Password")?>
                            </div>
                        </div>
                        <div class="col-12 my-2">
                            <div class="input-group">
                                <?=$template->input("confirm_password", "password", "Confirm Password")?>
                            </div>
                        </div>
                        <div class="col-12 my-2">
                            <div class="input-group">
                                <label for="address" class="input-group-text w-25 fw-lighter text-white"><i
                                        class="mx-auto m-lg-2 fas fa-map-marked"></i>
                                    <sapn class="d-none d-lg-inline">Address</span>
                                </label>
                                <input type="text" list="addresses" name="address" id="address"
                                    class="form-control text-white" placeholder="Enter Your Address" autocomplete="off" <?php if (isset($_SESSION["old_address"])) {echo "value='" . $_SESSION["old_address"] . "'";
    $_SESSION['old_address'] = "";}?> />
                                <datalist id="addresses">
                                    <option selected disabled>Choose Your Address</option>
                                    <option value="Yangon">Yangon</option>
                                    <option value="Mandalay">Mandalay</option>
                                    <option value="Nay Pyi Thaw">Nay Pyi Thaw</option>
                                    <option value="Pakokku">Pakokku</option>
                                    <option value="Shan State">Shan State</option>
                                    <option value="Mawlamyine">Mawlamyine</option>
                                    <option value="Bago">Bago</option>
                                    <option value="Hpa-An">Hpa-An</option>
                                    <option value="Myeik">Myeik</option>
                                    <option value="Taunggyi">Taunggyi</option>
                                </datalist>
                            </div>
                        </div>
                        <div class="col-12 my-2">
                            <div class="input-group">
                                <label for="gender" class="input-group-text w-25 fw-lighter text-white"><i
                                        class="mx-auto m-lg-2 fas fa-venus-mars"></i>
                                    <sapn class="d-none d-lg-inline">Gender</span>
                                </label>
                                <select name="gender" id="gender" class="form-select text-white">
                                    <option selected disabled>Choose Your Gender</option>
                                    <option value="male" <?php if (isset($_SESSION["old_gender"]) && $_SESSION["old_gender"] == "male") {echo "selected";
    $_SESSION["old_gender"] = "";}?>>Male</option>
                                    <option value="female" <?php if (isset($_SESSION["old_gender"]) && $_SESSION["old_gender"] == "female") {echo "selected";
    $_SESSION["old_gender"] = "";}?>>Female</option>
                                    <option value="other" <?php if (isset($_SESSION["old_gender"]) && $_SESSION["old_gender"] == "other") {echo "selected";
    $_SESSION["old_gender"] = "";}?>>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 my-2">
                            <div class="form-check">
                                <input type="checkbox" name="agree" id="agree" class="form-check-input" />
                                <label for="agree" class="form-label text-white h6"><strong>I accept <a href="#">Terms
                                            of Use</a> & <a href="#">Privacy Policy.</a></strong></label>
                            </div>
                        </div>
                        <div class="col-5 my-2 d-grid mx-auto">
                            <input type="submit" name="resbtn" class="btn text-light btn-light custom-btn"
                                value="Cancel" />
                        </div>
                        <div class="col-5 my-2 d-grid mx-auto">
                            <input type="submit" name="subbtn" class="btn text-light btn-primary" value="Submit" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<?php $template->footer()?>