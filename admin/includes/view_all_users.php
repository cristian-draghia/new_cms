
<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Id</th>
      <th>Username</th>
      <th>Firstname</th>
      <th>Lastname</th>
      <th>Email</th>
      <th>Role</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  
  <tbody>
    <?php 


    $select_all_users_query = 'SELECT * FROM users';
    $select_all_users_query_result = mysqli_query( $connection, $select_all_users_query );


    while ( $row = mysqli_fetch_assoc( $select_all_users_query_result )) {
      $user_id = $row['user_id'];
      $user_name = $row['user_name'];
      $user_password = $row['user_password'];
      $user_firstname = $row['user_firstname'];
      $user_lastname = $row['user_lastname'];
      $user_email = $row['user_email'];
      $user_image = $row['user_image'];
      $user_role = $row['user_role'];


      echo "<tr>";
      echo "<td>$user_id</td>";
      echo "<td>$user_name</td>";
      echo "<td>$user_firstname</td>";
      echo "<td>$user_lastname</td>";
      echo "<td>$user_email</td>";

      echo "<td>"; ?> 

      <form action="users.php?&user_id=<?php echo $user_id ?>" method="post" >

      <select class="form-control" name="updated_user_role" id="updated_user_role" onchange='this.form.submit()'>

        <?php 
        
        if ( $user_role == 'administrator' ) {
          echo "<option selected='selected' value='administrator'>Administrator</option>";
          echo "<option value='subscriber'>Subscriber</option>";

        } else {
          echo "<option value='administrator'>Administrator</option>";
          echo "<option selected='selected' value='subscriber'>Subscriber</option>";

        }

        ?>
       
      
      
      
      
      </select>
      
      
      
      
      </form>
      
      <?php
      echo "</td>";
      echo "<td><a href='users.php?source=edit_user&user_id=$user_id'>Edit</a></td>";
      echo "<td><a href='users.php?delete=$user_id'>Delete</a></td>";
      echo "</tr>";

    }

    //Delete user
    delete_user();
    
    //Update user role
    update_user_role();

    ?>


    
  </tbody>
</table>