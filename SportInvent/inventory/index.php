<?php 
session_start();
include_once('../utils.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: /profile/login.php");
    exit;
}

$search = isset($_POST['search']) ? sanitize(mysqli_real_escape_string($db, $_POST['search'])) : '';
$state = isset($_POST['state']) ? sanitize(mysqli_real_escape_string($db, $_POST['state'])) : 0;
$amount = isset($_POST['amount']) ? sanitize(mysqli_real_escape_string($db, $_POST['amount'])) : 0;
$type = isset($_POST['type']) ? sanitize(mysqli_real_escape_string($db, $_POST['type'])) : 0;
$sport = isset($_POST['sport']) ? sanitize(mysqli_real_escape_string($db, $_POST['sport'])) : 0;

$items = get_items();
$filtered_items = [];
while ($item = mysqli_fetch_assoc($items)) {
    $add = true;
    
    if (!empty($search) && strpos(mb_strtolower($item['name']), mb_strtolower($search)) === false) {
    	$add = false;       
    }
        
    if ($state != 0 && $item['state'] != $state) {
    	$add = false;       
    }
        
    if ($amount != 0) {
    	if ($amount == 1 && $item['amount'] <= 3) {
        	$add = false;
        }
        if ($amount == 2 && ($item['amount'] == 0 || $item['amount'] > 3)) {
            $add = false;
        }
        if ($amount == 3 && $item['amount'] > 0) {
            $add = false;
        }
    }
        
    if ($type != 0 && $item['type'] != $type) {
        $add = false;
    }
        
    if ($sport != 0 && $item['sport'] != $sport) {
        $add = false;
    }
        
    if ($add) {
        $filtered_items[] = $item;
    }
}


