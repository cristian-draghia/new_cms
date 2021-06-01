<?php

//Get default values for edit
if ( isset( $_GET['user_id'] ) ) {
  
  $user_id = escape( $_GET['user_id'] );
  $user_info_query = "SELECT * FROM users WHERE user_id = $user_id";
  $user_info_query_result = query_result( $user_info_query );
  while ( $row = mysqli_fetch_assoc( $user_info_query_result ) ) {
    $user_name = escape( $row['user_name'] );
    $user_password = escape( $row['user_password'] );
    $user_firstname = escape( $row['user_firstname'] );
    $user_lastname = escape( $row['user_lastname'] );
    $user_email = escape( $row['user_email'] );
    $user_role = escape( $row['user_role'] );
    $user_image = escape( $row['user_image'] );
  }
}

if ( isset( $_POST['update_user'] ) ) {
  $new_user_name = escape( $_POST['user_name'] );
  $new_user_firstname = escape( $_POST['user_firstname'] );
  $new_user_lastname = escape( $_POST['user_lastname'] );
  $new_user_email = escape( $_POST['user_email'] );

  $new_user_image  = escape( $_FILES['user_image']['name'] );
  $new_user_image_temp  = escape( $_FILES['user_image']['tmp_name'] );

  move_uploaded_file($new_user_image_temp, "images/$new_user_image");

  // Test if image is empy
  $post_image = test_empty_image( $user_id, $new_user_image, 'users' );

  //Write error messages
  if ( empty( $messages ) ) {
    $messages = array();
  }
  
  update_user_name_email( $user_id, $user_name, $new_user_name, 'user_name', $messages);
  update_user_name_email( $user_id, $user_email, $new_user_email, 'user_email', $messages);
  update_user_info( $user_id, $user_firstname, $new_user_firstname, 'user_firstname');
  update_user_info( $user_id, $user_lastname, $new_user_lastname, 'user_lastname');
  if ( !empty( $new_user_image ) ) {
    update_user_info( $user_id, $user_image, $new_user_image, 'user_image');
  } 

  //Update Password
  if ( !empty( $_POST['user_old_password'] ) && !empty( $_POST['user_new_password'] ) && !empty( $_POST['user_confirm_password'] ) ) {
    $user_old_password = escape_string( $_POST['user_old_password'] );
    $user_new_password = escape_string( $_POST['user_new_password'] );
    $user_confirm_password = escape_string( $_POST['user_confirm_password'] );
    $verify = password_verify($user_old_password , $user_password);
    if ( $verify ) {
      if ($user_old_password === $user_new_password && $user_old_password === $user_confirm_password) {
        array_push( $messages, "The new password cannot be the old password");
      }
      if ( $user_new_password !== $user_confirm_password ) {
        array_push( $messages, "The new password and the confirm password don't match");
      } else {
        $hash = password_hash($user_new_password, PASSWORD_BCRYPT);
        $update_user_password_query = "UPDATE users SET user_password = '$hash' WHERE user_id = $user_id";
        $update_user_password_query_result = mysqli_query( $connection, $update_user_password_query );
        confirm_query( $update_user_password_query_result );
      }
    } else {
      array_push( $messages, "The old password is wrong");
    }
  }
  
  header( "Location: users.php?source=edit_user&user_id=$user_id");

}


?>

<form role="form" action="" method="post" id="update_user_form" autocomplete="off" enctype="multipart/form-data">
  <?php 
    if ( !empty($messages) ) {
      foreach ( $messages as $message) {
        echo "<h5 class='error_message'>$message</h5>";
      }
  }
  ?>
  <div class="form-group">
    <label for="user_name">Username</label>
    <input type="text" name="user_name" id="user_name" class="form-control" value = "<?php echo $user_name; ?>">
  </div>
  <div class="form-group">
    <label for="user_firstname">First Name</label>
    <input type="text" name="user_firstname" id="user_firstname" class="form-control" value = "<?php echo $user_firstname; ?>">
  </div>
  <div class="form-group">
    <label for="user_lastname">Last Name</label>
    <input type="text" name="user_lastname" id="user_lastname" class="form-control" value = "<?php echo $user_lastname; ?>">
  </div>
  <div class="form-group">
    <label for="user_email">Email</label>
    <input type="email" name="user_email" id="user_email" class="form-control" value = "<?php echo $user_email; ?>">
  </div>        
  <div class="form-group">
    <label for="user_image">Avatar</label><br>
    <img src="images/<?php echo $user_image; ?>" height=150>
    <input type="file" name="user_image" id="user_image">
  </div>
  <div class="form-group">
    <label for="user_old_password">Old password</label>
    <input type="password" name="user_old_password" id="user_old_password" class="form-control">
  </div>
  <div class="form-group">
    <label for="user_new_password">New password</label>
    <input type="password" name="user_new_password" id="user_new_password" class="form-control">
  </div>
  <div class="form-group">
    <label for="user_confirm_password">Confirm password</label>
    <input type="password" name="user_confirm_password" id="user_confirm_password" class="form-control">
  </div>
    <input type="submit" name="update_user" id="btn-login" class="btn btn-custom btn-lg btn-block register-btn" value="Save changes">
</form>