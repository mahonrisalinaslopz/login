<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
	header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Perfil</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
	<link rel="stylesheet" href="css/style.css">

</head>

<body>

	<h1 class="title"> <span>BIENVENIDO</span> A TU PERFIL </h1>

	<section class="profile-container">

		<?php
		$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
		$select_profile->execute([$user_id]);
		$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
		?>

		<div class="profile">
			<img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
			<h3> <br>Usuario: </br> <?= $fetch_profile['name']; ?></h3>
			<h3> <br>Teléfono: </br> <?= $fetch_profile['phone']; ?></h3>
			<h3> <br>Correo: </br> <?= $fetch_profile['email']; ?></h3>
			<h3> <br>Biografía: </br> <?= $fetch_profile['bio']; ?></h3>
			<a href="user_profile_update.php" class="btn">Editar Perfil</a>
			<a href="logout.php" class="delete-btn">Salir</a>
		</div>

	</section>

</body>

</html>