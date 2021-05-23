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
                <a class="navbar-brand" href="./index.php">CMS Site</a>
            </div>
            
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                <?php 
                //All postss button
                if ( $active_page === 'posts' && empty( $_GET ) ) {
                  echo "<li class='active'><a href='posts.php'>All posts</a></li>";
                } else {
                  echo "<li><a href='posts.php'>All posts</a></li>";
                }
                //Edit Post Button
                if ( isset( $_SESSION['user_role'] ) && $_SESSION['user_role'] === 'administrator' && isset( $_GET['post_id'] ) )  {
                  $post_id = $_GET['post_id'];
                  echo "<li><a href='admin/posts.php?source=edit_post&post_id=$post_id'>Edit Post</a></li>";
                }
                ?>
                </ul>
                <!--Right side elements-->
                <ul class="nav navbar-nav navbar-right">
                <?php 
                if ( !isset( $_SESSION['user_name'] ) ) {
                  echo "<li><a href='./login.php'><i class='fa fa-sign-in' aria-hidden='true'></i> Login</a></li>";
                  echo "<li><a href='./register.php'><i class='fa fa-pencil-square-o' aria-hidden='true'></i> Register</a></li>";
                }

                if ( isset( $_SESSION['user_name'] ) ){
                  echo "<li><a href='admin/index.php'><i class='fa fa-tachometer' aria-hidden='true'></i> Dashboard</a></li>";
                  echo "<li><a href='account.php'><i class='fa fa-user' aria-hidden='true'></i> " . $_SESSION['user_name'] . "</a></li>";
                  echo "<li><a href='includes/logout.php'><i class='fa fa-sign-out' aria-hidden='true'></i> Log Out</a></li>";
                }
                ?>
              </ul>
            </div>
            <!-- /.navbar-collapse -->
            
        </div>
        <!-- /.container -->

    </nav>