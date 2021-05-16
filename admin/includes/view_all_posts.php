<?php
if ( isset( $_POST['submit_bulk_option'] ) && $_POST['select_bulk_option'] !== 'bulk_option' && isset( $_POST['posts'] ) ) {
  $bulk_option = $_POST['select_bulk_option'];
  $posts = $_POST['posts'];
  foreach ($posts as $post_id) {
    if ( $bulk_option === 'delete') {
      $delete_posts_query = "DELETE FROM posts WHERE post_id = $post_id";
      $delete_posts_query_result = mysqli_query( $connection, $delete_posts_query );
      confirm_query( $delete_posts_query_result );
    }
    else {
      $update_posts_query = "UPDATE posts SET post_status = '$bulk_option' WHERE post_id = $post_id";
      $update_posts_query_result = mysqli_query( $connection, $update_posts_query );
      confirm_query( $update_posts_query_result );
    }
  }
    
}


?>

<form action="posts.php" method="post" >

<div id="select_bulk_option" class="col-xs-4">
<select class="form-control" name="select_bulk_option">
  <option selected="selected" value="bulk_option">Bulk Option</option>  
  <option value="published">Published</option>
  <option value="draft">Draft</option>
  <option value="delete">Delete</option>
</select>
</div>

<div class="col-xs-4 form-group">
  <input class="btn btn-success" type="submit" name="submit_bulk_option" value="Apply"> 
  <a class="btn btn-primary " href="posts.php?source=add_post">Add New Post</a>
</div>

<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th><input class="form-control" type="checkbox" id="check_all_boxes" name="check_all_boxes"></th>
      <th>Id</th>
      <th>Author</th>
      <th>Title</th>
      <th>Category</th>
      <th>Status</th>
      <th>Image</th>
      <th>Tags</th>
      <th>Comments</th>
      <th>Date</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  
  <tbody>
    <?php 

    $query = 'SELECT * FROM posts';
    $select_posts = mysqli_query( $connection, $query );


    while ( $row = mysqli_fetch_assoc( $select_posts )) {
      $post_id = $row['post_id'];
      $post_author = $row['post_author'];
      $post_title = $row['post_title'];
      $post_category_id = $row['post_category_id'];
      $post_status = $row['post_status'];
      $post_image = $row['post_image'];
      $post_tags = $row['post_tags'];
      $post_comment_count = $row['post_comment_count'];
      $post_data = $row['post_date'];

      echo "<tr>";
      echo "<td><input class='form-control check_box' type='checkbox' name='posts[]' value='$post_id'></td>";
      echo "<td>$post_id</td>";
      echo "<td>$post_author</td>";
      echo "<td><a href='../post.php?post_id=$post_id'>$post_title</a></td>";
      echo "<td>"; ?>

      <form action="posts.php?post_id=<?php echo $post_id; ?>" method="post">
      <select class="form-control" name="update_post_category" id="update_post_category" onchange='this.form.submit()'>
      <?php
      //Display category
      $query = "SELECT * FROM categories";
      $select_categories_id = mysqli_query( $connection, $query );
      while ( $row = mysqli_fetch_assoc( $select_categories_id )) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        if ( $cat_id == $post_category_id ) {
          echo "<option selected='selected' value='$cat_id'>$cat_title</option>";
        } else {
          echo "<option value='$cat_id'>$cat_title</option>";
        }
      }
      ?>
 
      </select>
      </form>

      <?php
      echo "</td>";
      echo "<td>";?> 

      <form action="posts.php?post_id=<?php echo $post_id; ?>" method="post">
      <select class="form-control" name="post_status_update" id="post_status_update" onchange='this.form.submit()'>
      <?php
        if ( $post_status == 'draft' ) {
          echo "<option selected='selected' value='draft'>Draft</option>";
          echo "<option value='published'>Published</option>";
          
        } else {
          echo "<option value='draft'>Draft</option>";
          echo "<option selected='selected' value='published'>Published</option>";
        }
      // }
      ?>
      
        </select>
      </form>
      
      <?php echo "</td>";

      echo "<td align='center'><img src='../images/$post_image' width=75px ></td>";
      echo "<td>$post_tags</td>";

      //Total comments and approved comments
      $query = "SELECT * FROM comments WHERE comment_post_id = $post_id AND comment_status = 'approved'";
      $query_result = mysqli_query( $connection, $query );
      confirm_query( $query_result );
      $approved_comments = mysqli_num_rows( $query_result );
      echo "<td>$post_comment_count (" . ($approved_comments ? "$approved_comments" : "0") .  ")</td>";     
           

      echo "<td>$post_data</td>";
      echo "<td><a href='posts.php?source=edit_post&post_id={$post_id}'>Edit</a></td>";
      echo "<td><a href='posts.php?delete={$post_id}'>Delete</a></td>"; 
      echo "</tr>";

    }
    //Delete post
    delete_post();
    //Update post status
    update_post_status();
    //Update post category
    update_post_category();



    ?>


    
  </tbody>
</table>
</form>