<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- titulo -->
  <title>LOGIN</title>
  <!-- bootstrap, validator y jquery -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link rel="stylesheet" href="./FRONTEND/bower_components/bootstrap/dist/css/bootstrap.min.css" />
  <script type="text/javascript" src="./FRONTEND/bower_components/jquery/dist/jquery.min.js"></script>
  <script type="text/javascript" src="./FRONTEND/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">


  <!-- estilos -->
  <link rel="stylesheet" href="./FRONTEND/css/estilos.css" />
  <script src="FRONTEND/principal.js"></script>


</head>

<body class="principal">


  <div class="container-fluid" style="margin-top:30px">



    <nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top">

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-primary" id="navbardrop" data-toggle="dropdown">
              Listados<b class="caret"></b>
            </a>
            <div class="dropdown-menu">
              <button class="dropdown-item" onclick="MostrarUsuarios()">Usuarios</button>
              <button class="dropdown-item" onclick="MostrarAutos()">Autos</button>
            </div>
          </li>

          <li class="dropdown dropdown">
            <a class="nav-link text-primary" id="navbardrop" data-toggle="dropdown" onclick="AltaAutos()">
              Alta Autos <b class="caret"></b>
            </a>
          </li>

        </ul>
      </div>
    </nav>
  </div>




  <div class="container" style="height:auto;  padding-top: 5%; ">
    <div class="row">
      <div id="divAlert">
      </div>
    </div>
    <div class="row">
      <div class="col bg-danger ">
        <h6>IZQUIERDA</h6>
        <div style="height: auto;" id="tabIzquierda">
        </div>
      </div>

      <div class="col bg-success w-100">
        <h6>DERECHA</h6>
        <div style="height: auto; " id="tabDerecha">

        </div>
      </div>
    </div>
  </div>





</body>

</html>