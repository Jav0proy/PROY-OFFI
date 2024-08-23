<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Prueba jQuery</title>
</head>
<body>
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1"><!-- Inicio de modal -->
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel">Modal 1</h5>
                    <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
                </div> 
                <div class="modal-body" id="modal-body">
                    Muestra un segundo modal y oculta este con el botón de abajo.
                    
                </div>
                <div class="modal-footer">
                    <!--<button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Siguiente <i class="bi bi-arrow-return-right"></i></button>-->
                    <!--Este boton manda al segundo modal-->
                </div>
            </div>
        </div>
    </div><!-- Termino de modal -->

    <button >Ir a Index</button>

    <script>
$(document).ready(function(){
  $("button").click(function(){ 
    $("#modal-body").load("modales.php");
  });
});
</script>
</body>
</html>