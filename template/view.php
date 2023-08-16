<?php
require_once "./template/db.php";
class Template
{
    public function headerOne()
    {
        require_once "./template/header_one.php";
    }
    public function headerTow()
    {
        require_once "./template/header_two.php";
        echo '<section id="mm">';
        require_once "./template/navbar.php";
    }

    public function title($name = "")
    {
        echo $name ? "<title>$name</title>" : "<title>Document</title>";
    }

    public function css($names = [])
    {
        foreach ($names as $name) {
            // echo '<link rel="stylesheet" type="text/css" href="./assets/css/' . $name . '" />';
            echo "<link rel='stylesheet' type='text/css' href='./assets/css/$name' />";
        }
    }

    public function javascript($names = "")
    {
        if (isset($names) && is_array($names)) {
            foreach ($names as $name) {
                echo '<script style="text/javascript" src="./assets/js/' . $name . '.js"></script>';
            }
        }
    }

    public function header($title = "", $name = [])
    {
        $this->headerOne();
        $this->title($title);
        $this->css($name);
        $this->headerTow();
    }

    public function footerOne()
    {
        echo '</section>';
        require_once "./template/copyright.php";
    }

    public function footerTwo()
    {
        require_once "./template/footer.php";

    }

    public function footer($names = "")
    {
        $this->footerOne();
        if ($names) {
            $this->javascript([$names]);
        }
        $this->footerTwo();
    }

    public function error($name)
    {
        if (isset($_SESSION[$name . "_error"])) {
            $error = $_SESSION[$name . "_error"];
        } else {
            $error = "";
        }
        return $error;
    }

