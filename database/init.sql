CREATE TABLE `felhasznalo` (
                               `id` int(11) NOT NULL,
                               `email` varchar(255) DEFAULT NULL,
                               `pw` varchar(255) DEFAULT NULL,
                               `rendszam` char(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

CREATE TABLE `foglalas` (
                            `id` int(11) NOT NULL,
                            `kezdeti_datum` datetime DEFAULT NULL,
                            `veg_datum` datetime DEFAULT NULL,
                            `felhasznalo_id` int(11) DEFAULT NULL,
                            `parkolohely_szam` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

CREATE TABLE `parkolohely` (
                               `szam` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

ALTER TABLE `felhasznalo`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `rendszam` (`rendszam`);

ALTER TABLE `foglalas`
    ADD PRIMARY KEY (`id`),
  ADD KEY `felhasznalo_id` (`felhasznalo_id`),
  ADD KEY `parkolohely_szam` (`parkolohely_szam`);

ALTER TABLE `parkolohely`
    ADD PRIMARY KEY (`szam`);

ALTER TABLE `felhasznalo`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `foglalas`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `parkolohely`
    MODIFY `szam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `foglalas`
    ADD CONSTRAINT `foglalas_ibfk_1` FOREIGN KEY (`felhasznalo_id`) REFERENCES `felhasznalo` (`id`),
    ADD CONSTRAINT `foglalas_ibfk_2` FOREIGN KEY (`parkolohely_szam`) REFERENCES `parkolohely` (`szam`);

INSERT INTO `parkolohely` (`szam`) VALUES
                                       (1),
                                       (2),
                                       (3),
                                       (4),
                                       (5),
                                       (6),
                                       (7),
                                       (8),
                                       (9),
                                       (10);

INSERT INTO `felhasznalo`(`id`, `email`, `pw`, `rendszam`) VALUES ('1','test@test.test','$2a$12$3XZfzjOCTtm/ZUIv62e1guSB44lpXXMMNQH17YFW0wxDzzAsccKgS','ABC-123');
INSERT INTO `felhasznalo`(`id`, `email`, `pw`, `rendszam`) VALUES ('2','test2@test.test','$2a$12$vp2tfq7IQ4CWr0JD.6ExX.u12rM8K6m76r4u42GZ8bTjq/UCDDKLS','XYZ-789');

INSERT INTO `foglalas`(`id`, `kezdeti_datum`, `veg_datum`, `felhasznalo_id`, `parkolohely_szam`) VALUES ('1','2026:08:03 10:00:00','2026:08:03 12:00:00','1','1');
INSERT INTO `foglalas`(`id`, `kezdeti_datum`, `veg_datum`, `felhasznalo_id`, `parkolohely_szam`) VALUES ('2','2026:08:03 11:00:00','2026:08:03 12:00:00','2','2');
INSERT INTO `foglalas`(`id`, `kezdeti_datum`, `veg_datum`, `felhasznalo_id`, `parkolohely_szam`) VALUES ('3','2026:08:03 14:00:00','2026:08:03 15:00:00','1','1');
INSERT INTO `foglalas`(`id`, `kezdeti_datum`, `veg_datum`, `felhasznalo_id`, `parkolohely_szam`) VALUES ('4','2026:08:03 16:00:00','2026:08:03 20:00:00','2','1');
INSERT INTO `foglalas`(`id`, `kezdeti_datum`, `veg_datum`, `felhasznalo_id`, `parkolohely_szam`) VALUES ('5','2026:08:03 17:00:00','2026:08:03 18:00:00','1','2');
INSERT INTO `foglalas`(`id`, `kezdeti_datum`, `veg_datum`, `felhasznalo_id`, `parkolohely_szam`) VALUES ('6','2026:08:04 08:00:00','2026:08:03 18:00:00','1','1');