<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <title> Ejemplo de Modales </title>
    


</head>
<body>
  <table class="table">
  <thead>
  <h5>Ejemplo Contenido. Para agregar boton para llamar al modal</h5>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li> 
        <li class="nav-item"> 
          <a class="nav-link disabled" aria-disabled="true">Disabled</a> 
        </li>
      </ul>
    </div>
  </div>
</nav>
                            
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                                <th scope="col">Abir Modales</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr> 
                                <th scope="row">1</th>
                                <td>Mark1</td>
                                <td>Otto1</td> 
                                <td>@mdo1</td>
                                <td>
                                <div class="card" style="width: 18rem;"> 
                                <!--<img src="..." class="card-img-top" alt="...">-->
                                <div class="card-body">
                                <h5 class="card-title">Tarjeta Ejemplo</h5>
                                <p class="card-text">Contenido en tarjeta.</p>
                                </div>
                                <div class="card-body">
                                <a class="btn btn-primary" data-bs-toggle="modal" href="#exampleModalToggle" role="button">1er modal</a> 
                                <!--<a class="btn btn-primary" data-bs-toggle="modal" href="#exampleModalToggle2" role="button">2do modal</a>-->
                                </div>
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Otto2</td>
                                <td>Mark2</td> 
                                <td>@otto2</td> 
                                <td>
                                <div class="card" style="width: 18rem;">
                                <!--<img src="..." class="card-img-top" alt="No hay imagen">-->
                                <div class="spinner-border text-danger" role="status">
                                <span class="visually-hidden">Loading...</span>
                                </div>
                                <div class="card-body"> 
                                <p class="card-text">Ejemplo de una tarjeta.</p>
                                </div>
                                </div>
                                    <a class="btn btn-primary" data-bs-toggle="modal" href="#exampleModalToggle2" role="button2">2do modal</a></td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Otto3</td>
                                <td>Mark3</td> 
                                <td>@otto3</td> 
                                <td>
                                <a class="btn btn-primary" data-bs-toggle="modal" href="#exampleModalToggle3" role="button">3er modal</a></td>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">4</th>
                                <td>Otto4</td>
                                <td>Mark4</td>
                                <td>@otto4</td> 
                                <td>
                                <a class="btn btn-primary" data-bs-toggle="modal" href="#exampleModalToggle4" role="button">4to modal</a></td>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">5</th>
                                <td>Otto5</td>
                                <td>Mark5</td>
                                <td>@otto5</td>
                                <td>
                                <a class="btn btn-primary" data-bs-toggle="modal" href="#exampleModalToggle5" role="button">5to modal</a></td>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>

    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1"><!-- Inicio de modal -->
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel">Modal 1</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> 
                <div class="modal-body" id="modal-body">
                    Muestra de jquery
                    <button id="1modal">Abre index</button>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Siguiente <i class="bi bi-arrow-return-right"></i></button>
                    <!--Este boton manda al segundo modal-->
                </div>
            </div>
        </div>
    </div><!-- Termino de modal -->
    <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1"><!-- Inicio de modal -->
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content"> 
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel2">Modal 2</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body " id="modal-body2">
                    <!--En este apartado va todo el contenido del modal-->
                    Oculta este modal y muestra el primero con el botón de abajo.
                    <h3>Ejemplo de datos en columnas. 2do Modal</h3>
                    
                    <button id="2modal">Abre 2modal</button>
                    
                <div class="modal-footer">
                    <div>
                <a class="btn btn-primary" data-bs-toggle="modal" href="#exampleModalToggle" role="button">Regresar <i class="bi bi-arrow-return-left"></i></a>
                    </div>
                    <button class="btn btn-primary" data-bs-target="#exampleModalToggle3" data-bs-toggle="modal">Siguiente <i class="bi bi-arrow-return-right"></i></button>
                    <!--Este boton regresa al primer modal dentro del id que se tiene en el modal-->
                </div>
            </div>
        </div>
    </div><!-- Termino de modal -->

    <div class="modal fade" id="exampleModalToggle3" aria-hidden="true" aria-labelledby="exampleModalToggleLabel3" tabindex="-1"><!-- Inicio de modal -->
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"> 
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel3">Modal 3</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body3">
                    <!--En este apartado va todo el contenido del modal-->
                    Oculta este modal y muestra el primer modal con el botón de abajo.
                    <h3> Ejemplo de columna y tabla en modal 3</h3>

                    <button id="3modal">Abre 3modal</button>
                    </br> 
                    <p>Aqui termina el contenedor de columnas</p>
                    </br>
                  
                </div>
                <div class="modal-footer" id="modal-footer3">
                    <div>
                        
                <a class="btn btn-primary" data-bs-toggle="modal" href="#exampleModalToggle2" role="button">Regresar <i class="bi bi-arrow-return-left"></i></a>
                    </div>
                    <button class="btn btn-primary" data-bs-target="#exampleModalToggle4" data-bs-toggle="modal">Siguiente <i class="bi bi-arrow-return-right"></i></button>
                    <!--Este boton regresa al primer modal dentro del id que se tiene en el modal-->
                </div>
            </div>
        </div>
    </div><!-- Termino de modal -->
    <div class="modal fade" id="exampleModalToggle4" aria-hidden="true" aria-labelledby="exampleModalToggleLabel4" tabindex="-1"><!-- Inicio de modal -->
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel4">Modal 4</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!--En este apartado va todo el contenido del modal-->
                    Oculta este modal y muestra diferentes modales con los botones de abajo
                    <h3>Ejemplo menu desplegable. 4to Modal</h3>
                    <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Desplegable
                    </button>
                    <ul class="dropdown-menu">
                    <li><button class="dropdown-item" type="button" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Modal 1</button></li>
                    <li><button class="dropdown-item" type="button" data-bs-target="#exampleModalToggle3" data-bs-toggle="modal">Modal 3</button></li>
                    <li><button class="dropdown-item" type="button" data-bs-target="#exampleModalToggle5" data-bs-toggle="modal">Modal 5</button></li>
                    </ul>
                    </div>
                    </br> 
                    <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Desplegable2
                    </button> 
                    <ul class="dropdown-menu">
                    <li><button class="btn btn-primary" type="button" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Modal </button></li>
                    <li><button class="btn btn-primary" type="button" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Modal 2</button></li>
                    <li><button class="btn btn-primary" type="button" data-bs-target="#exampleModalToggle3" data-bs-toggle="modal">Modal 3</button></li>
                    </ul>
                    </div>
                    </br>
                    <div class="btn-group"> 
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Selecciona boton
                    </button>
                    <ul class="dropdown-menu">
                        <li>Hola</li>
                        <li>Prueba2</li>
                        <li>Prueba3</li>
                    </ul> 
                    </div>
                    <div class="btn-group">
                    <button class="btn btn-secondary btn-sm" type="button">
                     Selecciona
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>Colum</li>
                        <li>Colum 2</li>
                        <li>Colum 3</li>
                    </ul>
                    </div>
                </div>
                <div class="modal-footer"> 
                    <div>
                <a class="btn btn-primary" data-bs-toggle="modal" href="#exampleModalToggle3" role="button">Regresar <i class="bi bi-arrow-return-left"></i> </a>
                    </div>
                    <button class="btn btn-primary" data-bs-target="#exampleModalToggle5" data-bs-toggle="modal">Siguiente <i class="bi bi-arrow-return-right"></i> </button>
                    <!--Este boton regresa al primer modal dentro del id que se tiene en el modal-->
                </div>
            </div>
        </div>
    </div><!-- Termino de modal -->

    <div class="modal fade" id="exampleModalToggle5" aria-hidden="true" aria-labelledby="exampleModalToggleLabel5" tabindex="-1"><!-- Inicio de modal -->
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel5">Modal 5</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!--En este apartado va todo el contenido del modal-->
                    Oculta este modal y muestra diferentes modales con los botones de abajo
                    <h3>Formulario dentro de un deplegable. 5to Modal</h3>

                    <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                       Formulario Desplegable Ejemplo
                    </button>
                    <form class="dropdown-menu p-4">
                    <div class="mb-3">
                    <label for="exampleDropdownFormEmail2" class="form-label">Email </label>
                    <input type="email" class="form-control" id="exampleDropdownFormEmail2" placeholder="email@example.com">
                    </div>
                    <div class="mb-3">
                    <label for="exampleDropdownFormPassword2" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleDropdownFormPassword2" placeholder="Password">
                    </div>
                    <div class="mb-3">
                    <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="dropdownCheck2">
                    <label class="form-check-label" for="dropdownCheck2">
                       Recordarme
                    </label>
                    </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Sign in</button>
                    </form>
                    </div>
                <div class="modal-footer">
                    <div> 
                <a class="btn btn-primary" data-bs-toggle="modal" href="#exampleModalToggle" role="button">Ir 1er Modal <i class="bi bi-house-fill"></i></a>
                    </div>
                    <button class="btn btn-primary" data-bs-target="#exampleModalToggle4" data-bs-toggle="modal">Regresar <i class="bi bi-arrow-return-left"></i></button>
                    <!--Este boton regresa al primer modal dentro del id que se tiene en el modal-->
                </div>
            </div>
        </div>
    </div><!-- Termino de modal -->

    <script>
        $(document).ready(function () {
            $("#1modal").click(function () {
                $("#modal-body").load("index.php");
            });
        });

        $(document).ready(function () {
            $("#2modal").click(function () {
                $("#modal-body2").load("indexV2.php");
            }); 
        });

        $(document).ready(function () {
            $("#3modal").click(function () {
                $("modal-footer3").load("index.php");
            });
        });
    </script>
    
  

</body>
</html>