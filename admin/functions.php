<?php

function redirect( $location ) {
  header( "Location: " . $location);
  exit;
}

function ifItIsMethod( $method = null ) {
  if ($_SERVER['REQUEST_METHOD'] == strtoupper( $method ) ) {
    return true;
  } 
  return false;
}

function isLoggedIn( $session ) {
  if ( isset( $_SESSION[ $session ] ) ) {
    return true;
  }
  return false;
}

function checkIfUserIsLoggedInAndRedirect( $redirectLocation =null ) {
  if ( isLoggedIn( 'user_name' ) ) {
    redirect( $redirectLocation );
  }

}

function escape( $string ) {
  global $connection;
  return mysqli_real_escape_string( $connection, trim( $string ) );
}

function confirm_query( $query ) {
  global $connection;
  if ( !$query) {
    die("Query Failed" . mysqli_error($connection) );
  }
}
function query_result( $query ) {
  global $connection;
  $query_result = mysqli_query ( $connection, $query );
  confirm_query( $query_result );
  return $query_result;
}

function escape_string( $string ) {
  global $connection;
  return mysqli_real_escape_string ( $connection, $string );
}

function is_admin( $user_name ) {
  global $connection;
  $is_admin_query = "SELECT user_role FROM users WHERE user_name = '$user_name' ";
  $is_admin_query_result = query_result( $is_admin_query );
  $row = mysqli_fetch_assoc( $is_admin_query_result );
  return ($row['user_role'] === 'administrator' ? true : false); 
}

function register_user( &$user_name, &$user_email, &$message, &$message_state) {
  global $connection;
  if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset( $_POST['register'] ) ) {
  $user_name = trim( escape( $_POST['user_name'] ) ) ;
  $user_email = trim( escape( $_POST['user_email'] ) );
  $user_password = trim( escape( $_POST['user_password'] ) );
  $user_password_confirm = trim( escape( $_POST['user_password_confirm'] ) );
  
  $check_name = !empty($user_name) && strlen($user_name) > 3;
  $check_email = !empty($user_email) && strlen($user_email) > 3;
  $check_password = !empty($user_password) && strlen($user_password) > 3;
  $check_password_confirm = !empty($user_password_confirm) && strlen($user_password_confirm) > 3;

  if ( $check_name && $check_email && $check_password && $check_password_confirm ) {

    $check_users_query = "SELECT user_name, user_email FROM users WHERE user_name = '$user_name' OR user_email = '$user_email'";
    $check_users_query_result = query_result( $check_users_query );

    while ( $row = mysqli_fetch_array( $check_users_query_result ) ) {
      if ( $user_name === $row['user_name'] ) {
        $message = "This username already exists";
        $message_state = "error";
        break;
      }
      if ( $user_email === $row['user_email'] ) {
        $message = "An account with this email has already been created";
        $message_state = "error";
        break;
      }
    }

    if ( mysqli_num_rows( $check_users_query_result ) == 0 ) {
      if ( $user_password !== $user_password_confirm ) {
        $message = "The passwords has to be the same";
        $message_state = "error";
      } else {
        $hash = password_hash($user_password, PASSWORD_BCRYPT);
        $add_user_query = "INSERT INTO users (user_name, user_password, user_email, user_image, user_role) ";
        $add_user_query .= "VALUES('$user_name', '$hash', '$user_email', 'default_user.jpg', 'subscriber')";
        $add_user_query_result = mysqli_query( $connection, $add_user_query );
        confirm_query( $add_user_query_result );
        $message = "The user <span style='color:blue;'>$user_name</span> has just been created";
        if ( basename( $_SERVER['PHP_SELF'] )  === 'register.php') {
          $message .= "<br>Click <a href='login.php?user_name=$user_name'>here</a> to log in";
        }
        $message_state = "correct";
      }
        
    }

  } else {
    $message = "Fields cannot be empy or lower than 4 characters";
    $message_state = "error";
  }
       
}

}

