<?php
require_once "./template/auth.php";
require_once "./template/view.php";
require_once "./template/db.php";
$auth = new Auth;
$template = new Template;
$db = new DB;
if ((empty($_SESSION["user_id"]) && strlen($_SESSION["user_id"]) <= 0) || (empty($_COOKIE["user_id"]) && strlen($_COOKIE["user_id"]) <= 0)) {
    header("Location: ./login.php");
    return;
}
if (empty($_GET["id"])) {
    header("Location: ./index.php");
    return;
}

$template->header('Show', ['']);

$data = $db->search($_GET["id"]);
if (!$data) {
    header("Location: ./index.php");
    return;
}
$expiredDatas = $db->fourExpiredRecords($_GET["id"]);
?>

<div class="container m-5">
    <div class="row">
        <div class="col-8 card shadow bg-dark bg-opacity-25 p-4 border-light">
            <h1 class="d-inline fw-bold text-white"><?=$data["task_title"]?></h1>
            <div class="d-flex justify-content-end">
                <div class="btn-group">
                    <a href="edit.php?id=<?=$data["id"]?>" class="btn btn-dark border-light">Update</a>
                    <button class="btn btn-light border-light delete-btn" id="delete<?=$data["id"]?>">Delete</button>
                </div>
            </div>
            <div class="d-flex mt-3">
                <div class="d-flex card bg-dark bg-opacity-50 border-light col-5 p-3 my-3 ms-4 me-2">
                    <div class="text-white-50 h5 my-1">Created - <?=$template->plainDate($data["created_at"])?></div>
                    <div class="text-white-50 h5 my-1">Updated - <?=$template->plainDate($data["updated_at"])?></div>
                    <div class="text-white-50 h5 my-1">Done - <?=$template->plainDate($data["done_at"])?></div>
                </div>
                <div
                    class="d-flex card bg-dark bg-opacity-50 border-light col-6 p-3 my-3 ms-2 me-4  justify-content-center align-items-center">
                    <form>
                        <div class="form-switch ps-0">
                            <label for="<?=$data["id"]?>" class="form-check-label d-inline mx-2 me-4 submit-class">
                                <img src="./assets/images/complete.png" alt="" class="w-25 h-25">
                            </label>
                            <input type="checkbox" name="done" id="<?=$data["id"]?>"
                                class="form-check-input mx-2 align-middle submit-class"
                                <?php if (isset($data["done"]) && $data["done"] == 1) {echo "checked";}?> />
                            <label for="<?=$data["id"]?>"
                                class="mx-2 form-check-label text-light align-middle mt-2 h5 fw-bold submit-class ms-4">
                                Mark As Done
                            </label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="d-flex card bg-dark bg-opacity-75 border-light p-3 mt-3">
                <div class="text-white">
                    <?=$data["description"]?>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="shadow mb-4">
                <div class="d-flex justify-content-center ps-3">
                    <h2 class="text-white-50 my-auto">Expired Tasks</h2>
                </div>
            </div>
            <?php foreach ($expiredDatas as $data): ?>
            <div class="card shadow bg-dark bg-opacity-25 border-light mb-4">
                <div class="d-flex flex-row justify-content-end ps-3">
                    <h4 class="text-white-50 flex-grow-1 my-auto py-3"><?=$data["task_title"]?></h4>
                    <a href="edit.php?id=<?=$data["id"]?>"
                        class="btn btn-link text-light border-start my-auto rounded-0 py-3">Update</a>
                    <a href="delete.php?id=<?=$data["id"]?>"
                        class="btn btn-link text-secondary border-start my-auto rounded-0 py-3">Delete</a>
                </div>
            </div>
            <?php endforeach?>
            <?php if (count($expiredDatas) < 5) {
    $count = count($expiredDatas);
    for ($count; $count < 4; $count++) {
        echo '
                        <div class="card shadow bg-dark bg-opacity-25 border-light mb-4">
                            <div class="d-flex flex-row justify-content-end ps-3">
                                <h4 class="text-white-50 flex-grow-1 my-auto py-3">No expired record found</h4>
                            </div>
                        </div>
                        ';
    }
}
?>
            <div class="btn-group w-100 mt-5">
                <a href="./index.php" class="btn btn-dark w-100 mt-4 py-2"><i class="fas fa-home"></i> Return To
                    Home</a>
            </div>
        </div>
    </div>

</div>


<!-- sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php $template->footer("show")?>