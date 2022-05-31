
<?php 
     include_once'connection.php';
    session_start();

    if($_SESSION['username']==''){

      header('location:index.php');
    }
    if($_SESSION['profile'] == "Administrator"){

    include_once'header.php';
    
    }else{

      include_once'headeruser.php';
    }

    if(isset($_POST['changepsw'])){

      $oldpassword=$_POST['oldpsw'];
      $newpassword=$_POST['newpsw'];
      $confirmpassword=$_POST['confirmpsw'];


      $user=$_SESSION['username'];

      $select = $pdo -> prepare("select * from users where username='$user'");
      $select -> execute();
      $row = $select -> fetch(PDO::FETCH_ASSOC);

      $username_db = $row['username'];
      $password_db = $row['password'];


      if($oldpassword == $password_db){

        if($newpassword == $confirmpassword){

          $update = $pdo -> prepare("update users set password=:pass where username=:user");
          $update -> bindparam(':pass',$confirmpassword);
          $update -> bindparam(':user',$user);

          if($update->execute()){
            echo '<script>
            
            swal.fire({

              icon: "success",
              title: "Congratulation",
              text: "Password Updated Successfully."
              

              })

            </script>';
            
          }else{
            echo '<script>
            
            swal.fire({

              icon: "error",
              title: "Opps..",
              text: "Password Update Failed."
              

              })

            </script>';
           
          }


        }else{
          echo '<script>
            
            swal.fire({

              icon: "error",
              title: "Opps..",
              text: "New Password and Confirm Password didnot  match."
              

              })

            </script>';

        }

      }else{
        echo '<script>
            
            swal.fire({

              icon: "error",
              title: "Opps..",
              text: "Previuos Password Incorrect."
              

              })

            </script>';

      }
    }




?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Change Password
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->

          
         <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Change Password</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="POST">
              
              <div class="box-body">

                <div class="col-md-4">

                <div class="form-group">
                  <label for="exampleInputPassword1">Old Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="oldpsw" required>
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">New Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="newpsw" required>
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">Confirm Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="confirmpsw" required>
                </div>


                <button type="submit" class="btn btn-primary" name="changepsw">Update</button>

              </div>
              
              
              <div class="col-md-8">
              </div>
              </div>

              
            </form>
          </div>
          
       
       
          <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php 

    include_once'footer.php';

  ?>
