<?php 
session_start();
include_once('utils.php');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Спортивный инвентарь</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <header>
        <?php include 'components/navbar.php'; ?>
    </header>

    <div class="hero d-flex flex-column justify-content-center text-center py-5 bg-purple">
    	<img class="d-block mx-auto mb-4" src="/img/logo.png" alt="" width="80" height="80">
    	<h1 class="display-5 fw-bold text-light mb-3">Спортивный инвентарь</h1>
    	<div class="col-lg-6 mx-auto">
      		<p class="lead mb-4 text-light">Простая и удобная система учета спортивного оборудования для школ и спортивных залов.</p>
      		<div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        		<a href="inventory/index.php" class="btn btn-light btn-lg">Перейти к инветарю</a>
      		</div>
    	</div>
  	</div>
        
    <div class="container p-5">
    	<h2 class="mb-3 text-center">Основные функции</h2>
    	<div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
      		<div class="feature col">
        		<div class="feature-icon bg-purple bg-gradient d-inline-flex p-3 rounded mb-3">
          			<i class="fa-solid fa-cart-shopping text-light"></i>
        		</div>
        		<h2>Учёт инвентаря</h2>
        		<p>Получите удобный доступ ко всему спортивному инвентарю, его состоянию и количеству</p>
      		</div>
      		<div class="feature col">
        		<div class="feature-icon bg-purple bg-gradient d-inline-flex p-3 rounded mb-3">
          			<i class="fa-solid fa-inbox text-light"></i>
        		</div>
        		<h2>Заявки на получение</h2>
        		<p>Арендуйте любой предмет из инвентаря с помощью удобной системы заявок</p>
      		</div>
      		<div class="feature col">
        		<div class="feature-icon bg-purple bg-gradient d-inline-flex p-3 rounded mb-3">
          			<i class="fa-solid fa-calendar-days text-light"></i>
        		</div>
        		<h2>План закупок</h2>
        		<p>Удобно планируйте закупки инвентаря, просматривайте историю и доступных поставщиков</p>
      		</div>
    	</div>
  	</div>
        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>