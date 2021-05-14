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
      echo "<td><a href='categories.php?delete={$cat_id}'>DELETE</a></td>";
      echo "<td><a href='categories.php?edit={$cat_id}'>EDIT</a></td>"; 
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

function test_empty_image($post_id, $post_image) {
  global $connection;
  if ( empty( $post_image )) {
    $query = "SELECT * FROM posts WHERE post_id = {$post_id} ";
    $query_select_image = mysqli_query( $connection, $query );
    while ($row = mysqli_fetch_assoc( $query_select_image ) ) {
      $post_image = $row['post_image'];
    }
  }
  return $post_image;
}


?>