function register_user_form( $user_name, $user_email, $message, $message_state) {
  global $connection;

  ?>
  <form role="form" action="" method="post" id="login-form" autocomplete="off">
  <?php 
  if ( !empty( $message ) && !empty( $message_state ) ) {
    if ( $message_state === "error") {
      echo "<h5 class='error_message'>$message</h5>";
    } else {
      echo "<h5 class='proper_message'>$message</h5>";
    }
  }
  ?>
  <div class="form-group">
    <input type="text" name="user_name" id="username" class="form-control" placeholder="Username" 
    autocomplete="on" value="<?php echo ( isset( $user_name) ? $user_name : '') ?>">
  </div>
  <div class="form-group">
    <input type="email" name="user_email" id="email" class="form-control" placeholder="Email" 
    autocomplete="on" value="<?php echo ( isset( $user_email) ? $user_email : '') ?>">
  </div>
  <div class="form-group">
    <input type="password" name="user_password" id="password" class="form-control" placeholder="Password">
  </div>
  <div class="form-group">
    <input type="password" name="user_password_confirm" id="password_confirm" class="form-control" placeholder="Confirm Password">
  </div>
  <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block register-btn" value="Register">
</form>

<?php
}

function update_user_name_email($user_id, $user_info, $new_user_info, $column, $messages) {
  global $connection;
  global $messages;
  if ( $user_info !== $new_user_info ) {
    $check_user_info_query = "SELECT $column FROM users WHERE $column = '$new_user_info'";
    $check_user_info_query_result = query_result( $check_user_info_query );
    if ( mysqli_num_rows( $check_user_info_query_result ) == 0 ) {
      $update_user_info_query = "UPDATE users SET $column = '$new_user_info' WHERE user_id = $user_id";
      $update_user_info_query_result = mysqli_query( $connection, $update_user_info_query );
      confirm_query( $update_user_info_query_result );
      if ( $user_info === $_SESSION[ $column ]) {
        $_SESSION[ $column ] = $new_user_info;
      }
    } else {
      if ( $column === 'user_name' ) {
        array_push( $messages, "This username already exists");
      } else {
        array_push( $messages, "This email already exists");
      }
    }
  }
}

function update_user_info($user_id, $user_info, $new_user_info, $column) {
  global $connection;
  if ( $user_info !== $new_user_info) {
    $update_user_info_query = "UPDATE users SET $column = '$new_user_info' WHERE user_id = $user_id";
    $update_user_info_query_result = mysqli_query( $connection, $update_user_info_query );
    confirm_query( $update_user_info_query_result );
    if ( $user_info === $_SESSION[ $column ]) {
      $_SESSION[ $column ] = $new_user_info;
    }
  }
}

function update_post( $post_id, $post_category_id, $post_title, $post_author_id, $post_image, $post_content, $post_status ) {
  global $connection;
  $query = "UPDATE posts SET ";
  $query .= "post_category_id = '$post_category_id', ";
  $query .= "post_title = '{$post_title}', ";
  $query .= "post_author_id = {$post_author_id}, ";
  $query .= "post_date = now(), ";
  $query .= "post_image = '{$post_image}', ";
  $query .= "post_content = '{$post_content}', ";
  $query .= "post_status = '{$post_status}' ";
  $query .= "WHERE post_id = {$post_id} ";    

  $query_result = query_result( $query );
  // header("Location: posts.php");
  echo "<h3 class='bg-success'>Post has been updated.</h3>
  <h4>Click <a href='/new_cms/posts/$post_id'>here</a> to view current post or <a href='/new_cms/admin/posts'>here</a> to view all posts.</h4>";

}

function get_post_info( $post_id ) {
  $query = "SELECT * FROM posts WHERE post_id = $post_id";
  $query_result = query_result( $query );
  $row = mysqli_fetch_assoc( $query_result );
  $post_array = array(
    "post_category_id" => escape( $row['post_category_id'] ),
    "post_title" => escape( $row['post_title'] ),
    "post_author_id" => escape( $row['post_author_id'] ),
    "post_date" => escape( $row['post_date'] ),
    "post_image" => escape( $row['post_image'] ),
    "post_content" => escape( $row['post_content'] ),
    "post_status" => escape( $row['post_status'] ),
  );

  return $post_array;

}

function delete_query( $table, $column, $value ) {
  $query = "DELETE FROM $table WHERE $column = $value";
  $query_result = query_result( $query );
}

function delete_category() {
  global $connection;
  if( isset( $_GET['delete'] ) && is_admin( $_SESSION['user_name'] ) ) {
    $cat_id = escape( $_GET['delete'] );
    delete_query( 'categories', 'cat_id', $cat_id );
    $select_all_posts_query = "SELECT * FROM posts WHERE post_category_id = $cat_id";
    $select_all_posts_query_result = query_result( $select_all_posts_query );
    while ( $row = mysqli_fetch_assoc( $select_all_posts_query_result ) ) {
      $update_category_query = "UPDATE posts SET post_category_id = 1";
      $update_category_query_result = query_result( $update_category_query );
    }
    header("Location: /new_cms/admin/categories");
  }
}

