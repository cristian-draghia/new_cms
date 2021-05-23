<?php session_start(); ?>

<?php
  // $_SESSION['user_id'] = null;
  // $_SESSION['user_name'] = null;
  // $_SESSION['user_firstname'] = null;
  // $_SESSION['user_lastname'] = null;
  // $_SESSION['user_email'] = null;
  // $_SESSION['user_image'] = null;
  // $_SESSION['user_role'] = null;

  session_destroy();

  header("Location: ../index.php");
?>


