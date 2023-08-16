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
$datas = $db->latesetOrPaginate(7);
$template->header('All Lists', ['index.css']);
if (isset($_GET["q"])) {
    $datas = $template->filter(7)[0];
    $ids = [];
    foreach ($template->filter(7)[1] as $data) {
        $ids[] = $data["id"];
    }
} else {
    $datas = $db->latesetOrPaginate(7)[0];
    $ids = [];
    foreach ($db->latesetOrPaginate(7)[1] as $data) {
        $ids[] = $data["id"];
    }
}
?>

<div class="ms-5 my-3 col-11 text-white">
    <div class="shadow card bg-white bg-opacity-50 py-3 px-1">
        <form action="" method="get" class=" d-flex flex-row">
            <div class="dropdown-center mx-2">
                <div class="btn-group">
                    <div class="btn btn-secondary" id="status-display">Status - 
                        <?php
                            if (isset($_GET["status"]) && $_GET["status"] == 1) {
                                echo "Done";
                            } elseif (isset($_GET["status"]) && $_GET["status"] == 0) {
                                echo "Not Done";
                            } elseif (isset($_GET["status"]) && $_GET["status"] == "all") {
                                echo "All";
                            } else {
                                echo "All";
                            }
                        ?>
                    </div>
                    <button class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown"></button>
                    <div class="dropdown-menu dropdown-menu-dark p-2">
                        <div class="form-check">
                                <input type="radio" name="status" id="status_all" class="form-check-input change-check" value="all" <?= empty($_GET["status"])?"checked":"" ?> <?php if (isset($_GET["status"])) { echo $_GET["status"] == "all"?"checked":""; } ?> />
                                <label for="status_all" class="form-check-label change-check">All</label>
                            </div>    
                        <div class="form-check">
                            <input type="radio" name="status" id="status_done" class="form-check-input change-check" value="1" <?php if (isset($_GET["status"])) { echo $_GET["status"] == 1?"checked":""; }  ?> />
                            <label for="status_done" class="form-check-label change-check">Done</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="status" id="status_not_done" class="form-check-input change-check" value="0" <?php if (isset($_GET["status"])) { echo $_GET["status"] == 0?"checked":""; } ?> />
                            <label for="status_not_done" class="form-check-label change-check">Not Done</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dropdown-center mx-2">
                <div class="btn-group">
                    <div class="btn btn-secondary" id="order-display">
                        <?php
                            if (empty($_GET["sort_by"])) {
                                echo "Descending Order By - Date";
                            } elseif ($_GET["sort_by"] == "id _asc") {
                                echo "Ascending Order By - Date";
                            } elseif ($_GET["sort_by"] == "id desc") {
                                echo "Descending Order By - Date";
                            } elseif ($_GET["sort_by"] == "title _asc") {
                                echo "Ascending Order By - Title";
                            } elseif ($_GET["sort_by"] == "title desc") {
                                echo "Descending Order By - Title";
                            }
                        ?>
                    </div>
                    <button class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown"></button>
                    <div class="dropdown-menu dropdown-menu-dark p-2">
                        <div class="form-check">
                            <input type="radio" name="sort_by" id="asc_ord_by_date" class="form-check-input change-check" value="id _asc" <?php if (isset($_GET["sort_by"])) { echo $_GET["sort_by"] == "id _asc"?"checked":""; } ?> />
                            <label for="asc_ord_by_date" class="form-check-label change-check">Ascending Order ( Date )</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="sort_by" id="desc_ord_by_date" class="form-check-input change-check" value="id desc" <?= empty($_GET["sort_by"])?"checked":"" ?> <?php if (isset($_GET["sort_by"])) { echo $_GET["sort_by"] == "id desc"?"checked":""; } ?> />
                            <label for="desc_ord_by_date" class="form-check-label change-check">Descending Order ( Date )</label>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="form-check">
                            <input type="radio" name="sort_by" id="asc_ord_by_title" class="form-check-input change-check" value="title _asc" <?php if (isset($_GET["sort_by"])) { echo $_GET["sort_by"] == "title _asc"?"checked":""; } ?> />
                            <label for="asc_ord_by_title" class="form-check-label change-check">Ascending Order ( Title )</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="sort_by" id="desc_ord_by_title" class="form-check-input change-check" value="title desc" <?php if (isset($_GET["sort_by"])) { echo $_GET["sort_by"] == "title desc"?"checked":""; } ?> />
                            <label for="desc_ord_by_title" class="form-check-label change-check">Descending Order ( Title )</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dropdown-center mx-2">
                <div class="btn-group">
                    <div class="btn btn-secondary" id="dead-line-display">Deadline - 
                        <?php
                            if (empty($_GET["expired"])) {
                                echo "All";
                            } elseif ($_GET["expired"] == "all") {
                                echo "All";
                            } elseif ($_GET["expired"] == "expired") {
                                echo "Expired";
                            } elseif ($_GET["expired"] == "not_expired") {
                                echo "Not Expired";
                            } elseif ($_GET["expired"] == "date_less") {
                                echo "Date Less";
                            }
                        ?>
                    </div>
                    <button class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown"></button>
                    <div class="dropdown-menu dropdown-menu-dark p-2">
                        <div class="form-check">
                            <input type="radio" name="expired" id="all" class="form-check-input change-check" value="all" <?= empty($_GET["expired"])?"checked":"" ?> <?php if (isset($_GET["expired"])) { echo $_GET["expired"] == "all"?"checked":""; } ?> />
                            <label for="all" class="form-check-label change-check">All</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="expired" id="expired" class="form-check-input change-check" value="expired" <?php if (isset($_GET["expired"])) { echo $_GET["expired"] == "expired"?"checked":""; } ?>/>
                            <label for="expired" class="form-check-label change-check">Expired</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="expired" id="not_expired" class="form-check-input change-check" value="not_expired" <?php if (isset($_GET["expired"])) { echo $_GET["expired"] == "not_expired"?"checked":""; } ?>/>
                            <label for="not_expired" class="form-check-label change-check">Not Expired</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="expired" id="date_less" class="form-check-input change-check" value="date_less" <?php if (isset($_GET["expired"])) { echo $_GET["expired"] == "date_less"?"checked":""; } ?>/>
                            <label for="date_less" class="form-check-label change-check">Date Less</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mx-2 w-25">
                <input type="text" name="q" class="form-control me-3" placeholder="Search..." value="<?= isset($_GET["q"])?$_GET["q"]:"" ?>"/>
            </div>
            <div class="mx-2">
                <button type="submit" class="btn btn-primary me-3"><i class="fas fa-filter"></i> Filter</button>
                <a href="./index.php" class="btn btn-danger"><i class="fas fa-redo"></i> Reset</a>
            </div>
        </form>
    </div>
