<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Etiquetas</title>
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Template Stylesheet -->
    <link href="../../public/css/style.css" rel="stylesheet">

    <style>
        .select2-container {
            width: 100% !important;
        }

        textarea {
            width: 100% !important;
        }
    </style>
</head>

<body>

    <!-- Botón para agregar etiquetas -->
    <div class="container mt-3">
        <button class="btn btn-success mb-3" onclick="abrirModal('insertar')">Agregar Etiqueta</button>
    </div>

    <!-- Tabla Etiquetas -->
    <table class="table table-bordered table-striped table-hover table-responsive">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nombre de la Etiqueta</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="cuerpoEtiquetas">
        </tbody>
    </table>
    <!-- Fin de la tabla -->

    <!-- Modal para insertar/editar etiqueta -->
    <div class="modal fade" id="modalEtiqueta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Insertar/Actualizar Etiqueta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEtiqueta">
                        <input type="hidden" id="id_etiqueta" name="id_etiqueta">
                        <div class="form-group">
                            <label for="nombre_etiqueta">Nombre de la Etiqueta</label>
                            <input type="text" class="form-control" id="nombre_etiqueta" name="nombre_etiqueta" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Tu script principal -->
    <script src="etiquetas.js"></script>

    <script>
        window.onload = function() {
            cargarEtiquetas();
        };
    </script>
</body>

</html>