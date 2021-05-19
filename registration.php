<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>


    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>



    <?php

    if ( isset( $_POST['register'] ) ) {
        $user_name = $_POST['user_name'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];

        $user_name = mysqli_real_escape_string ( $connection, $user_name );
        $user_email = mysqli_real_escape_string ( $connection, $user_email );
        $user_password = mysqli_real_escape_string ( $connection, $user_password );

        $check_name = !empty($user_name) && strlen($user_name) > 3;
        $check_email = !empty($user_email) && strlen($user_email) > 3;
        $check_password = !empty($user_password) && strlen($user_password) > 3;

        if ( $check_name && $check_email && $check_password ) {

            $check_users_query = "SELECT user_name, user_email FROM users WHERE user_name = '$user_name' OR user_email = '$user_email'";
            $check_users_query_result = mysqli_query( $connection, $check_users_query );
            confirm_query( $check_users_query_result );

            while ( $row = mysqli_fetch_array( $check_users_query_result) ) {
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

    

                $randSalt = get_randSalt();

                $user_password = crypt( $user_password, $randSalt );


                $add_user_query = "INSERT INTO users (user_name, user_password, user_email, user_role) ";
                $add_user_query .= "VALUES('$user_name', '$user_password', '$user_email', 'subscriber')";
                $add_user_query_result = mysqli_query( $connection, $add_user_query );
                confirm_query( $add_user_query_result );
                $message = "The user <span style='color:blue;'>$user_name</span> has just been created";
                $message_state = "corret";
                
            }

        } else {
            $message = "Fields cannot be empy or lower than 4 characters";
            $message_state = "error";
        }
       

    }


    ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
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
                            <label for="user_name" class="sr-only">username</label>
                            <input type="text" name="user_name" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                         <div class="form-group">
                            <label for="user_email" class="sr-only">Email</label>
                            <input type="email" name="user_email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="user_password" class="sr-only">Password</label>
                            <input type="password" name="user_password" id="key" class="form-control" placeholder="Password">
                        </div>
                
                        <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