function delete_post() {
  global $connection;
  if ( isset( $_POST['delete_post'] ) && is_admin($_SESSION['user_name'])) {
    $post_id = escape( $_POST['post_id'] );
    delete_query( 'posts', 'post_id', $post_id );
    delete_post_comments( $post_id );
    header("Location: /new_cms/admin/posts");
  }
}

function delete_post_comments( $post_id ) {
  global $connection;
  $select_all_comments_querry = "SELECT comment_id FROM comments WHERE comment_post_id = $post_id";
  $select_all_comments_querry_result = query_result( $select_all_comments_querry );
  while ( $row = mysqli_fetch_assoc( $select_all_comments_querry_result ) ) {
    delete_query( 'comments ', 'comment_id', escape( $row['comment_id'] ) );
  }

}

function delete_comment() {
  global $connection;
  if ( isset( $_GET['delete'] ) && is_admin( $_SESSION['user_name'] ) ) {
    $comment_id = escape( $_GET['delete'] );
    $post_id = escape( $_GET['post_id'] );
    delete_query( 'comments ', 'comment_id', $comment_id );
    if ( isset( $_GET['post_id'] ) ) {
      header("Location: /new_cms/admin/comments.php?post_id=$post_id"); 
    } else {
      header("Location: /new_cms/admin/comments"); 
    }
  }
}

function insert_categories() {
  global $connection;

  if( isset( $_POST['submit'] )) {
                      
    $cat_title = escape( $_POST['cat_title'] );

    if( $cat_title == '' || empty( $cat_title )) {
      echo "This field should not be empy";
    } else {
      $stmt = mysqli_prepare( $connection, "INSERT INTO categories(cat_title) VALUE (?)");
      mysqli_stmt_bind_param( $stmt, "s", $cat_title );
      mysqli_stmt_execute( $stmt );
      if( !$stmt ) {
        die('QUERY FAILED' . mysqli_error( $connection ));
      }
      mysqli_stmt_close( $stmt );
    }
  }
}

function find_all_categories() {
  global $connection;
  $query = 'SELECT * FROM categories';
  $select_categories = mysqli_query( $connection, $query );


  while ( $row = mysqli_fetch_assoc( $select_categories )) {
      $cat_id = escape( $row['cat_id'] );
      $cat_title = escape( $row['cat_title'] );
      echo "<tr>";
      echo "<td>{$cat_id}</td>";
      echo "<td>{$cat_title}</td>";
      if ( $cat_id > 1 ) {
        echo "<td><a href='categories.php?edit={$cat_id}'>EDIT</a></td>"; 
        echo "<td><a href='categories.php?delete={$cat_id}' OnClick=\"return confirm( 'Are you sure you want to delete this category?' );\">DELETE</a></td>";
      }
      echo "</tr>";
  }
}

function display_categories( $selected_cat_id ) {
  $select_all_categories_query = "SELECT * FROM categories";
  $select_all_categories_query_result = query_result( $select_all_categories_query );
  while ( $row = mysqli_fetch_assoc( $select_all_categories_query_result ) ) {
    $cat_id = escape( $row['cat_id'] );
    $cat_title = escape( $row['cat_title'] );
    if ( $cat_id == $selected_cat_id ) {
      echo "<option selected='selected' value='{$cat_id}'>{$cat_title}</option>";
    } else {
      echo "<option value='{$cat_id}'>{$cat_title}</option>";
    }
  }
}

function update_post_author( $post_author_id, $post_id ) {
  global $connection;
  $update_post_author_query = "UPDATE posts SET post_author_id = $post_author_id WHERE post_id = $post_id";
  $update_post_author_query_result = query_result( $update_post_author_query );
}

function update_post_status() {
  global $connection;
  if ( isset( $_POST['update_post_status'] ) && isset( $_GET['post_id'] ) ) {
    $post_status = escape( $_POST['update_post_status'] );
    $post_id = escape( $_GET['post_id'] );
    $update_post_status_query = "UPDATE posts SET post_status = '$post_status' WHERE  post_id = $post_id";
    $update_post_status_query_result = query_result( $update_post_status_query );
    header("Location: /new_cms/admin/posts");
  }

}

