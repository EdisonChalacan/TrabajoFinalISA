<?php
    require 'functions.php';

    $permisos = ['Administrador','Profesor'];
    permisos($permisos);
    //consulta los alumnos para el listaddo de alumnos
    $alumnos = $conn->prepare("select a.id, a.num_lista, a.nombres, a.apellidos, a.genero, b.nombre as grado, c.nombre as seccion from alumnos as a inner join grados as b on a.id_grado = b.id inner join secciones as c on a.id_seccion = c.id order by a.apellidos");
    $alumnos->execute();
    $alumnos = $alumnos->fetchAll();
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
    <div class="panel">
        <h4 class="text-center"><b>LISTA DE ALUMNOS</b></h4>
        <table class="table table-striped table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">No de<br>lista</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Nombres</th>
                    <th scope="col">Genero</th>
                    <th scope="col">Grado</th>
                    <th scope="col">Seccion</th>
                    <th scope="col">Editar</th>
                    <?php 
                    $val = $_SESSION["rol"];
                    if ($val == "Administrador") {
                        echo '<th scope="col">Eliminar</th>';
                    }
                    ?>
                   
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alumnos as $alumno) :?>
                <tr>
                    <td align="center"><?php echo $alumno['num_lista'] ?></td>
                    <td><?php echo $alumno['apellidos'] ?></td>
                    <td><?php echo $alumno['nombres'] ?></td>
                    <td align="center"><?php echo $alumno['genero'] ?></td>
                    <td align="center"><?php echo $alumno['grado'] ?></td>
                    <td align="center"><?php echo $alumno['seccion'] ?></td>
                    <td><a class="btn btn-primary" href="alumnoedit.view.php?id=<?php echo $alumno['id'] ?>">Editar</a></td>
                    <?php 
                    $val = $_SESSION["rol"];
                    if ($val == "Administrador") {
                        echo '<td><a class="btn btn-danger" href="alumnodelete.php?id=' . $alumno['id'] . '">Eliminar</a></td>';
                    }
                    ?>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <br><br>
        <div class="container">
        <a class="btn btn-success float-right" href="alumnos.view.php">Agregar Alumno</a>
        </div>
        <br><br>

        <?php
        if(isset($_GET['err']))
            echo '<span class="text-danger">Error al almacenar el registro</span>';
        if(isset($_GET['info']))
            echo '<span class="text-success">Registro almacenado correctamente!</span>';
        ?>
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