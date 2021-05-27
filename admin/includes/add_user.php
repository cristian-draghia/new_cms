<?php

if ( isset( $_POST['register'] ) ) {
  $user_name = escape_string( $_POST['user_name'] );
  $user_email = escape_string( $_POST['user_email'] );
  $user_password = escape_string( $_POST['user_password'] );
  $user_password_confirm = escape_string( $_POST['user_password_confirm'] );
  
  $check_name = !empty($user_name) && strlen($user_name) > 3;
  $check_email = !empty($user_email) && strlen($user_email) > 3;
  $check_password = !empty($user_password) && strlen($user_password) > 3;
  $check_password_confirm = !empty($user_password_confirm) && strlen($user_password_confirm) > 3;

  if ( $check_name && $check_email && $check_password && $check_password_confirm ) {

    $check_users_query = "SELECT user_name, user_email FROM users WHERE user_name = '$user_name' OR user_email = '$user_email'";
    $check_users_query_result = query_result( $check_users_query );

    while ( $row = mysqli_fetch_array( $check_users_query_result ) ) {
      if ( $user_name === $row['user_name'] ) {
        $message = "This username already exists";
        $message_state = "error";
        break;
      }
      if ( $user_email === $row['user_email'] ) {
        $message = "An account with this email has already been created";
        $message_state = "error";
        break;
      }
    }

    if ( mysqli_num_rows( $check_users_query_result ) == 0 ) {
      if ( $user_password !== $user_password_confirm ) {
        $message = "The passwords has to be the same";
        $message_state = "error";
      } else {
        $hash = password_hash($user_password, PASSWORD_BCRYPT);
        $add_user_query = "INSERT INTO users (user_name, user_password, user_email, user_image, user_role) ";
        $add_user_query .= "VALUES('$user_name', '$hash', '$user_email', 'default_user.jpg', 'subscriber')";
        $add_user_query_result = mysqli_query( $connection, $add_user_query );
        confirm_query( $add_user_query_result );
        $message = "The user <span style='color:blue;'>$user_name</span> has just been created";
        $message_state = "corret";
      }
        
    }

  } else {
    $message = "Fields cannot be empy or lower than 4 characters";
    $message_state = "error";
  }
       
}

?>



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
    <input type="text" name="user_name" id="username" class="form-control" placeholder="Username">
  </div>
  <div class="form-group">
    <input type="email" name="user_email" id="email" class="form-control" placeholder="Email">
  </div>
  <div class="form-group">
    <input type="password" name="user_password" id="password" class="form-control" placeholder="Password">
  </div>
  <div class="form-group">
    <input type="password" name="user_password_confirm" id="password_confirm" class="form-control" placeholder="Confirm Password">
  </div>
  <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block register-btn" value="Register">
</form>