function test_empty_image($test_id, $test_image, $table) {
  global $connection;
  if ( empty( $test_image )) {
    $current_id = substr($table, 0, -1) . '_id';
    $current_image = substr($table, 0, -1) . '_image';
    $update_same_image_query = "SELECT * FROM $table WHERE $current_id = $test_id";
    $update_same_image_query_result = mysqli_query( $connection, $update_same_image_query );
    while ($row = mysqli_fetch_assoc( $update_same_image_query_result ) ) {
      $test_image = escape( $row[$current_image] );
    }
  }
  return $test_image;
}


function update_comment_status() {
  global $connection;

  if ( isset($_POST['comment_status_update']) && isset( $_GET['comment_id'] ) )  {

    $comment_status = escape( $_POST['comment_status_update'] );
    $comment_id = escape( $_GET['comment_id'] );
    
    $update_comment_status_query = "UPDATE comments SET comment_status = '$comment_status' WHERE  comment_id = $comment_id";
    $update_comment_status_query_result = query_result( $update_comment_status_query );
    if ( isset( $_GET['post_id'] ) ) {
      $post_id = escape( $_GET['post_id'] );
      header("Location: /new_cms/admin/comments/$post_id");
    } else {
      header("Location: /new_cms/admin/comments");
    }
    
  }


}

function delete_user() {
  global $connection;
  if ( isset( $_GET['delete'] ) && is_admin( $_SESSION['user_name'] ) ) {
    $delete_user_id = escape( $_GET['delete'] );
    $get_user_posts = "SELECT * FROM posts WHERE post_author_id = $delete_user_id";
    $get_user_posts_result = query_result ( $get_user_posts );
    while ($row = mysqli_fetch_assoc( $get_user_posts_result ) ) {
      $post_id = escape( $row['post_id'] );
      update_post_author(1, $post_id );
    }
    $delete_user_query = "DELETE FROM users WHERE user_id = $delete_user_id";
    $delete_user_query_result = query_result( $delete_user_query );
    header("Location: /new_cms/admin/users");
  }
}

function update_user_role() {
  global $connection;
  if ( isset( $_POST['updated_user_role'] ) && isset( $_GET['user_id'] ) ) {
    $user_id = escape( $_GET['user_id'] );
    $user_role = escape( $_POST['updated_user_role'] );
    
    $update_user_role_query = "UPDATE users SET user_role = '$user_role' WHERE  user_id = $user_id";
    $update_user_role_query_result = mysqli_query( $connection, $update_user_role_query );
    confirm_query( $update_user_role_query_result );
    if ( $user_id === $_SESSION['user_id'] ) {
      $_SESSION['user_role'] = $user_role;
    }

    header("Location: /new_cms/admin/users");

  }

}

function set_new_session( $user_id, $user_name, $user_firstname, $user_lastname, $user_email, $user_image, $user_role) {
  global $connection;
  $_SESSION['user_id'] = $user_id;
  $_SESSION['user_name'] = $user_name;
  $_SESSION['user_firstname'] = $user_firstname;
  $_SESSION['user_lastname'] = $user_lastname;
  $_SESSION['user_email'] = $user_email;
  $_SESSION['user_image'] = $user_image;
  $_SESSION['user_role'] = $user_role;
}

function get_author_name( $post_author_id ) {
  global $connection;
  $get_author_name_query = "SELECT user_name FROM users WHERE user_id = $post_author_id";
  $get_author_name_query_result = query_result( $get_author_name_query );
  $row = mysqli_fetch_array( $get_author_name_query_result );
  return escape( $row['user_name'] );
}

function get_post_category( $post_id ) {
  global $connection;
  $get_post_category_query = "SELECT cat_title FROM categories WHERE cat_id = $post_id";
  $get_post_category_query_result = query_result( $get_post_category_query );
  $row = mysqli_fetch_array( $get_post_category_query_result );
  return escape( $row['cat_title'] );
}

function get_post_comments_count ( $post_id ) {
  global $connection;
  $approved_comments = 0;
  $get_post_comments_count_query = "SELECT comment_status FROM comments WHERE comment_post_id = $post_id";
  $get_post_comments_count_query_result = query_result( $get_post_comments_count_query );
  while ( $row = mysqli_fetch_array( $get_post_comments_count_query_result ) ) {
    if ( escape( $row['comment_status'] ) === 'approved' ) {
      $approved_comments++;
    }
  }

  return [ mysqli_num_rows( $get_post_comments_count_query_result ), $approved_comments ];

}

