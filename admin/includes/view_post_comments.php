
<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Author</th>
      <th>Comment</th>
      <th>Email</th>
      <th>Status</th>
      <th>In Response to</th>
      <th>Date</th>
      <th>Delete</th>
    </tr>
  </thead>
  
  <tbody>
    <?php 

    if ( isset( $_GET['post_id'] ) ) {
      $comment_post_id = $_GET['post_id'];
    
      $query = "SELECT * FROM comments WHERE comment_post_id = $comment_post_id";
      $select_comments = mysqli_query( $connection, $query );


      while ( $row = mysqli_fetch_assoc( $select_comments )) {
        $comment_id = $row['comment_id'];
        $comment_author = $row['comment_author'];
        $comment_content = $row['comment_content'];
        $comment_email = $row['comment_email'];
        $comment_status = $row['comment_status'];
        $comment_date = $row['comment_date'];

        echo "<tr>";
        echo "<td>$comment_author</td>";
    
        
        echo "<td>$comment_content</td>";
        echo "<td>$comment_email</td>";
        
        echo "<td>";?> 

        <form action="comments.php?comment_id=<?php echo $comment_id; ?>&post_id=<?php echo $comment_post_id; ?>" method="post">
          <select class="form-control" name="comment_status_update" id="comment_status_update" onchange='this.form.submit()'>
            <?php 
            //Get Selected Status
            $selected_status_query = "SELECT comment_status FROM comments WHERE comment_id = $comment_id";
            $selected_status_query_result = mysqli_query( $connection, $selected_status_query );
            confirm_query( $selected_status_query_result );
            while ( $row = mysqli_fetch_assoc( $selected_status_query_result ) ) {
              $status_value = $row['comment_status'];

              if ( $status_value === 'approved' ) {
                echo "<option selected='selected' value = 'approved'>Approved</option>";
                echo "<option value = 'unapproved'>Unapproved</option>";

              } else {
                echo "<option value = 'approved'>Approved</option>";
                echo "<option selected='selected' value = 'unapproved'>Unapproved</option>";
              }
            
            }
            
            ?>
        
          </select>
        </form>
        
        <?php echo "</td>";

        //Display In Response to
        $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id}";
        $select_post_id = mysqli_query( $connection, $query );
        confirm_query( $select_post_id );
        while ($row = mysqli_fetch_assoc( $select_post_id ) ) {
          $comment_post_title = $row['post_title'];
          $comment_post_id = $row['post_id'];
          echo "<td><a href='../posts.php?post_id={$comment_post_id}'>$comment_post_title</a></td>";
        }

        echo "<td>$comment_date</td>";
        echo "<td><a href='comments.php?delete={$comment_id}&post_id=$comment_post_id' OnClick=\"return confirm( 'Are you sure you want to delete this comment?' );\">Delete</a></td>"; 
        echo "</tr>";

      }

      //Delete Comment
      delete_comment();

      // Update Comment Status
      update_comment_status();

    }

    ?>


    
  </tbody>
</table>