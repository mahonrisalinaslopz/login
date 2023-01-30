<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
  header('location:login.php');
};

if (isset($_POST['update'])) {

  $name = $_POST['name'];
  $name = ($name);
  $email = $_POST['email'];
  $email = ($email);
  $bio = $_POST['bio'];
  $bio = ($bio);
  $phone = $_POST['phone'];
  $phone = ($phone);

  $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ?, bio = ?, phone = ? WHERE id = ?");
  $update_profile->execute([$name, $email, $bio, $phone, $user_id]);

  $old_image = $_POST['old_image'];
  $image = $_FILES['image']['name'];
  $image_tmp_name = $_FILES['image']['tmp_name'];
  $image_size = $_FILES['image']['size'];
  $image_folder = 'uploaded_img/' . $image;

  if (!empty($image)) {

    if ($image_size > 2000000) {
      $message[] = '¡La imagen es muy grande!';
    } else {
      $update_image = $conn->prepare("UPDATE `users` SET image = ? WHERE id = ?");
      $update_image->execute([$image, $user_id]);

      if ($update_image) {
        move_uploaded_file($image_tmp_name, $image_folder);
        unlink('uploaded_img/' . $old_image);
        $message[] = '¡La imágen y tu perfil ha sido actualizado!';
      }
    }
  }

  $old_pass = $_POST['old_pass'];
  $previous_pass = md5($_POST['previous_pass']);
  $previous_pass = ($previous_pass);
  $new_pass = md5($_POST['new_pass']);
  $new_pass = ($new_pass);
  $confirm_pass = md5($_POST['confirm_pass']);
  $confirm_pass = ($confirm_pass);

  if (!empty($previous_pass) || !empty($new_pass) || !empty($confirm_pass)) {
    if ($previous_pass != $old_pass) {
      $message[] = '¡La contraseña anterior no coincide!';
    } elseif ($new_pass != $confirm_pass) {
      $message[] = '¡Confirmar contraseña no coincide!';
    } else {
      $update_password = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
      $update_password->execute([$confirm_pass, $user_id]);
      $message[] = '¡La contraseña y tu perfil ha sido actualizado!';
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
  <title>Editar Usuario</title>
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
         </div>
         ';
    }
  }
  ?>

  <h1 class="title"><span>INFORMACIÓN</span> PERSONAL </h1>

  <section class="update-profile-container">

    <?php
    $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
    $select_profile->execute([$user_id]);
    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
    ?>

    <form action="" method="post" enctype="multipart/form-data">
      <img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
      <div class="flex">
        <div class="inputBox">
          <span>Usuario : </span>
          <input type="text" name="name" required class="box" placeholder="Ingresa tu nombre de usuario" value="<?= $fetch_profile['name']; ?>">
          <span>Correo : </span>
          <input type="email" name="email" required class="box" placeholder="Ingresa tu correo" value="<?= $fetch_profile['email']; ?>">
          <span>Teléfono : </span>
          <input type="text" name="phone" required class="box" placeholder="Ingresa tu teléfono" value="<?= $fetch_profile['phone']; ?>">
          <span>Imagen : </span>          
          <input type="hidden" name="old_image" value="<?= $fetch_profile['image']; ?>">
          <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
        </div>
        <div class="inputBox">
        <span>Biografía : </span>
          <input type="text" name="bio" required class="box" placeholder="Ingresa tu biografía" value="<?= $fetch_profile['bio']; ?>">
          <input type="hidden" name="old_pass" value="<?= $fetch_profile['password']; ?>">
          <span>Contraseña Anterior :</span>
          <input type="text" class="box" name="previous_pass" placeholder="Ingresa tu contraseña anterior">
          <span>Contraseña Nueva :</span>
          <input type="text" class="box" name="new_pass" placeholder="Ingresa tu nueva contraseña">
          <span>Confirmar Contraseña :</span>
          <input type="password" class="box" name="confirm_pass" placeholder="Confirma tu contraseña">
        </div>
      </div>
      <div class="flex-btn">
        <input type="submit" value="guardar" name="update" class="btn">
        <a href="user_page.php" class="option-btn">Regresar</a>
      </div>
    </form>

  </section>

</body>

</html>