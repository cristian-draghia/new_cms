<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

<!-- Navigation -->

<?php include 'includes/navigation.php';?>

<!-- Page Content -->
<div class="container">

  <div class="row">

    <!-- Blog Entries Column -->
    <div class="col-md-8">

      

      <?php 
      if ( isset( $_GET['post_id'] ) ) {

        $post_id = $_GET['post_id'];
        $select_post_query = "SELECT * FROM posts WHERE post_id = {$post_id}";
        display_posts( $select_post_query );
        display_comments( $post_id ) ;


      } else {
      
        $select_all_posts_query = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_id DESC";
        display_posts( $select_all_posts_query );

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