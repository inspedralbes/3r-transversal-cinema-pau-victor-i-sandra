CREATE TABLE `sesion` (
  `id` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `vip` tinyint(1) DEFAULT NULL,
  `dia_espectador` tinyint(1) DEFAULT NULL,
  `butacas_ocupadas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_peli` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_peli` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ano_peli` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img_peli` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `entrada` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `sesion_id` int(11) DEFAULT NULL,
  `butaca` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `precio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `entrada`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C949A274DB38439E` (`usuario_id`),
  ADD KEY `IDX_C949A2741CCCADCB` (`sesion_id`);

ALTER TABLE `sesion`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `entrada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `sesion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `entrada`
  ADD CONSTRAINT `FK_C949A2741CCCADCB` FOREIGN KEY (`sesion_id`) REFERENCES `sesion` (`id`),
  ADD CONSTRAINT `FK_C949A274DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);
COMMIT;
