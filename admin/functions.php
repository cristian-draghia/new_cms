<?php

function confirm_query($the_query) {
  global $connection;
  if ( !$the_query) {
    die("Query Failed" . mysqli_error($connection));
  }
  
}



function insert_categories() {
  global $connection;
  if( isset( $_POST['submit'] )) {
                      
    $cat_title = $_POST['cat_title'];

    if( $cat_title == '' || empty( $cat_title )) {
      echo "This field should not be empy";
    } else {
      
      $query = "INSERT INTO categories(cat_title)";
      $query .= "VALUE ('{$cat_title}')";

      $create_categoriy_query = mysqli_query( $connection, $query);
      if( !$create_categoriy_query) {
        die('QUERY FAILED' . mysqli_error( $connection ));
      }
    }
  }
}


function find_all_categories() {
  global $connection;
  $query = 'SELECT * FROM categories';
  $select_categories = mysqli_query( $connection, $query );


  while ( $row = mysqli_fetch_assoc( $select_categories )) {
      $cat_id = $row['cat_id'];
      $cat_title = $row['cat_title'];
      echo "<tr>";
      echo "<td>{$cat_id}</td>";
      echo "<td>{$cat_title}</td>";
      echo "<td><a href='categories.php?edit={$cat_id}'>EDIT</a></td>"; 
      echo "<td><a href='categories.php?delete={$cat_id}' OnClick=\"return confirm( 'Are you sure you want to delete this category?' );\">DELETE</a></td>";
      echo "</tr>";
  }


}

function delete_category() {
  global $connection;

  if( isset( $_GET['delete'] )) {
    $the_cat_id = $_GET['delete'];
    $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id}";
    $delete_query = mysqli_query( $connection, $query );
    header("Location: categories.php");
  }

}

function delete_post() {
  global $connection;
  if ( isset( $_GET['delete'] ) ) {
    $delete_post_id = $_GET['delete'];

    $query = "DELETE FROM posts WHERE post_id = $delete_post_id";
    $delete_query = mysqli_query($connection, $query);
    confirm_query($delete_query);
    header("Location: posts.php");
  }
}

function delete_comment() {
  global $connection;
  if ( isset( $_GET['delete'] )) {
    $delete_Comment_id = $_GET['delete'];

    $delete_comment_query = "DELETE FROM comments WHERE comment_id = $delete_Comment_id";
    $delete_comment_query_result = mysqli_query( $connection, $delete_comment_query );
    confirm_query( $delete_comment_query_result );

    header("Location: comments.php");

  }
}


function update_post( $post_id, $post_category_id, $post_title, $post_author, $post_image, $post_content, $post_tags, $post_status ) {
  global $connection;
  $query = "UPDATE posts SET ";
  $query .= "post_category_id = '$post_category_id', ";
  $query .= "post_title = '{$post_title}', ";
  $query .= "post_author = '{$post_author}', ";
  $query .= "post_date = now(), ";
  $query .= "post_image = '{$post_image}', ";
  $query .= "post_content = '{$post_content}', ";
  $query .= "post_tags = '{$post_tags}', ";
  $query .= "post_status = '{$post_status}' ";
  $query .= "WHERE post_id = {$post_id} ";    

  $query_update_post = mysqli_query( $connection, $query );
  confirm_query( $query_update_post );
  // header("Location: posts.php");
  echo "<h3 class='bg-success'>Post has been updated.</h3>
  <h4>Click <a href='../post.php?post_id=$post_id'>here</a> to view current post or <a href='./posts.php'>here</a> to view all posts.</h4>";

}

function update_post_category() {
  global $connection;
  if ( isset( $_POST['update_post_category'] ) && isset( $_GET['post_id'] ) ) {
    $post_category = $_POST['update_post_category'];
    $post_id = $_GET['post_id'];
    
    $update_post_category_query = "UPDATE posts SET post_category_id = '$post_category' WHERE  post_id = $post_id";
    $update_post_category_query_result = mysqli_query( $connection, $update_post_category_query );
    confirm_query( $update_post_category_query_result );
    header("Location: posts.php");

  }
}

function update_post_status() {
  global $connection;
  if ( isset( $_POST['post_status_update'] ) && isset( $_GET['post_id'] ) ) {
    $post_status = $_POST['post_status_update'];
    $post_id = $_GET['post_id'];
    
    $update_post_status_query = "UPDATE posts SET post_status = '$post_status' WHERE  post_id = $post_id";
    $update_post_status_query_result = mysqli_query( $connection, $update_post_status_query );
    confirm_query( $update_post_status_query_result );
    header("Location: posts.php");

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
      $test_image = $row[$current_image];
    }
  }
  return $test_image;
}


