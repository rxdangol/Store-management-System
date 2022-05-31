
<?php 
  
    include_once'connection.php';
     session_start();

     if($_SESSION['profile'] == 'Cashier' OR $_SESSION['username'] == ''){

      header('location:index.php');
    }
  
    include_once'header.php';


?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Product
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">ViewProduct</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
         <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">View Product</h3>

            </div>
            <div><a href="productlist.php" class="btn btn-primary" role="button">Bact to ProductList</a></div>
            <!-- /.box-header -->
            <!-- form start -->

              <div class="box-body">

                <?php

                  $id=$_GET['id'];

                  $select=$pdo->prepare("select * from product where id=$id");
                  $select->execute();

                  while($row=$select->fetch(PDO::FETCH_OBJ)){

                      echo '  
                      <div class="col-md-3">
                      </div>
                          <div class="col-md-6">
                            <ul class="list-group">
                              <center><p class="list-group-item list-group-item-success"><b>Product Detail</b></p></center>
                              <li class="list-group-item"><b>ID </b><span class="label label-info pull-right">'.$row->id.'</span></li>
                              <li class="list-group-item"><b>Name</b><span class="label label-info pull-right">'.$row->name.'</span></li>
                              <li class="list-group-item"><b>Category</b><span class="label label-info pull-right">'.$row->categorie.'</span></li>
                              <li class="list-group-item"><b>Purchase Price</b><span class="label label-info pull-right">'.$row->purprice.'</span></li>
                              <li class="list-group-item"><b>Sell Price</b><span class="label label-info pull-right">'.$row->sellprice.'</span></li>
                              <li class="list-group-item"><b>Product Profit</b><span class="label label-info pull-right">'.$row->sellprice-$row->purprice.'</span></li>
                              <li class="list-group-item"><b>Stock</b><span class="label label-info pull-right">'.$row->stock.'</span></li>
                              <li class="list-group-item"><b>Description : </b><span class="center-block">'.$row->description.'</span></li>
                            </ul>
                            </div>
                            <div class="col-md-3">
                      </div>

                          



                    ';
                  }

                ?>

                

              </div>
            </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php 

    include_once'footer.php';

  ?>
