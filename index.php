


<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>POS | Log In</title>
  
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="views/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="views/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="views/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="views/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="views/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="views/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- SweetAlert -->
  <script src="views/bower_components/sweetalert/sweetalert2.all.js"></script>



</head>
<body class="hold-transition login-page">

<?php

  include_once'connection.php';
  session_start();

  error_reporting(0);

  if(isset($_POST['btn-login'])){

    $user = $_POST['loginUser'];
    $password = $_POST['loginPassword'];

    $select = $pdo -> prepare("select * from users where username='$user' AND password ='$password' ");

    $select -> execute();

    $row = $select -> fetch(PDO::FETCH_ASSOC);

    if($row['username'] == $user && $row['password'] == $password && $row['profile'] == 'Administrator'){

      $_SESSION['id']=$row['id'];
      $_SESSION['name']=$row['name'];
      $_SESSION['username']=$row['username'];
      $_SESSION['profile']=$row['profile'];
      

      header('location:dashboard.php');
      

    }else if($row['username'] == $user AND $row['password'] == $password AND $row['profile'] == 'Cashier'){

      $_SESSION['id']=$row['id'];
      $_SESSION['name']=$row['name'];
      $_SESSION['username']=$row['username'];
      $_SESSION['profile']=$row['profile'];
      
       header('location:user.php');
 
    }else{

      // echo '<script>alert("Incorrect Username or Password")</script>';
      // echo'<script src="views/bower_components/sweetalert/sweetalert2.all.js"></script>';
      echo '<script>
            
            swal.fire({

              icon: "error",
              title: "Opps..",
              text: "Incorrect Username or Password. Try Agian."
              

              })

            </script>';

      
    }

  }

?>
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><b>Grocery Store</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"><b>Login Here</b></p>

    <form action="" method="post">

      <div class="form-group has-feedback">
        <input type="user" class="form-control" placeholder="User" name="loginUser" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="loginPassword" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-4">
          
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" name="btn-login">Log In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="views/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="views/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="views/plugins/iCheck/icheck.min.js"></script>
<!-- SweetAlert -->
 <!--  <script src="views/bower_components/sweetalert/sweetalert2.all.js"></script> -->
<!-- <script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script> -->
</body>
</html>
