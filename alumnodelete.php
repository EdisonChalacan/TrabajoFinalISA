<?php
require 'functions.php';
if ($_SESSION['rol'] == 'Administrador') {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        try {
            $id_alumno = $_GET['id'];
           
            // Check for associated records in 'notas' table

            $delete_alum_nota = $conn->prepare("DELETE FROM notas WHERE id_alumno = ?");
            $delete_alum_nota->execute([$id_alumno]);
            

            $has_associated_records = $conn->prepare("SELECT id FROM notas WHERE id_alumno = ?");
            $has_associated_records->execute([$id_alumno]);

           
            
            if ($has_associated_records->rowCount() > 0) {
                // Handle associated records before deleting
                // For example, you might choose to delete or update the associated records first
                // And then proceed with deleting the student record
            }
            
            // If no associated records or after handling them
            $delete_alumno = $conn->prepare("DELETE FROM alumnos WHERE id = ?");
            $delete_alumno->execute([$id_alumno]);
            
            header('location: listadoalumnos.view.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        die('Ha ocurrido un error');
    }
} else {
    header('location: inicio.view.php?err=1');
}
?>
