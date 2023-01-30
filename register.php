<?php

include 'config.php';

if (isset($_POST['submit'])) {

  $name = $_POST['name'];
  $name = filter_var($name);
  $email = $_POST['email'];
  $email = filter_var($email);
  $pass = md5($_POST['pass']);
  $pass = filter_var($pass);
  $cpass = md5($_POST['cpass']);
  $cpass = filter_var($cpass);

  $image = $_FILES['image']['name'];
  $image_tmp_name = $_FILES['image']['tmp_name'];
  $image_size = $_FILES['image']['size'];
  $image_folder = 'uploaded_img/' . $image;

  $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
  $select->execute([$email]);

  if ($select->rowCount() > 0) {
    $message[] = '¡Usuario ya existente!';
  } else {
    if ($pass != $cpass) {
      $message[] = '¡Confirmar contraseña no coincide!';
    } elseif ($image_size > 2000000) {
      $message[] = '¡El tamaño de la imagen es muy grande!';
    } else {
      $insert = $conn->prepare("INSERT INTO `users`(name, email, password, image) VALUES(?,?,?,?)");
      $insert->execute([$name, $email, $cpass, $image]);
      if ($insert) {
        move_uploaded_file($image_tmp_name, $image_folder);
        $message[] = '¡Registro exitoso!';
        header('location:login.php');
      }
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <?php
  if (isset($message)) {
    foreach ($message as $message) {
    echo '<div class="message"><span>' . $message . '</span>
    <i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
  }
}
  ?>

  <section class="form-container">
    <form action="" method="post" enctype="multipart/form-data">
      <h3>REGISTRO</h3>
      <input type="text" required placeholder="Ingresa tu nombre de usuario" class="box" name="name">
      <input type="email" required placeholder="Ingresa tu email" class="box" name="email">
      <input type="password" required placeholder="Ingresa tu contraseña" class="box" name="pass">
      <input type="password" required placeholder="Confirma tu contraseña" class="box" name="cpass">
      <input type="file" name="image" required class="box" accept="image/jpg, image/png, image/jpeg"> 
      <input type="submit" value="Registrate" class="btn" name="submit">
      <p>¿Ya tienes una cuenta? <a href="login.php">Iniciar Sesión</a></p>
    </form>
  </section>
</body>
</html>