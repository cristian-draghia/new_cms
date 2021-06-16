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
    if ( isset( $_POST['search'] ) ) {
      $search_term = $_POST['search'];
      $search_query = "SELECT * FROM posts WHERE post_status = 'published' AND (post_title LIKE '%$search_term%' OR post_content LIKE '%$search_term%' OR post_title)";
      $search_query_result = query_result( $search_query );
      $count = mysqli_num_rows($search_query_result);

      if ( $count == 0 ) {
          echo '<h1>No Results</h1>';
      } else {
        display_posts($search_query);
      }

    }

    ?>




          
    




      </div>

      <!-- Blog Sidebar Widgets Column -->
      <?php include 'includes/sidebar.php'; ?>

  </div>
  <!-- /.row -->

  <hr>

 <?php include 'includes/footer.php'; ?>