?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Инвентарь</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../components/navbar.php'; ?>
    <main class="container-fluid p-0">
        <div class="row m-4">
            <div class="col p-0">
            	<div class="card p-3 shadow-sm bg-light border-0" style="width: 280px;">
                	<h5>Фильтры</h5>
                	<div class="nav flex-column mb-auto"> 
                    	<form action="index.php" method="POST">
                            <input type="hidden" name="search" value="<?php echo $search; ?>">
                        	<div class="mb-3">
                            	<label for="state" class="form-label">Состояние</label>
                            	<select class="form-select" id="state" name="state">
                                	<option value="0" <?php if ($state == 0) echo 'selected'; ?>>Все</option>
                                	<option value="1" <?php if ($state == 1) echo 'selected'; ?>>Новый</option>
                                	<option value="2" <?php if ($state == 2) echo 'selected'; ?>>Б/у</option>
                                	<option value="3" <?php if ($state == 3) echo 'selected'; ?>>Поврежденный</option>
                            	</select>
                        	</div>
                        	<div class="mb-3">
                            	<label for="amount" class="form-label">Наличие</label>
                            	<select class="form-select" id="amount" name="amount">
                                	<option value="0" <?php if ($amount == 0) echo 'selected'; ?>>Не важно</option>
                                	<option value="1" <?php if ($amount == 1) echo 'selected'; ?>>Есть</option>
                                	<option value="2" <?php if ($amount == 2) echo 'selected'; ?>>Мало</option>
                                	<option value="3" <?php if ($amount == 3) echo 'selected'; ?>>Нет</option>
                            	</select>
                        	</div>
                        	<div class="mb-3">
                            	<label for="type" class="form-label">Тип</label>
                            	<select class="form-select" id="type" name="type">
                                	<option value="0" <?php if ($type == 0) echo 'selected'; ?>>Все</option>
                                	<option value="1" <?php if ($type == 1) echo 'selected'; ?>>Мячи</option>
                                	<option value="2" <?php if ($type == 2) echo 'selected'; ?>>Ракетки</option>
                                    <option value="3" <?php if ($type == 3) echo 'selected'; ?>>Скакалки</option>
                                    <option value="4" <?php if ($type == 4) echo 'selected'; ?>>Обручи</option>
                                    <option value="5" <?php if ($type == 5) echo 'selected'; ?>>Штанги</option>  
                                    <option value="6" <?php if ($type == 6) echo 'selected'; ?>>Блины</option>
                                    <option value="7" <?php if ($type == 7) echo 'selected'; ?>>Перчатки</option>
                                    <option value="8" <?php if ($type == 8) echo 'selected'; ?>>Кроссовки</option>
                                   	<option value="9" <?php if ($type == 9) echo 'selected'; ?>>Коньки</option>
                                    <option value="10" <?php if ($type == 10) echo 'selected'; ?>>Лыжи</option>
                                    <option value="11" <?php if ($type == 11) echo 'selected'; ?>>Коврики и маты</option>
                            	</select>
                        	</div>
                            <div class="mb-3">
                            	<label for="sport" class="form-label">Спорт</label>
                            	<select class="form-select" id="sport" name="sport">
                                	<option value="0" <?php if ($sport == 0) echo 'selected'; ?>>Все</option>
                                	<option value="1" <?php if ($sport == 1) echo 'selected'; ?>>Футбол</option>
                                	<option value="2" <?php if ($sport == 2) echo 'selected'; ?>>Волейбол</option>
                                    <option value="3" <?php if ($sport == 3) echo 'selected'; ?>>Баскетбол</option>
                                    <option value="4" <?php if ($sport == 4) echo 'selected'; ?>>Ледовый спорт</option>
                                    <option value="5" <?php if ($sport == 5) echo 'selected'; ?>>Лыжный спорт</option>
                                    <option value="6" <?php if ($sport == 6) echo 'selected'; ?>>Теннис</option>
                                    <option value="7" <?php if ($sport == 7) echo 'selected'; ?>>Лёгкая атлетика</option>
                                    <option value="8" <?php if ($sport == 8) echo 'selected'; ?>>Боевые искусства</option>
                            	</select>
                        	</div>
                        	<button type="submit" class="btn btn-purple w-100">
                            	<i class="fa-solid fa-check me-2"></i> Применить
                        	</button>
                    	</form>
                        <a href="index.php" class="btn btn-secondary w-100 mt-2">
                            <i class="fa-solid fa-rotate-right"></i> Сбросить
                        </a>
                	</div>
            	</div>
            </div>
            <div class="col-10 p-0">
                <div class="d-flex justify-content-center mb-3">
                	<form class="w-50" action="index.php" method="POST">
                    	<input type="hidden" name="state" value="<?php echo $state; ?>">
                    	<input type="hidden" name="amount" value="<?php echo $amount; ?>">
                    	<input type="hidden" name="type" value="<?php echo $type; ?>">
                    	<input type="hidden" name="sport" value="<?php echo $sport; ?>">
                    	<div class="input-group"> 
                			<input type="text" class="form-control" placeholder="Поиск..." id="search" name="search" value="<?php echo $search ?>">
    						<button type="submit" class="btn btn-purple"><i class="fa-solid fa-magnifying-glass"></i></button>
                    	</div>
                	</form>
                </div>
                <div class="row overflow-y-scroll" style="max-height: 800px;">
                    <?php foreach ($filtered_items as $item) { ?>
                    <div class="col-md-3 mb-3 px-2">
                        <div class="card shadow-sm bg-light border-0">
                            <img height=200 src="<?php echo $item['photo']; ?>" class="card-img-top" alt="<?php echo $item['name']; ?>" style="object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $item['name']; ?></h5>
    							<h6 class="card-subtitle mb-2 text-muted">ID: <?php echo $item['id']; ?></h6>
                                <p class="card-text">
                                    <?php if ($item['state'] > 0) { ?><span class="badge <?php echo $item['state'] == 3 ? 'bg-danger' : ($item['state'] == 2 ? 'bg-warning' : 'bg-success') ?>"><?php echo state_to_text($item['state']); ?></span><?php } ?>
									<span class="badge <?php echo $item['amount'] == 0 ? 'bg-danger' : ($item['amount'] <= 3 ? 'bg-warning' : 'bg-success') ?>">В наличии: <?php echo $item['amount']; ?> шт.</span>
                                </p>
                                <a href="item.php?id=<?php echo $item['id']; ?>" class="btn btn-purple w-100">
                                    <i class="fa-solid fa-circle-info me-2"></i>Подробнее
                                </a>
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