    public function hasError($name)
    {
        if (!isset($_SESSION[$name . "_error"]) || str_word_count($_SESSION[$name . "_error"]) <= 0) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    public function input($inputName, $inputType, $labelName)
    {
        if ($inputName === "name") {
            $icon = "fas fa-user";
        } elseif ($inputName === "email") {
            $icon = "fas fa-envelope";
        } elseif ($inputName === "password") {
            $icon = "fas fa-lock";
        } elseif ($inputName === "confirm_password") {
            $icon = "fas fa-unlock";
        }
        if ($this->hasError($inputName)) {
            echo '<label for="' . $inputName . '"' . ' class="input-group-text w-25 text-white error errorLabel"><i class="mx-auto m-lg-2 ' . $icon . '"' . ' style="color: red !important;"></i><sapn class="d-none d-lg-inline" style="color: red !important;">' . $labelName . '</span></label>
                    <input type="' . $inputType . '"' . ' name="' . $inputName . '"' . ' id="' . $inputName . '"' . ' class="form-control text-white error" placeholder="' . $_SESSION[$inputName . "_error"] . '"' . ' autocomplete="off" />
                ';
            $_SESSION[$inputName . "_error"] = "";
            // header("Location: ./register.php");
            return;
        } elseif (isset($_SESSION["old_" . $inputName])) {
            echo '<label for="' . $inputName . '"' . ' class="input-group-text w-25 text-white"><i class="mx-auto m-lg-2 ' . $icon . '"' . '></i><sapn class="d-none d-lg-inline">' . $labelName . '</span></label>
                <input type="' . $inputType . '"' . ' name="' . $inputName . '"' . ' id="' . $inputName . '"' . ' class="form-control text-white" placeholder="Enter Your ' . $labelName . '"' . '  autocomplete="off"  value="' . $_SESSION["old_" . $inputName] . '"' . ' />
            ';
            $_SESSION["old_" . $inputName] = "";
            // header("Location: ./register.php");
            return;
        } else {
            echo '<label for="' . $inputName . '"' . ' class="input-group-text w-25 text-white"><i class="mx-auto m-lg-2 ' . $icon . '"' . '></i><sapn class="d-none d-lg-inline">' . $labelName . '</span></label>
                <input type="' . $inputType . '"' . ' name="' . $inputName . '"' . ' id="' . $inputName . '"' . ' class="form-control text-white" placeholder="Enter Your ' . $labelName . '"' . '  autocomplete="off" />
            ';
        }
    }

    public function date($date)
    {

        date_default_timezone_set("Asia/Rangoon");
        $now = new DateTime();
        $deadline = new DateTime($date);
        $interval = $now->diff($deadline);
        $d = "days";
        $m = "months";
        $y = "years";

        if ($interval->format("%d") == 1) {
            $d = "day";
        }

        if ($interval->format("%m") == 1) {
            $m = "month";
        }

        if ($interval->format("%Y") == 1) {
            $y = "year";
        }
        if ($deadline->format("Y-m-d") == $now->format("Y-m-d")) {
            $date = "<span class='text-warning'>" . "Today" . "</span>";
        } elseif ($deadline > $now) {
            if ($interval->format("%Y") === "00") {
                if ($interval->format("%m") === "0") {
                    $date = "<span class='text-warning'>" . $interval->format("Before %d $d") . "</span>";
                } else {
                    $date = "<span class='text-warning'>" . $interval->format("Before %m $m") . "</span>";
                }
            } else {
                $date = "<span class='text-warning'>" . $interval->format("Before %m $m") . "</span>";
            }
            if ($interval->format("%Y") !== "00") {
                $date = "<span class='text-warning'>" . $interval->format("Before %Y $y") . "</span>";
            }
        } elseif ($deadline < $now) {
            if ($interval->format("%Y") === "00") {
                if ($interval->format("%m") === "0") {
                    $date = "<span class='text-danger'>" . $interval->format("%d $d ago") . "</span>";
                } else {
                    $date = "<span class='text-danger'>" . $interval->format("%m $m ago") . "</span>";
                }
            } else {
                $date = "<span class='text-danger'>" . $interval->format("%m $m ago") . "</span>";
            }
            if ($interval->format("%Y") !== "00") {
                $date = "<span class='text-danger'>" . $interval->format("%Y $y ago") . "</span>";
            }

        }
        return $date;
    }
    public function plainDate($date)
    {

        date_default_timezone_set("Asia/Rangoon");
        $now = new DateTime();
        $deadline = new DateTime($date);
        $interval = $now->diff($deadline);
        $d = "days";
        $m = "months";
        $y = "years";

        if ($interval->format("%d") == 1) {
            $d = "day";
        }

        if ($interval->format("%m") == 1) {
            $m = "month";
        }

        if ($interval->format("%Y") == 1) {
            $y = "year";
        }
        if ($deadline->format("Y-m-d") == $now->format("Y-m-d")) {
            $date = "<span>" . "Today" . "</span>";
        } elseif ($deadline > $now) {
            if ($interval->format("%Y") === "00") {
                if ($interval->format("%m") === "0") {
                    $date = "<span>" . $interval->format("Before %d $d") . "</span>";
                } else {
                    $date = "<span>" . $interval->format("Before %m $m") . "</span>";
                }
            } else {
                $date = "<span>" . $interval->format("Before %m $m") . "</span>";
            }
            if ($interval->format("%Y") !== "00") {
                $date = "<span>" . $interval->format("Before %Y $y") . "</span>";
            }
        } elseif ($deadline < $now) {
            if ($interval->format("%Y") === "00") {
                if ($interval->format("%m") === "0") {
                    $date = "<span>" . $interval->format("%d $d ago") . "</span>";
                } else {
                    $date = "<span>" . $interval->format("%m $m ago") . "</span>";
                }
            } else {
                $date = "<span>" . $interval->format("%m $m ago") . "</span>";
            }
            if ($interval->format("%Y") !== "00") {
                $date = "<span>" . $interval->format("%Y $y ago") . "</span>";
            }

        }
        return $date;
    }

    public function filter($rows)
    {
        $db = new DB;
        $ids = [];
        $datas = $db->all();
        if (isset($_GET["q"])) {
            $i = 0;
            if (isset($_GET["page"])) {
                $page = $_GET["page"];
            } else {
                $page = 1;
                $_GET["page"] = null;
            }
            $rows_per_page = $rows;
            $start_from = ($page - 1) * $rows_per_page;
            $id = $_SESSION['user_id'];
            for ($i; $i < 5; $i++) {
                $x = 0;
                for ($x; $x < 5; $x++) {
                    $z = 0;
                    for ($z; $z < 4; $z++) {
                        if ($_GET["expired"] == "all") {
                            if (strpos($_GET["sort_by"], "asc")) {
                                $order = substr($_GET["sort_by"], 0, -5);
                                if ($order == "id") {
                                    if ($_GET["status"] == "all") {
                                        $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) ORDER BY id LIMIT $start_from, $rows_per_page");
                                        $stmt->execute([
                                            ":id" => $_COOKIE["user_id"],
                                            ":search" => "%" . $_GET["q"] . "%",
                                        ]);
                                        $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) ORDER BY id");
                                        $stmt_2->execute([
                                            ":id" => $_COOKIE["user_id"],
                                            ":search" => "%" . $_GET["q"] . "%",
                                        ]);
                                        return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                    } else {
                                        $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND done = :done ORDER BY id LIMIT $start_from, $rows_per_page");
                                        $stmt->execute([
                                            ":id" => $_COOKIE["user_id"],
                                            ":search" => "%" . $_GET["q"] . "%",
                                            ":done" => $_GET["status"],
                                        ]);
                                        $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND done = :done ORDER BY id");
                                        $stmt_2->execute([
                                            ":id" => $_COOKIE["user_id"],
                                            ":search" => "%" . $_GET["q"] . "%",
                                            ":done" => $_GET["status"],
                                        ]);
                                        return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                    }
                                } else {
                                    if ($_GET["status"] == "all") {
                                        $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) ORDER BY task_title LIMIT $start_from, $rows_per_page");
                                        $stmt->execute([
                                            ":id" => $_COOKIE["user_id"],
                                            ":search" => "%" . $_GET["q"] . "%",
                                        ]);
                                        $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) ORDER BY task_title");
                                        $stmt_2->execute([
                                            ":id" => $_COOKIE["user_id"],
                                            ":search" => "%" . $_GET["q"] . "%",
                                        ]);
                                        return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                    } else {
                                        $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND done = :done ORDER BY task_title LIMIT $start_from, $rows_per_page");
                                        $stmt->execute([
                                            ":id" => $_COOKIE["user_id"],
                                            ":search" => "%" . $_GET["q"] . "%",
                                            ":done" => $_GET["status"],
                                        ]);
                                        $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND done = :done ORDER BY task_title");
                                        $stmt_2->execute([
                                            ":id" => $_COOKIE["user_id"],
                                            ":search" => "%" . $_GET["q"] . "%",
                                            ":done" => $_GET["status"],
                                        ]);
                                        return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                    }
                                }
                            } elseif (strpos($_GET["sort_by"], "desc")) {
                                $order = substr($_GET["sort_by"], 0, -5);
                                if ($order == "id") {
                                    if ($_GET["status"] == "all") {
                                        $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) ORDER BY id DESC LIMIT $start_from, $rows_per_page");
                                        $stmt->execute([
                                            ":id" => $_COOKIE["user_id"],
                                            ":search" => "%" . $_GET["q"] . "%",
                                        ]);
                                        $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) ORDER BY id DESC");
                                        $stmt_2->execute([
                                            ":id" => $_COOKIE["user_id"],
                                            ":search" => "%" . $_GET["q"] . "%",
                                        ]);
                                        return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                    } else {
                                        $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND done = :done ORDER BY id DESC LIMIT $start_from, $rows_per_page");
                                        $stmt->execute([
                                            ":id" => $_COOKIE["user_id"],
                                            ":search" => "%" . $_GET["q"] . "%",
                                            ":done" => $_GET["status"],
                                        ]);
                                        $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND done = :done ORDER BY id DESC");
                                        $stmt_2->execute([
                                            ":id" => $_COOKIE["user_id"],
                                            ":search" => "%" . $_GET["q"] . "%",
                                            ":done" => $_GET["status"],
                                        ]);
                                        return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                    }
                                } else {
                                    if ($_GET["status"] == "all") {
                                        $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) ORDER BY task_title DESC LIMIT $start_from, $rows_per_page");
                                        $stmt->execute([
                                            ":id" => $_COOKIE["user_id"],
                                            ":search" => "%" . $_GET["q"] . "%",
                                        ]);
                                        $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) ORDER BY task_title DESC");
                                        $stmt_2->execute([
                                            ":id" => $_COOKIE["user_id"],
                                            ":search" => "%" . $_GET["q"] . "%",
                                        ]);
                                        return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                    } else {
                                        $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND done = :done ORDER BY task_title DESC LIMIT $start_from, $rows_per_page");
                                        $stmt->execute([
                                            ":id" => $_COOKIE["user_id"],
                                            ":search" => "%" . $_GET["q"] . "%",
                                            ":done" => $_GET["status"],
                                        ]);
                                        $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND done = :done ORDER BY task_title DESC");
                                        $stmt_2->execute([
                                            ":id" => $_COOKIE["user_id"],
                                            ":search" => "%" . $_GET["q"] . "%",
                                            ":done" => $_GET["status"],
                                        ]);
                                        return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                    }
                                }
                            }
                        } else {
                            if ($_GET["expired"] == "expired") {
                                if (strpos($_GET["sort_by"], "asc")) {
                                    $order = substr($_GET["sort_by"], 0, -5);
                                    if ($order == "id") {
                                        if ($_GET["status"] == "all") {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line < NOW() ORDER BY id LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line < NOW() ORDER BY id");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        } else {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND done = :done AND dead_line < NOW() ORDER BY id LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND done = :done AND dead_line < NOW() ORDER BY id");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        }
                                    } else {
                                        if ($_GET["status"] == "all") {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line < NOW() ORDER BY task_title LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line < NOW() ORDER BY task_title");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        } else {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND done = :done AND dead_line < NOW() ORDER BY task_title LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND done = :done AND dead_line < NOW() ORDER BY task_title");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        }
                                    }
                                } elseif (strpos($_GET["sort_by"], "desc")) {
                                    $order = substr($_GET["sort_by"], 0, -5);
                                    if ($order == "id") {
                                        if ($_GET["status"] == "all") {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line < NOW() ORDER BY id DESC LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line < NOW() ORDER BY id DESC");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        } else {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line < NOW() AND done = :done ORDER BY id DESC LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line < NOW() AND done = :done ORDER BY id DESC");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        }
                                    } else {
                                        if ($_GET["status"] == "all") {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line < NOW() ORDER BY task_title DESC LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line < NOW() ORDER BY task_title DESC");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        } else {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line < NOW() AND done = :done ORDER BY task_title DESC LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line < NOW() AND done = :done ORDER BY task_title DESC");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        }
                                    }
                                }
                            } elseif ($_GET["expired"] == "not_expired") {
                                if (strpos($_GET["sort_by"], "asc")) {
                                    $order = substr($_GET["sort_by"], 0, -5);
                                    if ($order == "id") {
                                        if ($_GET["status"] == "all") {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line > NOW() ORDER BY id LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line > NOW() ORDER BY id");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        } else {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND done = :done AND dead_line > NOW() ORDER BY id LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND done = :done AND dead_line > NOW() ORDER BY id");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        }
                                    } else {
                                        if ($_GET["status"] == "all") {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line > NOW() ORDER BY task_title LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line > NOW() ORDER BY task_title");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        } else {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND done = :done AND dead_line > NOW() ORDER BY task_title LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND done = :done AND dead_line > NOW() ORDER BY task_title");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        }
                                    }
                                } elseif (strpos($_GET["sort_by"], "desc")) {
                                    $order = substr($_GET["sort_by"], 0, -5);
                                    if ($order == "id") {
                                        if ($_GET["status"] == "all") {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line > NOW() ORDER BY id DESC LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line > NOW() ORDER BY id DESC");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        } else {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line > NOW() AND done = :done ORDER BY id DESC LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line > NOW() AND done = :done ORDER BY id DESC");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        }
                                    } else {
                                        if ($_GET["status"] == "all") {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line > NOW() ORDER BY task_title DESC LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line > NOW() ORDER BY task_title DESC");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        } else {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line > NOW() AND done = :done ORDER BY task_title DESC LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line > NOW() AND done = :done ORDER BY task_title DESC");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        }
                                    }
                                }
                            } elseif ($_GET["expired"] == "date_less") {
                                if (strpos($_GET["sort_by"], "asc")) {
                                    $order = substr($_GET["sort_by"], 0, -5);
                                    if ($order == "id") {
                                        if ($_GET["status"] == "all") {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line IS NULL ORDER BY id LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line IS NULL ORDER BY id");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        } else {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND done = :done AND dead_line IS NULL ORDER BY id LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND done = :done AND dead_line IS NULL ORDER BY id");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        }
                                    } else {
                                        if ($_GET["status"] == "all") {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line IS NULL ORDER BY task_title LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line IS NULL ORDER BY task_title");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        } else {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND done = :done AND dead_line IS NULL ORDER BY task_title LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND done = :done AND dead_line IS NULL ORDER BY task_title");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        }
                                    }
                                } elseif (strpos($_GET["sort_by"], "desc")) {
                                    $order = substr($_GET["sort_by"], 0, -5);
                                    if ($order == "id") {
                                        if ($_GET["status"] == "all") {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line IS NULL ORDER BY id DESC LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line IS NULL ORDER BY id DESC");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        } else {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line IS NULL AND done = :done ORDER BY id DESC LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line IS NULL AND done = :done ORDER BY id DESC");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        }
                                    } else {
                                        if ($_GET["status"] == "all") {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line IS NULL ORDER BY task_title DESC LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line IS NULL ORDER BY task_title DESC");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        } else {
                                            $stmt = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line IS NULL AND done = :done ORDER BY task_title DESC LIMIT $start_from, $rows_per_page");
                                            $stmt->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            $stmt_2 = $db->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id AND (task_title LIKE :search OR description LIKE :search) AND dead_line IS NULL AND done = :done ORDER BY task_title DESC");
                                            $stmt_2->execute([
                                                ":id" => $_COOKIE["user_id"],
                                                ":search" => "%" . $_GET["q"] . "%",
                                                ":done" => $_GET["status"],
                                            ]);
                                            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
