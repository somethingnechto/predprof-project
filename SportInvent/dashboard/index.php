<?php
session_start();
include_once('../utils.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../profile/login.php");
    exit;
}

$user = get_user_by_id($_SESSION['user_id']);

if ($user['role'] != 1) {
    header("Location: ../index.php");
    exit;
}

if (!isset($_GET['table'])) {
    $table = 0;
}
else {
    $table = $_GET['table'];
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель управления</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../components/navbar.php'; ?>
    <main class="container-fluid p-0">
        <div class="row m-4">
            <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
  				<i class="fa-solid fa-circle-exclamation me-2"></i> <?php echo $_SESSION['error'] ?>
  				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
            <?php } unset($_SESSION['error']); ?>
            <div class="col p-0">
            	<div class="card p-2 shadow-sm bg-light border-0" style="width: 280px;">
					<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-2 mb-2 text-muted">
                    	<span>Таблицы</span>
                	</h6>
    				<ul class="nav nav-pills flex-column">
      					<li class="nav-item">
        					<a href="index.php?table=0" class="nav-link <?php if ($table == 0) { ?>bg-purple link-light<?php } else { ?>link-body-emphasis<?php } ?>" aria-current="page">
          						<i class="fa-solid fa-user me-2"></i> Пользователи
        					</a>
      					</li>
      					<li>
        					<a href="index.php?table=1" class="nav-link <?php if ($table == 1) { ?>bg-purple link-light<?php } else { ?>link-body-emphasis<?php } ?>">
          						<i class="fa-solid fa-screwdriver-wrench me-2"></i> Предметы
        					</a>
      					</li>
                	</ul>
                	<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-2 text-muted">
                    	<span>Запросы</span>
                	</h6>
                	<ul class="nav nav-pills flex-column mb-auto">
      					<li>
        					<a href="index.php?table=2" class="nav-link <?php if ($table == 2) { ?>bg-purple link-light<?php } else { ?>link-body-emphasis<?php } ?>">
          						<i class="fa-solid fa-envelope me-2"></i> Заявки
        					</a>
      					</li>
      					<li>
        					<a href="index.php?table=3" class="nav-link <?php if ($table == 3) { ?>bg-purple link-light<?php } else { ?>link-body-emphasis<?php } ?>">
          						<i class="fa-solid fa-money-bill me-2"></i> Закупки
        					</a>
      					</li>
    				</ul>
  				</div>
            </div>
            <div class="col-10 p-0">
                <?php if ($table == 0) { 
                $users = get_users(); ?>
                <h3 class="mb-3">Пользователи (<?php echo mysqli_num_rows($users); ?>)</h3>
                <div class="mb-3 overflow-y-scroll" style="max-height: 500px;">
                	<?php while ($user = mysqli_fetch_assoc($users)) { ?>
					<div class="col mb-3">
                    	<div class="card h-100 shadow-sm bg-light border-0">
                        	<div class="ms-2 me-3 my-2 d-flex flex-wrap align-items-center">
                                <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#viewUserPhotoModal-<?php echo $user['id']; ?>">
                           			<img src="<?php echo $user['photo'] ?>" alt="Фото пользователя" width="32" height="32" class="rounded-circle" style="object-fit: cover;">
                                </button>
                        		<div class="ms-2">
                            		<p class="mb-0">
                                    	<strong><?php echo $user['login']; ?> (ID: <?php echo $user['id']; ?>)</strong><br>
                                    	<span class="text-muted"><?php echo role_to_text($user['role']); ?></span>
                                	</p>
                        		</div>
                            	<div class="ms-auto">
                                	<button type="button" class="btn btn-sm btn-purple" data-bs-toggle="modal" data-bs-target="#editUserModal-<?php echo $user['id']; ?>">
                                    	<i class="fa-solid fa-pen"></i>
                                	</button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal-<?php echo $user['id']; ?>">
                                    	<i class="fa-solid fa-trash"></i>
                                	</button>
                            	</div>
                        	</div>
                    	</div>
                	</div>
                    
                	<div class="modal fade" id="editUserModal-<?php echo $user['id']; ?>" tabindex="-1">
                		<div class="modal-dialog modal-dialog-centered">
                    		<div class="modal-content">
                        		<div class="modal-header">
                            		<h5 class="modal-title">Изменение пользователя</h5>
                                	<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            	</div>
                                <form action="update.php?table=<?php echo $table; ?>&id=<?php echo $user['id']; ?>" method="POST" enctype="multipart/form-data">
                            		<div class="modal-body">
                                        <div class="row mb-3">
                                        	<div class="col-sm-6">
                        						<label for="first_name-<?php echo $user['id']; ?>" class="form-label">Имя</label>
                        						<div class="input-group">
                            						<span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                            						<input type="text" class="form-control" id="first_name-<?php echo $user['id']; ?>" name="first_name" value="<?php echo $user['first_name']; ?>" required>
                        						</div>
                    						</div>
                                            <div class="col-sm-6">
                        						<label for="last_name-<?php echo $user['id']; ?>" class="form-label">Фамилия</label>
                        						<div class="input-group">
                            						<span class="input-group-text"><i class="fa-solid fa-user-tie"></i></span>
                            						<input type="text" class="form-control" id="last_name-<?php echo $user['id']; ?>" name="last_name" value="<?php echo $user['last_name']; ?>" required>
                        						</div>
                    						</div>
                                        </div>
                                        <div class="mb-3">
                        					<label for="login-<?php echo $user['id']; ?>" class="form-label">Логин</label>
                        					<div class="input-group">
                            					<span class="input-group-text"><i class="fa-solid fa-right-to-bracket"></i></span>
                            					<input type="text" class="form-control" id="login-<?php echo $user['id']; ?>" name="login" value="<?php echo $user['login']; ?>" required>
                        					</div>
                    					</div>
                                    	<div class="mb-3">
                                        	<label for="role-<?php echo $user['id']; ?>" class="form-label">Роль</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-gears"></i></span>
                                        		<select class="form-select" id="role-<?php echo $user['id']; ?>" name="role">
                                        			<option value="0" <?php if ($user['role'] == 0) echo 'selected'; ?>>Пользователь</option>
                                            		<option value="1" <?php if ($user['role'] == 1) echo 'selected'; ?>>Администратор</option>
                                        		</select>
                                            </div>
                                    	</div>
                                        <div class="mb-3">
                        					<label for="photo-<?php echo $user['id']; ?>" class="form-label">Фото пользователя</label>
                        					<input type="file" class="form-control" id="photo-<?php echo $user['id']; ?>" name="photo">
                    					</div>
                            		</div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-purple">
                                    		<i class="fa-solid fa-floppy-disk me-2"></i> Сохранить
                                    	</button>
                                    </div>
                                </form>
                        	</div>
                    	</div>
                	</div>
                        
                    <div class="modal fade" id="deleteUserModal-<?php echo $user['id']; ?>" tabindex="-1">
                		<div class="modal-dialog modal-dialog-centered">
                    		<div class="modal-content">
                        		<div class="modal-header">
                            		<h5 class="modal-title">Удаление пользователя</h5>
                                	<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            	</div>
                                <div class="modal-body">
                                    <p>
                                        Вы действительно хотите удалить пользователя <?php echo $user['login'] ?>?<br>
                                        Это действие нельзя отменить
                                    </p>
                            	</div>
                                <div class="modal-footer">
                                	<a href="delete.php?table=<?php echo $table; ?>&id=<?php echo $user['id']; ?>" class="btn btn-danger">
                                    	<i class="fa-solid fa-trash me-2"></i> Удалить
                                    </a>
                                </div>
                        	</div>
                    	</div>
                	</div>
                        
                    <div class="modal fade" id="viewUserPhotoModal-<?php echo $user['id']; ?>" tabindex="-1">
                		<div class="modal-dialog modal-dialog-centered">
                    		<div class="modal-content">
                        		<div class="modal-header">
                            		<h5 class="modal-title">Просмотр фото пользователя</h5>
                                	<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            	</div>
                            	<div class="modal-body">
                                	<img src="<?php echo $user['photo']; ?>" alt="Фото пользователя" class="rounded mx-auto d-block" width="300" height="300" style="object-fit: cover;">
                            	</div>
                       		</div>
                    	</div>
                	</div>
                	<?php } ?>
                </div>
                
                <button type="button" class="btn btn-purple" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fa-solid fa-plus me-2"></i> Добавить
                </button>

                <div class="modal fade" id="addUserModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Добавление пользователя</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="add.php?table=<?php echo $table; ?>" method="POST" enctype="multipart/form-data">
                            	<div class="modal-body">
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
                            				<input type="text" class="form-control" id="password" name="password" required>
                        				</div>
                    				</div>
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Роль</label>
                                        <div class="input-group">
                                        	<span class="input-group-text"><i class="fa-solid fa-gears"></i></span>
                                        	<select class="form-select" id="role" name="role">
                                            	<option value="0">Пользователь</option>
                                            	<option value="1">Администратор</option>
                                        	</select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                        				<label for="photo" class="form-label">Фото пользователя</label>
                        				<input type="file" class="form-control" id="photo" name="photo">
                    				</div>
                            	</div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-purple">
                                        <i class="fa-solid fa-plus me-2"></i> Добавить
                                    </button>
                                </div>
                        	</form>
                        </div>
                    </div>
                </div>
                <?php } else if ($table == 1) {
                $items = get_items(); ?>
                <h3 class="mb-3">Предметы (<?php echo mysqli_num_rows($items); ?>)</h3>
                <div class="mb-3 overflow-y-scroll" style="max-height: 500px;">
                    <?php while ($item = mysqli_fetch_assoc($items)) { ?>
                	<div class="col mb-3">
                    	<div class="card h-100 shadow-sm bg-light border-0">
                        	<div class="ms-2 me-3 my-2 d-flex flex-wrap align-items-center">
                                <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#viewItemPhotoModal-<?php echo $item['id']; ?>">
                           			<img src="<?php echo $item['photo'] ?>" alt="Фото предмета" class="rounded" width="96" height="64" style="object-fit: cover;">
                                </button>
                        		<div class="ms-2">
                            		<p class="mb-0">
                                    	<strong><?php echo $item['name']; ?> (ID: <?php echo $item['id']; ?>)</strong>
                                    	<?php if ($item['state'] > 0) { ?><span class="badge <?php echo $item['state'] == 3 ? 'bg-danger' : ($item['state'] == 2 ? 'bg-warning' : 'bg-success') ?>"><?php echo state_to_text($item['state']); ?></span><?php } ?>
										<span class="badge <?php echo $item['amount'] == 0 ? 'bg-danger' : ($item['amount'] <= 3 ? 'bg-warning' : 'bg-success') ?>">В наличии: <?php echo $item['amount']; ?> шт.</span><br>
                                        <span class="text-muted"><?php echo $item['description']; ?></span>
                                	</p>
                        		</div>
                            	<div class="ms-auto">
                                	<button type="button" class="btn btn-sm btn-purple" data-bs-toggle="modal" data-bs-target="#editItemModal-<?php echo $item['id']; ?>">
                                    	<i class="fa-solid fa-pen"></i>
                                	</button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteItemModal-<?php echo $item['id']; ?>">
                                    	<i class="fa-solid fa-trash"></i>
                                	</button>
                            	</div>
                        	</div>
                    	</div>
                	</div>
                        
                    <div class="modal fade" id="editItemModal-<?php echo $item['id']; ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                        	<div class="modal-content">
                            	<div class="modal-header">
                                	<h5 class="modal-title">Изменение предмета</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="update.php?table=<?php echo $table; ?>&id=<?php echo $item['id']; ?>" method="POST" enctype="multipart/form-data">
                                	<div class="modal-body">
                                    	<div class="mb-3">
                                        	<label for="name-<?php echo $item['id']; ?>" class="form-label">Название</label>
                                            <div class="input-group">
                            					<span class="input-group-text"><i class="fa-solid fa-pen"></i></span>
                                            	<input type="text" class="form-control" id="name-<?php echo $item['id']; ?>" name="name" value="<?php echo $item['name']; ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                        	<label for="description-<?php echo $item['id']; ?>" class="form-label">Описание</label>
                                        	<textarea class="form-control" id="description-<?php echo $item['id']; ?>" name="description" cols="40" rows="5" style="resize: none;"><?php echo $item['description']; ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                        	<label for="type-<?php echo $item['id']; ?>" class="form-label">Тип</label>
                                               <div class="input-group">
                            					<span class="input-group-text"><i class="fa-solid fa-pen-fancy"></i></span>
                                            	<select class="form-select" id="type-<?php echo $item['id']; ?>" name="type">
                                                	<option value="0" <?php if ($item['type'] == 0) echo 'selected'; ?>>Не указано</option>
                                					<option value="1" <?php if ($item['type'] == 1) echo 'selected'; ?>>Мячи</option>
                                					<option value="2" <?php if ($item['type'] == 2) echo 'selected'; ?>>Ракетки</option>
                                    				<option value="3" <?php if ($item['type'] == 3) echo 'selected'; ?>>Скакалки</option>
                                    				<option value="4" <?php if ($item['type'] == 4) echo 'selected'; ?>>Обручи</option>
                                    				<option value="5" <?php if ($item['type'] == 5) echo 'selected'; ?>>Штанги</option>  
                                    				<option value="6" <?php if ($item['type'] == 6) echo 'selected'; ?>>Блины</option>
                                    				<option value="7" <?php if ($item['type'] == 7) echo 'selected'; ?>>Перчатки</option>
                                    				<option value="8" <?php if ($item['type'] == 8) echo 'selected'; ?>>Кроссовки</option>
                                   					<option value="9" <?php if ($item['type'] == 9) echo 'selected'; ?>>Коньки</option>
                                    				<option value="10" <?php if ($item['type'] == 10) echo 'selected'; ?>>Лыжи</option>
                                    				<option value="11" <?php if ($item['type'] == 11) echo 'selected'; ?>>Коврики и маты</option>
                                            	</select>
                                            </div>
                                        </div>   
                                        <div class="mb-3">
                                        	<label for="sport-<?php echo $item['id']; ?>" class="form-label">Спорт</label>
                                            <div class="input-group">
                            					<span class="input-group-text"><i class="fa-solid fa-football"></i></span>
                                            	<select class="form-select" id="sport-<?php echo $item['id']; ?>" name="sport">
                                                	<option value="0" <?php if ($item['sport'] == 0) echo 'selected'; ?>>Не указано</option>
                                					<option value="1" <?php if ($item['sport'] == 1) echo 'selected'; ?>>Футбол</option>
                                					<option value="2" <?php if ($item['sport'] == 2) echo 'selected'; ?>>Волейбол</option>
                                    				<option value="3" <?php if ($item['sport'] == 3) echo 'selected'; ?>>Баскетбол</option>
                                    				<option value="4" <?php if ($item['sport'] == 4) echo 'selected'; ?>>Ледовый спорт</option>
                                    				<option value="5" <?php if ($item['sport'] == 5) echo 'selected'; ?>>Лыжный спорт</option>
                                    				<option value="6" <?php if ($item['sport'] == 6) echo 'selected'; ?>>Теннис</option>
                                    				<option value="7" <?php if ($item['sport'] == 7) echo 'selected'; ?>>Лёгкая атлетика</option>
                                    				<option value="8" <?php if ($item['sport'] == 8) echo 'selected'; ?>>Боевые искусства</option>
                                            	</select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-8">
                                        		<label for="state-<?php echo $item['id']; ?>" class="form-label">Состояние</label>
                                            	<div class="input-group">
                            						<span class="input-group-text"><i class="fa-solid fa-sliders"></i></span>
                                            		<select class="form-select" id="state-<?php echo $item['id']; ?>" name="state">
                                                    	<option value="0" <?php if ($item['state'] == 0) echo 'selected'; ?>>Не задано</option>
                                                    	<option value="1" <?php if ($item['state'] == 1) echo 'selected'; ?>>Новый</option>
                                            			<option value="2" <?php if ($item['state'] == 2) echo 'selected'; ?>>Б/у</option>
                                                		<option value="3" <?php if ($item['state'] == 3) echo 'selected'; ?>>Повреждённый</option>
                                            		</select>
                                            	</div>
                                        	</div>
                                        	<div class="col-sm-4">
                                        		<label for="amount-<?php echo $item['id']; ?>" class="form-label">Количество</label>
                                            	<div class="input-group">
                            						<span class="input-group-text"><i class="fa-solid fa-tag"></i></span>
                                            		<input type="number" class="form-control" id="amount-<?php echo $item['id']; ?>" name="amount" value="<?php echo $item['amount']; ?>">
                                            	</div>
                                        	</div>
                                        </div>
                                        <div class="mb-3">
                        					<label for="photo-<?php echo $item['id']; ?>" class="form-label">Фото предмета</label>
                        					<input type="file" class="form-control" id="photo-<?php echo $item['id']; ?>" name="photo">
                    					</div>
                                	</div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-purple">
                                    		<i class="fa-solid fa-floppy-disk me-2"></i> Сохранить
                                    	</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                        
                    <div class="modal fade" id="deleteItemModal-<?php echo $item['id']; ?>" tabindex="-1">
                		<div class="modal-dialog modal-dialog-centered">
                    		<div class="modal-content">
                        		<div class="modal-header">
                            		<h5 class="modal-title">Удаление предмета</h5>
                                	<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            	</div>
                                <div class="modal-body">
                                    <p>
                                        Вы действительно хотите удалить предмет <?php echo $item['name'] ?>?<br>
                                        Это действие нельзя отменить
                                    </p>
                            	</div>
                                <div class="modal-footer">
                                	<a href="delete.php?table=<?php echo $table; ?>&id=<?php echo $item['id']; ?>" class="btn btn-danger">
                                    	<i class="fa-solid fa-trash me-2"></i> Удалить
                                    </a>
                                </div>
                        	</div>
                    	</div>
                	</div>
                        
                    <div class="modal fade" id="viewItemPhotoModal-<?php echo $item['id']; ?>" tabindex="-1">
                		<div class="modal-dialog modal-dialog-centered">
                    		<div class="modal-content">
                        		<div class="modal-header">
                            		<h5 class="modal-title">Просмотр фото предмета</h5>
                                	<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            	</div>
                            	<div class="modal-body">
                                	<img src="<?php echo $item['photo']; ?>" alt="Фото предмета" class="rounded mx-auto d-block" width="384" height="256" style="object-fit: cover;">
                            	</div>
                       		</div>
                    	</div>
                	</div>
                    <?php } ?>
                </div>
                
                <button type="button" class="btn btn-purple" data-bs-toggle="modal" data-bs-target="#addItemModal">
                    <i class="fa-solid fa-plus me-2"></i> Добавить
                </button>

                <div class="modal fade" id="addItemModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Добавление предмета</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="add.php?table=<?php echo $table; ?>" method="POST" enctype="multipart/form-data">
                            	<div class="modal-body">
                                    <div class="mb-3">
                                    	<label for="name" class="form-label">Название</label>
                                        <div class="input-group">
                            				<span class="input-group-text"><i class="fa-solid fa-pen"></i></span>
                                        	<input type="text" class="form-control" id="name" name="name">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Описание</label>
                                        <textarea class="form-control" id="description" name="description" cols="40" rows="5" style="resize: none;"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="type" class="form-label">Тип</label>
                                        <div class="input-group">
                            				<span class="input-group-text"><i class="fa-solid fa-pen-fancy"></i></span>
                                            <select class="form-select" id="type" name="type">
                                                <option value="0">Не указано</option>
                                				<option value="1">Мячи</option>
                                				<option value="2">Ракетки</option>
                                    			<option value="3">Скакалки</option>
                                    			<option value="4">Обручи</option>
                                    			<option value="5">Штанги</option>  
                                    			<option value="6">Блины</option>
                                    			<option value="7">Перчатки</option>
                                    			<option value="8">Кроссовки</option>
                                   				<option value="9">Коньки</option>
                                    			<option value="10">Лыжи</option>
                                    			<option value="11">Коврики и маты</option>
                                            </select>
                                        </div>
                                    </div>   
                                    <div class="mb-3">
                                        <label for="sport" class="form-label">Спорт</label>
                                        <div class="input-group">
                            				<span class="input-group-text"><i class="fa-solid fa-football"></i></span>
                                            <select class="form-select" id="sport" name="sport">
                                                <option value="0">Не указано</option>
                                				<option value="1">Футбол</option>
                                				<option value="2">Волейбол</option>
                                    			<option value="3">Баскетбол</option>
                                    			<option value="4">Ледовый спорт</option>
                                    			<option value="5">Лыжный спорт</option>
                                    			<option value="6">Теннис</option>
                                    			<option value="7">Лёгкая атлетика</option>
                                    			<option value="8">Боевые искусства</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-8">
                                        	<label for="state" class="form-label">Состояние</label>
                                        	<div class="input-group">
                            					<span class="input-group-text"><i class="fa-solid fa-sliders"></i></span>
                                        		<select class="form-select" id="state" name="state">
                                                	<option value="0">Не задано</option>
                                            		<option value="1">Новый</option>
                                                	<option value="2">Б/у</option>
                                                	<option value="3">Повреждённый</option>	
                                        		</select>
                                        	</div>
                                    	</div>
                                        <div class="col-sm-4">
                                        	<label for="amount" class="form-label">Количество</label>
                                        	<div class="input-group">
                            					<span class="input-group-text"><i class="fa-solid fa-tag"></i></span>
                                        		<input type="number" class="form-control" id="amount" name="amount">
                                        	</div>
                                    	</div>
                                    </div>
                                    <div class="mb-3">
                        				<label for="photo" class="form-label">Фото предмета</label>
                        				<input type="file" class="form-control" id="photo" name="photo">
                    				</div>
                            	</div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-purple">
                                        <i class="fa-solid fa-plus me-2"></i> Добавить
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php } else if ($table == 2) {
                $requests = get_requests(); ?>
                <h3 class="mb-3">Заявки (<?php echo mysqli_num_rows($requests); ?>)</h3>
                <div class="mb-3 overflow-y-scroll" style="max-height: 500px;">
                    <?php while ($req = mysqli_fetch_assoc($requests)) { ?>
                	<div class="col mb-3">
                    	<div class="card h-100 shadow-sm bg-light border-0">
                        	<div class="ms-2 me-3 my-2 d-flex flex-wrap align-items-center">
                                <?php $req_user = get_user_by_id($req['user_id']);
                                $req_item = get_item_by_id($req['item_id']); ?>
                        		<div class="ms-2">
                            		<p class="mb-0">
                                    	<strong>Заявка <?php echo $req['id']; ?> (Пользователь: <?php echo $req_user['login'] ?>)</strong>
										<span class="badge <?php echo $req['status'] == 0 ? 'bg-danger' : ($req['status'] == 1 ? 'bg-warning' : 'bg-success') ?>"><?php echo status_to_text($req['status']); ?></span><br>
                                        <span class="text-muted">Дата создания: <?php echo $req['date']; ?></span><br>
                                        <span class="text-muted">Предметы: <?php echo $req_item['name']; ?> (ID: <?php echo $req_item['id']; ?>) - <?php echo $req['amount']; ?> шт.</span>
                                	</p>
                        		</div>
                            	<div class="ms-auto">
                                    <button type="button" class="btn btn-sm btn-purple" data-bs-toggle="modal" data-bs-target="#viewRequestModal-<?php echo $req['id']; ?>">
                                    	<i class="fa-solid fa-eye"></i>
                                	</button>
                                    <?php if ($req['status'] == 1) { ?>
                                	<button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#acceptRequestModal-<?php echo $req['id']; ?>">
                                    	<i class="fa-solid fa-check"></i>
                                	</button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectRequestModal-<?php echo $req['id']; ?>">
                                    	<i class="fa-solid fa-xmark"></i>
                                	</button>
                                    <?php } else { ?>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteRequestModal-<?php echo $req['id']; ?>">
                                    	<i class="fa-solid fa-trash"></i>
                                	</button>
                                    <?php } ?>
                            	</div>
                        	</div>
                    	</div>
                	</div>
                        
                    <div class="modal fade" id="viewRequestModal-<?php echo $req['id']; ?>" tabindex="-1">
                		<div class="modal-dialog modal-dialog-centered">
                    		<div class="modal-content">
                        		<div class="modal-header">
                            		<h5 class="modal-title">Просмотр заявки</h5>
                                	<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            	</div>
                                <div class="modal-body">
                                    <p><?php echo $req['comment'] ?></p>
                            	</div>
                        	</div>
                    	</div>
                	</div>
                        
                    <div class="modal fade" id="acceptRequestModal-<?php echo $req['id']; ?>" tabindex="-1">
                		<div class="modal-dialog modal-dialog-centered">
                    		<div class="modal-content">
                        		<div class="modal-header">
                            		<h5 class="modal-title">Подтверждение заявки</h5>
                                	<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            	</div>
                                <form action="update.php?table=<?php echo $table; ?>&id=<?php echo $req['id']; ?>" method="POST">
                                    <input type="hidden" name="status" value="2">
                                	<div class="modal-body">
                                    	<p>
                                        	Вы действительно хотите подтвердить заявку <?php echo $req['id'] ?>?
                                    	</p>
                            		</div>
                                	<div class="modal-footer">
                                        <button type="submit" class="btn btn-success">
                                        	<i class="fa-solid fa-check me-2"></i> Подтвердить
                                    	</button>
                                	</div>
                                </form>
                        	</div>
                    	</div>
                	</div>
                        
                    <div class="modal fade" id="rejectRequestModal-<?php echo $req['id']; ?>" tabindex="-1">
                		<div class="modal-dialog modal-dialog-centered">
                    		<div class="modal-content">
                        		<div class="modal-header">
                            		<h5 class="modal-title">Отклонение заявки</h5>
                                	<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            	</div>
                                <form action="update.php?table=<?php echo $table; ?>&id=<?php echo $req['id']; ?>" method="POST">
                                    <input type="hidden" name="status" value="0">
                                	<div class="modal-body">
                                    	<p>
                                        	Вы действительно хотите отклонить заявку <?php echo $req['id'] ?>?
                                    	</p>
                            		</div>
                                	<div class="modal-footer">
                                        <button type="submit" class="btn btn-danger">
                                        	<i class="fa-solid fa-xmark me-2"></i> Отклонить
                                    	</button>
                                	</div>
                                </form>
                        	</div>
                    	</div>
                	</div>
                        
                    <div class="modal fade" id="deleteRequestModal-<?php echo $req['id']; ?>" tabindex="-1">
                		<div class="modal-dialog modal-dialog-centered">
                    		<div class="modal-content">
                        		<div class="modal-header">
                            		<h5 class="modal-title">Удаление заявки</h5>
                                	<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            	</div>
                                <div class="modal-body">
                                    <p>
                                        Вы действительно хотите удалить заявку <?php echo $req['id'] ?>?<br>
                                        Это действие нельзя отменить
                                    </p>
                            	</div>
                                <div class="modal-footer">
                                	<a href="delete.php?table=<?php echo $table; ?>&id=<?php echo $req['id']; ?>" class="btn btn-danger">
                                    	<i class="fa-solid fa-trash me-2"></i> Удалить
                                    </a>
                                </div>
                        	</div>
                    	</div>
                	</div>
                    <?php } ?>
                </div>
                <?php } else if ($table == 3) {
                $orders = get_orders(); ?>
                <h3 class="mb-3">Планируемые закупки (<?php echo mysqli_num_rows($orders); ?>)</h3>
                <div class="mb-3 overflow-y-scroll" style="max-height: 500px;">
                    <?php while ($order = mysqli_fetch_assoc($orders)) { ?>
                	<div class="col mb-3">
                    	<div class="card h-100 shadow-sm bg-light border-0">
                        	<div class="ms-2 me-3 my-2 d-flex flex-wrap align-items-center">
                        		<div class="ms-2">
                            		<p class="mb-0">
                                    	<strong>Закупка <?php echo $order['id']; ?></strong><br>
                                        <span class="text-muted">Дата создания: <?php echo $order['date']; ?></span><br>
                                        <span class="text-muted">Бюджет: <?php echo $order['budget']; ?>₽</span>
                                	</p>
                        		</div>
                            	<div class="ms-auto">
                                    <button type="button" class="btn btn-sm btn-purple" data-bs-toggle="modal" data-bs-target="#viewOrderModal-<?php echo $order['id']; ?>">
                                    	<i class="fa-solid fa-eye"></i>
                                	</button>
                                    <button type="button" class="btn btn-sm btn-purple" data-bs-toggle="modal" data-bs-target="#editOrderModal-<?php echo $order['id']; ?>">
                                    	<i class="fa-solid fa-pen"></i>
                                	</button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteOrderModal-<?php echo $order['id']; ?>">
                                    	<i class="fa-solid fa-trash"></i>
                                	</button>
                            	</div>
                        	</div>
                    	</div>
                	</div>
                        
                    <div class="modal fade" id="viewOrderModal-<?php echo $order['id']; ?>" tabindex="-1">
                		<div class="modal-dialog modal-dialog-centered">
                    		<div class="modal-content">
                        		<div class="modal-header">
                            		<h5 class="modal-title">Просмотр закупки</h5>
                                	<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            	</div>
                                <div class="modal-body">
                                    <p><?php echo $order['data'] ?></p>
                            	</div>
                        	</div>
                    	</div>
                	</div>
                        
                    <div class="modal fade" id="editOrderModal-<?php echo $order['id']; ?>" tabindex="-1">
                    	<div class="modal-dialog modal-dialog-centered">
                        	<div class="modal-content">
                            	<div class="modal-header">
                                	<h5 class="modal-title">Изменение закупки</h5>
                                	<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            	</div>
                            	<form action="update.php?table=<?php echo $table; ?>&id=<?php echo $order['id']; ?>" method="POST">
                            		<div class="modal-body">
                                    	<div class="mb-3">
                                        	<label for="data-<?php echo $order['id']; ?>" class="form-label">Данные</label>
                                        	<textarea class="form-control" id="data-<?php echo $order['id']; ?>" name="data" cols="40" rows="5" style="resize: none;"><?php echo $order['data']; ?></textarea>
                                    	</div>
                                    	<div class="mb-3">
                                        	<label for="budget-<?php echo $order['id']; ?>" class="form-label">Бюджет</label>
                                        	<div class="input-group">
                            					<span class="input-group-text"><i class="fa-solid fa-tag"></i></span>
                                        		<input type="number" class="form-control" id="budget-<?php echo $order['id']; ?>" name="budget" value="<?php echo $order['budget']; ?>">
                                        	</div>
                                    	</div>
                            		</div>
                                	<div class="modal-footer">
                                        <button type="submit" class="btn btn-purple">
                                    		<i class="fa-solid fa-floppy-disk me-2"></i> Сохранить
                                    	</button>
                                    </div>
                            	</form>
                        	</div>
                    	</div>
                	</div>
                        
                    <div class="modal fade" id="deleteOrderModal-<?php echo $order['id']; ?>" tabindex="-1">
                		<div class="modal-dialog modal-dialog-centered">
                    		<div class="modal-content">
                        		<div class="modal-header">
                            		<h5 class="modal-title">Удаление закупки</h5>
                                	<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            	</div>
                                <div class="modal-body">
                                    <p>
                                        Вы действительно хотите удалить закупку <?php echo $order['id'] ?>?<br>
                                        Это действие нельзя отменить
                                    </p>
                            	</div>
                                <div class="modal-footer">
                                	<a href="delete.php?table=<?php echo $table; ?>&id=<?php echo $order['id']; ?>" class="btn btn-danger">
                                    	<i class="fa-solid fa-trash me-2"></i> Удалить
                                    </a>
                                </div>
                        	</div>
                    	</div>
                	</div>
                    <?php } ?>
                </div>
                
                <button type="button" class="btn btn-purple" data-bs-toggle="modal" data-bs-target="#addOrderModal">
                    <i class="fa-solid fa-plus me-2"></i> Добавить
                </button>

                <div class="modal fade" id="addOrderModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Добавление закупки</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="add.php?table=<?php echo $table; ?>" method="POST">
                            	<div class="modal-body">
                                    <div class="mb-3">
                                        <label for="data" class="form-label">Данные</label>
                                        <textarea class="form-control" id="data" name="data" cols="40" rows="5" style="resize: none;"></textarea>
                                    </div>
                                        
                                    <div class="mb-3">
                                        <label for="budget" class="form-label">Бюджет</label>
                                        <div class="input-group">
                            				<span class="input-group-text"><i class="fa-solid fa-tag"></i></span>
                                        	<input type="number" class="form-control" id="budget" name="budget">
                                        </div>
                                    </div>
                            	</div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-purple">
                                        <i class="fa-solid fa-plus me-2"></i> Добавить
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>