<?php
session_start();
include_once('../utils.php');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../components/navbar.php'; ?>
    <main class="container my-5">
        <div class="row justify-content-center">
            <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
  				<i class="fa-solid fa-circle-exclamation me-2"></i> <?php echo $_SESSION['error'] ?>
  				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
            <?php } unset($_SESSION['error']); ?>
            <div class="col-md-6">
                <h2 class="text-center mb-4">Регистрация</h2>
                <form action="register_process.php" method="POST" enctype="multipart/form-data">
                    <div class="row mb-3">
                    	<div class="col-sm-6">
                        	<label for="first_name" class="form-label">Имя</label>
                        	<div class="input-group">
                            	<span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                            	<input type="text" class="form-control" id="first_name" name="first_name" required>
                        	</div>
                    	</div>
                        <div class="col-sm-6">
                        	<label for="last_name" class="form-label">Фамилия</label>
                        	<div class="input-group">
                            	<span class="input-group-text"><i class="fa-solid fa-user-tie"></i></span>
                            	<input type="text" class="form-control" id="last_name" name="last_name" required>
                        	</div>
                    	</div>
                    </div>
                    <div class="mb-3">
                        <label for="login" class="form-label">Логин</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-right-to-bracket"></i></span>
                            <input type="text" class="form-control" id="login" name="login" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-purple w-100">Зарегистрироваться</button>
                </form>
                <p class="mt-2">Уже есть аккаунт? <a class="text-purple" href="login.php">Войти</a></p>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>