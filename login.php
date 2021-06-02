<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php
  if (!isset( $_SESSION ) ) { 
    session_start(); 
  } 

  if ( isset( $_SESSION['user_name'] ) ) {
    header("Location: index.php");
  }
?>


<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>

<?php

if ( isset( $_POST['login'] ) ) {
  $new_user_name = escape( $_POST['user_name'] );
  $new_user_password = escape( $_POST['user_password'] );

  $select_all_users_query = "SELECT * FROM users WHERE user_name = '$new_user_name' OR user_email = '$new_user_name' ";
  $select_all_users_query_result = mysqli_query ( $connection, $select_all_users_query );

  while ( $row = mysqli_fetch_assoc( $select_all_users_query_result ) ) {
    $db_user_id = $row['user_id'];
    $db_user_name = $row['user_name'];
    $db_user_password = $row['user_password'];
    $db_user_firstname = $row['user_firstname'];
    $db_user_lastname = $row['user_lastname'];
    $db_user_email = $row['user_email'];
    $db_user_image = $row['user_image'];
    $db_user_role = $row['user_role'];
    
    if ( password_verify($new_user_password, $db_user_password) ) {

    set_new_session($db_user_id, $db_user_name, $db_user_firstname, $db_user_lastname, $db_user_email,$db_user_image, $db_user_role );

    header("Location: admin/index.php");
    } else {     
      $message = "The password is wrong";
    }

  }

  if ( mysqli_num_rows( $select_all_users_query_result ) == 0) {
    $message = "The username or email doesn't exist";
  }
}


?>

<!-- Page Content -->
<div class="container">
  <section id="login">
    <div class="container">
      <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
          <div class="form-wrap">
            <h1 class="text-center">Login</h1>
              <form role="form" action="login.php" method="post" id="login-form" autocomplete="off">
                <?php 
                  if ( !empty($message) ) {
                    echo "<h5 class='error_message'>$message</h5>";
                  }
       
                ?>
                <div class="form-group">
                  <input type="text" name="user_name" id="username" class="form-control" placeholder="Username or Email">
                </div>
                <div class="form-group">
                  <input type="password" name="user_password" id="password" class="form-control" placeholder="Password">
                </div>
                  <input type="submit" name="login" id="btn-login" class="btn btn-custom btn-lg btn-block register-btn" value="Login">
              </form>
          </div>
        </div> <!-- /.col-xs-12 -->
      </div> <!-- /.row -->
    </div> <!-- /.container -->
  </section>
  <hr>
  <?php include "includes/footer.php";?>
