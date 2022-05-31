
<?php 

    include_once'connection.php';

    session_start();

     if($_SESSION['profile'] == 'Cashier' OR $_SESSION['username'] == ''){

      header('location:index.php');
    }
  
    include_once'header.php';

    
    //Add category
    if(isset($_POST['btnsave'])){

      $categorie = $_POST['categorie'];

      if(empty($categorie)){

              $error='
                  <script>
                  swal.fire({

              icon: "warning",
              title: "Error",
              text: "Field Is Empty."
              

              })
                  </script>';

                  echo $error;
        }

        if(!isset($error)){

      $insert = $pdo->prepare("insert into categories(categorie) values(:categorie) ");

      $insert->bindparam(':categorie',$categorie);
      

      if($insert->execute()){

        echo '<script>
            
            swal.fire({

              icon: "success",
              title: "Congratulation",
              text: "Succesfully Added."
              

              })

            </script>';

      } else {

        echo '<script>
            
            swal.fire({

              icon: "error",
              title: "Opps..",
              text: "Error Adding product."
              

              })

            </script>';
      }

    }
    }

    //Update categorie
    if(isset($_POST['btnupdate'])){

      $categorie = $_POST['categorie'];
      $id = $_POST['id'];

      if(empty($categorie)){

          $errorupdate='
                  <script>
                  alert("Field is Empty!")
                  </script>';

          echo $errorupdate;

      }

      if(!isset($errorupdate)){

        $update=$pdo->prepare("update categories set categorie=:categorie where id=".$_POST['id']);
        $update->bindParam(':categorie',$categorie);
        $update->execute();
        
      }

    }

    //Delete Category

    if(isset($_POST['btndelete'])){

      $delete=$pdo->prepare("delete from categories where id=".$_POST['btndelete']);
      $delete->execute();

    }


?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Category
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Categories</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->

         <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Add Categories</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

              <div class="box-body">
                <form role="form" action="" method="post">

                  <?php
                    if(isset($_POST['btnedit'])){

                      $select=$pdo->prepare("select * from categories where id=".$_POST['btnedit']);
                      
                      $select->execute();

                      if($select){

                        $row=$select->fetch(PDO::FETCH_OBJ);

                        echo'<div class="col-md-4">
                  
                         <div class="form-group">
                         <label>Category</label>

                         <input type="hidden" class="form-control" placeholder="Enter Category" name="id" value="'.$row->id.'"">

                         <input type="text" class="form-control" placeholder="Enter Category" name="categorie" value="'.$row->categorie.'"">
                         </div>

                         <button type="submit" class="btn btn-info" name="btnupdate">Update</button>
                         <div>  <label></label> </div>

                         </div>';

                      }


                    }else{

                      echo'<div class="col-md-4">
                  
                  <div class="form-group">
                  <label>Category</label>
                  <input type="text" class="form-control" placeholder="Enter Category" name="categorie"  >
                </div>

                <button type="submit" class="btn btn-warning" name="btnsave">Save</button>
                <div>  <label></label> </div>

                </div>';
                    }

                  ?>

                  <div class="col-md-1">
              </div>
                
                <div class="col-md-7">
                    <table id="tablecategory" class="table table-striped">
                      <thead>

                
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Action</th>


                        </tr>
                      </thead>

                      <tbody>

                        <?php

                        $select=$pdo->prepare("select * from categories");

                        $select->execute();

                        while($row=$select->fetch(PDO::FETCH_OBJ)){

                          echo '
                              
                              <tr>
                                <td>'.$row->id.'</td>
                                <td>'.$row->categorie.'</td>
                                <td><button type="submit" value="'.$row->id.'" class="btn btn-success" name="btnedit">Edit</button>

                                <button type="submit" value="'.$row->id.'" class="btn btn-danger" name="btndelete">Delete</button>

                                
                              </tr>


                          ';


                        }


                        ?>
                        
                        

                      </tbody>

                    </table>


                </div>
              
              
                </form>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
              </div>
            
          </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script>
    
    $(document).ready( function () {
    $('#tablecategory').DataTable();
    } );
  </script>
 

  <?php 

    include_once'footer.php';

  ?>

    
