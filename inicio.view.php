<?php
    require 'functions.php';
    $permisos = ['Administrador','Profesor','Padre'];
    permisos($permisos);

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    

    <title>INESUR</title>
    <style>
   body {
      background-color:#D7E6FE;
    }
    /* Sticky footer styles */
    html, body {
      height: 100%;
    }
    #page-content {
      flex: 1 0 auto;
      padding-bottom: 60px; /* Adjust this value to match the footer's height */
    }
    
  </style>
  </head>
 <body>

 <!--aqui llamar header-->

<?php
  require("layout/header.php");

  $val = $_SESSION["rol"];
?>

<br>
<div class="container">
        <h3 class="text-center"><b>Bienvenido:  <?php echo $_SESSION["username"] ?></b></h3>
</div>
  <!--cards para redirects-->
  <div class="container" style="padding:2em;">
  <div class="row row-cols-1 row-cols-md-2">
    <!--card--2-->
  <?php 
   if ($val == "Administrador" || $val == "Profesor") {
    require("cards/card1.php");
   }
   ?>
  <div class="col mb-4">
     <!--card--2-->
     <div class="card mb-3" style="max-width: 540px; border-radius:20px;">
    <div class="row no-gutters">
        <div class="col-md-4">
        <img src="img/img5.png" alt="..." width="85%;" >
        </div>
        <div class="col-md-8">
        <div class="card-body">
            <h5 class="card-title">Consulta de notas</h5>
            <p class="card-text">
             En esta sección puede consultar las notas de cada alumno.
            </p>
            <p class="card-text"><small class="text-muted">
                <a href="listadonotas.view.php" class="btn btn-info float-right" >Ingresar</a>
            </small></p>
        </div>
        </div>
    </div>
    </div>
    <!--end card-->
  </div>
</div>
</div>
  <!--end cards-->
  <?php 
  if($val == "Padre"){
    echo "<br><br><br><br><br><br><br>";
  }
  require("layout/footer.php");
    ?>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->
  </body>
</html>