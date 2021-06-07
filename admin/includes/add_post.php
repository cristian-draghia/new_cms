<?php

  if ( isset( $_POST['create_post'] ) ) {

    $post_title  = escape( $_POST['post_title'] );
    $post_category_id  = escape( $_POST['post_category_id'] );
    $post_author_id  = escape( $_POST['post_author_id'] );
    $post_status  = escape( $_POST['post_status'] );

    $post_image  = escape( $_FILES['post_image']['name'] );
    $post_image_temp  = escape( $_FILES['post_image']['tmp_name'] );

    $post_content  = escape( $_POST['post_content'] );
    $post_data = escape( date('d-m-y') );

    if ( empty( $post_title ) && isset( $post_title ) ) {
      echo "<h5 class='error_message'>The title cannot be empty</h5>";
    } else {

      if ( !empty( $post_image ) ) {
        move_uploaded_file($post_image_temp, "../images/$post_image");
      } else {
        $post_image = 'default_post.jpg';
      }
      
      $query = "INSERT INTO posts( post_category_id, post_title, post_author_id, post_date, ";
      $query .= "post_image, post_content, post_status) ";
      $query .= "VALUES('{$post_category_id}', '{$post_title}', '{$post_author_id}', ";
      $query .= "now(), '{$post_image}', '{$post_content}', '{$post_status}')";

      $create_post_query = mysqli_query($connection, $query);

      confirm_query($create_post_query);

      $post_id = mysqli_insert_id( $connection);

      echo "<h3 class='bg-success'>Post has been created.</h3>
      <h4>Click <a href='/new_cms/posts/$post_id'>here</a> to view current post or <a href='/new_cms/admin/posts'>here</a> to view all posts.</h4>";
    }


  }

?>

<form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="title">Post Title *</label>
    <input type="text" class="form-control" name="post_title">
  </div>

  <div class="form-group">
    <label for="post_author_id">Author</label>
    <select class="form-control" name="post_author_id" id="post_author_id">

    <?php display_authors( $_SESSION['user_id'] ); ?>
    
    </select>
   
  </div>

  <div class="form-group">
    <label for="post_category_id">Post Category</label>
    <select class="form-control" name="post_category_id" id="post_category_id">

    <?php display_categories( $post_category_id ); ?>
    
    </select>
   
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
    <input type="file" name="post_image" id="post_image">
  </div>

  <div class="form-group">
    <label for="summernote">Post Content</label>
    <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10"></textarea>
  </div>


  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="create_post" value="Create Post">
  </div>


</form>