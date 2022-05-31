
<?php 

    include_once'connection.php';

    session_start();

     if($_SESSION['profile'] == 'Cashier' OR $_SESSION['username'] == ''){

      header('location:index.php');
    }
  
    include_once'header.php';

    if(isset($_POST['btnadd'])){

      $productname=$_POST['proname'];
      $categorie=$_POST['categorie'];
      $purchaseprice=$_POST['purprice'];
      $sellprice=$_POST['sellprice'];
      $stock=$_POST['stock'];
      $description=$_POST['description'];

      $insert=$pdo->prepare("insert into product(name,categorie,purprice,sellprice,stock,description) values(:name,:categorie,:purprice,:sellprice,:stock,:description) ");
      $insert->bindParam(':name',$productname);
      $insert->bindParam(':categorie',$categorie);
      $insert->bindParam(':purprice',$purchaseprice);
      $insert->bindParam(':sellprice',$sellprice);
      $insert->bindParam(':stock',$stock);
      $insert->bindParam(':description',$description);

      if($insert->execute()){
          echo '<script>
            
            swal.fire({

              icon: "success",
              title: "Congratulation",
              text: "Succesfully Added."
              

              })

            </script>';

      }else{
        echo '<script>
            
            swal.fire({

              icon: "error",
              title: "Opps..",
              text: "Error Adding product."
              

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
        Add Product
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

        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Product Form</h3>
            </div>
         
            <!-- /.box-header -->
            <!-- form start -->

              <div class="box-body">

                <form role="form" action="" method="post">

                  <div class="col-md-5">
                    
                    <div class="form-group">
                  <label>Product Name</label>
                  <input type="text" class="form-control" placeholder="Enter Product Name" name="proname" required>
                </div>

                <div class="form-group">
                  <label>Categorie</label>
                  <select class="form-control" name="categorie" required>
                    <option value="" selected disabled>Select Categorie</option>
                    <?php

                        $select=$pdo->prepare("select *from categories");
                        $select->execute();

                        while($row=$select->fetch(PDO::FETCH_ASSOC)){

                          extract($row);
                    ?>
                            <option><?php echo $row['categorie'];?></option>

                            <?php

                        }
                          ?>

                    
                    
                  </select>
                </div>

                <div class="form-group">
                  <label>Purchase Price</label>
                  <input type="number" min="1" step="1" class="form-control" placeholder="Enter Price" name="purprice" required>
                </div>

                <div class="form-group">
                  <label>Sell Price</label>
                  <input type="number" min="1" step="1" class="form-control" placeholder="Enter Price" name="sellprice" required>
                </div>

              

                  </div>

                  <div class="col-md-1">

                  </div>
                  <div class="col-md-5">
                    
                    <div class="form-group">
                  <label>Stock</label>
                  <input type="number" min="1" step="1" class="form-control" placeholder="Quantity" name="stock" required>
                </div>

                <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" name="description" placeholder="Enter...."></textarea>
                </div>

                

                  </div>

                  <div class="col-md-1">

                  </div>

                

              </div>

               <div class="box-footer">

                

                <button type="submit" class="btn btn-info" name="btnadd">Add  Product</button>
                
              </div>

              </form>
            

    </section>
  </div>
    <!-- /.content -->

  <!-- /.content-wrapper -->

  <?php 

    include_once'footer.php';

  ?>

  

