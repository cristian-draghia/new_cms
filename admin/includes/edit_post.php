<?php

if ( isset( $_GET['post_id'] ) ) {
  $post_id = $_GET['post_id'];

  $query = "SELECT * FROM posts WHERE post_id = $post_id";
  $select_posts_by_id = mysqli_query( $connection, $query );


  while ( $row = mysqli_fetch_assoc( $select_posts_by_id ) ) {
    $post_author = $row['post_author'];
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_content = $row['post_content'];
    $post_tags = $row['post_tags'];
    $post_comment_count = $row['post_comment_count'];
    $post_data = $row['post_date'];

  }

  if ( isset( $_POST['update_post'] ) ) {

    $post_title  = $_POST['post_title'];
    $post_category_id  = $_POST['post_category_id'];
    $post_author  = $_POST['post_author'];
    $post_status  = $_POST['post_status'];

    $post_image  = $_FILES['post_image']['name'];
    $post_image_temp  = $_FILES['post_image']['tmp_name'];

    $post_tags  = $_POST['post_tags'];
    $post_content  = $_POST['post_content'];

    move_uploaded_file($post_image_temp, "../images/$post_image");

    // Test if image is empy
    $post_image = test_empty_image( $post_id, $post_image, 'posts' );

    // Update Post
    update_post( $post_id, $post_category_id, $post_title, $post_author, $post_image, $post_content, $post_tags, $post_status );

  }

}



?>

<form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="title">Post Title</label>
    <input type="text" value="<?php echo $post_title; ?>" class="form-control" name="post_title">
  </div>

  <div class="form-group">
    <label for="post_category_id">Post Category ID</label><br>
    <select class="form-control" name="post_category_id" id="post_category_id">

    <?php 
    $query = 'SELECT * FROM categories';
    $select_categories = mysqli_query( $connection, $query );

    confirm_query($select_categories);
  
  
    while ( $row = mysqli_fetch_assoc( $select_categories ) ) {
      $cat_id = $row['cat_id'];
      $cat_title = $row['cat_title'];
      
      if ($cat_id == $post_category_id) {
      echo "<option selected value='{$cat_id}'>{$cat_title}</option>";
      } else {
        echo "<option value='{$cat_id}'>{$cat_title}</option>";
      }

    }
    ?>
    


    </select>
  </div>

  <div class="form-group">
    <label for="post_author">Post Author</label>
    <input type="text" value="<?php echo $post_author; ?>" class="form-control" name="post_author">
  </div>

  <div class="form-group">
    <label for="post_status">Post Status</label>
    <select class="form-control" name="post_status" id="post_status">
      <?php
      //Get Post Status
      $selected_status_query = "SELECT post_status FROM posts WHERE post_id = $post_id";
      $selected_status_query_result = mysqli_query( $connection, $selected_status_query );
      confirm_query( $selected_status_query_result );
      while ( $row = mysqli_fetch_assoc( $selected_status_query_result ) ) {
        $status_value = $row['post_status'];
       
          echo "<option ". (($status_value == 'draft') ? "selected" : "") . " value='draft'>Draft</option>";
          echo "<option " . (($status_value == 'published') ? "selected" : "") . " value='published'>Published</option>"; 
  
      }
      
      ?>
      
        </select>
  </div>

  <div class="form-group">
    <label for="post_image">Post Image</label><br>
    <img width="100" src="../images/<?php echo $post_image;?>">
    <input type="file" class="form-control" name="post_image">
  </div>

  <div class="form-group">
    <label for="post_tags">Post Tags</label>
    <input type="text" value="<?php echo $post_tags; ?>" class="form-control" name="post_tags">
  </div>

  <div class="form-group">
    <label for="post_content">Post Content</label>
    <textarea class="form-control" name="post_content" id="" cols="30" rows="10"><?php echo $post_content; ?></textarea>
  </div>


  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
  </div>


</form>