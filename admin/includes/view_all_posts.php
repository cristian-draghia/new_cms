
<table class="table table-bordered table-hover">
  <thead>
    <tr>
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
      echo "<td>$post_id</td>";
      echo "<td>$post_author</td>";
      echo "<td><a href='../post.php?post_id=$post_id'>$post_title</a></td>";
      //Display category
      $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
      $select_categories_id = mysqli_query( $connection, $query );
      while ( $row = mysqli_fetch_assoc( $select_categories_id )) {
        $cat_title = $row['cat_title'];
      }
      echo "<td>$cat_title</td>";
      echo "<td>";?> 

      <form action="posts.php?post_id=<?php echo $post_id; ?>" method="post">
      <select class="form-control" name="post_status_update" id="post_status_update" onchange='this.form.submit()'>
      <?php
      //Get Post Status
      $selected_status_query = "SELECT post_status FROM posts WHERE post_id = $post_id";
      $selected_status_query_result = mysqli_query( $connection, $selected_status_query );
      confirm_query( $selected_status_query_result );
      while ( $row = mysqli_fetch_assoc( $selected_status_query_result ) ) {
        $status_value = $row['post_status'];

        if ( $status_value == 'draft' ) {
          echo "<option selected value='draft'>Draft</option>";
          echo "<option value='published'>Published</option>";
          
        } else {
          echo "<option value='draft'>Draft</option>";
          echo "<option selected value='published'>Published</option>";
        }
      }
      ?>
      
        </select>
      </form>
      
      <?php echo "</td>";

      echo "<td align='center'><img src='../images/$post_image' width=75px ></td>";
      echo "<td>$post_tags</td>";

      //Total comments and approved comments
      $query = "SELECT SUM(IF(comment_status = 'approved', 1, 0)) AS approved_comments FROM comments WHERE comment_post_id = $post_id";
      $query_result = mysqli_query( $connection, $query );
      confirm_query( $query_result );
      while ( $row = mysqli_fetch_assoc( $query_result ) ) {
        $approved_comments = $row['approved_comments'];
        echo "<td>$post_comment_count (" . ($approved_comments ? "$approved_comments" : "0") .  ")</td>";     
      }      

      echo "<td>$post_data</td>";
      echo "<td><a href='posts.php?source=edit_post&post_id={$post_id}'>Edit</a></td>";
      echo "<td><a href='posts.php?delete={$post_id}'>Delete</a></td>"; 
      echo "</tr>";

    }

    delete_post();


    if ( isset( $_POST['post_status_update'] ) && isset( $_GET['post_id'] ) ) {
      $post_status = $_POST['post_status_update'];
      $post_id = $_GET['post_id'];
      
      $update_post_status_query = "UPDATE posts SET post_status = '$post_status' WHERE  post_id = $post_id";
      $update_post_status_query_result = mysqli_query( $connection, $update_post_status_query );
      confirm_query( $update_post_status_query_result );
      header("Location: posts.php");

    }

    ?>


    
  </tbody>
</table>