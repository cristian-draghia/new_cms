<?php

if ( !is_admin( $_SESSION['user_name'] ) ) {
  header("Location: posts.php");
}

if ( isset( $_POST['edit_post'] ) ) {
  $post_id = $_POST['post_id'];

  $query = "SELECT * FROM posts WHERE post_id = $post_id";
  $select_posts_by_id = mysqli_query( $connection, $query );


  while ( $row = mysqli_fetch_assoc( $select_posts_by_id ) ) {
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_author_id = $row['post_author_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_content = $row['post_content'];

  }

  if ( isset( $_POST['update_post'] ) ) {

    $post_title  = escape( $_POST['post_title'] );
    $post_category_id  = escape( $_POST['post_category_id'] );
    $post_author_id  = escape( $_POST['post_author_id'] );
    $post_status  = escape( $_POST['post_status'] );
    $post_image  = escape( $_FILES['post_image']['name'] );
    $post_image_temp  = escape( $_FILES['post_image']['tmp_name'] );
    $post_content  = escape( $_POST['post_content'] );

    move_uploaded_file($post_image_temp, "../images/$post_image");

    // Test if image is empy
    $post_image = test_empty_image( $post_id, $post_image, 'posts' );

    // Update Post
    update_post( $post_id, $post_category_id, $post_title, $post_author_id, $post_image, $post_content, $post_status );

  }

}

?>

<form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="title">Post Title</label>
    <input type="text" value="<?php echo $post_title; ?>" class="form-control" name="post_title">
  </div>

  <div class="form-group">
    <label for="post_author_id">Author</label><br>
    <select class="form-control" name="post_author_id" id="post_author_id">
    <?php display_authors( $post_author_id ); ?>
    </select>
  </div>

  <div class="form-group">
    <label for="post_category_id">Post Category</label><br>
    <select class="form-control" name="post_category_id" id="post_category_id">
    <?php display_categories( $post_category_id ); ?>
    </select>
  </div>


  <div class="form-group">
    <label for="post_status">Post Status</label>
    <select class="form-control" name="post_status" id="post_status">
      <?php
      //Get Post Status
      $selected_status_query = "SELECT post_status FROM posts WHERE post_id = $post_id";
      $selected_status_query_result = query_result( $selected_status_query );
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
    <input type="file" name="post_image" id="post_image">
  </div>

  <div class="form-group">
    <label for="summernote">Post Content</label>
    <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10"><?php echo $post_content; ?></textarea>
  </div>


  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
  </div>


</form>