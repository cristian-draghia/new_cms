<?php include("delete_modal.php"); ?>

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
      $user_id = escape( $row['user_id'] );
      $user_name = escape( $row['user_name'] );
      $user_password = escape( $row['user_password'] );
      $user_firstname = escape( $row['user_firstname'] );
      $user_lastname = escape( $row['user_lastname'] );
      $user_email = escape( $row['user_email'] );
      $user_image = escape( $row['user_image'] );
      $user_role = escape( $row['user_role'] );


      echo "<tr>";
      echo "<td>$user_id</td>";
      echo "<td>$user_name</td>";
      echo "<td>$user_firstname</td>";
      echo "<td>$user_lastname</td>";
      echo "<td>$user_email</td>";
      $current_user_id = $_SESSION['user_id'];
      if ( $user_id == $current_user_id || $user_role=='subscriber' || $current_user_id == 1) {
      if ($_SESSION['user_role'] !== 'subscriber') {
      echo "<td>"; 
      ?> 

      <form action="/new_cms/admin/users?&user_id=<?php echo $user_id ?>" method="post" >

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
      } else {
        echo "<td>$user_role</td>";
      }
        echo "<td><a href='/new_cms/admin/users?source=edit_user&user_id=$user_id'>Edit</a></td>";
        echo "<td><a rel='$user_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";
        // echo "<td><a href='users.php?delete=$user_id' OnClick=\"return confirm( 'Are you sure you want to delete this user?' );\">Delete</a></td>";
        echo "</tr>";

      } else {
        echo "<td>$user_role</td>";

      }
    }

    //Delete user
    delete_user();
    
    //Update user role
    update_user_role();

    ?>
  </tbody>
</table>

<script>
  $(document).ready(function() {
    $(".delete_link").on("click", function() {
      var id = $(this).attr("rel");
      var delete_url ="/new_cms/admin/users?delete=" + id;

      $(".modal-delete_link").attr("href", delete_url);
      $("#myModal").modal("show");
    });

  });


</script>