<?php

  if ( isset( $_POST['create_post'] ) ) {

    $post_title  = $_POST['post_title'];
    $post_category_id  = $_POST['post_category_id'];
    $post_author  = $_POST['post_author'];
    $post_status  = $_POST['post_status'];

    $post_image  = $_FILES['post_image']['name'];
    $post_image_temp  = $_FILES['post_image']['tmp_name'];

    $post_tags  = $_POST['post_tags'];
    $post_content  = $_POST['post_content'];
    $post_data = date('d-m-y');

    move_uploaded_file($post_image_temp, "../images/$post_image");
    
    $query = "INSERT INTO posts( post_category_id, post_title, post_author, post_date, ";
    $query .= "post_image, post_content, post_tags, post_status) ";
    $query .= "VALUES('{$post_category_id}', '{$post_title}', '{$post_author}', ";
    $query .= "now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";

    $create_post_query = mysqli_query($connection, $query);

    confirm_query($create_post_query);

    $post_id = mysqli_insert_id( $connection);

    echo "<h3 class='bg-success'>Post has been created.</h3>
    <h4>Click <a href='../post.php?post_id=$post_id'>here</a> to view current post or <a href='./posts.php'>here</a> to view all posts.</h4>";

    // header("Location: posts.php");


  }

?>



<form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="title">Post Title</label>
    <input type="text" class="form-control" name="post_title">
  </div>

  <div class="form-group">
    <label for="post_category_id">Post Category ID</label>
    <select class="form-control" name="post_category_id" id="post_category_id">

    <?php 
    $query = 'SELECT * FROM categories';
    $select_categories = mysqli_query( $connection, $query );

    confirm_query($select_categories);
  
  
    while ( $row = mysqli_fetch_assoc( $select_categories ) ) {
      $cat_id = $row['cat_id'];
      $cat_title = $row['cat_title'];
      
      echo "<option value='{$cat_id}'>{$cat_title}</option>";

    }
    ?>
    
    </select>
   
  </div>

  <div class="form-group">
    <label for="post_author">Post Author</label>
    <input type="text" class="form-control" name="post_author">
  </div>

  <div class="form-group">
    <label for="post_status">Post Status</label>
    <select class="form-control" name="post_status" id="post_status">
      <option value='draft' selected>Draft</option>
      <option value='published'>Published</option>
    </select>
  </div>

  <div class="form-group">
    <label for="post_image">Post Image</label>
    <input type="file" class="form-control" name="post_image">
  </div>

  <div class="form-group">
    <label for="post_tags">Post Tags</label>
    <input type="text" class="form-control" name="post_tags">
  </div>

  <div class="form-group">
    <label for="summernote">Post Content</label>
    <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10"></textarea>
  </div>


  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="create_post" value="Create Post">
  </div>


</form>