
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
        User Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->


  </div>
  <!-- /.content-wrapper -->

  <?php 

    include_once'footer.php';

  ?>

