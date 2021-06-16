<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>


<!-- Navigation -->

<?php  include "includes/navigation.php"; ?>

<?php
  
  if ( !isset( $_GET['email'] ) && !isset( $_GET['token'] ) ) {
    redirect("index");
  } else {
    $user_email = $_GET['email'];
    $token = $_GET['token'];
    if ( $stmt = mysqli_prepare( $connection, "SELECT user_email, token FROM users WHERE token = ?" ) ) {
      mysqli_stmt_bind_param( $stmt, 's', $token);
      mysqli_stmt_execute( $stmt );
      mysqli_stmt_bind_result( $stmt, $user_email_db, $token_db );
      mysqli_stmt_fetch( $stmt );
      mysqli_stmt_close( $stmt );
      if ( $token !== $token_db || $user_email !== $user_email_db ) {
        redirect("index");
      }

    }
  }

  if ( isset( $_POST['reset_password'] ) ) {
    $user_password = trim( escape( $_POST['user_password'] ) );
    $user_password_confirm = trim( escape( $_POST['user_password_confirm'] ) );
    if( $user_password !== $user_password_confirm ) {
      $message = "The passwords have to be the same";
      $message_state = "error";
    } 
    else {
      $hash = password_hash($user_password, PASSWORD_BCRYPT);
      if ( $stmt = mysqli_prepare( $connection, "UPDATE users SET token = '', user_password = '$hash' WHERE user_email = ?") ) {
        mysqli_stmt_bind_param( $stmt, 's', $user_email_db);
        mysqli_stmt_execute( $stmt );
        if ( mysqli_stmt_affected_rows ( $stmt ) >= 1 ) {
          $message = "The password has been changed<br>Click <a href='/new_cms/login'>here</a> to login ";
          $message_state = "correct";
        }
        mysqli_stmt_close( $stmt );
      }
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
            <h1 class="text-center">Reset Password</h1>
            <form role="form" action="" method="post" id="login-form" autocomplete="off">
            <?php 
            if ( !empty( $message ) && !empty( $message_state ) ) {
              if ( $message_state === "error") {
                echo "<h5 class='error_message'>$message</h5>";
              } else {
                echo "<h5 class='proper_message'>$message</h5>";
              }
            }
            ?>
            <div class="form-group">
              <input type="password" name="user_password" id="password" class="form-control" placeholder="New Password">
            </div>
            <div class="form-group">
              <input type="password" name="user_password_confirm" id="password_confirm" class="form-control" placeholder="Confirm Password">
            </div>
            <input type="submit" name="reset_password" id="btn-login" class="btn btn-custom btn-lg btn-block register-btn" value="Reset Password">
          </form>
          </div>
        </div> <!-- /.col-xs-12 -->
      </div> <!-- /.row -->
    </div> <!-- /.container -->
  </section>
<hr>
<?php include "includes/footer.php";?>