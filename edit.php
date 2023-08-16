<?php
require_once "./template/auth.php";
require_once "./template/view.php";
require_once "./template/db.php";
$auth = new Auth;
$template = new Template;
$db = new DB;
$template->css(["custom_error3.css"]);
if ((empty($_SESSION["user_id"]) && strlen($_SESSION["user_id"]) <= 0) || (empty($_COOKIE["user_id"]) && strlen($_COOKIE["user_id"]) <= 0)) {
    header("Location: ./login.php");
    return;
}
if (empty($_GET["id"])) {
    header("Location: ./index.php");
    return;
}

$template->header('Edit', ['create2.css']);
$data = $db->search($_GET["id"]);

?>

<form action="update.php" method="POST">
    <div class="row m-5">
        <div class="col-12">
            <h1 class="h2 text-light text-center my-4 fw-bold">Edit Your Plans</h1>
        </div>
        <input type="hidden" name="id" id="id" class="form-control" value="<?=$_GET["id"]?>" />
        <div class="col-lg-10 col-12 mx-auto my-3">
            <?php if (isset($_SESSION["task_title_error"]) && strlen($_SESSION["task_title_error"]) > 0): ?>
            <small class="text-danger fw-bold"><?=$_SESSION["task_title_error"]?></small>
            <?php $_SESSION["task_title_error"] = ""?>
            <div class="input-group">
                <label for="task_title" class="input-group-text text-light"
                    style="color: red !important; border-color: red;"><i class="mx-auto mx-lg-3 fas fa-plus"></i><span
                        class="d-lg-inline d-none add">New Task</span></label>
                <div class="form-floating w-75">
                    <input type="text" name="task_title" id="task_title" class="form-control font"
                        placeholder="Task Title" autocomplete="off" style="border-color: red;" />
                    <label for="task_title" class="label text-light">Task Title</label>
                </div>
            </div>

            <?php elseif (isset($_SESSION["old_task_title"]) && strlen($_SESSION["old_task_title"]) > 0): ?>
            <div class="input-group">
                <label for="task_title" class="input-group-text text-light"><i
                        class="mx-auto mx-lg-3 fas fa-plus"></i><span class="d-lg-inline d-none add">New
                        Task</span></label>
                <div class="form-floating w-75">
                    <input type="text" name="task_title" id="task_title" class="form-control font"
                        placeholder="New Task" autocomplete="off" value='<?=$_SESSION["old_task_title"]?>' />
                    <label for="task_title" class="label text-light">Task Title</label>
                </div>
            </div>
            <?php $_SESSION["old_task_title"] = ""?>

            <?php else: ?>
            <div class="input-group">
                <label for="task_title" class="input-group-text text-light"><i
                        class="mx-auto mx-lg-3 fas fa-plus"></i><span class="d-lg-inline d-none add">New
                        Task</span></label>
                <div class="form-floating w-75">
                    <input type="text" name="task_title" id="task_title" class="form-control font"
                        placeholder="New Task" autocomplete="off" value="<?=$data["task_title"]?>" />
                    <label for="task_title" class="label text-light">Task Title</label>
                </div>
            </div>
            <?php endif?>

        </div>
        <div class="col-lg-10 col-12 mx-auto my-3">
            <?php if (isset($_SESSION["description_error"]) && strlen($_SESSION["description_error"]) > 0): ?>
            <small class="text-danger fw-bold"><?=$_SESSION["description_error"]?></small>
            <?php $_SESSION["description_error"] = ""?>
            <div class="input-group">
                <label for="description" class="input-group-text text-light errorLabel" style="color:red !important;"><i
                        class="mx-auto mx-lg-3 fas fa-file-alt"></i><span
                        class="d-lg-inline d-none add">Description</span></label>
                <div class="form-floating">
                    <textarea class="font form-control" placeholder="Enter Your Description Here" name="description"
                        id="description" style="height: 155px; resize:none;"></textarea>
                    <label for="floatingTextarea2" class="label text-light">Enter Your Description Here</label>
                </div>
            </div>
            <?php elseif (isset($_SESSION["old_description"]) && strlen($_SESSION["old_description"]) > 0): ?>
            <div class="input-group">
                <label for="description" class="input-group-text text-light"><i
                        class="mx-auto mx-lg-3 fas fa-file-alt"></i><span
                        class="d-lg-inline d-none add">Description</span></label>
                <div class="form-floating">
                    <textarea class="font form-control" placeholder="Enter Your Description Here" name="description"
                        id="description"
                        style="height: 155px; resize:none;"><?=$_SESSION["old_description"];?></textarea>
                    <label for="floatingTextarea2" class="label text-light">Enter Your Description Here</label>
                </div>
            </div>
            <?php $_SESSION["old_description"] = ""?>
            <?php else: ?>
            <div class="input-group">
                <label for="description" class="input-group-text text-light"><i
                        class="mx-auto mx-lg-3 fas fa-file-alt"></i><span
                        class="d-lg-inline d-none add">Description</span></label>
                <div class="form-floating">
                    <textarea class="font form-control" placeholder="Enter Your Description Here" name="description"
                        id="description" style="height: 155px; resize:none;"><?=$data["description"]?></textarea>
                    <label for="floatingTextarea2" class="label text-light">Description</label>
                </div>
            </div>
            <?php endif?>
        </div>

        <div class="col-lg-10 col-12 mx-auto my-3">
            <?php if (isset($_SESSION["old_dead_line"]) && strlen($_SESSION["old_description"]) > 0): ?>
            <div class="input-group">
                <label for="dead_line" class="input-group-text text-light"><i
                        class="mx-auto mx-lg-3 fas fa-hourglass-start"></i><span
                        class="d-lg-inline d-none add">Deadline</span></label>
                <input type="date" name="dead_line" id="dead_line" class="form-control font py-3"
                    value="<?=$_SESSION["old_dead_line"]?>" />
            </div>
            <?php $_SESSION["old_dead_line"] = ""?>
            <?php else: ?>
            <div class="input-group">
                <label for="dead_line" class="input-group-text text-light"><i
                        class="mx-auto mx-lg-3 fas fa-hourglass-start"></i><span
                        class="d-lg-inline d-none add">Deadline</span></label>
                <input type="date" name="dead_line" id="dead_line" class="form-control font py-3"
                    value="<?=$data["dead_line"]?>" />
            </div>
            <?php endif?>
        </div>
        <div class="col-4 mx-auto my-4 d-grid">
            <input type="submit" name="resbtn" id="restart-btn" class="btn text-light custom-btn" value="Cancel" />
        </div>
        <div class="col-4 mx-auto my-4 d-grid">
            <input type="submit" name="subbtn" id="submit-btn" class="btn text-light btn-primary" value="Update Task" />
        </div>
    </div>
</form>

<?php $template->footer()?>