
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
          Sales Report
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">Sales Report</li>
          </ol>
        </section>
    
        <!-- Main content -->
        <section class="content container-fluid">
    
          <!--------------------------
            | Your Page Content Here |
            -------------------------->
             <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Sales Report</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
            
                <form class="form-inline" action="" name="form1" method="post">
                    <div class="form-group">
                        <label for="email">Select Start Date</label>
                        <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="datepicker" name="startdate" value="<?php echo date("Y-m-d");?>" data-date-format="yyyy-mm-dd">
                      </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Select End Date</label>
                        <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="datepicker1" name="endate" value="<?php echo date("Y-m-d");?>" data-date-format="yyyy-mm-dd">
                      </div>
                    </div>
                    <button type="submit" name="submit1" class="btn btn-success">Show Purchase From These Dates</button>
                    <!-- <button type="button" name="submit2" class="btn btn-warning" onclick="window.location.href=window.location.href">Clear Search</button> -->
                </form>


        
    
                  <div class="box-body">
                      <?php
                      if(isset($_POST["submit1"])){
                        $sdate = $_POST['startdate'];
                                $edate = $_POST['endate'];
                    ?>
    
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
                              
                            </tr>
                          </thead>
    
                          <tbody>
                            
                            <?php
                                
                              $select = $pdo -> prepare("select * from invoice where date >= $sdate && date <= $edate");
    
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
                                  </tr>';
    
    
                              }
    
                      }else{
                          
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

        //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    $('#datepicker1').datepicker({
      autoclose: true
    })
    
      </script>
    
      <?php 
    
        include_once'footer.php';
    
      ?>
    