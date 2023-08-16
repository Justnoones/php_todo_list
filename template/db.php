<?php
require_once "auth.php";
class DB
{
    public $db;
    public function __construct()
    {
        try {
            $this->db = new PDO("mysql:dbname=todo_list;host=localhost", "todo_list_admin", "Wns@0853");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        } catch (Exception $e) {
            die($e->getTrace());
        }
    }

    public function get($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM `users` WHERE `email` = :email");
        $stmt->execute([
            ":email" => $email,
        ]);
        $data = $stmt->fetch();
        return $data;
    }

    public function register()
    {
        require_once "./template/db.php";
        $pdo = new DB;
        if (isset($_SESSION["user_id"])) {
            header("Location: ./index.php");
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['resbtn'])) {
                header("Location: ./index.php");
            } else {
                // validation
                $error = false;
                if (empty($_POST["name"])) {
                    $_SESSION["name_error"] = "Name is required.";
                    $error = true;
                } elseif (strlen($_POST["name"]) <= 3) {
                    $_SESSION["name_error"] = "Name At Least Should Be Four Charachters.";
                    $error = true;
                } else {
                    $_SESSION["old_name"] = $_POST["name"];
                }
                if (empty($_POST["email"])) {
                    $_SESSION["email_error"] = "Email is required.";
                    $error = true;
                } elseif (!str_contains($_POST["email"], "@")) {
                    $_SESSION["email_error"] = "Email must contain '@'.";
                    $error = true;
                } elseif ($this->get($_POST["email"])) {
                    $_SESSION["email_error"] = "Email Has Already Been Taken.";
                    $error = true;
                } else {
                    $_SESSION["old_email"] = $_POST["email"];
                }
                if (empty($_POST["password"])) {
                    $_SESSION["password_error"] = "Password is required.";
                    $error = true;
                } elseif (strlen($_POST["password"]) <= 7) {
                    $_SESSION["password_error"] = "Password At Least Should Be Eight Charachters.";
                    $error = true;
                } elseif ($_POST["password"] != $_POST["confirm_password"]) {
                    $_SESSION["old_password"] = $_POST["password"];
                    $_SESSION["confirm_password_error"] = "Password and comfirm passsword doesn't match please try again.";
                    $error = true;
                } else {
                    $_SESSION["old_password"] = $_POST["password"];
                }
                if (isset($_POST["address"])) {
                    $_SESSION["old_address"] = $_POST["address"];
                }
                if (isset($_POST["gender"])) {
                    $_SESSION["old_gender"] = $_POST["gender"];
                }

                if ($error) {
                    header("Location: ./register.php");
                    return;
                }
                $sql = "INSERT INTO `users` (`name`, `email`, `password`, `address`, `gender`) VALUES
                            (:name, :email, :password, :address, :gender)";
                $stmt = $this->db->prepare($sql);
                $status = $stmt->execute([
                    ":name" => $_POST["name"],
                    ":email" => $_POST["email"],
                    ":password" => password_hash($_POST["password"], PASSWORD_BCRYPT),
                    ":address" => $_POST["address"],
                    ":gender" => $_POST["gender"],
                ]);

                $auth = new Auth();
                $auth->login($this->db->lastInsertId(), $status);
            }
        } else {
            header("Location: ./index.php");
        }
    }

    public function all()
    {
        $auth = new Auth();
        if ($auth->loggedIn()) {
            if (isset($_COOKIE["user_id"])) {
                $stmt = $this->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id");
                $stmt->execute([
                    ":id" => $_COOKIE["user_id"],
                ]);
                $datas = $stmt->fetchAll();
            } else {
                $stmt = $this->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id");
                $stmt->execute([
                    ":id" => $_SESSION["user_id"],
                ]);
                $datas = $stmt->fetchAll();
            }
            return $datas;
        }
    }

    public function latesetOrPaginate($rows)
    {
        $auth = new Auth();
        if ($auth->loggedIn()) {
            if (isset($_GET["page"])) {
                $page = $_GET["page"];
            } else {
                $page = 1;
                $_GET["page"] = null;
            }
            $rows_per_page = $rows;
            $start_from = ($page - 1) * $rows_per_page;
            $id = $_SESSION['user_id'];
            $stmt = $this->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id ORDER BY id desc LIMIT $start_from, $rows_per_page");
            $stmt->execute([
                ":id" => $_COOKIE["user_id"],
            ]);
            $stmt_2 = $this->db->prepare("SELECT * FROM `lists` WHERE `user_id` = :id ORDER BY id desc");
            $stmt_2->execute([
                ":id" => $_COOKIE["user_id"],
            ]);
            return [$stmt->fetchAll(), $stmt_2->fetchAll()];
        }
    }

    public function links($rows_per_page, $ids)
    {
        $_SESSION["rows_per_page"] = $rows_per_page;
        $_SESSION["ids"] = $ids;
        require_once "paginate.php";
    }

    public function totalRows()
    {
        return count($this->all());
    }

    public function store($data)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($data["resbtn"])) {
                header("Location: ./index.php");
            } else {
                $error = false;
                $email_oldvalue = true;
                $description_oldvalue = true;
                if (empty($data["task_title"])) {
                    $_SESSION["task_title_error"] = "Task Title Is Required.";
                    $email_oldvalue = false;
                    $error = true;
                }

                if (empty($data["description"])) {
                    $_SESSION["description_error"] = "Description Is Required.";
                    $description_oldvalue = false;
                    $error = true;
                }

                if ($description_oldvalue) {
                    $_SESSION["old_description"] = $data["description"];
                }

                if ($email_oldvalue) {
                    $_SESSION["old_task_title"] = $data["task_title"];
                }

                if (isset($data["dead_line"])) {
                    $_SESSION["old_dead_line"] = $data["dead_line"];
                }

                if ($error) {
                    header("Location: ./create.php");
                    return;
                }

                $stmt = $this->db->prepare("INSERT INTO lists (`user_id`, `task_title`, `description`, `dead_line`) VALUES
                    (:user_id, :task_title, :description, :dead_line)
                    ");
                $stmt->execute([
                    ":user_id" => $_SESSION["user_id"],
                    ":task_title" => $data["task_title"],
                    ":description" => $data["description"],
                    ":dead_line" => $data["dead_line"] ? $data["dead_line"] : null,
                ]);
                $_SESSION["old_task_title"] = "";
                $_SESSION["old_description"] = "";
                $_SESSION["old_dead_line"] = "";
                $_SESSION["create_success"] = true;
                header("Location: ./index.php");
                return;
            }
        } else {
            header("Location: ./index.php");
        }
    }

    public function update($data)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($data["resbtn"]) {
                header("Location: ./index.php");
                return;
            } else {
                $error = false;
                $email_oldvalue = true;
                $description_oldvalue = true;
                if (empty($data["task_title"])) {
                    $_SESSION["task_title_error"] = "Task Title Is Required.";
                    $email_oldvalue = false;
                    $error = true;
                }

                if (empty($data["description"])) {
                    $_SESSION["description_error"] = "Description Is Required.";
                    $description_oldvalue = false;
                    $error = true;
                }

                if ($description_oldvalue) {
                    $_SESSION["old_description"] = $data["description"];
                }

                if ($email_oldvalue) {
                    $_SESSION["old_task_title"] = $data["task_title"];
                }

                if (isset($data["dead_line"])) {
                    $_SESSION["old_dead_line"] = $data["dead_line"];
                }

                if ($error) {
                    header("Location: ./edit.php?id=" . $data['id']);
                    return;
                }

                $stmt = $this->db->prepare("UPDATE lists
                SET task_title = :task_title,
                    description = :description,
                        dead_line = :dead_line
                        WHERE id = :id AND user_id = :user_id");
                $stmt->execute([
                    ":id" => $data["id"],
                    ":user_id" => $_SESSION["user_id"],
                    ":task_title" => $data["task_title"],
                    ":description" => $data["description"],
                    ":dead_line" => $data["dead_line"] ? $data["dead_line"] : null,
                ]);
                $_SESSION["old_task_title"] = "";
                $_SESSION["old_description"] = "";
                $_SESSION["old_dead_line"] = "";
                $_SESSION["success_update"] = true;
                header("Location: ./index.php");
                return;
            }
        } else {
            header("./index.php");
            return;
        }
    }

    public function updateDone()
    {
        $stmt = $this->db->prepare("UPDATE lists
        SET done = :done, done_at = NOW()
        WHERE id = :id AND :user_id = :user_id");
        $stmt->execute([
            ":done" => $_POST["check"],
            ":id" => $_POST["id"],
            ":user_id" => $_SESSION["user_id"],
        ]);
        return;
    }

    public function destory()
    {
        $stmt = $this->db->prepare("DELETE FROM lists WHERE
        id = :id AND user_id = :user_id");
        $stmt->execute([
            ":id" => $_POST["id"],
            ":user_id" => $_SESSION["user_id"],
        ]);
        return;
    }

    public function search($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM lists WHERE id = :id AND user_id = :user_id");
        $stmt->execute([
            ":id" => $id,
            ":user_id" => $_COOKIE["user_id"],
        ]);
        return $stmt->fetch();
    }

    public function fourExpiredRecords($expect)
    {
        $stmt = $this->db->prepare("SELECT * FROM `lists` WHERE dead_line < NOW() AND user_id = :user_id AND id != :expect ORDER BY id DESC LIMIT 4;");
        $stmt->execute([
            ":user_id" => $_COOKIE["user_id"],
            ":expect" => $expect,
        ]);
        return $stmt->fetchAll();
    }
}