function create_single_post( $post_id, $post_category_id, $post_category_name, $post_title, $post_author_id, $post_author_name, 
                             $post_date, $post_image, $post_content, $post_status ) {

  if ( (isset( $_SESSION['user_role'] ) && $_SESSION['user_role'] == 'administrator' ) || $post_status === 'published')  {
  ?>
  
  <!-- HTML -->
  <div class="single-post">
      
      <!-- First Blog Post -->
      <h2>
      <?php
        if ( isset( $_GET['post_id'] ) ) {
          echo "$post_title";
        } else {
          echo "<a href='posts/$post_id'>$post_title</a>";
        }
      ?>
      </h2>
      <p class="lead">
        <?php 
        if ( isset( $_GET['author_id'] ) ) {
          echo "Done by: $post_author_name";
        } else {
          echo "Done by: <a href='/new_cms/authors/$post_author_id'>$post_author_name</a>";
        }
        ?>
      </p>
      <?php 
      if ( isset( $_SESSION['user_role'] ) && $_SESSION['user_role'] == 'administrator' && $_SERVER['PHP_SELF'] !== '/new_cms/index.php' ) {
        echo "<p class='lead'> Status: $post_status</p>";
      }
      ?>
      <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
      <hr>
      <?php
        if ( isset( $_GET['post_id'] ) ) {
          echo "<img class='img-responsive' src='/new_cms/images/$post_image' alt=''>";
        } else {
          echo "<a href='/new_cms/posts/$post_id'><img class='img-responsive' src='/new_cms/images/$post_image' alt=''></a>";
        }
      ?>
      <hr>
      <p><?php echo $post_content; ?></p>
      <?php 
        if ( !isset( $_GET['post_id'] ) ) {
          echo "<a class='btn btn-primary' href='/new_cms/posts/$post_id'>Read More <span class='glyphicon glyphicon-chevron-right'></span></a>";
        }
      ?>  
      <hr>
      <p>
      <?php 
        if ( isset( $_GET['category_id'] ) ) {
          echo "Category: $post_category_name";
        } else {
          echo "Category: <a href='/new_cms/categories/$post_category_id'>$post_category_name</a>";
        }

      ?>
    </div>

  <?php
  //Return to post if post is draft and user not admin
  } elseif ( $post_status === 'draft') {
    header("Location: /new_cms/posts");
  }
  
}

function display_posts( $query ) {
  global $connection;
  $query_result = query_result( $query );

  while ( $row = mysqli_fetch_assoc( $query_result )) {
    $post_id = escape( $row['post_id'] );
    $post_category_id = escape( $row['post_category_id'] );
    $post_category_name = get_post_category( $post_category_id );
    $post_title = escape( $row['post_title'] );
    $post_author_id = escape( $row['post_author_id'] );
    $post_author_name = get_author_name( $post_author_id );
    
    $post_date = escape( $row['post_date'] );
    $post_image = escape( $row['post_image'] );
    if ( empty( $_GET ) || basename( $_SERVER['PHP_SELF'] )  === 'categories.php') {
      $post_content = substr(escape( $row['post_content'] ), 0, 100);
    } else {
      $post_content = escape( $row['post_content'] );
    }
    $post_status = escape( $row['post_status'] );

    create_single_post( $post_id, $post_category_id, $post_category_name, $post_title, $post_author_id, $post_author_name, 
                        $post_date, $post_image, $post_content, $post_status );
  
  }

  if ( mysqli_num_rows( $query_result ) == 0) {
    echo "<h1>No Posts Yet</h1>";
  }
}

function display_comments( $post_id, $post_status ) {

  global $connection;

  if ( ( isset( $_SESSION['user_role'] ) && $_SESSION['user_role'] === 'administrator') || $post_status === 'published' ) {


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

  <?php
  $select_all_comments_querry = "SELECT * from comments WHERE comment_post_id = $post_id AND comment_status = 'approved' ORDER BY comment_id DESC";
  $select_all_comments_querry_result = query_result( $select_all_comments_querry );
  
  while ( $row = mysqli_fetch_assoc( $select_all_comments_querry_result ) ) {
    $comment_author = escape( $row['comment_author'] );
    $comment_content = escape( $row['comment_content'] );
    $comment_date = escape( $row['comment_date'] );

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

  <?php 
  }
} 

}

