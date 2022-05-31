
<?php 

    include_once'connection.php';

    session_start();

    

    function fill_product($pdo,$id){

      $output='';

      $select=$pdo->prepare("select * from product order by name asc");
      $select->execute();

      $result=$select->fetchAll();

      foreach($result as $row){

        $output.='<option value="'.$row["id"].'"'; 

          if($id==$row['id']){

            $output.='selected';
          }
          $output.='>'.$row["name"].' </option>';
        
      }

      return $output;
    }

    /*FETCHING DATA FROM DATABASE*/

    $id=$_GET['id'];
    $select=$pdo -> prepare("select * from invoice where invoice_id = $id");
    $select->execute();

    $row=$select->fetch(PDO::FETCH_ASSOC);

    $customer_name=$row['customer_name'];
      $date=date('Y-m-d',strtotime($row['date']));
      $subtotal=$row['subtotal'];
      $tax=$row['tax'];
      $discount=$row['discount'];
      $total=$row['total'];
      $paid=$row['paid'];
      $due=$row['due'];
      $payment_method=$row['payment_method'];


    $select=$pdo -> prepare("select * from invoice_details where invoice_id = $id");
    $select->execute();

    $row_invoice_details=$select->fetchAll(PDO::FETCH_ASSOC);


    if(isset($_POST['btnupdateorder'])){

      //Steps for btnupdateorder button.

      //1) Get values from text fields and from array in variables.

      $txt_customer_name=$_POST['customer'];
      $txt_date=date('y-m-d',strtotime($_POST['orderdate']));
      $txt_subtotal=$_POST['subtotal'];
      $txt_tax=$_POST['tax'];
      $txt_discount=$_POST['discount'];
      $txt_total=$_POST['total'];
      $txt_paid=$_POST['paid'];
      $txt_due=$_POST['due'];
      $txt_payment_method=$_POST['rb'];

      /*-------------------------*/

      $arr_productid=$_POST['productid'];
      $arr_productname=$_POST['productname'];
      $arr_stock=$_POST['stock'];
      $arr_qty=$_POST['qty'];
      $arr_price=$_POST['price'];
      $arr_total=$_POST['total'];

      //2) Write update query for table product stock.

      foreach($row_invoice_details as $item_invoice_details){

        $updateproduct = $pdo -> prepare("update product set stock=stock+".$item_invoice_details['qty']." where id='".$item_invoice_details['product_id']."'");

        $updateproduct -> execute();

      }

      //3) Write delete query fot invoice_details table data where invoice_id=$id .

      $delete_invoice_details = $pdo -> prepare("delete from invoice_details where invoice_id=$id");
      $delete_invoice_details->execute();

      // 4) Write update query for invoice table data.

       $update_invoice=$pdo->prepare("update invoice set customer_name=:name,date=:date,subtotal=:subtotal,tax=:tax,discount=:discount,total=:total,paid=:paid,due=:due,payment_method=:pmethod where invoice_id=$id");

      $update_invoice->bindParam(':name',$txt_customer_name);
      $update_invoice->bindParam(':date',$txt_date);
      $update_invoice->bindParam(':subtotal',$txt_subtotal);
      $update_invoice->bindParam(':tax',$txt_tax);
      $update_invoice->bindParam(':discount',$txt_discount);
      $update_invoice->bindParam(':total',$txt_total);
      $update_invoice->bindParam(':paid',$txt_paid);
      $update_invoice->bindParam(':due',$txt_due);
      $update_invoice->bindParam(':pmethod',$txt_payment_method);

      $update_invoice->execute();

      /*----------------------*/

      $invoice_id=$pdo->LastInsertId();


      if($invoice_id!=null){

        for($i=0; $i<count($arr_productid); $i++){

      // 5) Write select query for product table to get out stock values.

          $selectpdt=$pdo -> prepare("select * from product where id='".$arr_productid[$i]."'");
          $selectpdt->execute();

          while($rowpdt=$selectpdt->fetch(PDO::FETCH_OBJ)){

            $db_stock[$i]=$rowpdt->stock;

          $rem_qty = $db_stock[$i]-$arr_qty[$i];

          if($rem_qty<0){

            return "Order is Not complete";

          }else{

          // 6) Write update query for product table to update stock values.

            $update=$pdo->prepare("update product set stock ='$rem_qty' where id='".$arr_productid[$i]."'");

            $update->execute();

          }

        }
        // 7) Write insert query for invoice_details for insert new records.

          $insert=$pdo->prepare("insert into invoice_details(invoice_id,product_id,product_name,qty,price,date) values (:invid,:pid,:pname,:qty,:price,:date)");

          $insert->bindParam(':invid',$id);
          $insert->bindParam(':pid',$arr_productid[$i]);
          $insert->bindParam(':pname',$arr_productname[$i]);
          $insert->bindParam(':qty',$arr_qty[$i]);
          $insert->bindParam(':price',$arr_price[$i]);
          $insert->bindParam(':date',$date);

          $insert->execute();

          

      }

     // echo '<script>
            
     //        swal.fire({

     //          icon: "success",
     //          title: "Congratulation",
     //          text: "Succesfully Added."
              

     //          })

     //        </script>';
      header('location:orderlist.php');

    }

    }

    

    
    include_once'header.php';
    ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Order
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Order</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
         <div class="box box-warning">
          <form action="" method="post" name="">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Order</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

              <!-- customer and date -->
              <div class="box-body">
                  <div class="col-md-6">
                    
                    <div class="form-group">
                  <label>Customer Name</label>

                  <div class="input-group">
                    <div class="input-group-addon">
                          <i class="fa fa-user"></i>
                        </div>
                  <input type="text" class="form-control" value="<?php echo $customer_name; ?>" name="customer" ></div>
                </div>

                  </div>
                  <div class="col-md-6">
                    <!-- Date -->
                    <div class="form-group">
                      <label>Date:</label>

                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="datepicker" name="orderdate" value="<?php echo $date;?>" data-date-format="yyyy-mm-dd">
                      </div>
                      <!-- /.input group -->
                    </div>
                  </div>


              </div>
                <!-- Table -->
                <div class="box-body">
                  <div class="col-md-12">
                    <div style="overflow-x:auto;">
                  <table id="producttable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Search Product</th>
                          <th>Stock</th>
                          <th>Price</th>
                          <th>Quantity</th>
                          <th>Total</th>
                          <th><button type="button" class="btn btn-info btn-sm btnadd"><span class="glyphicon glyphicon-plus" ></span></button></th>
                          
                        </tr>
                      </thead>

                      <?php 

                      foreach($row_invoice_details as $item_invoice_details){

                        $select=$pdo -> prepare("select * from product where id = '{$item_invoice_details['product_id']}'");
                         $select->execute();

                         $row_product=$select->fetch(PDO::FETCH_ASSOC);

                      ?>
                      <tr>
                        <?php

                          echo '<td><input type="hidden" class="form-control pname" name="productname[]"  value="'.$row_product['name'].'" readonly></td>';

                          echo '<td><select class="form-control productidedit" name="productid[]" style="width: 250px"><option value=""></option> '.fill_product($pdo,$item_invoice_details['product_id']).'</select></td>';

                          echo '<td><input type="text"  class="form-control stock" name="stock[]" value="'.$row_product['stock'].'" readonly></td>';
                          echo '<td><input type="text"  class="form-control price" name="price[]" value="'.$row_product['sellprice'].'" readonly></td>';
                          echo '<td><input type="number" min="1" class="form-control qty" name="qty[]" value="'.$item_invoice_details['qty'].'" required></td>';
                          echo '<td><input type="text" class="form-control total" name="total[]" value="'.$row_product['sellprice']*$item_invoice_details['qty'].'" readonly></td>';
                          echo '<td><center><button type="button" class="btn btn-danger btn-sm btnremove"><span class="glyphicon glyphicon-remove" ></span></button></center></td>';

                        ?>

                      </tr>

                      <?php

                        }

                        ?>

                      <tbody></tbody>
                    </table>
                    </div>
                        </div>
                </div>
                  <!-- Tax, Discount, total -->
                  <div class="box-body">
                    <div class="col-md-6">     
                    
                    <div class="form-group">
                  <label>SubTotal</label>

                  <div class="input-group">
                    <div class="input-group-addon">
                          <i class="fa fa-usd"></i>
                        </div>
                  <input type="text" class="form-control" value="<?php echo $subtotal; ?>" name="subtotal" id="subtotal" required readonly></div>
                </div>

                  <div class="form-group">
                  <label>Tax (13%)</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                          <i class="fa fa-usd"></i>
                        </div>
                  <input type="text" class="form-control" name="tax" value="<?php echo $tax;?>" id="tax" required readonly></div>
                </div>

                <div class="form-group">
                  <label>Discount</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                          <i class="fa fa-usd"></i>
                        </div>
                  <input type="text" class="form-control" name="discount" value="<?php echo $discount;?>" id="discount" required></div>
                </div>

                    </div>
                    <div class="col-md-6">
                      
                      <div class="form-group">
                      <label>Total</label>
                      <div class="input-group">
                    <div class="input-group-addon">
                          <i class="fa fa-usd"></i>
                        </div>
                      <input type="text" class="form-control" name="total" value="<?php echo $total;?>" id="total" required readonly></div>
                    </div>

                      <div class="form-group">
                      <label>Paid</label>
                      <div class="input-group">
                    <div class="input-group-addon">
                          <i class="fa fa-usd"></i>
                        </div>
                      <input type="text" class="form-control" value="<?php echo $paid;?>" name="paid" id="paid" required></div>
                    </div>

                    <div class="form-group">
                      <label>Due</label>
                      <div class="input-group">
                    <div class="input-group-addon">
                          <i class="fa fa-usd"></i>
                        </div>
                      <input type="text" class="form-control" value="<?php echo $due;?>" name="due" id="due" required readonly></div>
                    </div>

                       <br>

                  <!-- radio -->
                  <label>Payment Method</label>
                    <div class="form-group">
                     <label>
                        <input type="radio" name="rb" class="minimal-red" value="Cash"<?php echo $payment_method=='Cash'?'checked':''?>>CASH
                      </label>
                      <label>
                        <input type="radio" name="rb" class="minimal-red" value="Card"<?php echo $payment_method=='Card'?'checked':''?>>CARD
                      </label>
                      <label>
                        <input type="radio" name="rb" class="minimal-red" value="Digital Wallet"<?php echo $payment_method=='Digital Wallet'?'checked':''?> >DIGITAL WALLET
                        
                      </label>
                    </div>

                    </div>

                  </div>
