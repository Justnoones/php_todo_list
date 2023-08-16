    <header>
        <nav class="navbar navbar-expand-sm top-fixed">
            <div class="container-fluid">
                <div class="navbar-brand">
                    <a href="index.php" class="d-flex hmnav">
                        <h1 class="h4 fw-bold my-auto text-uppercase text-light d-none d-lg-flex hm">T o d o</h1>
                        <img src="./assets/images/logo.png" alt="logo" width="100px" height="50px" class="mx-2" />
                        <h1 class="h4 fw-bold my-auto text-uppercase text-light d-none d-lg-flex hm">L i s t s</h1>
                    </a>
                </div>
                <div>
                </div>
                <div class=" justify-content-end" id="nav">
                    <div class="navbar-nav">
                        <?php if (isset($_COOKIE["user_id"]) || isset($_SESSION["user_id"])): ?>
                        <li class="nav-item mx-lg-5 my-lg-auto d-lg-inline d-none"><a href="create.php"
                                class="nav-link text-light fw-bold text-uppercase"><span
                                    class="hov pb-2 px-1 <?php if (strpos($_SERVER['REQUEST_URI'], "create.php")) {echo "active";}?>">A
                                    d d <span class="mx-1"></span> N e w</span></a></li>
                        <li class="nav-item mx-lg-5 my-lg-auto d-lg-inline d-none"><a href="index.php"
                                class="nav-link text-light fw-bold text-uppercase"><span
                                    class="hov pb-2 px-1 <?php if (strpos($_SERVER['REQUEST_URI'], "index.php")) {echo "active";}?>">L
                                    i s t s</span></span></span></a></li>
                        <?php endif?>
                        <li class="nav-item mx-lg-5 my-lg-auto">
                            <div class="dropdown btn-group me-lg-3 me-5 ">
                                <?php if (isset($_COOKIE["user_id"]) || isset($_SESSION["user_id"])): ?>
                                <a href="logout.php" class="btn btn-outline-warning my-auto fw-bold" href="#">L o g o u
                                    t</a>
                                <?php else: ?>
                                <a href="login.php" class="btn btn-outline-warning my-auto fw-bold" href="#">L o g i
                                    n</a>
                                <?php endif;?>
                                <button class="btn btn-outline-warning " data-bs-toggle="dropdown"><i
                                        class="fas fa-chevron-circle-down"></i></button>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <?php if (isset($_COOKIE["user_id"]) || isset($_SESSION["user_id"])): ?>
                                    <li><a href="create.php" class="dropdown-item">Add New</a></li>
                                    <li><a href="index.php" class="dropdown-item">Lists</a></li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                    <?php else: ?>
                                    <li><a class="dropdown-item" href="login.php">Login</a></li>
                                    <li><a class="dropdown-item" href="register.php">Sign Up</a></li>
                                    <?php endif;?>
                                </ul>
                            </div>
                        </li>
                    </div>
                </div>
            </div>
        </nav>
    </header>