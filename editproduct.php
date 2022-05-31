
<?php 
  
    include_once'connection.php';
     session_start();

     if($_SESSION['profile'] == 'Cashier' OR $_SESSION['username'] == ''){

      header('location:index.php');
    }
  
    include_once'header.php';

    //Fetch data

    $id=$_GET['id'];

    $select=$pdo->prepare("select * from product where id=$id");
    $select->execute();
    $row=$select->fetch(PDO::FETCH_ASSOC);

    $id_db=$row['id'];
    $name_db=$row['name'];
    $categorie_db=$row['categorie'];
    $purprice_db=$row['purprice'];
    $sellprice_db=$row['sellprice'];
    $stock_db=$row['stock'];
    $description_db=$row['description'];

    //Update Button
    if(isset($_POST['btnupdate'])){

      $productname=$_POST['proname'];
      $categorie=$_POST['categorie'];
      $purchaseprice=$_POST['purprice'];
      $sellprice=$_POST['sellprice'];
      $stock=$_POST['stock'];
      $description=$_POST['description'];

      $update=$pdo->prepare("update product set name=:proname, categorie=:categorie, purprice=:purprice, sellprice=:sellprice, stock=:stock, description=:description where id=$id");

      $update->bindParam(':proname',$productname);
      $update->bindParam(':categorie',$categorie);
      $update->bindParam(':purprice',$purchaseprice);
      $update->bindParam(':sellprice',$sellprice);
      $update->bindParam(':stock',$stock);
      $update->bindParam(':description',$description);

      if($update->execute()){


        echo '<script>
            
            swal.fire({

              icon: "success",
              title: "Congratulation",
              text: "Successfully Updated Product."
              

              }).then((result)=>{

                if(result.value){

                  window.location ="productlist.php";
                }

            });

            </script>';

      }else{
        echo '<script>
            
            swal.fire({

              icon: "error",
              title: "Opps..",
              text: "Error Updating product."
              

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
        Edit Product
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Edit Product</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
         <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Update Product</h3>
            </div>
             <div><a href="productlist.php" class="btn btn-primary" role="button">Bact to ProductList</a></div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post">

             <div class="box-body">

                

                  <div class="col-md-5">
                    
                    <div class="form-group">
                  <label>Product Name</label>
                  <input type="text" class="form-control" placeholder="Enter Product Name" name="proname" value="<?php echo $name_db;?>" required>
                </div>

                <div class="form-group">
                  <label>Categorie</label>
                  <select class="form-control" name="categorie" required>
                    <option  selected disabled>Select Categorie</option>
                    <?php

                        $select=$pdo->prepare("select *from categories");
                        $select->execute();

                        while($row=$select->fetch(PDO::FETCH_ASSOC)){

                          extract($row);
                    ?>
                            <option <?php if($row['categorie']==$categorie_db){ ?>

                                selected="selected"
                            <?php } ?> >

                              <?php echo $row['categorie'];?></option>

                            <?php

                        }
                          ?>

                    
                    
                  </select>
                </div>

                <div class="form-group">
                  <label>Purchase Price</label>
                  <input type="number" min="1" step="1" class="form-control" placeholder="Enter Price" name="purprice" value="<?php echo $purprice_db;?>" required> 
                </div>

                <div class="form-group">
                  <label>Sell Price</label>
                  <input type="number" min="1" step="1" class="form-control" placeholder="Enter Price" name="sellprice" value="<?php echo $sellprice_db;?>" required>
                </div>

              

                  </div>

                  <div class="col-md-1">

                  </div>
                  <div class="col-md-5">
                    
                    <div class="form-group">
                  <label>Stock</label>
                  <input type="number" min="1" step="1" class="form-control" placeholder="Quantity" name="stock" value="<?php echo $stock_db;?>" required>
                </div>

                <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" name="description" placeholder="Enter...."><?php echo $description_db;?></textarea>
                </div>

                

                  </div>

                  <div class="col-md-1">

                  </div>

                

              </div>

              <div class="box-footer">

                

                <button type="submit" class="btn btn-info" name="btnupdate">Update Product</button>
                
              </div>

            </form>
            </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php 

    include_once'footer.php';

  ?>
