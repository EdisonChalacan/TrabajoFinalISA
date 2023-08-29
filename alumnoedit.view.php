<?php
require 'functions.php';
$permisos = ['Administrador','Profesor'];
permisos($permisos);
if(isset($_GET['id'])) {

    $id_alumno = $_GET['id'];

    $alumno = $conn->prepare("select * from alumnos where id = ".$id_alumno);
    $alumno->execute();
    $alumno = $alumno->fetch();

//consulta las secciones
    $secciones = $conn->prepare("select * from secciones");
    $secciones->execute();
    $secciones = $secciones->fetchAll();

//consulta de grados
    $grados = $conn->prepare("select * from grados");
    $grados->execute();
    $grados = $grados->fetchAll();

}else{
    Die('Ha ocurrido un error');
}
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
<br>
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card mt-5" style="border-radius:20px;">
                <div class="card-body" >
                    <h4 class="card-title">Registro de Alumnos</h4>
                    <form method="post" class="form" action="procesaralumno.php">
                        <div class="form-group">
                        <input type="hidden" value="<?php echo $alumno['id']?>" name="id">
                            <label for="nombres">Nombres</label>
                            <input type="text" class="form-control" id="nombres" required maxlength="45" name="nombres"  value="<?php echo $alumno['nombres']?>">
                        </div>
                        <div class="form-group">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" required maxlength="45" name="apellidos" value="<?php echo $alumno['apellidos']?>">
                        </div>
                        <div class="form-group">
                            <label for="numlista">No de Lista</label>
                            <input type="number" class="form-control" id="numlista" min="1" name="numlista" value="<?php echo $alumno['num_lista']?>">
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label>Sexo</label><br>
                                <div class="form-check form-check-inline">
                                    <input required type="radio" name="genero" <?php if($alumno['genero'] == 'M') echo "checked"; ?> value="M" class="form-check-input">
                                    <label class="form-check-label">Masculino</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input required type="radio" name="genero" <?php if($alumno['genero'] == 'F') echo "checked"; ?> value="F" class="form-check-input">
                                    <label class="form-check-label">Femenino</label>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="grado">Grado</label>
                            <select class="form-control" name="grado" required>
                                <?php foreach ($grados as $grado):?>
                                    <option value="<?php echo $grado['id'] ?>" <?php if($alumno['id_grado'] == $grado['id']) { echo "selected";} ?> ><?php echo $grado['nombre'] ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Sección</label><br>
                            <?php foreach ($secciones as $seccion):?>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="seccion" <?php if($alumno['id_seccion'] == $seccion['id']) echo "checked"; ?> required value="<?php echo $seccion['id'] ?>">
                                    <label class="form-check-label">Seccion <?php echo $seccion['nombre'] ?></label>
                                </div>
                            <?php endforeach;?>
                        </div>

                        <div class="container float-left">
                        <button type="submit" class="btn btn-info" name="modificar">Guardar Cambios</button> <a class="btn btn-success" href="listadoalumnos.view.php">Ver Listado</a>
                        </div>
                    </form>
                   <!--mostrando los mensajes que recibe a traves de los parametros en la url-->
                <?php
                if(isset($_GET['err']))
                    echo '<span class="error">Error al editar el registro</span>';
                if(isset($_GET['info']))
                    echo '<span class="success">Registro modificado correctamente!</span>';
                ?>

                </div>
            </div>
        </div>
    </div>
</div>
<br><br><br><br><br>
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