function leave_comment() {
  global $connection;
  $post_id = escape( $_GET['post_id'] );
  $comment_author = escape( $_POST['comment_author'] );
  $comment_content = escape( $_POST['comment_content'] );
  $comment_email = escape( $_POST['comment_email'] );

  if (!empty( $comment_author )  && !empty( $comment_email ) && !empty( $comment_content ) )  {

      $insert_comment_query = "INSERT INTO ";
      $insert_comment_query .= "comments(comment_post_id, comment_author, comment_content, ";
      $insert_comment_query .= "comment_email, comment_status, comment_date) " ;
      $insert_comment_query .= "VALUES({$post_id}, '{$comment_author}', '{$comment_content}', ";
      $insert_comment_query .= "'{$comment_email}', 'unapprove', now())";

      $insert_comment_query_result = query_result( $insert_comment_query );
      echo "<script>alert('Your message has been registered')</script>";
  } else {
    echo "<script>alert('The fields cannot be empty')</script>";
  }
}

function users_online() {

  if( isset( $_GET['online_users'] ) ) {
    global $connection;
    if ( !$connection ) {
      session_start();
      include("../includes/db.php");
    }
    $session = session_id();
    $time = time();
    $time_out_in_seconds = 30;
    $time_out = $time - $time_out_in_seconds;

    $query = "SELECT * FROM users_online WHERE user_session = '$session'";
    $query_result = query_result( $query );
    $test_user = mysqli_num_rows( $query_result );

    if ( $test_user == NULL ) {
        $insert_query = "INSERT INTO users_online(user_session, user_time) VALUES('$session', $time)";
        $insert_query_result = query_result( $insert_query );
    } else {
        $update_query = "UPDATE users_online SET user_time = $time WHERE user_session = '$session'";
        $update_query_result = query_result( $update_query );

    }
    $users_online_query = "SELECT * FROM users_online WHERE user_time > $time_out";
    $users_online_query_result = query_result( $users_online_query );
    $count_users_online = mysqli_num_rows( $users_online_query_result );
    echo $count_users_online;
  
  }
}

users_online();

function display_authors( $selected_user_id ) {
  $select_user_query = "SELECT * FROM users";
  $select_user_query_result = query_result( $select_user_query );
  while ( $row = mysqli_fetch_assoc( $select_user_query_result ) ) {
    $user_id = escape( $row['user_id'] );
    $user_name = escape( $row['user_name'] );
    if ( $user_id == $selected_user_id ) {
      echo "<option selected='selected' value='{$user_id}'>{$user_name}</option>";
      
    } else {
      echo "<option value='{$user_id}'>{$user_name}</option>";
      
    }
  }
}

function display_graph( &$var_array, $graph ) {
  global $connection;
  echo "<div class='col-lg-3 col-md-6'>";
  if ( $graph === 'Posts') {
    echo "<div class='panel panel-primary'>";
  } elseif ( $graph === 'Comments' ) {
    echo " <div class='panel panel-green'>";
  } elseif ( $graph === 'Users' ) {
    echo "<div class='panel panel-yellow'>";
  } elseif ( $graph === 'Categories' ) {
    echo "<div class='panel panel-red'>";
  }
  ?>
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-3">
          <?php 
            if ( $graph === 'Posts') {
              echo "<i class='fa fa-file-text fa-5x'></i>";
            } elseif ( $graph === 'Comments' ) {
              echo "<i class='fa fa-comments fa-5x'></i>";
            } elseif ( $graph === 'Users' ) {
              echo "<i class='fa fa-users fa-5x'></i>";
            } elseif ( $graph === 'Categories' ) {
              echo "<i class='fa fa-list fa-5x'></i>";
            }
            
            ?>
          </div>
          <div class="col-xs-9 text-right">
          <?php
            $post_results = select_graph( $graph );
            foreach ( $post_results as $post) {
              array_push($var_array, $post );
            }
          ?>
          <div class='huge'><?php echo $post_results[0]; ?></div>
            <div><?php echo $graph ?></div>
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
<?php  
}

function select_graph( $graph ) {
  global $connection;
  switch ($graph) {
    case 'Posts': {
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
        return array( $posts_count, $posts_published, $posts_draft );
      }
    break;

    case 'Comments': {
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
      return array( $coments_count, $comments_approved, $comments_unapproved );
    }
    break;
    
    case 'Users': {
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
       return array( $users_count, $users_admin, $users_subscriber );
    }

    case 'Categories': {
      //Count how many categories
      $categories_count_query = "SELECT * FROM categories";
      $categories_count_query_result = mysqli_query( $connection, $categories_count_query );
      confirm_query( $categories_count_query_result );
      $categories_count = mysqli_num_rows( $categories_count_query_result );
      return array( $categories_count );
    }

    
    default:
      break;
  }

}

?>