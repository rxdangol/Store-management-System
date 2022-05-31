
<?php 
    include_once'connection.php';

    session_start();

    if($_SESSION['profile'] == 'Cashier' OR $_SESSION['username'] == ''){

      header('location:index.php');
    }

    include_once'header.php';

    error_reporting(0);

    // Delete User

    $username=$_GET['username'];

    $delete=$pdo->prepare("delete from users where username='$username'");

    $delete->execute();

    if(isset($_POST['btnsave'])){

    $name=$_POST['Name'];
    $username=$_POST['Username'];
    $contact=$_POST['Contact'];
    $password=$_POST['Password'];
    $profile=$_POST['Profile'];

    if(isset($_POST['Username'])){

      $select = $pdo->prepare("select username from users where username='$username'");
      $select->execute();
      
      if($select->rowCount()>0){

        echo '<script>
            
            swal.fire({

              icon: "error",
              title: "Opps..",
              text: "Username Already Exists."
              

              })

            </script>';

      }else{
    

    $insert = $pdo->prepare("INSERT INTO users(name,username,contact,password,profile) values(:name,:username,:contact,:password,:profile)");

    $insert->bindparam(':name',$name);
    $insert->bindparam(':username',$username);
    $insert->bindparam(':contact',$contact);
    $insert->bindparam(':password',$password);
    $insert->bindparam(':profile',$profile);

    if($insert -> execute()){
        echo '<script>
            
            swal.fire({

              icon: "success",
              title: "Congratulation",
              text: "Registration Succesful."
              

              })

            </script>';
      

      }else{
        echo '<script>
            
            swal.fire({

              icon: "error",
              title: "Opps..",
              text: "Registration Failed."
              

              })

            </script>';
      


    }
 }
}
}


?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       User Registration
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Registration</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->

        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add User</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="POST">

              <div class="box-body">

                <div class="col-md-4">
                  
                  <div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control" placeholder="Enter Name" name="Name" required>
                </div>

                <div class="form-group">
                  <label>Username</label>
                  <input type="text" class="form-control" placeholder="Enter username" name="Username" required>
                </div>

                <div class="form-group">
                  <label>Contact</label>
                  <input type="text" class="form-control" placeholder="Enter Contact" name="Contact" required>
                </div>

                <div class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control" placeholder="Password" name="Password" required>
                </div>

                <div class="form-group">
                  <label>Profile</label>
                  <select class="form-control" name="Profile" required>
                    <option value="" selected disabled>Select Profile</option>
                    <option>Administrator</option>
                    <option>Cashier</option>
                  </select>
                </div>

                <button type="submit" class="btn btn-info" name="btnsave">Save</button>
                <div>  <label></label> </div>

                </div>
                <div class="col-md-8">
                    <table id="tableuser" class="table table-striped table-bordered">
                      <thead>

                
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Username</th>
                          <th>Contact</th>
                          <th>Profile</th>
                          <th>Delete</th>

                        </tr>
                      </thead>

                      <tbody>
                        
                        <?php

                          $select = $pdo -> prepare("select * from users");

                          $select -> execute();

                          while($row = $select -> fetch(PDO::FETCH_OBJ)){

                            echo '  
                              <tr>
                              <td>'.$row->id.'</td>
                              <td>'.$row->name.'</td>
                              <td>'.$row->username.'</td>
                              <td>'.$row->contact.'</td>
                              <td>'.$row->profile.'</td>
                              <td>
                              <a href="registration.php?username='.$row->username.'" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-trash" title="delete"></span></a>
                              </td>
                              </tr>';


                          }

                        ?>

                      </tbody>

                    </table>


                </div>
              
              
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
              </div>
            </form>
          </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>
    
    $(document).ready( function () {
    $('#tableuser').DataTable();
    } );
  </script>

  <?php 

    include_once'footer.php';

  ?>

    
