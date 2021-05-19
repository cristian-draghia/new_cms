<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="./index.php">CMS Home Page</a>
            </div>
            
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                

                  <?php 
                  //All postss button
                  echo "<li><a href='posts.php'>All posts</a></li>";

                  
        

                  //Registration Button
                  if ( !isset( $_SESSION['user_name'] ) ) {
                    echo "<li><a href='registration.php'>Register</a></li>";

                  }
                  
                  //Admin Button
                  if ( isset( $_SESSION['user_role'] ) && $_SESSION['user_role'] === 'administrator' ) {
                      echo "<li><a href='admin'>Admin</a></li>";
                  }

                  //Log Out Button
                  if ( isset( $_SESSION['user_role'] ) ) {
                    echo "<li><a href='includes/logout.php'>Log out</a></li>";
                  }

                  //Edit Post Button
                  if ( isset( $_SESSION['user_role'] ) && $_SESSION['user_role'] === 'administrator' && isset( $_GET['post_id'] ) )  {
                    $post_id = $_GET['post_id'];
                    echo "<li><a href='admin/posts.php?source=edit_post&post_id=$post_id'>Edit Post</a></li>";

                }
                  
                  ?>


                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>