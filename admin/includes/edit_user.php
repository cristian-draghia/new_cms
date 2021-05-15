<?php

//Get default values for edit
if ( isset( $_GET['user_id']) ) {
  $user_id = $_GET['user_id'];

  $select_user_data_query = "SELECT * FROM users WHERE user_id = $user_id";
  $select_user_data_query_result = mysqli_query( $connection, $select_user_data_query );
  confirm_query( $select_user_data_query_result );
  while ( $row = mysqli_fetch_assoc( $select_user_data_query_result  ) ) {
    $user_name = $row['user_name'];
    $user_password = $row['user_password'];
    $user_firstname = $row['user_firstname'];
    $user_lastname = $row['user_lastname'];
    $user_email = $row['user_email'];
    $user_role = $row['user_role'];
    $user_image = $row['user_image'];

  }

  // move_uploaded_file($user_image_temp, "../images/$user_image");

  
  // $user_image = test_empty_image( $user_id, $user_image );

  if ( isset( $_POST['update_user'] ) ) {

    
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    $user_image  = $_FILES['user_image']['name'];
    $user_image_temp  = $_FILES['user_image']['tmp_name'];

    $user_role = $_POST['user_role'];

    move_uploaded_file($user_image_temp, "../images/$user_image");

    // Test if image is empy
    $user_image = test_empty_image( $user_id, $user_image, 'users' );

    // Update User
    update_user( $user_id, $user_name, $user_password, $user_firstname, $user_lastname, $user_email, $user_image, $user_role );
  
  }
  


}






  if ( isset( $_POST['create_user'] ) ) {


    $user_name = $_POST['user_name'];
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    $user_image  = $_FILES['user_image']['name'];
    $user_image_temp  = $_FILES['user_image']['tmp_name'];

    $user_role = $_POST['user_role'];

    move_uploaded_file($user_image_temp, "../images/$post_image");
    
    $add_user_query = "INSERT INTO users( user_name, user_password, user_firstname, ";
    $add_user_query .= "user_lastname, user_email, user_image, user_role) ";
    $add_user_query .= "VALUES('{$user_name}', '{$user_password}', '{$user_firstname}', ";
    $add_user_query .= "'{$user_lastname}', '{$user_email}', '{$user_image}', '{$user_role}')";

    $add_user_query_result = mysqli_query($connection, $add_user_query);

    confirm_query($add_user_query_result);

    header("Location: users.php");


  }

?>




<form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="user_firstname">Firstname</label>
    <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname; ?>">
  </div>

  <div class="form-group">
    <label for="user_lastname">Lastname</label>
    <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname; ?>">
  </div>

  <div class="form-group">
    <label for="user_name">Username</label>
    <input type="text" class="form-control" name="user_name" value="<?php echo $user_name; ?>">
  </div>

  <div class="form-group">
    <label for="user_email">Email</label>
    <input type="email" class="form-control" name="user_email" value="<?php echo $user_email; ?>">
  </div>

  <form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="user_password">Password</label>
    <input type="password" class="form-control" name="user_password" value="<?php echo $user_password; ?>">
  </div>

  <div class="form-group">
    <label for="user_image">Image</label><br>
    <img width="100" src="../images/<?php echo $user_image;?>">
    <input type="file" class="form-control" name="user_image">
  </div>

  <div class="form-group">
    <label for="user_role">Role</label>
    <select class="form-control" name="user_role" id="user_role">
      <?php 
      if ( $user_role == 'administrator' ) {
        echo "<option value='subscriber'>Subscriber</option>";
        echo "<option selected='selected' value='administrator'>Administrator</option>";
      }
      else {
        echo "<option selected='selected' value='subscriber'>Subscriber</option>";
        echo "<option value='administrator'>Administrator</option>";
      }
      ?>"
    </select>
  </div>


  <div class="form-group">
    <input type="submit" class="btn-primary" name="update_user" value="Update User">
  </div>


</form>