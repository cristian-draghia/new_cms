<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php checkIfUserIsLoggedInAndRedirect( "/new_cms/index" ); ?>

<!-- Navigation -->

<?php  include "includes/navigation.php"; ?>

<?php

$message = '';
$message_state = '';
$user_name = '';
$user_email = '';
register_user( $user_name, $user_email, $message, $message_state);

?>

<!-- Page Content -->
<div class="container">
  <section id="login">
    <div class="container">
      <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
          <div class="form-wrap">
            <h1 class="text-center">Register</h1>
            <?php register_user_form( $user_name, $user_email, $message, $message_state ); ?>;
          </div>
        </div> <!-- /.col-xs-12 -->
      </div> <!-- /.row -->
    </div> <!-- /.container -->
  </section>
<hr>
<?php include "includes/footer.php";?>