// usuarios.js
function cargarUsuarios() {
    document.getElementById("cuerpoUsuarios").innerHTML = "";
    
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/examen/Sistema_GContenidos/controllers/usuarios.controllers.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("Respuesta del servidor: " + xhr.responseText);
            var usuarios = JSON.parse(xhr.responseText);
            
            usuarios.forEach(function(usuario) {
                var row = "<tr>";
                row += "<td>" + usuario.id_usuario + "</td>";
                row += "<td>" + usuario.nombre + "</td>";
                row += "<td>" + usuario.apellido + "</td>";
                row += "<td>" + usuario.correo_electronico + "</td>";
                row += "<td><button class='btn btn-sm btn-warning' onclick='abrirModal(\"editar\", " + JSON.stringify(usuario) + ")'>Editar</button> ";
                row += "<button class='btn btn-sm btn-danger' onclick='eliminarUsuario(" + usuario.id_usuario + ")'>Eliminar</button></td>";
                row += "</tr>";
                document.getElementById("cuerpoUsuarios").innerHTML += row;
            });
        }
    };
    xhr.send();
}

function abrirModal(modo, usuario = null) {
    if (modo === "insertar") {
        document.getElementById("formUsuario").reset();
        document.getElementById("id_usuario").value = "";
        $('#modalUsuario').modal('show');
    } else if (modo === "editar") {
        document.getElementById("id_usuario").value = usuario.id_usuario;
        document.getElementById("nombre").value = usuario.nombre;
        document.getElementById("apellido").value = usuario.apellido;
        document.getElementById("correo_electronico").value = usuario.correo_electronico;
        $('#modalUsuario').modal('show');
    }
}

document.getElementById("formUsuario").onsubmit = function(event) {
    event.preventDefault();
    
    var id_usuario = document.getElementById("id_usuario").value;
    var nombre = document.getElementById("nombre").value;
    var apellido = document.getElementById("apellido").value;
    var correo_electronico = document.getElementById("correo_electronico").value;
    
    var datos = JSON.stringify({
        id_usuario: id_usuario,
        nombre: nombre,
        apellido: apellido,
        correo_electronico: correo_electronico
    });
    
    var xhr = new XMLHttpRequest();
    if (id_usuario) {
        xhr.open("PUT", "/examen/Sistema_GContenidos/controllers/usuarios.controllers.php", true);
    } else {
        xhr.open("POST", "/examen/Sistema_GContenidos/controllers/usuarios.controllers.php", true);
    }
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            $('#modalUsuario').modal('hide');
            cargarUsuarios();
        }
    };
    xhr.send(datos);
};

function eliminarUsuario(id_usuario) {
    if (confirm("¿Está seguro de eliminar este usuario?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("DELETE", "/examen/Sistema_GContenidos/controllers/usuarios.controllers.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                cargarUsuarios();
            }
        };
        xhr.send(JSON.stringify({
            id_usuario: id_usuario
        }));
    }
}

// Cargar usuarios al iniciar la página
window.onload = function() {
    cargarUsuarios();
};