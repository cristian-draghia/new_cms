<?php include "db.php"; ?>
<?php session_start(); ?>

<?php
  if (isset ( $_POST['login_user']) ) {

    $current_user_name = $_POST['user_name'];
    $current_user_password = $_POST['user_password'];

    $current_user_name = mysqli_real_escape_string( $connection, $current_user_name );
    $current_user_password = mysqli_real_escape_string( $connection, $current_user_password );

    $select_all_users_query = "SELECT * FROM users WHERE user_name = '$current_user_name' ";
    $select_all_users_query_result = mysqli_query ( $connection, $select_all_users_query );
    while ( $row = mysqli_fetch_assoc( $select_all_users_query_result ) ) {
      $db_user_id = $row['user_id'];
      $db_user_name = $row['user_name'];
      $db_user_password = $row['user_password'];
      $db_user_firstname = $row['user_firstname'];
      $db_user_lastname = $row['user_lastname'];
      $db_user_role = $row['user_role'];

      if ( $current_user_name === $db_user_name && $current_user_password === $db_user_password ) {
        
        $_SESSION['user_name'] = $db_user_name;
        $_SESSION['user_firstname'] = $db_user_firstname;
        $_SESSION['user_lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;
  
        header("Location: ../admin");

      } else {
        header("Location: ../index.php");
      }

    }

    if ( mysqli_num_rows( $select_all_users_query_result ) == 0) {
      header("Location: ../index.php");
    }
  }


?>


