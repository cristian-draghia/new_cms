<?php ob_start();

$db = array(
  'db_host' => 'localhost',
  'db_user' => 'root',
  'db_pass' => '',
  'db_name' => 'new_cms',
);

foreach ( $db as $key => $value ) {

  define (strtoupper($key), $value);

}


$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$query = "SET NAMES utf8";
mysqli_query( $connection, $query );

if ( $connection ) {
  // echo "We are connected";
}

?>