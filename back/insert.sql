INSERT INTO `usuari` (`idUsuario`, `nombre`, `apellidos`, `username`, `email`) VALUES
(1, 'Victor', 'Moreno', 'victormoreno_018', 'a20vicmormor@inspedralbes.cat'),
(2, 'Benito', 'Aka BadBunny', 'BadBunny', 'badbunny@gmail.com'),
(3, 'Pau', 'Muñoz', 'pauchinpun', 'a20paumonoli@inspedralbes.cat'),
(4, 'Rosa', 'Pepita', 'LaPepi', 'lapepi@gmail.com');

INSERT INTO `sesion` (`id`, `fecha`, `hora`, `vip`, `dia_espectador`, `butacas_ocupadas`, `id_peli`, `nombre_peli`, `ano_peli`, `img_peli`) VALUES (1, '2022-03-29', '20:00:00', 1, 1, 6, 12, 'Cars', 2006, 'https://pics.filmaffinity.com/Cars-746710621-mmed.jpg'), (2, '2022-03-30', '16:00:00', 0, 0, 8, 25, 'Toy Story 3', 2012, 'https://pics.filmaffinity.com/Cars-746710621-mmed.jpg');

INSERT INTO `entrada` (`idEntrada`, `usuari`, `sesion`, `butaca`, `precio`) VALUES
(1, 3, 1, '5', 6),
(2, 2, 2, '4', 6);