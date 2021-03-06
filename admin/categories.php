<?php include 'includes/admin_header.php' ?>

    <div id="wrapper">

        <!-- Navigation -->

        <?php include 'includes/admin_navigation.php' ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Category
                            <small>Author</small>
                        </h1>

                      <div class='col-xs-6'>

                      <!--Insert Categories-->
                      <?php insert_categories(); ?>

                        <!--Add Categories-->
                        <form action="" method="post">
                        <div class="form-group">
                        <label for="cat_title">Add Category</label>
                          <input type="text" class="form-control" name="cat_title">
                        </div>
                        <div class="form-group">
                          <input type="submit" class="btn-primary" name="submit" value="Add categorie">
                        </div>

                        </form>

                        <?php // Update and include
                        
                        if( isset( $_GET['edit'] )) {
                          $cat_id = $_GET['edit'];
                          include "includes/update_categories.php";
                        }
                        ?>

                      </div>

                      <div class='col-xs-6'>

                   

                      <table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>Id</th>
                            <th>Category Title</th>
                            <th>Category Author</th>
                            <th>Edit</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>

                        <!--Find All Categories-->
                        <?php find_all_categories(); ?>

                        <!--Delete Category-->
                        <?php delete_category(); ?>
                        
                        </tbody>
                      </table>

                      </div>
            
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include 'includes/admin_footer.php' ?>