<?php
    require 'functions.php';
    //Define queienes tienen permiso en este archivo
    $permisos = ['Administrador','Profesor'];
    permisos($permisos);
    //consulta las secciones
    $secciones = $conn->prepare("select * from secciones");
    $secciones->execute();
    $secciones = $secciones->fetchAll();

    //consulta de grados
    $grados = $conn->prepare("select * from grados");
    $grados->execute();
    $grados = $grados->fetchAll();
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
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card mt-5" style="border-radius:20px;">
                <div class="card-body" >
                    <h4 class="card-title">Registro de Alumnos</h4>
                    <form method="post" class="needs-validation" action="procesaralumno.php" novalidate>
                        <div class="form-group">
                            <label for="nombres">Nombres</label>
                            <input type="text" class="form-control" id="nombres" required maxlength="45" name="nombres">
                        </div>
                        <div class="form-group">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" required maxlength="45" name="apellidos">
                        </div>
                        <div class="form-group">
                            <label for="numlista">No de Lista</label>
                            <input type="number" class="form-control" id="numlista" min="1" name="numlista">
                        </div>
                        <div class="form-group">
                            <label>Sexo</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="genero" id="generoM" value="M" required>
                                <label class="form-check-label" for="generoM">Masculino</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="genero" id="generoF" value="F" required>
                                <label class="form-check-label" for="generoF">Femenino</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="grado">Grado</label>
                            <select class="form-control" id="grado" name="grado" required>
                                <?php foreach ($grados as $grado):?>
                                    <option value="<?php echo $grado['id'] ?>"><?php echo $grado['nombre'] ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Sección</label><br>
                            <?php foreach ($secciones as $seccion):?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="seccion" required value="<?php echo $seccion['id'] ?>">
                                    <label class="form-check-label"><?php echo $seccion['nombre'] ?></label>
                                </div>
                            <?php endforeach;?>
                        </div>
                        <div class="container float-left">
                        <button type="submit" class="btn btn-primary" name="insertar">Guardar</button>
                        <button type="reset" class="btn btn-warning">Limpiar</button>
                        <a class="btn btn-success" href="listadoalumnos.view.php">Ver Listado</a>
                        </div>
                    </form>
                    <?php
                    if(isset($_GET['err']))
                        echo '<span class="error">Error al almacenar el registro</span>';
                    if(isset($_GET['info']))
                        echo '<span class="success">Registro almacenado correctamente!</span>';
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<br>
  <!--end cards-->
  <?php
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