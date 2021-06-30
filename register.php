<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php checkIfUserIsLoggedInAndRedirect( "/new_cms/index" ); ?>

<!-- Navigation -->

<?php  include "includes/navigation.php"; ?>

<?php

//Setting Language Variables

if ( isset(  $_GET['lang'] ) && !empty( $_GET['lang']) ) {
  $_SESSION['lang'] = $_GET['lang'];

  if ( isset ( $_SESSION['lang'] ) && $_SESSION['lang'] != $_GET['lang'] ) {
    echo "<script type ='text/javascript'> location.reload(); </script>";
  }
}

  if ( isset ( $_SESSION['lang'] ) ) {
    include "includes/languages/" . $_SESSION['lang']. ".php";
  } else {
    include "includes/languages/en.php";
  }



//Register User
$message = '';
$message_state = '';
$user_name = '';
$user_email = '';
register_user( $user_name, $user_email, $message, $message_state);

?>

<!-- Page Content -->
<div class="container">

<form method="get" class="navbar-form navbar-right"  action="" id="language_switcher">
  <div class="form-group">
    <select name="lang" class="form-control" onchange="change_language()">
      <option value="en" <?php if ( isset ( $_SESSION['lang'] ) && $_SESSION['lang'] == 'en' ) { echo "selected"; } ?> >English</option>
      <option value="es" <?php if ( isset ( $_SESSION['lang'] ) && $_SESSION['lang'] == 'es' ) { echo "selected"; } ?>>Spanish</option>
      <option value="de" <?php if ( isset ( $_SESSION['lang'] ) && $_SESSION['lang'] == 'de' ) { echo "selected"; } ?>>German</option>
    </select>
  </div>


</form>

  <section id="login">
    <div class="container">
      <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
          <div class="form-wrap">
            <h1 class="text-center"><?php echo _REGISTER ?></h1>
            <?php register_user_form( $user_name, $user_email, $message, $message_state ); ?>;
          </div>
        </div> <!-- /.col-xs-12 -->
      </div> <!-- /.row -->
    </div> <!-- /.container -->
  </section>
<hr>

<script>
  function change_language() {
    document.getElementById('language_switcher').submit();
  }


</script>

<?php include "includes/footer.php";?>