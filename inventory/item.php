<?php 
session_start();
include_once('../utils.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: inventory.php");
    exit; 
}

$id = sanitize(mysqli_real_escape_string($db, $_GET['id']));
$item = get_item_by_id($id);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $item['name']; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../components/navbar.php'; ?>
    <main class="container my-5">
        <div class="row">
            <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
  				<i class="fa-solid fa-circle-check me-2"></i> <?php echo $_SESSION['success'] ?>
  				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
            <?php } unset($_SESSION['success']); ?>
                
            <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
  				<i class="fa-solid fa-circle-exclamation me-2"></i> <?php echo $_SESSION['error'] ?>
  				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
            <?php } unset($_SESSION['error']); ?>
                
            <div class="col-md-6">
                <img src="<?php echo $item['photo']; ?>" class="img-fluid rounded" alt="<?php echo $item['name']; ?>">
            </div>
            <div class="col-md-6">
                <h2><?php echo $item['name']; ?></h2>
                <p class="text-muted"><?php echo $item['description']; ?></p>
                <p><strong>ID:</strong> <?php echo $item['id']; ?></p>
                <p><strong>Состояние:</strong> <?php echo state_to_text($item['state']); ?></p>
                <p><strong>В наличии:</strong> <?php echo $item['amount']; ?> шт.</p>
                <button type="button" class="btn btn-purple w-50 " data-bs-toggle="modal" data-bs-target="#rentModal">
                	<i class="fa-solid fa-bell me-2"></i> Запросить
                </button>
            </div>
        </div>
    </main>

    <div class="modal fade" id="rentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Заявка на получение</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <form action="send_request.php?item_id=<?php echo $item['id']; ?>" method="POST">
                    <div class="modal-body">  
                        <div class="mb-3">
                        	<label for="amount" class="form-label">Количество</label>
                            <div class="input-group">
                            	<span class="input-group-text"><i class="fa-solid fa-tag"></i></span>
                                <input type="number" class="form-control" id="amount" name="amount" required>
                            </div>
                        </div>
                    	<div class="mb-3">
                        	<label for="comment" class="form-label">Комментарий</label>
                            <textarea class="form-control" id="comment" name="comment" cols="40" rows="5" style="resize: none;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                    	<button type="submit" class="btn btn-purple">
                            <i class="fa-solid fa-paper-plane me-2"></i> Отправить
                        </button>
                    </div>     
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>