<?php

include("delete_modal.php");

if ( isset( $_POST['submit_bulk_option'] ) && $_POST['select_bulk_option'] !== 'bulk_option' && isset( $_POST['posts'] ) ) {
  $bulk_option = escape( $_POST['select_bulk_option'] );
  $posts = $_POST['posts'];
  foreach ( $posts as $post_id ) {
    if ( $bulk_option === 'delete') {
      delete_query( 'posts', 'post_id', $post_id );
      delete_post_comments( $post_id );
    }
    elseif( $bulk_option === 'duplicate') {
      $post_array = get_post_info( $post_id );
      $duplicate_query = "INSERT INTO ";
      $duplicate_query .= "posts( post_category_id, post_title, post_author_id, post_date, post_image, post_content, post_status ) ";
      $duplicate_query .= "VALUES( {$post_array['post_category_id']}, '{$post_array['post_title']}', {$post_array['post_author_id']}, ";
      $duplicate_query .= "'{$post_array['post_date']}', '{$post_array['post_image']}', '{$post_array['post_content']}', '{$post_array['post_status']}' )";
      $duplicate_query_result = query_result( $duplicate_query );
    }
    elseif ( $bulk_option === 'reset_views' ) {
      $reset_views_query = "UPDATE posts SET post_views = 0 WHERE post_id = $post_id";
      $reset_views_query_result = query_result( $reset_views_query );
    }
    else {
      $update_posts_query = "UPDATE posts SET post_status = '$bulk_option' WHERE post_id = $post_id";
      $update_posts_query_result = query_result( $update_posts_query );
    }
  }
    
}
?>

<form action="posts.php" method="post" >

<div id="select_bulk_option" class="col-xs-4">
  <select class="form-control" name="select_bulk_option">
    <option selected="selected" value="bulk_option">Bulk Option</option>
    <option value="duplicate">Duplicate</option>
    <option value="published">Published</option>
    <option value="draft">Draft</option>
    <option value="reset_views">Reste Views</option>
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
      <th>Author</th>
      <th>Title</th>
      <th>Category</th>
      <th>Status</th>
      <th>Image</th>
      <th>Comments</th>
      <th>Date</th>
      <th>Edit</th>
      <th>Delete</th>
      <th>Views</th>
    </tr>
  </thead>
  
  <tbody>
    <?php 

    $query = 'SELECT * FROM posts ORDER BY post_id DESC';
    $select_posts = query_result( $query );
    
    while ( $row = mysqli_fetch_assoc( $select_posts )) {
      $post_id = escape( $row['post_id'] );
      $post_category_id = escape( $row['post_category_id'] );
      $post_category_name = get_post_category( $post_category_id );
      $post_title = escape( $row['post_title'] );
      $post_author_id = escape( $row['post_author_id'] );
      $post_author_name = get_author_name( $post_author_id );
      $post_date = escape( $row['post_date'] );
      $post_image = escape( $row['post_image'] );
      $post_status = escape( $row['post_status'] );    
      $post_views = escape( $row['post_views'] );
      $post_comments = get_post_comments_count( $post_id );
      $post_comment_count = $post_comments[0];
      $post_approved_comment_count = $post_comments[1];

      echo "<tr>";
      echo "<td><input class='form-control check_box' type='checkbox' name='posts[]' value='$post_id'></td>";
      echo "</form>";
      echo "<td>$post_author_name</td>";
      echo "<td><a href='/new_cms/posts/$post_id'>$post_title</a></td>";
      echo "<td>$post_category_name</td>";
      echo "<td>";
      ?>
      <form action="posts.php?post_id=<?php echo $post_id ?>" method="post" >
        <select class="form-control" name="update_post_status" onchange='this.form.submit();'>
        <?php
          if ( $post_status === 'draft' ) {
            echo "<option selected='selected' value='draft'>Draft</option>";
            echo "<option value='published'>Published</option>";
          } else {
            echo "<option value='draft'>Draft</option>";
            echo "<option selected='selected' value='published'>Published</option>";

          }
        ?>
        </select>
      </form>

      <?php
      echo"</td>";
      echo "<td align='center'><img src='../images/$post_image' width=75px ></td>";
      //Total comments and approved comments
      echo "<td>";
      if ( $post_comment_count > 0 ) {
        echo "<a href='comments.php?post_id=$post_id'>$post_comment_count ($post_approved_comment_count)</a>";
      } else {
        echo "$post_comment_count ($post_approved_comment_count)";
      }
      
      echo "</td>";
      echo "<td>$post_date</td>";
      echo "<td><a href='posts?source=edit_post&post_id={$post_id}'>Edit</a></td>";
      
      ?>
      
      <td>
      <form action="" method="post">
      
      <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
      <input class="btn btn-danger" type="submit" name="delete_post" value="Delete">

      </form>
      </td>

      <?php
      

      // echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";



      echo "<td>$post_views</td>";
      echo "</tr>";

    }
    
    //Delete post
    delete_post();
    //Update post status
    update_post_status();
    ?>

  </tbody>
</table>
</form>

<script>
  $(document).ready(function() {
    $(".delete_link").on("click", function() {
      var id = $(this).attr("rel");
      var delete_url ="posts.php?delete=" + id;

      $(".modal-delete_link").attr("href", delete_url);
      $("#myModal").modal("show");
    });

  });

</script>