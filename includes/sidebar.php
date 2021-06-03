<div class="col-md-4">


<!-- Blog Search Well -->
<div class="well">
    <h4>Blog Search</h4>

    <form action="search.php" method='post'>
    <div class="input-group">
        <input name='search' type="text" class="form-control">
        <span class="input-group-btn">
            <button name='submit'  class="btn btn-default" type="submit">
                <span class="glyphicon glyphicon-search"></span>
        </button>
        </span>
    </div>
    </form> <!-- search form -->
    <!-- /.input-group -->
</div>

<?php 

if ( !isset($_SESSION['user_name'] ) ) {

?>
<!-- Login Form -->
<div class="well">
    <h4>Login</h4>
    <form action="login.php" method='post'>
    <div class="form-group">
        <input class="form-control" type="text" name="user_name" placeholder="Enter username">
    </div>
    <div class="form-group">
        <input class="form-control" type="password" name="user_password" placeholder="Enter password">
    </div>
    <div class="form-group">
    <input class="form-control login-button" type="submit" name="login" value="Login">
  </div>
    </form>
</div>

<?php 
} else {
    ?>

    <!-- Login Form -->
<div class="well">
    <h4>You are login as <?php echo "<a href='account.php'>". $_SESSION['user_name'] . "</a>"; ?></h4>
    <div class="form-group">
    <a href="includes/logout.php"><input class="form-control login-button" type="submit" name="login" value="Log Out"></a>
  </div>

</div>

    <?php




}
?>

<!-- Blog Categories Well -->
<div class="well">


    <?php 

    $query = 'SELECT * FROM categories';
    $select_categories_sidebar = mysqli_query( $connection, $query );
   
    ?>

    <h4>Blog Categories</h4>
    <div class="row">
        <div class="col-lg-12">
            <ul class="list-unstyled">
            <li><a href="categories.php">All categories</a></li>
            <?php 
                while ( $row = mysqli_fetch_assoc( $select_categories_sidebar )) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    echo "<li><a href='categories.php?category_id=$cat_id'>{$cat_title}</a></li>";
            
                }
            
            ?>
            </ul>
        </div>



        <!-- /.col-lg-6 -->

        <!-- /.col-lg-6 -->
    </div>
    <!-- /.row -->
</div>

<!-- Side Widget Well -->
<?php include "widget.php"; ?>

</div>