CREATE TABLE sesion
(
    idSesion int(4) AUTO_INCREMENT PRIMARY KEY,
    fecha date,
    hora time,
    vip boolean,
    diaEspectador boolean,
    butacasOpupadas int(3) default 0,
    idPeli int(8),
    nombrePeli varchar(255),
    anoPeli year,
    imgPeli varchar(255)
);

CREATE TABLE usuari
(
    idUsuario int(8) AUTO_INCREMENT PRIMARY KEY,
    nombre varchar(50),
    password varchar(20),
    apellidos varchar(70),
    username varchar(50),
    email varchar(50)
);

CREATE TABLE entrada
(
    idEntrada int(8) AUTO_INCREMENT PRIMARY KEY,
    usuari int(8),
    sesion int(8),
    butaca varchar(255),
    precio int(2),
    FOREIGN KEY (usuari) REFERENCES usuari (idUsuario),
    FOREIGN KEY (sesion) REFERENCES sesion (idSesion)
);