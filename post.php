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
                }
                
                $query_post = "SELECT * FROM posts WHERE post_id = {$post_id}";

                $select_all_post_query = mysqli_query( $connection, $query_post );

                while ( $row = mysqli_fetch_assoc( $select_all_post_query )) {
                  $post_title = $row['post_title'];
                  $post_author = $row['post_author'];
                  $post_date = $row['post_date'];
                  $post_image = $row['post_image'];
                  $post_content = $row['post_content'];
                  ?>

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

    


                <?php } ?>

                
                <!-- Blog Comments -->

                <?php
                if ( isset( $_POST['create_comment'] ) ) {
                    $post_id = $_GET['post_id'];
                    $comment_author = $_POST['comment_author'];
                    $comment_content = $_POST['comment_content'];
                    $comment_email = $_POST['comment_email'];

                    $insert_comment_query = "INSERT INTO ";
                    $insert_comment_query .= "comments(comment_post_id, comment_author, comment_content, ";
                    $insert_comment_query .= "comment_email, comment_status, comment_date) " ;
                    $insert_comment_query .= "VALUES({$post_id}, '{$comment_author}', '{$comment_content}', ";
                    $insert_comment_query .= "'{$comment_email}', 'unapprove', now())";

                    $insert_comment_query_result = mysqli_query( $connection, $insert_comment_query );

                    confirm_query( $insert_comment_query_result );

                    $update_comment_count_query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
                    $update_comment_count_query .= "WHERE post_id = $post_id";

                    $update_comment_count_query_result = mysqli_query( $connection, $update_comment_count_query);
                    confirm_query($update_comment_count_query_result);


                    
                    
                }


                ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form" >
                        <div class="form-group">
                            <label for="comment_author">Author</label>
                            <input type="text" name="comment_author" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="comment_email">Email</label>
                            <input type="email" name="comment_email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="comment_content">Comment Content</label>
                            <textarea name="comment_content" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <?php 

                $select_all_comments_querry = "SELECT * from comments WHERE comment_post_id = $post_id AND comment_status = 'approved' ORDER BY comment_id DESC";
                $select_all_comments_querry_result = mysqli_query( $connection, $select_all_comments_querry );
                confirm_query( $select_all_comments_querry_result );
                
                while ( $row = mysqli_fetch_assoc( $select_all_comments_querry_result ) ) {
                    $comment_author = $row['comment_author'];
                    $comment_content = $row['comment_content'];
                    $comment_date = $row['comment_date'];

                    ?>
                    <!-- Comment -->
                    <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>

                <?php } ?>

        
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include 'includes/sidebar.php'; ?>

        </div>
        <!-- /.row -->

        <hr>

 <?php include 'includes/footer.php'; ?>