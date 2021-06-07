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
        $count_posts_query = "SELECT * FROM posts WHERE post_status = 'published'";
        $count_posts_query_result = query_result( $count_posts_query );
        $count_posts = mysqli_num_rows( $count_posts_query_result );
        $count_divider = 5;
        $count_posts = ceil( $count_posts / $count_divider );
        
        if ( isset( $_GET['page'] ) ) {
          $page_number = $_GET['page'];
          $page_limit = ($page_number - 1) * $count_divider;
          $select_all_posts_query = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_id DESC ";
          $select_all_posts_query .= "LIMIT $page_limit, $count_divider";
          display_posts($select_all_posts_query);
        } else {
          $page_number = 1;
          $select_all_posts_query = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_id DESC ";
          $select_all_posts_query .= "LIMIT $count_divider";
          display_posts($select_all_posts_query);
        }
      ?>

    </div>

    <!-- Blog Sidebar Widgets Column -->
      <?php include 'includes/sidebar.php'; ?>

  </div>

  <ul class="pager">
    <?php
    if ( $count_posts > 1 ) {
      for( $i = 1; $i <= $count_posts; $i++ ) {
        if ($i == $page_number ) {
          echo "<li><a class='page-active' href='/new_cms/index?page=$i'>$i</a></li>";
        } else {
          echo "<li><a href='/new_cms/index?page=$i'>$i</a></li>";
        }
      }
    }
    ?>  
  </ul>
  

 <?php include 'includes/footer.php'; ?>