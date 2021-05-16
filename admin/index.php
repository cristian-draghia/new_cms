<?php include 'includes/admin_header.php' ?>

    <div id="wrapper">




        <!-- Navigation -->

        <?php include 'includes/admin_navigation.php' ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin 
                            <small><?php echo $_SESSION['user_name']; ?></small>
                        </h1>
            
                    </div>
                </div>
                <!-- /.row -->
                
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <?php
                                    //Count how many posts
                                    $posts_count_query = "SELECT * FROM posts";
                                    $posts_count_query_result = mysqli_query( $connection, $posts_count_query );
                                    confirm_query( $posts_count_query_result );
                                    $posts_count = mysqli_num_rows( $posts_count_query_result );
                                    //Count published and draft posts
                                    $posts_published = 0;
                                    $posts_draft = 0;
                                    while ( $row = mysqli_fetch_assoc( $posts_count_query_result ) ) {
                                        if ( $row['post_status'] === 'published' ) {
                                            $posts_published++;
                                        } else {
                                            $posts_draft++;
                                        }
                                    }
                                    ?>
                                     <div class='huge'><?php echo $posts_count; ?></div>
                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <?php
                                    //Count how many comments
                                    $coments_count_query = "SELECT * FROM comments";
                                    $coments_count_query_result = mysqli_query( $connection, $coments_count_query );
                                    confirm_query( $coments_count_query_result );
                                    $coments_count = mysqli_num_rows( $coments_count_query_result );
                                    //Count approved and unapproved comments
                                    $comments_approved = 0;
                                    $comments_unapproved = 0;
                                    while ( $row = mysqli_fetch_assoc( $coments_count_query_result ) ) {
                                        if ( $row['comment_status'] === 'approved' ) {
                                            $comments_approved++;
                                        } else {
                                            $comments_unapproved++;
                                        }
                                    }
                                    ?>
                                    <div class='huge'><?php echo $coments_count; ?></div>
                                    <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <?php
                                    //Count how many users
                                    $users_count_query = "SELECT * FROM users";
                                    $users_count_query_result = mysqli_query( $connection, $users_count_query );
                                    confirm_query( $users_count_query_result );
                                    $users_count = mysqli_num_rows( $users_count_query_result );
                                    //Count admin and subscriber users
                                    $users_admin = 0;
                                    $users_subscriber = 0;
                                    while ( $row = mysqli_fetch_assoc( $users_count_query_result ) ) {
                                        if ( $row['user_role'] === 'administrator' ) {
                                            $users_admin++;
                                        } else {
                                            $users_subscriber++;
                                        }
                                    }
                                    ?>
                                    <div class='huge'><?php echo $users_count; ?></div>
                                        <div> Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <?php
                                    //Count how many categories
                                    $categories_count_query = "SELECT * FROM categories";
                                    $categories_count_query_result = mysqli_query( $connection, $categories_count_query );
                                    confirm_query( $categories_count_query_result );
                                    $categories_count = mysqli_num_rows( $categories_count_query_result );
                                    ?>
                                        <div class='huge'><?php echo $categories_count; ?></div>
                                        <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <?php

                ?>

                <div class="row">
                <script type="text/javascript">
                    google.charts.load('current', {'packages':['bar']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                        ['Data', 'Count'],

                        <?php
                        $chart_element_text = array(
                            'Published Posts',
                            'Draft Posts',
                            'Approved Comments',
                            'Unapproved Comments',
                            'Admin Users',
                            'Subscriber Users',
                        );

                        $chart_element_count = array(
                            $posts_published,
                            $posts_draft,
                            $comments_approved,
                            $comments_unapproved,
                            $users_admin,
                            $users_subscriber,
                        ) ;

                        for( $i = 0; $i < sizeof( $chart_element_count ); $i++) {
                            echo "['$chart_element_text[$i]', $chart_element_count[$i]],";
                        }
                        ?>


                 
                        ]);

                        var options = {
                        chart: {
                            title: '',
                            subtitle: '',
                        }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                </script>

                    
                    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>


                
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include 'includes/admin_footer.php' ?>