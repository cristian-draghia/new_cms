<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

<!-- Navigation -->

<?php include 'includes/navigation.php';?>


<?php 

if ( isset( $_POST['liked'] ) ) {
  $post_id = $_POST['post_id'];
  $user_id = $_POST['user_id'];

  $create_likes_query = "INSERT INTO likes(user_id, post_id) VALUES($user_id, $post_id)";
  $create_likes_query_result = query_result( $create_likes_query );
  exit();

}

if ( isset( $_POST['unliked'] ) ) {
  $post_id = $_POST['post_id'];
  $user_id = $_POST['user_id'];

  $delete_likes_query = "DELETE FROM likes WHERE post_id = $post_id and user_id = $user_id";
  $delete_likes_query_result = query_result( $delete_likes_query );
  exit();

}



?>

<!-- Page Content -->
<div class="container">

  <div class="row">

    <!-- Blog Entries Column -->
    <div class="col-md-8">

      <?php 
      if ( isset( $_GET['post_id'] ) ) {
        $post_id = $_GET['post_id'];
        $select_post_query = "SELECT * FROM posts WHERE post_id = {$post_id}";
        $select_post_query_result = query_result( $select_post_query );
        while ( $row = mysqli_fetch_assoc( $select_post_query_result ) ) {
          $post_status = escape( $row['post_status'] );
          if ( $post_status === 'published' ) {
            $query_update_view = "UPDATE posts SET post_views = post_views + 1 WHERE post_id = $post_id";
            $query_update_view_result = query_result ( $query_update_view );
          }
          display_posts( $select_post_query );
          display_comments( $post_id, $post_status );
        }
        //Return to post if id doesn't exist
        if ( mysqli_num_rows( $select_post_query_result ) == 0 ) {
          header("Location: /new_cms/posts");
        }
            
      } else {
        if ( isset( $_SESSION['user_role'] ) && $_SESSION['user_role'] == 'administrator' ) {
          $select_all_posts_query = "SELECT * FROM posts ORDER BY post_id DESC";
          display_posts( $select_all_posts_query );
        } else {
          $select_all_posts_query = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_id DESC";
          display_posts( $select_all_posts_query );
        }
      }
      if ( isset( $_POST['create_comment'] ) ) {
        leave_comment(); 
      }
      ?>
      
    </div>

    <!-- Blog Sidebar Widgets Column -->
      <?php include 'includes/sidebar.php'; ?>

  </div>

  <hr>

 <?php include 'includes/footer.php'; ?>

 <script>
 
      $(document).ready(function() {
        $("[data-toggle='tooltip']").tooltip();


        var the_post_id = <?php echo $post_id; ?>;
        var user_id = <?php echo get_logged_user_id(); ?>

        //Like
        $('.like').click(function() {
          $.ajax({
            url: "/new_cms/posts.php?post_id=<?php echo $post_id; ?>",
            type: 'post',
            data: {
              'liked': 1,
              'post_id': the_post_id,
              'user_id': user_id
              
            }
          })
        });

        //Unlike
        $('.unlike').click(function() {
          $.ajax({
            url: "/new_cms/posts.php?post_id=<?php echo $post_id; ?>",
            type: 'post',
            data: {
              'unliked': 1,
              'post_id': the_post_id,
              'user_id': user_id
              
            }
          })
        });


      });
 
 </script>