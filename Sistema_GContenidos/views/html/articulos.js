// articulos.js
function cargarArticulos() {
    document.getElementById("cuerpoArticulos").innerHTML = "";
    
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/examen/Sistema_GContenidos/controllers/articulos.controllers.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("Respuesta del servidor: " + xhr.responseText);
            var articulos = JSON.parse(xhr.responseText);
            
            articulos.forEach(function(articulo) {
                var row = "<tr>";
                row += "<td>" + articulo.id_articulo + "</td>";
                row += "<td>" + articulo.titulo + "</td>";
                row += "<td>" + articulo.contenido.substring(0, 50) + "...</td>";
                row += "<td>" + articulo.fecha_publicacion + "</td>";
                row += "<td>" + articulo.id_usuario + "</td>";
                row += "<td><button class='btn btn-sm btn-warning' onclick='abrirModal(\"editar\", " + JSON.stringify(articulo) + ")'>Editar</button> ";
                row += "<button class='btn btn-sm btn-danger' onclick='eliminarArticulo(" + articulo.id_articulo + ")'>Eliminar</button></td>";
                row += "</tr>";
                document.getElementById("cuerpoArticulos").innerHTML += row;
            });
        }
    };
    xhr.send();
}

function abrirModal(modo, articulo = null) {
    if (modo === "insertar") {
        document.getElementById("formArticulo").reset();
        document.getElementById("id_articulo").value = "";
        $('#modalArticulo').modal('show');
    } else if (modo === "editar") {
        document.getElementById("id_articulo").value = articulo.id_articulo;
        document.getElementById("titulo").value = articulo.titulo;
        document.getElementById("contenido").value = articulo.contenido;
        document.getElementById("fecha_publicacion").value = articulo.fecha_publicacion;
        document.getElementById("id_usuario").value = articulo.id_usuario;
        $('#modalArticulo').modal('show');
    }
}

document.getElementById("formArticulo").onsubmit = function(event) {
    event.preventDefault();
    
    var id_articulo = document.getElementById("id_articulo").value;
    var titulo = document.getElementById("titulo").value;
    var contenido = document.getElementById("contenido").value;
    var fecha_publicacion = document.getElementById("fecha_publicacion").value;
    var id_usuario = document.getElementById("id_usuario").value;
    
    var datos = JSON.stringify({
        id_articulo: id_articulo,
        titulo: titulo,
        contenido: contenido,
        fecha_publicacion: fecha_publicacion,
        id_usuario: id_usuario
    });
    
    var xhr = new XMLHttpRequest();
    if (id_articulo) {
        xhr.open("PUT", "/examen/Sistema_GContenidos/controllers/articulos.controllers.php", true);
    } else {
        xhr.open("POST", "/examen/Sistema_GContenidos/controllers/articulos.controllers.php", true);
    }
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            $('#modalArticulo').modal('hide');
            cargarArticulos();
        }
    };
    xhr.send(datos);
};

function eliminarArticulo(id_articulo) {
    if (confirm("¿Está seguro de eliminar este artículo?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("DELETE", "/examen/Sistema_GContenidos/controllers/articulos.controllers.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                cargarArticulos();
            }
        };
        xhr.send(JSON.stringify({
            id_articulo: id_articulo
        }));
    }
}

// Cargar artículos al iniciar la página
window.onload = function() {
    cargarArticulos();
};