function update_comment_status() {
  global $connection;

  if ( isset($_POST['comment_status_update']) && isset( $_GET['comment_id'] ) )  {

    $comment_status = $_POST['comment_status_update'];
    $comment_id = $_GET['comment_id'];
    
    $update_comment_status_query = "UPDATE comments SET comment_status = '$comment_status' WHERE  comment_id = $comment_id";
    $update_comment_status_query_result = mysqli_query( $connection, $update_comment_status_query );
    confirm_query( $update_comment_status_query_result );
    header("Location: comments.php");
    
  }


}

function delete_user() {
  global $connection;
  if ( isset( $_GET['delete'] ) ) {
    $delete_user_id = $_GET['delete'];

    $delete_user_query = "DELETE FROM users WHERE user_id = $delete_user_id";
    $delete_user_query_result = mysqli_query($connection, $delete_user_query);
    confirm_query($delete_user_query_result);
    header("Location: users.php");
  }
}

function update_user_role() {
  global $connection;
  if ( isset( $_POST['updated_user_role'] ) && isset( $_GET['user_id'] ) ) {
    $user_id = $_GET['user_id'];
    $user_role = $_POST['updated_user_role'];
    
    $update_user_role_query = "UPDATE users SET user_role = '$user_role' WHERE  user_id = $user_id";
    $update_user_role_query_result = mysqli_query( $connection, $update_user_role_query );
    confirm_query( $update_user_role_query_result );

    $_SESSION['user_role'] = $user_role;

    header("Location: users.php");

  }

}

function update_user( $user_id, $user_name, $user_password, $user_firstname, $user_lastname, $user_email, $user_image, $user_role ) {
  global $connection;

  $randSalt = get_randSalt();

  $user_password = crypt( $user_password, $randSalt );


  $update_user_data_query = "UPDATE users SET ";
  $update_user_data_query .= "user_name = '$user_name', ";
  $update_user_data_query .= "user_password = '$user_password', ";
  $update_user_data_query .= "user_firstname = '$user_firstname', ";
  $update_user_data_query .= "user_lastname = '$user_lastname', ";
  $update_user_data_query .= "user_email = '$user_email', ";
  $update_user_data_query .= "user_image = '$user_image', ";
  $update_user_data_query .= "user_role = '$user_role' ";
  $update_user_data_query .= "WHERE user_id = $user_id";
  
  $update_user_data_query_result = mysqli_query( $connection, $update_user_data_query );
  confirm_query( $update_user_data_query_result );

  if ( isset( $_SESSION['user_name'] ) && $_SESSION['user_name'] === $user_name ) {
    $_SESSION['user_name'] = $user_name;
    $_SESSION['user_firstname'] = $user_firstname;
    $_SESSION['user_lastname'] = $user_lastname;
    $_SESSION['user_role'] = $user_role;
  }

  header("Location: users.php");
  
}

function get_randSalt() {
  global $connection;
  $get_randSalt_query = "SELECT randSalt FROM users";
  $get_randSalt_query_result = mysqli_query( $connection, $get_randSalt_query );
  confirm_query( $get_randSalt_query_result );
  $row = mysqli_fetch_assoc( $get_randSalt_query_result );
  return $row['randSalt'];
}

function set_new_session( $user_id, $user_name, $user_firstname, $user_lastname, $user_role) {
  global $connection;
  $_SESSION['user_id'] = $user_id;
  $_SESSION['user_name'] = $user_name;
  $_SESSION['user_firstname'] = $user_firstname;
  $_SESSION['user_lastname'] = $user_lastname;
  $_SESSION['user_role'] = $user_role;

}

function get_author_name( $post_author_id ) {
  global $connection;
  $get_author_name_query = "SELECT user_name FROM users WHERE user_id = $post_author_id";
  $get_author_name_query_result = mysqli_query( $connection, $get_author_name_query );
  confirm_query( $get_author_name_query_result );
  $row = mysqli_fetch_array( $get_author_name_query_result );
  return $row['user_name'];
}

