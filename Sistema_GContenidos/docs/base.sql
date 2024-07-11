-- Crear tabla Usuarios
CREATE TABLE Usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    correo_electronico VARCHAR(100) UNIQUE NOT NULL
);

-- Crear tabla Artículos
CREATE TABLE Articulos (
    id_articulo INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(100) NOT NULL,
    contenido TEXT NOT NULL,
    fecha_publicacion DATE NOT NULL,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);

-- Crear tabla Comentarios
CREATE TABLE Comentarios (
    id_comentario INT PRIMARY KEY AUTO_INCREMENT,
    id_articulo INT,
    id_usuario INT,
    contenido TEXT NOT NULL,
    fecha_comentario DATETIME NOT NULL,
    FOREIGN KEY (id_articulo) REFERENCES Articulos(id_articulo),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);

-- Crear tabla Categorías
CREATE TABLE Categorias (
    id_categoria INT PRIMARY KEY AUTO_INCREMENT,
    nombre_categoria VARCHAR(50) UNIQUE NOT NULL
);

-- Crear tabla Articulos_Categorias
CREATE TABLE Articulos_Categorias (
    id_articulo_categoria INT PRIMARY KEY AUTO_INCREMENT,
    id_articulo INT,
    id_categoria INT,
    FOREIGN KEY (id_articulo) REFERENCES Articulos(id_articulo),
    FOREIGN KEY (id_categoria) REFERENCES Categorias(id_categoria)
);

-- Crear tabla Etiquetas
CREATE TABLE Etiquetas (
    id_etiqueta INT PRIMARY KEY AUTO_INCREMENT,
    nombre_etiqueta VARCHAR(50) UNIQUE NOT NULL
);

-- Crear tabla Articulos_Etiquetas
CREATE TABLE Articulos_Etiquetas (
    id_articulo_etiqueta INT PRIMARY KEY AUTO_INCREMENT,
    id_articulo INT,
    id_etiqueta INT,
    FOREIGN KEY (id_articulo) REFERENCES Articulos(id_articulo),
    FOREIGN KEY (id_etiqueta) REFERENCES Etiquetas(id_etiqueta)
);