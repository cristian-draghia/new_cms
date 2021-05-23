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
      if ( isset( $_GET['category_id'] ) ) {

        $post_category_id = $_GET['category_id'];
        $post_category_name = get_post_category( $post_category_id );
        $select_post_category_query = "SELECT * FROM posts WHERE post_status = 'published' AND post_category_id = $post_category_id";
        echo "<h2>Category: $post_category_name</h2>";
        display_posts( $select_post_category_query );
     


      } else {
      
        $select_all_categories_query = "SELECT * FROM posts WHERE post_status = 'published' GROUP BY post_category_id ORDER BY post_category_id DESC";
        $select_all_categories_query_result = query_result( $select_all_categories_query );

        while ( $row = mysqli_fetch_assoc( $select_all_categories_query_result ) ) {
          $post_category_id = $row['post_category_id'];
          $post_category_name = get_post_category( $post_category_id );
          echo "<h2>Category: <a href='categories.php?category_id=$post_category_id'>$post_category_name</a></h2>";
          //Select each individual post for this category
          $select_category_posts_query = "SELECT * FROM posts WHERE post_status = 'published' AND post_category_id = $post_category_id";
          display_posts( $select_category_posts_query );

        } 
        if ( mysqli_num_rows( $select_all_categories_query_result) == 0) {
          echo "<h1>No Categories Yet</h1>";  
        }
      }
      ?>

    </div>

    <!-- Blog Sidebar Widgets Column -->
      <?php include 'includes/sidebar.php'; ?>

  </div>

  <hr>

 <?php include 'includes/footer.php'; ?>