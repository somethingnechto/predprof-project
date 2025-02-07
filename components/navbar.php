<?php
if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
}

if (isset($_SESSION['user_id'])) {
	$user = get_user_by_id($_SESSION['user_id']);
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-purple">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="/img/logo.png" alt="Лого" width="30" height="30" class="d-inline-block align-text-top me-2">
            Спортивный инвентарь
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="../index.php">Главная</a></li>
                <li class="nav-item"><a class="nav-link" href="../inventory/index.php">Инвентарь</a></li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if (isset($user)) { ?>
                <li class="nav-item d-flex align-items-center">
                    <span class="link-light" style="margin-right: 10px"><?php echo $user['login'] ?></span>
                    <img src="<?php echo $user['photo'] ?>" alt="Фото профиля" width="32" height="32" class="rounded-circle"  style="object-fit: cover;">
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle link-light" href="#" role="button" data-bs-toggle="dropdown"></a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="../profile/index.php">Профиль</a>
                        <?php if ($user['role'] == 1) { ?><a class="dropdown-item" href="../dashboard/index.php">Панель управления</a><?php } ?>
                        <a class="dropdown-item" href="../profile/logout.php">Выйти</a>
                    </div>
                </li>
                <?php } else { ?>
                <li class="nav-item">
                    <a class="btn btn-outline-light" href="../profile/login.php" role="button" >
                    	Вход/регистрация
                	</a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>