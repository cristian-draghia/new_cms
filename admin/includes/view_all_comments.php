<?php include("delete_modal.php"); ?>

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


    $query = 'SELECT * FROM comments';
    $select_comments = mysqli_query( $connection, $query );


    while ( $row = mysqli_fetch_assoc( $select_comments )) {
      $comment_id = escape( $row['comment_id'] );
      $comment_post_id = escape( $row['comment_post_id'] );
      $comment_author = escape( $row['comment_author'] );
      $comment_content = escape( $row['comment_content'] );
      $comment_email = escape( $row['comment_email'] );
      $comment_status = escape( $row['comment_status'] );
      $comment_date = escape( $row['comment_date'] );

      echo "<tr>";
      echo "<td>$comment_author</td>";
  
      
      echo "<td>$comment_content</td>";
      echo "<td>$comment_email</td>";
      
      echo "<td>";?> 

      <form action="comments.php?comment_id=<?php echo $comment_id; ?>" method="post">
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
      echo "<td><a rel='$comment_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>"; 
      echo "</tr>";

    }

    //Delete Comment
    delete_comment();

    // Update Comment Status
    update_comment_status();

    ?>


    
  </tbody>
</table>

<script>
  $(document).ready(function() {
    $(".delete_link").on("click", function() {
      var id = $(this).attr("rel");
      var delete_url ="comments.php?delete=" + id;

      $(".modal-delete_link").attr("href", delete_url);
      $("#myModal").modal("show");
    });

  });


</script>