<hr>
                  <div align="center">
                      <input type="submit" name="btnupdateorder" value="Update Order" class="btn btn-warning">
                  </div>

<hr>

               
              
          </form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script>
   //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })


   

    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })

    $(document).ready(function(){

       //Initialize Select2 Elements

    $('.productidedit').select2({
      placeholder: "Select option",

    });

    $(".productidedit").on('change', function(e){

      var productid = this.value;
      var tr=$(this).parent().parent();

      $.ajax({

        url:"getproduct.php",
        method:"get",
        data:{id:productid},
        success:function(data){

          // console.log(data);
        tr.find(".pname").val(data["name"]);
        tr.find(".stock").val(data["stock"]);
        tr.find(".price").val(data["sellprice"]);
        tr.find(".qty").val(1);
        tr.find(".total").val(tr.find(".qty").val()*tr.find(".price").val());
        calculate(0,0);
        $("#paid").val("");



        }
      })
    })
      
      $(document).on('click','.btnadd',function(){

        var html='';
        html+='<tr>';

        html+='<td><input type="hidden" class="form-control pname" name="productname[]" readonly></td>';

        html+='<td><select class="form-control productid" name="productid[]" style="width: 250px"><option value=""></option> <?php echo fill_product($pdo,''); ?></select></td>';

        html+='<td><input type="text"  class="form-control stock" name="stock[]" readonly></td>';
        html+='<td><input type="text"  class="form-control price" name="price[]" readonly></td>';
        html+='<td><input type="number" min="1" class="form-control qty" name="qty[]" required></td>';
        html+='<td><input type="text" class="form-control total" name="total[]" readonly></td>';
        html+='<td><center><button type="button" class="btn btn-danger btn-sm btnremove"><span class="glyphicon glyphicon-remove" ></span></button></center></td>';
        html+='</tr>';
        
        $('#producttable').append(html);

         //Initialize Select2 Elements
    $('.productid').select2({
      placeholder: "Select option",

    });

    $(".productid").on('change', function(e){

      var productid = this.value;
      var tr=$(this).parent().parent();

      $.ajax({

        url:"getproduct.php",
        method:"get",
        data:{id:productid},
        success:function(data){

          // console.log(data);
        tr.find(".pname").val(data["name"]);
        tr.find(".stock").val(data["stock"]);
        tr.find(".price").val(data["sellprice"]);
        tr.find(".qty").val(1);
        tr.find(".total").val(tr.find(".qty").val()*tr.find(".price").val());
        calculate(0,0);
        $("#paid").val("");



        }
      })
    })

      })

      $(document).on('click','.btnremove',function(){

        $(this).closest('tr').remove();
        calculate(0,0);
        // $("#paid").val(0);
        $("#paid").val("");

        })

      $("#producttable").delegate(".qty","keyup change", function(){

        var quantity = $(this);
        var tr=$(this).parent().parent();
            $("#paid").val("");
        if((quantity.val()-0)>(tr.find(".stock").val()-0) ){

          swal.fire("WARNING!","Sorry! This much of quantity is not available","warning");

          quantity.val(1);

          tr.find(".total").val(quantity.val()*tr.find(".price").val());
          calculate(0,0);
        }else{

          tr.find(".total").val(quantity.val()*tr.find(".price").val());
          calculate(0,0);
          $("#paid").val("");
        }
      })

      function calculate(dis, paid){

        var subtotal=0;
        var exctax=0;
        var tax=0;
        var discount=dis;
        var total=0;
        var paid=paid;
        var due=0;

        $(".total").each(function(){

          subtotal = subtotal+($(this).val()*1)
          
        })
        exctax = subtotal-(0.13*subtotal)
        tax = 0.13*subtotal;
        total = tax+exctax;
        total = total-discount;
        due = paid-total;

        $("#exctax").val(exctax.toFixed(2));

        $("#tax").val(tax.toFixed(2));

        $("#total").val(total.toFixed(2));

        $("#discount").val(discount);

        $("#due").val(due.toFixed(2));

      }

      $("#discount").keyup(function(){

        var discount = $(this).val();
        calculate(discount,0);
      })

      $("#paid").keyup(function(){

        var paid = $(this).val();
        var discount = $("#discount").val();
        calculate(discount,paid);
      })




      
    });
  </script>

  <?php 

    include_once'footer.php';

  ?>
