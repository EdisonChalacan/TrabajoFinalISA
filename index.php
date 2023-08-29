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
      background-image: url('img/img1.jpeg');
      background-size: cover;
      background-repeat: no-repeat;
    }
    /* Sticky footer styles */
    html, body {
      height: 100%;
    }
    #page-content {
      flex: 1 0 auto;
      padding-bottom: 60px; /* Adjust this value to match the footer's height */
    }
    #footer {
      position: fixed;
      bottom: 0;
      width: 100%;
      background-color: #f8f9fa;
      padding: 10px 0;
    }
  </style>
  </head>
 <body>
    
<?php
//arreglo con mensajes que puede recibir
$messages = [
    "1" => "Credenciales incorrectas",
    "2" => "No ha iniciado sesión"
];
?>
<nav class="navbar navbar-expand-lg" style="background-color:#2F4794; color:white;">
  <a class="navbar-brand" href="/" style="color:white;"><b>INESUR</b></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#" style="color:white;"><b>Inicio</b><span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <!--modal mision-->
        <!-- Button trigger modal -->
            <a type="button" class="nav-link" data-toggle="modal" data-target="#mision" style="color:white;">
            <b> Misión </b>
           </a>

            <!-- Modal -->
            <div class="modal fade" id="mision" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"  style="color:black;"> Nuestra misión:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="color:black;">
                Es capacitar a personas comprometidas con el desarrollo social y económico, formando líderes con integridad humana, capaces de contribuir a alcanzar una sociedad más justa y equitativa.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Salir</button>
                </div>
                </div>
            </div>
            </div>
        <!--end mision-->
      </li>
      <li class="nav-item">
          <!-- Button trigger modal visión -->
          <a type="button" class="nav-link" data-toggle="modal" data-target="#vision" style="color:white;">
            <b> Visión </b>
           </a>

            <!-- Modal -->
            <div class="modal fade" id="vision" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"  style="color:black;">Nuestra visión:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="color:black;">
               Es convertirnos en una institución educativa líder y comprometida con el desarrollo de los sectores económicos a nivel regional,departamental y nacional. Seremos reconocidos por ofrecer talento humano experto en competencias laborales, las cuales desarrollaremos mediante programas certificados que garantizan la calidad en la formación para el trabajo y el desarrollo humano; fortalecidos en valores, espíritu de servicio, compromiso y sentido de pertenencia.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Salir</button>
                </div>
                </div>
            </div>
            </div>
        <!--end mision-->
      </li>
    </ul>
  </div>
</nav>
<!--formulario-->

<div class="container" style="padding-left:20em; padding-top:10em; padding-right:20em;">
<form method="post" class="form" action="login_post.php" style=" background-color:#F7BD71; padding:15px; border-radius:20px;">
<h4 class="text-center" style="color:white;"><b>INICIO DE SESIÓN</b></h4>
 <div class="form-group">
    <label for="exampleInputEmail1">Usuario</label>
    <input type="text" name="username" class="form-control" id="username" aria-describedby="emailHelp">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Contraseña</label>
    <input type="password" name="password" class="form-control" id="password">
  </div>
  <button type="submit" class="btn btn-primary">Entrar</button>
</form>
  <?php
    if(isset($_GET['err']) && is_numeric($_GET['err']) && $_GET['err'] > 0 && $_GET['err'] < 3 )
        echo '<span class="error">'.$messages[$_GET['err']].'</span>';
    ?>
</div>
<!--end formulario-->
  <footer id="footer" class="py-4 text-center" style="background-color:#2F4794;">
    <p style="color:white; font-size:20px;">INESUR todos los derechos reservados &copy; 2023</p>
  </footer>

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