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
      if ( isset( $_GET['author_id'] ) ) {

        $post_author_id = $_GET['author_id'];
        $post_author_name = get_author_name( $post_author_id   );
        $select_post_author_query = "SELECT * FROM posts WHERE post_status = 'published' AND post_author_id = $post_author_id";
        echo "<h2>Author: $post_author_name</h2>";
        display_posts( $select_post_author_query );
     


      } else {
      
        $select_all_authors_query = "SELECT * FROM posts WHERE post_status = 'published' GROUP BY post_author_id ORDER BY post_author_id DESC ";
        $select_all_authors_query_result = mysqli_query( $connection, $select_all_authors_query );
        confirm_query( $select_all_authors_query_result);

        while ( $row = mysqli_fetch_array( $select_all_authors_query_result ) ) {
          $post_author_id = $row['post_author_id'];
          $post_author_name = get_author_name( $post_author_id );
          echo "<h2>Author: <a href='authors.php?author_id=$post_author_id'>$post_author_name</a></h2>";
          //Select each individual post for this category
          $select_category_posts_query = "SELECT * FROM posts WHERE post_status = 'published' AND post_author_id = $post_author_id";
          display_posts( $select_category_posts_query );

        } 
        if ( mysqli_num_rows( $select_all_authors_query_result) == 0) {
          echo "<h1>No Author Yet</h1>";  
        }

      }
     
      
      ?>

    </div>

    <!-- Blog Sidebar Widgets Column -->
      <?php include 'includes/sidebar.php'; ?>

  </div>

  <hr>

 <?php include 'includes/footer.php'; ?>