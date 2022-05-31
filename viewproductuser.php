
<?php 
  
    include_once'connection.php';
     session_start();

     if($_SESSION['username']=='' OR $_SESSION['profile']=="Administrator"){

      header('location:index.php');
    }
  
    include_once'headeruser.php';


?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Product List
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Product</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->

        <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Product List</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

              <div class="box-body">

                <div style="overflow-x:auto;">
                <table id="producttable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Product Name</th>
                          <th>Categorie</th>
                          <th>Purchase Price</th>
                          <th>Selling Price</th>
                          <th>Stock</th>
                          <th>Description</th>
                        
                          
                        </tr>
                      </thead>

                      <tbody>
                        
                        <?php

                          $select = $pdo -> prepare("select * from product");

                          $select -> execute();

                          while($row = $select -> fetch(PDO::FETCH_OBJ)){

                            echo '
                              <tr>
                              <td>'.$row->id.'</td>
                              <td>'.$row->name.'</td>
                              <td>'.$row->categorie.'</td>
                              <td>'.$row->purprice.'</td>
                              <td>'.$row->sellprice.'</td>
                              <td>'.$row->stock.'</td>
                              <td>'.$row->description.'</td>
                              
                              </tr>';


                          }

                        ?>

                      </tbody>

                    </table>
                  </div>


              </div>
            </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

   <script>
    
    $(document).ready(function(){

      $('[data-toggle="tooltip"]').tooltip();
    });

  </script>
  
  <script>
    
    $(document).ready(function(){

      $('#producttable').DataTable();
    });

  </script>

  <script>
    
    $(document).ready(function(){

      $('.btndelete').click(function(){

       var tdh=$(this);
       var id=$(this).attr("id");

       Swal.fire({
          title: 'Are you sure?',
          text: "Once Deleted, You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({

          url:'productdelete.php',
          type:'post',
          data:{

            pid:id
          },
          success:function(data){

            tdh.parents('tr').hide();
          }

       });
            Swal.fire(
              'Deleted!',
              'Your Product has been deleted.',
              'success'
            )
          }
        });

       

      });

    });

  </script>

  <?php 

    include_once'footer.php';

  ?>