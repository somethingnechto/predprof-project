<?php
session_start();
include_once('../utils.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user = get_user_by_id($_SESSION['user_id']);
if (!$user) {
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../components/navbar.php'; ?>
    <main class="container my-5">
        <div class="row">
            <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
  				<i class="fa-solid fa-circle-exclamation me-2"></i> <?php echo $_SESSION['error'] ?>
  				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
            <?php } unset($_SESSION['error']); ?>
            <div class="col-md-6">
                <h3>Мой профиль</h3>
                <div class="card p-4 text-center shadow-sm bg-light border-0">
                    <button class="btn mb-2" data-bs-toggle="modal" data-bs-target="#viewProfilePhotoModal">
                    	<img src="<?php echo $user['photo']; ?>" alt="Фото профиля" class="rounded-circle m-1 mx-auto" width="150" height="150" style="object-fit: cover;">
                    </button>
                    <h3 class="mb-1"><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></h3>
                    <h6 class="text-muted"><?php echo role_to_text($user['role']); ?></h6>

                    <div class="row mt-4">
                        <div class="col">
                        	<button class="btn btn-purple w-100" data-bs-toggle="modal" data-bs-target="#editProfileModal"><i class="fa-solid fa-pen me-2"></i> Редактировать</button>
                        </div>
						<div class="col">
                        	<button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteProfileModal"><i class="fa-solid fa-trash me-2"></i> Удалить</button>
                        </div>
                    </div>
                </div>
                
                <div class="modal fade" id="editProfileModal" tabindex="-1">
        			<div class="modal-dialog modal-dialog-centered">
            			<div class="modal-content">
                			<div class="modal-header">
                    			<h5 class="modal-title">Изменение профиля</h5>
                    			<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                			</div>
                			<form action="update.php" method="POST" enctype="multipart/form-data">
                				<div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                        					<label for="first_name" class="form-label">Имя</label>
                        					<div class="input-group">
                            					<span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                            					<input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user['first_name']; ?>" required>
                        					</div>
                    					</div>
                                        <div class="col-sm-6">
                        					<label for="last_name" class="form-label">Фамилия</label>
                        					<div class="input-group">
                            					<span class="input-group-text"><i class="fa-solid fa-user-tie"></i></span>
                            					<input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user['last_name']; ?>" required>
                        					</div>
                    					</div>
                                    </div>
                        			<div class="mb-3">
                            			<label for="photo" class="form-label">Аватар</label>
                            			<input type="file" class="form-control" id="photo" name="photo">
                        			</div>
                				</div>
                    			<div class="modal-footer">
                        			<button type="submit" class="btn btn-purple"><i class="fa-solid fa-floppy-disk me-2"></i> Сохранить</button>
                    			</div>
                			</form>
            			</div>
        			</div>
    			</div>
                    
                <div class="modal fade" id="deleteProfileModal" tabindex="-1">
                	<div class="modal-dialog modal-dialog-centered">
                    	<div class="modal-content">
                        	<div class="modal-header">
                            	<h5 class="modal-title">Удаление профиля</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>
                                	Вы действительно хотите удалить ваш профиль?<br>
                                    Это действие нельзя отменить
                                </p>
                            </div>
                            <div class="modal-footer">
                                <a href="delete.php" class="btn btn-danger">
                                    <i class="fa-solid fa-trash me-2"></i> Удалить
                                </a>
                            </div>
                       	</div>
                    </div>
                </div>
                    
                <div class="modal fade" id="viewProfilePhotoModal" tabindex="-1">
                	<div class="modal-dialog modal-dialog-centered">
                    	<div class="modal-content">
                        	<div class="modal-header">
                            	<h5 class="modal-title">Просмотр фото профиля</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <img src="<?php echo $user['photo']; ?>" alt="Фото профиля" class="rounded mx-auto d-block" width="300" height="300" style="object-fit: cover;">
                            </div>
                       	</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <?php $requests = get_user_requests($user['id']); ?>
                <h3>Мои заявки (<?php echo mysqli_num_rows($requests); ?>)</h3>
                <div class="mb-3 overflow-y-scroll" style="max-height: 500px;">
                	<?php while ($req = mysqli_fetch_assoc($requests)) { ?>
                	<div class="col mb-4">
                    	<div class="card h-100 shadow-sm bg-light border-0">
                        	<div class="card-body">
                                <?php $req_user = get_user_by_id($req['user_id']);
                                $req_item = get_item_by_id($req['item_id']); ?>
                                <div class="card-title">
                                    <strong>Заявка <?php echo $req['id'] ?></strong>
                                    <span class="badge <?php echo $req['status'] == 0 ? 'bg-danger' : ($req['status'] == 1 ? 'bg-warning' : 'bg-success') ?>"><?php echo status_to_text($req['status']); ?></span>
                                </div>
                                <h6 class="card-subtitle mb-2 text-muted">Дата создания: <?php echo $req['date'] ?></h6>
                            	<p class="card-text">
                                	<?php echo $req_item['name']; ?> - <?php echo $req['amount']; ?> шт.
                            	</p>
                        	</div>
                    	</div>
                	</div>
                	<?php } ?>
            	</div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>