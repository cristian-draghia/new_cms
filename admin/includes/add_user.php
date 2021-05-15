<?php

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
    <input type="text" class="form-control" name="user_firstname">
  </div>

  <div class="form-group">
    <label for="user_lastname">Lastname</label>
    <input type="text" class="form-control" name="user_lastname">
  </div>

  <div class="form-group">
    <label for="user_name">Username</label>
    <input type="text" class="form-control" name="user_name">
  </div>

  <div class="form-group">
    <label for="user_email">Email</label>
    <input type="email" class="form-control" name="user_email">
  </div>

  <form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="user_password">Password</label>
    <input type="password" class="form-control" name="user_password">
  </div>

  <div class="form-group">
    <label for="user_image">Image</label>
    <input type="file" class="form-control" name="user_image">
  </div>

  <div class="form-group">
    <label for="user_role">Role</label>
    <select class="form-control" name="user_role" id="user_role">
      <option selected="selected" value='subscriber'>Subscriber</option>
      <option value='administrator'>Administrator</option>
    </select>
  </div>


  <div class="form-group">
    <input type="submit" class="btn-primary" name="create_user" value="Add New User">
  </div>


</form>