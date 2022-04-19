INSERT INTO `sesion` (`id`, `fecha`, `hora`, `vip`, `dia_espectador`, `butacas_ocupadas`, `id_peli`, `nombre_peli`, `ano_peli`, `img_peli`) VALUES
(1, '2022-04-19', '20:00:00', 1, 1, 'b12', 'tt0317219', 'Cars', '2006', 'https://m.media-amazon.com/images/M/MV5BMTg5NzY0MzA2MV5BMl5BanBnXkFtZTYwNDc3NTc2._V1_SX300.jpg'),
(2, '2022-04-20', '18:00:00', 0, 1, 'b45', 'tt0348150', 'Superman Returns', '2006', 'https://m.media-amazon.com/images/M/MV5BNzY2ZDQ2MTctYzlhOC00MWJhLTgxMmItMDgzNDQwMDdhOWI2XkEyXkFqcGdeQXVyNjc1NTYyMjg@._V1_SX300.jpg'),
(3, '2022-04-21', '16:00:00', 1, 0, NULL, 'tt1464335', 'Uncharted', '2006', 'https://m.media-amazon.com/images/M/MV5BMWEwNjhkYzYtNjgzYy00YTY2LThjYWYtYzViMGJkZTI4Y2MyXkEyXkFqcGdeQXVyNTM0OTY1OQ@@._V1_SX300.jpg'),
(4, '2022-04-22', '18:00:00', 0, 0, NULL, 'tt13097626', 'U.S.B.', '2006', 'https://m.media-amazon.com/images/M/MV5BNjc1ZTBiYmYtYmQyZS00ODM0LWFjYzUtNTkzMjQ1MzM3MjI0XkEyXkFqcGdeQXVyMTAzMDcwNDg1._V1_SX300.jpg'),
(5, '2022-04-23', '20:00:00', 1, 0, NULL, 'tt5978586', 'Spiderman in Cannes', '2006', 'https://m.media-amazon.com/images/M/MV5BZDlmMGQwYmItNTNmOS00OTNkLTkxNTYtNDM3ZWVlMWUyZDIzXkEyXkFqcGdeQXVyMTA5Mzk5Mw@@._V1_SX300.jpg'),
(6, '2022-04-24', '16:00:00', 0, 1, NULL, 'tt0081427', 'Ricomincio da tre', '2006', 'https://m.media-amazon.com/images/M/MV5BZWNlMDU2YjAtM2M2OC00NmNhLWI4NGUtOTAzNjllNWRiN2M4XkEyXkFqcGdeQXVyNjA5NTM4MTY@._V1_SX300.jpg'),
(7, '2022-04-25', '20:00:00', 1, 1, NULL, 'tt0317219', 'Cars', '2006', 'https://m.media-amazon.com/images/M/MV5BMTg5NzY0MzA2MV5BMl5BanBnXkFtZTYwNDc3NTc2._V1_SX300.jpg'),
(8, '2022-04-26', '18:00:00', 1, 0, NULL, 'tt0463985', 'The Fast and the Furious: Tokyo Drift', '2006', 'https://m.media-amazon.com/images/M/MV5BMTQ2NTMxODEyNV5BMl5BanBnXkFtZTcwMDgxMjA0MQ@@._V1_SX300.jpg'),
(9, '2022-04-27', '20:00:00', 0, 1, NULL, 'tt2294629', 'Frozen', '2013', 'https://m.media-amazon.com/images/M/MV5BMTQ1MjQwMTE5OF5BMl5BanBnXkFtZTgwNjk3MTcyMDE@._V1_SX300.jpg'),
(10, '2022-04-28', '16:00:00', 0, 0, NULL, 'tt5978586', 'Spiderman in Cannes', '2016', 'https://m.media-amazon.com/images/M/MV5BZDlmMGQwYmItNTNmOS00OTNkLTkxNTYtNDM3ZWVlMWUyZDIzXkEyXkFqcGdeQXVyMTA5Mzk5Mw@@._V1_SX300.jpg'),
(11, '2022-04-29', '18:00:00', 1, 0, NULL, 'tt2338096', 'Counting Cars', '2012', 'https://m.media-amazon.com/images/M/MV5BOGYxOTM2MjgtZWFlOC00Y2UwLWI3MzItMWMyNjY0YWY5NmEyXkEyXkFqcGdeQXVyMTAwMzM3NDI3._V1_SX300.jpg');

INSERT INTO `usuario` (`id`, `nombre`, `password`, `apellidos`, `email`) VALUES
(1, 'Admin', '---', 'admin', 'admin@admin.com'),
(2, 'Tom', '$2y$10$U8kkZLsduLAO/G6HAEl6ied4Gx6lFoAJdkiBD0nnZnxT0P7WOTkdq', 'Tom', 'tom@gmail.com'),
(3, 'Victor', '$2y$10$wzVvuVH7y1.ZfcCcvdLhw.cJJsYjWhtCZCvpXc0qvkjIe9J6DdGfK', 'Moreno', 'a20vicmormor@inspedralbes.cat');

INSERT INTO `entrada` (`id`, `usuario_id`, `sesion_id`, `butaca`, `precio`) VALUES
(1, 2, 1, 'b12', 8),
(2, 3, 2, 'b45', 6);
