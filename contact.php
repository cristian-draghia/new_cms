<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<!-- Navigation -->

<?php  include "includes/navigation.php"; ?>

<?php


// Import the Postmark Client Class:

  // Send an email:


require_once('./vendor/autoload.php');
use Postmark\PostmarkClient;

if ( isset( $_POST['submit'] ) ) {

  $client = new PostmarkClient("454278d7-42b8-425b-a887-9f8a9fbd6a69");

  $email_to   = "draghiacristian97@gmail.com";
  $email_from = escape( $_POST['email'] );
  $subject    = escape( $_POST['subject'] );
  $content    = escape( $_POST['content'] );

  $messages = array();

  if ( !$email_from ) {
    array_push($messages, "The email is required");
  }
  if ( !$subject ) {
    array_push($messages, "The subject is required");
  }
  if ( !$content ) {
    array_push($messages, "The content is required");
  }

  if ( empty( $messages ) ) {

    $sendResult = $client->sendEmail(
      "hello@cozmoslabs.com",
      "$email_to",
      "$subject",
      "Email sent by: $email_from <br><br> $content"
    );
  }

  if ( !empty( $sendResult ) ) {
    array_push($messages, "Your message has been succesfuly sent");
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
            <h1 class="text-center">Contact</h1>
            <form role="form" action="" method="post" id="login-form" autocomplete="off">
            <?php 
              if ( !empty( $messages ) ) {
                foreach ($messages as $message) {
                  if ( $message == "Your message has been succesfuly sent") {
                    echo "<h5 class='proper_message'>$message</h5>";
                  } else {
                    echo "<h5 class='error_message'>$message</h5>";
                  }
                }
              }
            ?>
            <div class="form-group">
              <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
            </div>
            <div class="form-group">
              <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter your subject">
            </div>
            <div class="form-group">
              <textarea name="content" id="content" class="form-control" cols="30" rows="10"></textarea>
            </div>
            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block register-btn" value="Submit">
            </form>
          </div>
        </div> <!-- /.col-xs-12 -->
      </div> <!-- /.row -->
    </div> <!-- /.container -->
  </section>
<hr>
<?php include "includes/footer.php";?>