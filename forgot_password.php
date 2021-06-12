<?php 
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
require 'classes/Config.php';
?>

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

      //MAIL
      $mail = new PHPMailer(true);

      try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
        $mail->isSMTP();                                           
        $mail->Host       = Config::SMTP_HOST;
        $mail->Username   = Config::SMTP_USER;                     
        $mail->Password   = Config::SMTP_PASSWORD;    
        $mail->Port       = Config::SMTP_PORT; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;              
        $mail->SMTPAuth   = true;     
        $mail->isHTML(true);
        
        //Recipients
        $mail->setFrom('draghiacristian97@gmail.com', 'Mailer');
        $mail->addAddress($user_email);

        //Content
        $mail->Subject = 'This is test email';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if( $mail->send() ) {
          echo "It was sent";
        } else {
          echo "It wasn't me";
        }


       
      } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }


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
