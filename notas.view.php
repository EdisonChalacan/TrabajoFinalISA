<?php
require 'functions.php';
//arreglo de permisos
$permisos = ['Administrador','Profesor'];
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
<div class="c">
    <div class="container" style="background-color:white; border-radius:20px;">
    <br>
            <h3 class="text-center">Registro y Modificación Notas</h3>
           <?php
           if(!isset($_GET['revisar'])){
               ?>

            <form method="get" class="form" action="notas.view.php" >
                <label>Seleccione el Grado</label><br>
                <select name="grado" class="form-control" required>
                    <?php foreach ($grados as $grado):?>
                        <option value="<?php echo $grado['id'] ?>"><?php echo $grado['nombre'] ?></option>
                    <?php endforeach;?>
                </select>
                <br><br>
                <label>Seleccione la Materia</label><br>
                <select name="materia" class="form-control" required>
                    <?php foreach ($materias as $materia):?>
                        <option value="<?php echo $materia['id'] ?>"><?php echo $materia['nombre'] ?></option>
                    <?php endforeach;?>
                </select>

                <br><br>
                <label>Seleccione la Sección</label><br>
                <?php foreach ($secciones as $seccion):?>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="seccion" required value="<?php echo $seccion['id'] ?>" class="form-check-input">
                        <label class="form-check-label">Sección <?php echo $seccion['nombre'] ?></label>
                     </div>
               <?php endforeach;?>

                <br><br>
                <button class="btn btn-info" type="submit" name="revisar" value="1">Ingresar Notas</button> <a class="btn btn-success" href="listadonotas.view.php">Consultar Notas</a>
                <br><br>
            </form>
        <?php
           }
        ?>
        <hr>

        <?php
        if(isset($_GET['revisar'])){
            $id_materia = $_GET['materia'];
            $id_grado = $_GET['grado'];
            $id_seccion = $_GET['seccion'];

            //extrayendo el numero de evaluaciones para esa materia seleccionada
            $num_eval = $conn->prepare("select num_evaluaciones from materias where id = ".$id_materia);
            $num_eval->execute();
            $num_eval = $num_eval->fetch();
            $num_eval = $num_eval['num_evaluaciones'];


            //mostrando el cuadro de notas de todos los alumnos del grado seleccionado
            $sqlalumnos = $conn->prepare("select a.id, a.num_lista, a.apellidos, a.nombres, b.nota, avg(b.nota) as promedio, b.observaciones from alumnos as a left join notas as b on a.id = b.id_alumno
            where id_grado = ".$id_grado." and id_seccion = ".$id_seccion." group by a.id");
            $sqlalumnos->execute();
            $alumnos = $sqlalumnos->fetchAll();
            $num_alumnos = $sqlalumnos->rowCount();

            ?>
            <br>
            <a class="btn btn-success" href="notas.view.php"><strong><< Volver</strong></a>
            <br>
            <br>
        <form action="procesarnota.php" method="post">
        <div class="table-responsive">
            <table class="table" cellpadding="0" cellspacing="0">
                <tr class="bg-warning" >
                    <th style="vertical-align: center;">Lista</th>
                    <th style="vertical-align: center;">Apellidos</th><th>Nombres</th>
                    <?php
                        for($i = 1; $i <= $num_eval; $i++){
                           echo '<th>Nota '.$i .'</th>';
                        }
                    ?>
                    <th style="vertical-align: none;">Promedio</th>
                    <th style="vertical-align: center;">Observaciones</th>
                    <th style="vertical-align: center;">Eliminar</th>
                </tr>
                <?php foreach ($alumnos as $index => $alumno) :?>
                    <!-- campos ocultos necesarios para realizar el insert-->
                    <input type="hidden" value="<?php echo $num_alumnos ?>" name="num_alumnos">
                    <input type="hidden" value="<?php echo $alumno['id'] ?>" name="<?php echo 'id_alumno'.$index ?>">
                    <input type="hidden" value="<?php echo $num_eval ?>" name="num_eval">
                     <!-- campos para devolver los parametros en el get y mantener los mismos datos al hacer el header location-->
                    <input type="hidden" value="<?php echo $id_materia ?>" name="id_materia">
                    <input type="hidden" value="<?php echo $id_grado ?>" name="id_grado">
                    <input type="hidden" value="<?php echo $id_seccion ?>" name="id_seccion">
                    <tr>
                        <td align="center"><?php echo $alumno['num_lista'] ?></td><td><?php echo $alumno['apellidos'] ?></td>
                        <td><?php echo $alumno['nombres'] ?></td>
                        <?php
                           if(existeNota($alumno['id'],$id_materia,$conn) > 0){
                                //ya tiene notas registradas
                                $notas = $conn->prepare("select id, nota from notas where id_alumno = ".$alumno['id']." and id_materia = ".$id_materia);
                                $notas->execute();
                                $registrosnotas = $notas->fetchAll();
                                $num_notas = $notas->rowCount();
                                foreach ($registrosnotas as $eval => $nota){
                                    echo '<input type="hidden" value="'.$nota['id'].'" name="idnota' . $eval .'alumno' . $index . '">';
                                    echo '<td><input type="text" maxlength="5" value="'.$nota['nota'].'" name="evaluacion' . $eval . 'alumno' . $index . '" class="txtnota"></td>';
                                }
                                if($num_eval > $num_notas){
                                    $dif = $num_eval - $num_notas;

                                    for($i = $num_notas; $i < $dif + $num_notas; $i++) {
                                        echo '<input type="hidden" value="'.$nota['id'].'" name="idnota' . $i .'alumno' . $index . '">';
                                        echo '<td><input type="text" maxlength="5" value="'.$nota['nota'].'" name="evaluacion' . $i . 'alumno' . $index . '" class="txtnota"></td>';
                                    }
                                }


                            }else {
                                //extrayendo el numero de evaluaciones para esa materia seleccionada
                                for($i = 0; $i < $num_eval; $i++) {
                                    echo '<td><input type="text" maxlength="5" name="evaluacion' . $i . 'alumno' . $index . '" class="txtnota"></td>';
                                }
                            }

                            echo '<td align="center">'.number_format($alumno['promedio'], 2).'</td>';

                            if(existeNota($alumno['id'],$id_materia,$conn) > 0){
                                echo '<td><input type="text" maxlength="100" value="'.$alumno['observaciones'].'" name="observaciones' . $index . '" class="txtnota"></td>';
                            }else {
                                echo '<td><input type="text" name="observaciones' . $index . '" class="txtnota"></td>';
                            }

                        if(existeNota($alumno['id'],$id_materia,$conn) > 0){
                            echo '<td><a class="btn btn-danger" href="notadelete.php?idalumno='.$alumno['id'].'&idmateria='.$id_materia.'">Eliminar</a> </td>';
                        }else{
                            echo '<td>Sin notas</td>';
                        }
                        ?>
                    </tr>
                <?php endforeach;?>
                <tr></tr>
            </table>
           </div>
                <br>
                <button class="btn btn-primary" type="submit" name="insertar">Guardar</button> <button class="btn btn-warning" type="reset">Limpiar</button> <a class="btn btn-success" href="listadonotas.view.php">Consultar Notas</a>
                <br>
            </form>


        <?php }

        ?>
                <!--mostrando los mensajes que recibe a traves de los parametros en la url-->
                <?php
                if(isset($_GET['err']))
                    echo '<span class="error">Error al almacenar el registro</span>';
                if(isset($_GET['info']))
                    echo '<span class="success">Registro almacenado correctamente!</span>';
                ?>

            </form>
        <?php
        if(isset($_GET['err']))
            echo '<span class="error">Error al guardar</span>';
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