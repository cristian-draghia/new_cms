<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php
  if (!isset( $_SESSION ) ) { 
    session_start(); 
  } 
  checkIfUserIsLoggedInAndRedirect("/new_cms/index");

  if ( !ifItIsMethod('get')  && !isset( $_GET['forgot'] ) ) {
    redirect("/new_cms/index");
  }


?>


<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>

<?php

if ( ifItIsMethod('post') ) {
  if ( isset( $_POST['forgot_password'] ) ) {
    $user_email =  escape( $_POST['user_email'] );
    $length = 50;
    $token = bin2hex( openssl_random_pseudo_bytes( $length ) );

    $stmt_select = mysqli_prepare( $connection, "SELECT user_email FROM users WHERE user_email = ?");
    mysqli_stmt_bind_param( $stmt_select, 's', $user_email);
    mysqli_stmt_execute( $stmt_select );
    mysqli_stmt_store_result($stmt_select);

    if ( mysqli_stmt_num_rows ( $stmt_select ) == 0 ) {
      $message = "An account with this email doesn't exist";
    } else {
      $stmt_udpdate = mysqli_prepare( $connection, "UPDATE users SET token = '$token' WHERE user_email = ?");
      mysqli_stmt_bind_param( $stmt_udpdate, 's', $user_email);
      mysqli_stmt_execute( $stmt_udpdate );
      mysqli_stmt_close( $stmt_udpdate );
    }
    mysqli_stmt_close( $stmt_select );

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
            <h1 class="text-center">Forgot Password</h1>
              <form role="form" action="" method="post" id="login-form" autocomplete="off">
                <?php 
                  if ( !empty($message) ) {
                    echo "<h5 class='error_message'>$message</h5>";
                  }
       
                ?>
                <div class="form-group">
                  <input type="email" name="user_email" id="user_email" class="form-control" placeholder="Email adress">
                </div>
                <input type="submit" name="forgot_password" id="btn-login" class="btn btn-custom btn-lg btn-block register-btn" value="Reset Password">
              </form>
          </div>
        </div> <!-- /.col-xs-12 -->
      </div> <!-- /.row -->
    </div> <!-- /.container -->
  </section>
  <hr>
  <?php include "includes/footer.php";?>
