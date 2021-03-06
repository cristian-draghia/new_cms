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
                <a class="navbar-brand" href="/new_cms/">CMS Site</a>
            </div>
            
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                <?php 
                //All postss button
                if ( basename( $_SERVER['PHP_SELF'] )  === 'posts.php' && empty( $_GET ) ) echo "<li class='active'>"; else echo "<li>";
                echo "<a href='/new_cms/posts'>All posts</a></li>";
                //Edit Post Button
                if ( isLoggedIn( 'user_role' ) && $_SESSION['user_role'] === 'administrator' && isset( $_GET['post_id'] ) )  {
                  $post_id = $_GET['post_id'];
                  echo "<li><a href='/new_cms/admin/posts?source=edit_post&post_id=$post_id'>Edit Post</a></li>";
                }
                ?>
                </ul>
                <!--Right side elements-->

                <ul class="nav navbar-nav navbar-right">
                <!-- Contact page -->
                <?php if ( basename( $_SERVER['PHP_SELF'] )  === 'contact.php') echo "<li class='active'>"; else echo "<li>";?>
                <a href="/new_cms/contact"><i class="fa fa-pencil-square" aria-hidden="true"></i> Contact</a></li>
                <?php 
                if ( !isLoggedIn( 'user_name' ) ) {
                  if ( basename( $_SERVER['PHP_SELF'] )  === 'login.php') echo "<li class='active'>"; else echo "<li>";
                  echo "<a href='/new_cms/login'><i class='fa fa-sign-in' aria-hidden='true'></i> Login</a></li>";
                  if ( basename( $_SERVER['PHP_SELF'] )  === 'register.php') echo "<li class='active'>"; else echo "<li>";
                  echo "<a href='/new_cms/register'><i class='fa fa-pencil-square-o' aria-hidden='true'></i> Register</a></li>";
                } else {
                  echo "<li><a href='/new_cms/admin/'><i class='fa fa-tachometer' aria-hidden='true'></i> Dashboard</a></li>";
                  if ( basename( $_SERVER['PHP_SELF'] )  === 'account.php') echo "<li class='active'>"; else echo "<li>";
                  echo "<a href='/new_cms/account.php'><i class='fa fa-user' aria-hidden='true'></i> " . $_SESSION['user_name'] . "</a></li>";
                  echo "<li><a href='/new_cms/includes/logout'><i class='fa fa-sign-out' aria-hidden='true'></i> Log Out</a></li>";
                }
                
                ?>
              </ul>
            </div>
            <!-- /.navbar-collapse -->
            
        </div>
        <!-- /.container -->

    </nav>