</div>

<?php if (isset($datas)): ?>
<?php foreach ($datas as $data): ?>
<?php
    $now = new DateTime();
    $deadline = new DateTime($data["dead_line"]);
    if ($data["done"] == 1) {
        $check = "checked";
        $line = "bg-success bg-opacity-50";
    } else {
        $check = "";
        $line = "";
    }
?>
<?php if (empty($data["dead_line"])): ?>
<div class='col-lg-11 col-12 mx-auto my-3'>
    <span></span>
    <div class="parent d-flex flex-row h5 <?= $line ?>">
        <div class='child-1 my-auto'>
            <a class="fw-bold text-decoration-none" href="./show.php?id=<?=$data["id"]?>">
                <?=htmlentities($data["task_title"])?>
            </a> - <span></span></span><?=htmlentities(substr($data["description"], 0, 90))?><?php if (strlen($data["description"]) > 90) { echo "..."; } ?></span>
        </div>
        <form action="" method="POST" class="my-auto">
            <span class="form-check child-7 mb-0 ps-0">
                <input type="checkbox" name="done" id="<?= $data["id"] ?>" class="form-check-input ms-2 m-0 mt-1" <?= $check ?> />
                <label for="<?= $data["id"] ?>" class="form-check-label my-auto me-1 ms-2">Done</label>
            </span>
        </form>
        <a href="show.php?id=<?=$data["id"]?>" class="child-9">
            <i class="fas fa-eye"></i>
        </a>
        <a href='./edit.php?id=<?=$data["id"]?>' class='child-3'>
            <i class='far fa-edit'></i>
        </a>
        <i class='fas fa-trash-alt child-4' id="<?= $data["id"] ?>"></i>
    </div>
</div>

<?php else: ?>

<div class='col-lg-11 col-12 mx-auto my-3'>
    <?php if ($deadline < $now) : ?>
        <span class="bg-danger bg-opacity-50"></span>
    <?php else : ?>
        <span></span>
    <?php endif ?>
    <div class="parent d-flex flex-row h5 <?= $line ?>">
        <div class='child-1 my-auto'>
            <a class="fw-bold text-decoration-none" href="./show.php?id=<?=$data["id"]?>">
                <?=htmlentities($data["task_title"])?>
            </a> - <span><?=htmlentities(substr($data["description"], 0, 70))?><?php if (strlen($data["description"]) > 70) { echo "..."; } ?></span>
        </div>

        <b class='child-2 d-none d-lg-inline'>
            <?=$template->date($data["dead_line"])?>
        </b>
        <form action="" method="POST" class="my-auto">
            <span class="form-check child-7 mb-0 ps-0">
                <input type="checkbox" name="done" id="<?= $data["id"] ?>" class="form-check-input ms-2 m-0 mt-1" <?= $check ?> />
                <label for="<?= $data["id"] ?>" class="form-check-label my-auto me-1 ms-2">Done</label>
            </span>
        </form>
        <a href="show.php?id=<?=$data["id"]?>" class="child-9">
            <i class="fas fa-eye"></i>
        </a>
        <a href='edit.php?id=<?=$data["id"]?>' class='child-3'>
            <i class='far fa-edit'></i>
        </a>
        <i class='fas fa-trash-alt child-4' id="<?= $data["id"] ?>"></i>
    </div>
</div>

<?php endif?>

<?php endforeach?>
<?php endif?>

<!-- pagination -->
<?php if ($db->totalRows() <= 0): ?>
<div class="col-8 mx-auto my-5">
    <p class="alert alert-warning px-3 h5 fw-bold" style="letter-spacing: 1px;">No Record Found In Database <a
            href="./create.php">Create</a> New</p>
    </p>
</div>
</div>
<?php elseif (count($ids) > 7): ?>
<?=$db->links(7, $ids)?>
<?php endif?>
<!-- sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (isset($_SESSION["create_success"]) && strlen($_SESSION["create_success"]) > 0) : ?>
    <script type="text/javascript">
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Successfully created new task.',
            showConfirmButton: false,
            timer: 2500
        })
    </script>
    <?php $_SESSION["create_success"] = ""; ?>
<?php endif ?>

<?php if (isset($_SESSION["success_update"]) && strlen($_SESSION["success_update"]) > 0) : ?>
    <script type="text/javascript">
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Successfully updated new task.',
            showConfirmButton: false,
            timer: 2500
        })
    </script>
    <?php $_SESSION["success_update"] = ""; ?>
<?php endif ?>
<?php $template->footer("index")?>