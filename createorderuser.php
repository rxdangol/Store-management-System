
<?php 

    include_once'connection.php';

    session_start();
    if($_SESSION['profile'] == '' OR $_SESSION['username'] == ''){
      
      header('location:index.php');
      
    }

    

    function fill_product($pdo){

      $output='';

      $select=$pdo->prepare("select * from product order by name asc");
      $select->execute();

      $result=$select->fetchAll();

      foreach($result as $row){

        $output.='<option value="'.$row["id"].'"> '.$row["name"].' </option>';
      }

      return $output;
    }

    if(isset($_POST['btnsaveorder'])){

      $customer_name=$_POST['customer'];
      $date=date('y-m-d',strtotime($_POST['orderdate']));
      $subtotal=$_POST['exctax'];
      $tax=$_POST['tax'];
      $discount=$_POST['discount'];
      $total=$_POST['total'];
      $paid=$_POST['paid'];
      $due=$_POST['due'];
      $payment_method=$_POST['rb'];

      /*-------------------------*/

      $arr_productid=$_POST['productid'];
      $arr_productname=$_POST['productname'];
      $arr_stock=$_POST['stock'];
      $arr_qty=$_POST['qty'];
      $arr_price=$_POST['price'];
      $arr_total=$_POST['total'];

      $insert=$pdo->prepare("insert into invoice(customer_name,date,subtotal,tax,discount,total,paid,due,payment_method) values(:name,:date,:subtotal,:tax,:discount,:total,:paid,:due,:pmethod)");

      $insert->bindParam(':name',$customer_name);
      $insert->bindParam(':date',$date);
      $insert->bindParam(':subtotal',$subtotal);
      $insert->bindParam(':tax',$tax);
      $insert->bindParam(':discount',$discount);
      $insert->bindParam(':total',$total);
      $insert->bindParam(':paid',$paid);
      $insert->bindParam(':due',$due);
      $insert->bindParam(':pmethod',$payment_method);

      $insert->execute();


      /*----------------------*/

      $invoice_id=$pdo->LastInsertId();
      if($invoice_id!=null){

        for($i=0; $i<count($arr_productid); $i++){

          $rem_qty = $arr_stock[$i]-$arr_qty[$i];

          if($rem_qty<0){

            return "Order is Not complete";

          }else{

            $update=$pdo->prepare("update product set stock ='$rem_qty' where id='".$arr_productid[$i]."'");

            $update->execute();

          }

          $insert=$pdo->prepare("insert into invoice_details(invoice_id,product_id,product_name,qty,price,date) values (:invid,:pid,:pname,:qty,:price,:date)");

          $insert->bindParam(':invid',$invoice_id);
          $insert->bindParam(':pid',$arr_productid[$i]);
          $insert->bindParam(':pname',$arr_productname[$i]);
          $insert->bindParam(':qty',$arr_qty[$i]);
          $insert->bindParam(':price',$arr_price[$i]);
          $insert->bindParam(':date',$date);

          $insert->execute();


          

      }

    
     header('location:orderlist.php');

    }

    }

    include_once'headeruser.php';
    
    ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Create Order
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
              <h3 class="box-title">New Order</h3>
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
                  <input type="text" class="form-control" placeholder="Enter Customer Name" name="customer" ></div>
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
                        <input type="text" class="form-control pull-right" id="datepicker" name="orderdate" value="<?php echo date("Y-m-d");?>" data-date-format="yyyy-mm-dd">
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
                          <th><button type="button" class="btn btn-success btn-sm btnadd"><span class="glyphicon glyphicon-plus" ></span></button></th>
                          
                        </tr>
                      </thead>

                      <tbody></tbody>
                    </table>
                    </div>
                        </div>
                </div>
                  <!-- Tax, Discount, total -->
                  <div class="box-body">
                    <div class="col-md-6">     
                    
                    <div class="form-group">
                  <label>SubTotal(Excluding Tax)</label>

                  <div class="input-group">
                    <div class="input-group-addon">
                          <i class="fa fa-usd"></i>
                        </div>
                  <input type="text" class="form-control" name="exctax" id="exctax" required readonly></div>
                </div>

                  <div class="form-group">
                  <label>Tax (13%)</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                          <i class="fa fa-usd"></i>
                        </div>
                  <input type="text" class="form-control" name="tax" id="tax" required readonly></div>
                </div>

                <div class="form-group">
                  <label>Discount</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                          <i class="fa fa-usd"></i>
                        </div>
                  <input type="text" class="form-control" name="discount" id="discount" required></div>
                </div>

                    </div>
                    <div class="col-md-6">
                      
                      <div class="form-group">
                      <label>Total(Including Tax)</label>
                      <div class="input-group">
                    <div class="input-group-addon">
                          <i class="fa fa-usd"></i>
                        </div>
                      <input type="text" class="form-control" name="total" id="total" required readonly></div>
                    </div>

                      <div class="form-group">
                      <label>Paid</label>
                      <div class="input-group">
                    <div class="input-group-addon">
                          <i class="fa fa-usd"></i>
                        </div>
                      <input type="text" class="form-control" name="paid" id="paid" required></div>
                    </div>

                    <div class="form-group">
                      <label>Due</label>
                      <div class="input-group">
                    <div class="input-group-addon">
                          <i class="fa fa-usd"></i>
                        </div>
                      <input type="text" class="form-control" name="due" id="due" required readonly></div>
                    </div>

                       <br>

                  <!-- radio -->
                  <label>Payment Method</label>
                    <div class="form-group">
                      <label>
                        <input type="radio" name="rb" class="minimal-red" value="Cash" checked>CASH
                      </label>
                      <label>
                        <input type="radio" name="rb" class="minimal-red" value="Card">CARD
                      </label>
                      <label>
                        <input type="radio" name="rb" class="minimal-red" value="Digital Wallet" >DIGITAL WALLET
                        
                      </label>
                    </div>

                    </div>

                  </div>
<hr>
                  <div align="center">
                      <input type="submit" name="btnsaveorder" value="Save Order" class="btn btn-info">
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
      
      $(document).on('click','.btnadd',function(){

        var html='';
        html+='<tr>';

        html+='<td><input type="hidden" class="form-control pname" name="productname[]" readonly></td>';

        html+='<td><select class="form-control productid" name="productid[]" style="width: 250px"><option value=""></option> <?php echo fill_product($pdo); ?></select></td>';

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



        }
      })
    })

      })

      $(document).on('click','.btnremove',function(){

        $(this).closest('tr').remove();
        calculate(0,0);
        $("#paid").val(0);

        })

      $("#producttable").delegate(".qty","keyup change", function(){

        var quantity = $(this);
        var tr=$(this).parent().parent();

        if((quantity.val()-0)>(tr.find(".stock").val()-0) ){

          swal.fire("WARNING!","Sorry! This much of quantity is not available","warning");

          quantity.val(1);

          tr.find(".total").val(quantity.val()*tr.find(".price").val());
          calculate(0,0);
        }else{

          tr.find(".total").val(quantity.val()*tr.find(".price").val());
          calculate(0,0);
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
