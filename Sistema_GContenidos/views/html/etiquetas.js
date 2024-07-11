// etiquetas.js
function cargarEtiquetas() {
    document.getElementById("cuerpoEtiquetas").innerHTML = "";
    
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/examen/Sistema_GContenidos/controllers/etiquetas.controllers.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("Respuesta del servidor: " + xhr.responseText);
            var etiquetas = JSON.parse(xhr.responseText);
            
            etiquetas.forEach(function(etiqueta) {
                var row = "<tr>";
                row += "<td>" + etiqueta.id_etiqueta + "</td>";
                row += "<td>" + etiqueta.nombre_etiqueta + "</td>";
                row += "<td><button class='btn btn-sm btn-warning' onclick='abrirModal(\"editar\", " + JSON.stringify(etiqueta) + ")'>Editar</button> ";
                row += "<button class='btn btn-sm btn-danger' onclick='eliminarEtiqueta(" + etiqueta.id_etiqueta + ")'>Eliminar</button></td>";
                row += "</tr>";
                document.getElementById("cuerpoEtiquetas").innerHTML += row;
            });
        }
    };
    xhr.send();
}

function abrirModal(modo, etiqueta = null) {
    if (modo === "insertar") {
        document.getElementById("formEtiqueta").reset();
        document.getElementById("id_etiqueta").value = "";
        $('#modalEtiqueta').modal('show');
    } else if (modo === "editar") {
        document.getElementById("id_etiqueta").value = etiqueta.id_etiqueta;
        document.getElementById("nombre_etiqueta").value = etiqueta.nombre_etiqueta;
        $('#modalEtiqueta').modal('show');
    }
}

document.getElementById("formEtiqueta").onsubmit = function(event) {
    event.preventDefault();
    
    var id_etiqueta = document.getElementById("id_etiqueta").value;
    var nombre_etiqueta = document.getElementById("nombre_etiqueta").value;
    
    var datos = JSON.stringify({
        id_etiqueta: id_etiqueta,
        nombre_etiqueta: nombre_etiqueta
    });
    
    var xhr = new XMLHttpRequest();
    if (id_etiqueta) {
        xhr.open("PUT", "/examen/Sistema_GContenidos/controllers/etiquetas.controllers.php", true);
    } else {
        xhr.open("POST", "/examen/Sistema_GContenidos/controllers/etiquetas.controllers.php", true);
    }
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            $('#modalEtiqueta').modal('hide');
            cargarEtiquetas();
        }
    };
    xhr.send(datos);
};

function eliminarEtiqueta(id_etiqueta) {
    if (confirm("¿Está seguro de eliminar esta etiqueta?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("DELETE", "/examen/Sistema_GContenidos/controllers/etiquetas.controllers.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                cargarEtiquetas();
            }
        };
        xhr.send(JSON.stringify({
            id_etiqueta: id_etiqueta
        }));
    }
}

// Cargar etiquetas al iniciar la página
window.onload = function() {
    cargarEtiquetas();
};