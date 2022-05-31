
<?php 
      
  include_once'connection.php';
    session_start();

     if($_SESSION['profile'] == '' OR $_SESSION['username'] == ''){

      header('location:index.php');
    }
  
    include_once'header.php';

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Order List
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Order List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
         <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Order List</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

              <div class="box-body">

                <div style="overflow-x:auto;">
                <table id="orderlisttable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Invoice ID</th>
                          <th>Order Date</th>
                          <th>Customer Name</th>
                          <th>Total</th>
                          <th>Paid</th>
                          <th>Due</th>
                          <th>Payment Type</th>
                          <th>Print</th>
                          <th>Edit</th>
                          <th>Delete</th>
                          
                        </tr>
                      </thead>

                      <tbody>
                        
                        <?php

                          $select = $pdo -> prepare("select * from invoice ORDER BY invoice_id DESC");

                          $select -> execute();

                          while($row = $select -> fetch(PDO::FETCH_OBJ)){

                            echo '
                              <tr>
                              <td>'.$row->invoice_id.'</td>
                              <td>'.$row->date.'</td>
                              <td>'.$row->customer_name.'</td>
                              <td>'.$row->total.'</td>
                              <td>'.$row->paid.'</td>
                              <td>'.$row->due.'</td>
                              <td>'.$row->payment_method.'</td>
                            
                            <td>
                              <a href="invoice_80mm.php?id='.$row->invoice_id.'" class="btn btn-warning" role="button" target="_blank"><span class="glyphicon glyphicon-print" style="color:#ffffff" data-toggle="tooltip" title="Print invoice"></span></a>
                              </td>
                              <td>
                              <a href="editorder.php?id='.$row->invoice_id.'" class="btn btn-info" role="button"><span class="glyphicon glyphicon-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit"></span></a>
                              </td>
                              <td>
                              <button id='.$row->invoice_id.' class="btn btn-danger btndelete"><span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete"></span></button>
                              
                              </td>
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

    //Delete 

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

          url:'orderdelete.php',
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
              'Your Order has been deleted.',
              'success'
            )
          }
        });

       

      });

    });


  </script>
  
  <script>
    
    $(document).ready(function(){

      $('#orderlisttable').DataTable();
    });

  </script>

  <?php 

    include_once'footer.php';

  ?>
