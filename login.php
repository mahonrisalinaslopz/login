<?php

include 'config.php';

session_start();

if (isset($_POST['submit'])) {

  $email = $_POST['email'];
  $email = filter_var($email);
  $pass = md5($_POST['pass']);
  $pass = filter_var($pass);

  $select = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
  $select->execute([$email, $pass]);
  $row = $select->fetch(PDO::FETCH_ASSOC);

  if ($select->rowCount() > 0) {

    if ($row['user_type'] == 'admin') {

      $_SESSION['admin_id'] = $row['id'];
      header('location:admin_page.php');
    } elseif ($row['user_type'] == 'user') {

      $_SESSION['user_id'] = $row['id'];
      header('location:user_page.php');
    } else {
      $message[] = '¡Usuario no encontrado!';
    }
  } else {
    $message[] = '¡Contraseña o correo incorrecto!';
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">

</head>

<body>

  <?php
  if (isset($message)) {
    foreach ($message as $message) {
      echo '
         <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>';
    }
  }
  ?>

  <section class="form-container">

    <form action="#" method="post" enctype="multipart/form-data">
      <h3>Iniciar Sesión</h3>
      <input type="email" required placeholder="Ingresa tu correo" class="box" name="email">
      <input type="password" required placeholder="Ingresa tu contraseña" class="box" name="pass">
      <input type="submit" value="Acceder" class="btn" name="submit">
      <p>¿Ya eres miembro? <a href="register.php">Registrate</a></p>
    </form>

  </section>

</body>

</html>