// categorias.js
function cargarCategorias() {
    document.getElementById("cuerpoCategorias").innerHTML = "";
    
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/examen/Sistema_GContenidos/controllers/categorias.controllers.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    console.log("Respuesta del servidor: " + xhr.responseText);
                    var categorias = JSON.parse(xhr.responseText);
                    
                    if (categorias.error) {
                        throw new Error(categorias.error);
                    }
                    
                    categorias.forEach(function(categoria) {
                        var row = "<tr>";
                        row += "<td>" + categoria.id_categoria + "</td>";
                        row += "<td>" + categoria.nombre_categoria + "</td>";
                        row += "<td>" + categoria.cantidad_articulos + "</td>";
                        row += "<td><button class='btn btn-sm btn-warning' onclick='abrirModal(\"editar\", " + JSON.stringify(categoria) + ")'>Editar</button> ";
                        row += "<button class='btn btn-sm btn-danger' onclick='eliminarCategoria(" + categoria.id_categoria + ")'>Eliminar</button></td>";
                        row += "</tr>";
                        document.getElementById("cuerpoCategorias").innerHTML += row;
                    });
                } catch (e) {
                    console.error("Error:", e.message);
                    alert("Error al cargar las categorías: " + e.message);
                }
            } else {
                console.error("Error HTTP: " + xhr.status);
                alert("Error al cargar las categorías. Código de estado: " + xhr.status);
            }
        }
    };
    xhr.onerror = function() {
        console.error("Error de red");
        alert("Error de conexión. Por favor, verifique su conexión a internet e intente de nuevo.");
    };
    xhr.send();
}

function abrirModal(modo, categoria = null) {
    if (modo === "insertar") {
        document.getElementById("formCategoria").reset();
        document.getElementById("id_categoria").value = "";
        $('#modalCategoria').modal('show');
    } else if (modo === "editar") {
        document.getElementById("id_categoria").value = categoria.id_categoria;
        document.getElementById("nombre_categoria").value = categoria.nombre_categoria;
        $('#modalCategoria').modal('show');
    }
}

document.getElementById("formCategoria").onsubmit = function(event) {
    event.preventDefault();
    
    var id_categoria = document.getElementById("id_categoria").value;
    var nombre_categoria = document.getElementById("nombre_categoria").value;
    
    var datos = JSON.stringify({
        id_categoria: id_categoria,
        nombre_categoria: nombre_categoria
    });
    
    var xhr = new XMLHttpRequest();
    var metodo = id_categoria ? "PUT" : "POST";
    xhr.open(metodo, "/examen/Sistema_GContenidos/controllers/categorias.controllers.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    var respuesta = JSON.parse(xhr.responseText);
                    alert(respuesta.message);
                    $('#modalCategoria').modal('hide');
                    cargarCategorias();
                } catch (e) {
                    console.error("Error:", e.message);
                    alert("Error al procesar la respuesta del servidor");
                }
            } else {
                console.error("Error HTTP: " + xhr.status);
                alert("Error al " + (id_categoria ? "actualizar" : "insertar") + " la categoría");
            }
        }
    };
    xhr.onerror = function() {
        console.error("Error de red");
        alert("Error de conexión. Por favor, verifique su conexión a internet e intente de nuevo.");
    };
    xhr.send(datos);
};

function eliminarCategoria(id_categoria) {
    if (confirm("¿Está seguro de eliminar esta categoría?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("DELETE", "/examen/Sistema_GContenidos/controllers/categorias.controllers.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    try {
                        var respuesta = JSON.parse(xhr.responseText);
                        alert(respuesta.message);
                        cargarCategorias();
                    } catch (e) {
                        console.error("Error:", e.message);
                        alert("Error al procesar la respuesta del servidor");
                    }
                } else {
                    console.error("Error HTTP: " + xhr.status);
                    alert("Error al eliminar la categoría");
                }
            }
        };
        xhr.onerror = function() {
            console.error("Error de red");
            alert("Error de conexión. Por favor, verifique su conexión a internet e intente de nuevo.");
        };
        xhr.send(JSON.stringify({
            id_categoria: id_categoria
        }));
    }
}

// Cargar categorías al iniciar la página
window.onload = function() {
    cargarCategorias();
};