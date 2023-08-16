<?php

if (!(isset($_SESSION["user_id"]) && strlen($_SESSION["user_id"]) > 0) || !(isset($_COOKIE["user_id"]) && strlen($_COOKIE["user_id"]) > 0)) {
    return;
}
require_once "./template/db.php";
$db = new DB;
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
    $_GET["page"] = null;
}
$id = $_COOKIE["user_id"];
$ids = $_SESSION["ids"];
$in = "";
foreach ($ids as $value) {
    if (array_search($value, $ids) == count($ids) - 1) {
        $in .= $value;
        break;
    } else {
        $in .= "$value,";
    }
}
$rows_per_page = $_SESSION["rows_per_page"];
$stmt = $db->db->prepare("SELECT * FROM `lists` WHERE id IN ($in) AND `user_id` = $id");
$stmt->execute();
$datas = $stmt->fetchAll();
$total = count($datas);
$total_pages = ceil($total / $rows_per_page);
?>

<?php if (isset($_GET["q"])): ?>
<?php
$status = $_GET["status"];
$sort_by = $_GET["sort_by"];
$expired = $_GET["expired"];
$q = $_GET["q"];
?>
<div class="page-info">
    <div class="h5 text-light text-center">Showing <?=$page?> of <?=$total_pages?></div>
</div>

<ul class='pagination justify-content-center'>
    <li class="page-item">
        <a href="index.php?page=1&status=<?=$status?>&sort_by=<?=$sort_by?>&expired=<?=$expired?>&q=<?=$q?>"
            class="page-link">First</a>
    </li>
    <?php if (isset($_GET["page"]) && $_GET["page"] > 1): ?>
    <li class="page-item">
        <a href="index.php?page=<?=$_GET['page'] - 1?>&status=<?=$status?>&sort_by=<?=$sort_by?>&expired=<?=$expired?>&q=<?=$q?>"
            class="page-link">Previous</a>
    </li>
    <?php else: ?>
    <li class="page-item">
        <a href="#status=<?=$status?>&sort_by=<?=$sort_by?>&expired=<?=$expired?>&q=<?=$q?>"
            class="page-link">Previous</a>
    </li>
    <?php endif;?>
    <?php
for ($i = 1; $i <= $total_pages; $i++) {
    echo "
                <li class='page-item'>
                    <a href='index.php?page={$i}&status={$status}&sort_by={$sort_by}&expired={$expired}&q={$q}' class='page-link'>{$i}</a>
                </li>
            ";
}
?>
    <?php if (!isset($GET["page"]) && $_GET["page"] < $total_pages): ?>
    <li class="page-item">
        <a href="index.php?page=<?=$_GET["page"] + 1?>&status=<?=$status?>&sort_by=<?=$sort_by?>&expired=<?=$expired?>&q=<?=$q?>"
            class="page-link">Next</a>
    </li>
    <?php else: ?>
    <li class="page-item">
        <a href="#&status=<?=$status?>&sort_by=<?=$sort_by?>&expired=<?=$expired?>&q=<?=$q?>" class="page-link">Next</a>
    </li>
    <?php endif;?>
    <li class="page-item">
        <a href="index.php?page=<?=$total_pages?>&status=<?=$status?>&sort_by=<?=$sort_by?>&expired=<?=$expired?>&q=<?=$q?>"
            class="page-link">Last</a>
    </li>
</ul>

<?php else: ?>

<div class="page-info">
    <div class="h5 text-light text-center">Showing <?=$page?> of <?=$total_pages?></div>
</div>

<ul class='pagination justify-content-center'>
    <li class="page-item">
        <a href="index.php?page=1" class="page-link">First</a>
    </li>
    <?php if (isset($_GET["page"]) && $_GET["page"] > 1): ?>
    <li class="page-item">
        <a href="index.php?page=<?=$_GET['page'] - 1?>" class="page-link">Previous</a>
    </li>
    <?php else: ?>
    <li class="page-item">
        <a href="#" class="page-link">Previous</a>
    </li>
    <?php endif;?>
    <?php
for ($i = 1; $i <= $total_pages; $i++) {
    echo "
                <li class='page-item'>
                    <a href='index.php?page={$i}' class='page-link'>{$i}</a>
                </li>
            ";
}
?>
    <?php if (!isset($GET["page"]) && $_GET["page"] < $total_pages): ?>
    <li class="page-item">
        <a href="index.php?page=<?=$_GET["page"] + 1?>" class="page-link">Next</a>
    </li>
    <?php else: ?>
    <li class="page-item">
        <a href="#" class="page-link">Next</a>
    </li>
    <?php endif;?>
    <li class="page-item">
        <a href="index.php?page=<?=$total_pages?>" class="page-link">Last</a>
    </li>
</ul>

<?php endif;?>