function get_post_category( $post_id ) {
  global $connection;
  $get_post_category_query = "SELECT cat_title FROM categories WHERE cat_id = $post_id";
  $get_post_category_query_result = mysqli_query( $connection, $get_post_category_query );
  confirm_query( $get_post_category_query_result );
  $row = mysqli_fetch_array( $get_post_category_query_result );
  return $row['cat_title'];
}
function get_post_comments_count ( $post_id ) {
  global $connection;
  $approved_comments = 0;
  $get_post_comments_count_query = "SELECT comment_status FROM comments WHERE comment_post_id = $post_id";
  $get_post_comments_count_query_result = mysqli_query( $connection, $get_post_comments_count_query );
  confirm_query( $get_post_comments_count_query_result );
  while ( $row = mysqli_fetch_array( $get_post_comments_count_query_result ) ) {
    if ( $row['comment_status'] === 'approved' ) {
      $approved_comments++;
    }
  }

  return [ mysqli_num_rows( $get_post_comments_count_query_result ), $approved_comments ];

}

function create_single_post( $post_id, $post_category_id, $post_category_name, $post_title, $post_author_id, $post_author_name, 
                             $post_date, $post_image, $post_content ) {
  ?>
  <div class="single-post">
      
      <!-- First Blog Post -->
      <h2>
      <?php
        if ( isset( $_GET['post_id'] ) ) {
          echo "$post_title";
        } else {
          echo "<a href='posts.php?post_id=$post_id'>$post_title</a>";
        }
      ?>
      </h2>
      <p class="lead">
        <?php 
        if ( isset( $_GET['author_id'] ) ) {
          echo "Done by: $post_author_name";
        } else {
          echo "Done by: <a href='authors.php?author_id=$post_author_id'>$post_author_name</a>";
        }
        ?>
        
      </p>
      <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
      <hr>
      <?php
        if ( isset( $_GET['post_id'] ) ) {
          echo "<img class='img-responsive' src='images/$post_image' alt=''>";
        } else {
          echo "<a href='posts.php?post_id=$post_id'><img class='img-responsive' src='images/$post_image' alt=''></a>";
        }
      ?>
      <hr>
      <p><?php echo $post_content; ?></p>
      <?php 
        if ( !isset( $_GET['post_id'] ) ) {
          echo "<a class='btn btn-primary' href='posts.php?post_id=$post_id'>Read More <span class='glyphicon glyphicon-chevron-right'></span></a>";
        }
      ?>  
      <hr>
      <p>
      <?php 
        if ( isset( $_GET['category_id'] ) ) {
          echo "Category: $post_category_name";
        } else {
          echo "Category: <a href='categories.php?category_id=$post_category_id'>$post_category_name</a>";
        }

      ?>


    </div>

  <?php
}

function display_posts( $query ) {
  global $connection;

  $query_result = mysqli_query( $connection, $query );
  confirm_query( $query_result );

  while ( $row = mysqli_fetch_assoc( $query_result )) {
    $post_id = $row['post_id'];
    $post_category_id = $row['post_category_id'];
    $post_category_name = get_post_category( $post_category_id );
    $post_title = $row['post_title'];
    $post_author_id = $row['post_author_id'];
    $post_author_name = get_author_name( $post_author_id );
    
    $post_date = $row['post_date'];
    $post_image = $row['post_image'];
    if ( empty( $_GET ) ) {
      $post_content = substr($row['post_content'], 0, 100);
    } else {
      $post_content = $row['post_content'];
    }

    create_single_post( $post_id, $post_category_id, $post_category_name, $post_title, $post_author_id, $post_author_name, 
                        $post_date, $post_image, $post_content );
  
  }

  if ( mysqli_num_rows( $query_result ) == 0) {
      echo "<h1>No Posts Yet</h1>";
  }
}

function display_comments( $post_id ) {

  global $connection;
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

  <?php 
  } 

  

}

function leave_comment() {
  global $connection;
  $post_id = $_GET['post_id'];
  $comment_author = $_POST['comment_author'];
  $comment_content = $_POST['comment_content'];
  $comment_email = $_POST['comment_email'];

  if (!empty( $comment_author )  && !empty( $comment_email ) && !empty( $comment_content ) )  {

      $insert_comment_query = "INSERT INTO ";
      $insert_comment_query .= "comments(comment_post_id, comment_author, comment_content, ";
      $insert_comment_query .= "comment_email, comment_status, comment_date) " ;
      $insert_comment_query .= "VALUES({$post_id}, '{$comment_author}', '{$comment_content}', ";
      $insert_comment_query .= "'{$comment_email}', 'unapprove', now())";

      $insert_comment_query_result = mysqli_query( $connection, $insert_comment_query );

      confirm_query( $insert_comment_query_result );
      echo "<script>alert('Your message has been registered')</script>";

      

  } else {
    echo "<script>alert('The fields cannot be empty')</script>";
    
  }
 
}




?>