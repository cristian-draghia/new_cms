<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/new_cms/admin/">CMS Admin</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li><a href="/new_cms/"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
                <?php echo users_online(); ?>
                <li><a href="/new_cms/admin/users">Online Users: <span class="users-online"></span></a></li>

                
       
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> 
                    <?php 
                    if ( isset(  $_SESSION['user_name']) ) {
                        echo $_SESSION['user_name'];
                    }
                     
                    ?>
                     <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="/new_cms/account.php"><i class="fa fa-user" aria-hidden="true"></i> Profile</a>
                        </li>
         
                        <li class="divider"></li>
                        <li>
                            <a href="/new_cms/includes/logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                     <li <?php if ( basename( $_SERVER['PHP_SELF'] )  === 'index.php') echo "class='active'"; ?>>
                        <a href="/new_cms/admin/"><i class="fa fa-tachometer" aria-hidden="true"></i> My Data</a>
                    </li>

                    <?php  if ( is_admin($_SESSION['user_name'] ) ):?>
                    <li <?php if ( basename( $_SERVER['PHP_SELF'] )  === 'dashboard.php') echo "class='active'"; ?>>
                        <a href="/new_cms/admin/dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a>
                    </li>
                    <?php endif ?>
                    
                    <li <?php if ( basename( $_SERVER['PHP_SELF'] )  === 'posts.php') echo "class='active'"; ?>>
                        <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-file-text" aria-hidden="true"></i> Posts <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                        <ul id="posts_dropdown" class="collapse">
                            <li>
                                <a href="/new_cms/admin/posts">Viw All Posts</a>
                            </li>
                            <li>
                                <a href="/new_cms/admin/posts?source=add_post">Add Posts</a>
                            </li>
                        </ul>
                    </li>
                    <li <?php if ( basename( $_SERVER['PHP_SELF'] )  === 'categories.php') echo "class='active'"; ?>>
                        <a href="/new_cms/admin/categories"><i class="fa fa-list" aria-hidden="true"></i> Categories</a>
                    </li>

                    <li <?php if ( basename( $_SERVER['PHP_SELF'] )  === 'comments.php') echo "class='active'"; ?> >
                        <a href="/new_cms/admin/comments"><i class="fa fa-comments" aria-hidden="true"></i> Comments</a>
                    </li>
           
                    <li <?php if ( basename( $_SERVER['PHP_SELF'] )  === 'users.php') echo "class='active'"; ?>>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-users" aria-hidden="true"></i> Users <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="/new_cms/admin/users">View All Users</a>
                            </li>
                            <li>
                                <a href="/new_cms/admin/users?source=add_user"> Add User </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <!-- /.navbar-collapse -->
        </nav>