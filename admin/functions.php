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
      echo "<td><a href='categories.php?delete={$cat_id}'>DELETE</a></td>";
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

    $get_post_id_query = "SELECT comment_post_id FROM comments WHERE comment_id = $delete_Comment_id";
    $get_post_id_query_result = mysqli_query( $connection, $get_post_id_query );
    confirm_query( $get_post_id_query_result );
    
    while ( $row = mysqli_fetch_assoc( $get_post_id_query_result ) ) {
      $post_id = $row['comment_post_id'];
      $decrese_comment_count_query = "UPDATE posts SET post_comment_count = post_comment_count - 1 WHERE post_id = $post_id";
      $decrese_comment_count_query_result = mysqli_query( $connection, $decrese_comment_count_query );
      confirm_query( $decrese_comment_count_query_result );


    }

    $delete_comment_query = "DELETE FROM comments WHERE comment_id = $delete_Comment_id";
    $delete_comment_query_result = mysqli_query( $connection, $delete_comment_query );
    confirm_query( $delete_comment_query_result );

    $get_post_id_query = "SELECT comment_post_id FROM comments WHERE comment_id = $delete_Comment_id";


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
  header("Location: posts.php");

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
  if ( empty( $image )) {
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
    header("Location: users.php");

  }

}

function update_user( $user_id, $user_name, $user_password, $user_firstname, $user_lastname, $user_email, $user_image, $user_role ) {
  global $connection;
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
  header("Location: users.php");
  
}


?>