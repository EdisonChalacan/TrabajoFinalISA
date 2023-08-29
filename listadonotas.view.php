<?php
require 'functions.php';

$permisos = ['Administrador','Profesor','Padre'];
permisos($permisos);
//consulta las materias
$materias = $conn->prepare("select * from materias");
$materias->execute();
$materias = $materias->fetchAll();

//consulta de grados
$grados = $conn->prepare("select * from grados");
$grados->execute();
$grados = $grados->fetchAll();

//consulta las secciones
$secciones = $conn->prepare("select * from secciones");
$secciones->execute();
$secciones = $secciones->fetchAll();
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
<div class="container" style="background-color:white; border-radius:20px;">
    <div class="panel">
        <h3 class="text-center">Consulta de Notas</h3>
        <?php
        if(!isset($_GET['consultar'])){
            ?>
            <p>Seleccione el grado, la materia y la sección</p>
            <form method="get" class="form" action="listadonotas.view.php">
                <label>Seleccione el Grado</label><br>
                <select name="grado" class="form-control" required>
                    <?php foreach ($grados as $grado):?>
                        <option value="<?php echo $grado['id'] ?>"><?php echo $grado['nombre'] ?></option>
                    <?php endforeach;?>
                </select>
                <br>
                <label>Seleccione la Materia</label><br>
                <select name="materia" class="form-control" required>
                    <?php foreach ($materias as $materia):?>
                        <option value="<?php echo $materia['id'] ?>"><?php echo $materia['nombre'] ?></option>
                    <?php endforeach;?>
                </select>
                <br>
                <div class="form-group">
                    <label>Seleccione la Sección</label><br>
                    <?php foreach ($secciones as $seccion) : ?>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="seccion" required value="<?php echo $seccion['id'] ?>" class="form-check-input">
                            
                        
                <label class="form-check-label">Sección <?php echo $seccion['nombre'] ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <br>
                <button class="btn btn-info" type="submit" name="consultar" value="1">Consultar Notas</button></a>
                <br><br>
            </form>
            <?php
        }
        ?>
        <hr>

        <?php
        if(isset($_GET['consultar'])){
            $id_materia = $_GET['materia'];
            $id_grado = $_GET['grado'];
            $id_seccion = $_GET['seccion'];

            //extrayendo el numero de evaluaciones para esa materia seleccionada
            $num_eval = $conn->prepare("select num_evaluaciones from materias where id = ".$id_materia);
            $num_eval->execute();
            $num_eval = $num_eval->fetch();
            $num_eval = $num_eval['num_evaluaciones'];


            //mostrando el cuadro de notas de todos los alumnos del grado seleccionado
            $sqlalumnos = $conn->prepare("select a.id, a.num_lista, a.apellidos, a.nombres, b.nota,b.observaciones, avg(b.nota) as promedio from alumnos as a left join notas as b on a.id = b.id_alumno
            where id_grado = ".$id_grado." and id_seccion = ".$id_seccion." group by a.id");
            $sqlalumnos->execute();
            $alumnos = $sqlalumnos->fetchAll();
            $num_alumnos = $sqlalumnos->rowCount();
            $promediototal = 0.0;

            ?>
            <br>
            <a class="btn btn-success" href="listadonotas.view.php"><strong><< Volver</strong></a>
            <br>
            <br>
              <div class="table-responsive">
                <table class="table" cellpadding="0" cellspacing="0">
                    <tr class="bg-warning">
                        <th>No de lista</th><th>Apellidos</th><th>Nombres</th>
                        <?php
                        for($i = 1; $i <= $num_eval; $i++){
                            echo '<th>Nota '.$i .'</th>';
                        }
                        ?>
                        <th>Promedio</th>
                        <th>Observaciones</th>
                    </tr>
                    <?php foreach ($alumnos as $index => $alumno) :?>
                        <!-- campos ocultos necesarios para realizar el insert-->
                        <tr>
                            <td align="center"><?php echo $alumno['num_lista'] ?></td><td><?php echo $alumno['apellidos'] ?></td>
                            <td><?php echo $alumno['nombres'] ?></td>
                            <?php

                                //escribiendo las notas en columnas
                                $notas = $conn->prepare("select id, nota from notas where id_alumno = ".$alumno['id']." and id_materia = ".$id_materia);
                                $notas->execute();
                                $notas = $notas->fetchAll();

                                foreach ($notas as $eval => $nota) {

                                    echo '<td align="center"><input type="hidden" 
                                            name="nota'.$eval.'" value="'. $nota['nota'] . '" >'. $nota['nota'] . '</td>';

                                }

                            echo '<td align="center">'.number_format($alumno['promedio'], 2).'</td>';
                            //echo '<td><a href="notas.view.php?grado='.$id_grado.'&materia='.$id_materia.'&seccion='.$id_seccion.'">Editar</a> </td>';
                            $promediototal += number_format($alumno['promedio'], 2);
                            echo '<td>'. $alumno['observaciones']. '</td>';
                            ?>

                        </tr>
                    <?php endforeach;?>
                    <tr><td colspan="3"><?php
                        for($i = 0; $i < $num_eval; $i++){
                            echo '<td><div class="text-center" id="promedio'.$i .'"><div></td>';
                        }
                        ?><td align="center"><?php echo number_format($promediototal / $num_alumnos,2) ?></td></tr>
                </table>
            </div>

                <br>


        <?php
        }
        ?>
    </div>
</div>


<br><br><br><br><br>
  <!--end cards-->
  <?php
  require("layout/footer.php");
    ?>

<script>
    <?php
    for($i = 0; $i < $num_eval; $i++){
        echo 'var values'.$i.' = [];
        var promedio'.$i.';
        var valor'.$i.' = 0;
        var nota'.$i.' = document.getElementsByName("nota'.$i.'");
        for(var i = 0; i < nota'.$i.'.length; i++) {
            valor'.$i.' += parseFloat(nota'.$i.'[i].value);
        }
        promedio'.$i.' = (valor'.$i.' / parseFloat(nota'.$i.'.length));
        document.getElementById("promedio'.$i.'").innerHTML = (promedio'.$i.').toFixed(2);';

    }
    ?>
</script>
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