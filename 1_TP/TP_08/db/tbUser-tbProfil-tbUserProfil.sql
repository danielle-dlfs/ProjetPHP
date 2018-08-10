/* ---------------------------------- VERSION FINALE SCRIPT  ---------------------------------- */
/* ---------------- CREATIONS DE TABLE ---------------- */

-- Ordre pour les FK : tbUser tbProfil tbUserProfil

CREATE TABLE `tbprofil` (
  `pId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pNom` char(20) NOT NULL,
  `pAbrev` char(10) DEFAULT NULL,
  `pIcon` blob,
  `pEstStatus` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`pId`),
  UNIQUE KEY `pNom_UNIQUE` (`pNom`),
  UNIQUE KEY `pAbrev_UNIQUE` (`pAbrev`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

CREATE TABLE `tbuser` (
  `uId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uPseudo` char(20) NOT NULL,
  `uEmail` char(50) NOT NULL,
  `uSemence` char(32) NOT NULL,
  `uMdp` char(32) NOT NULL,
  `uQuestion` varchar(100) DEFAULT 'null',
  `uReponse` varchar(50) DEFAULT 'null',
  `uAvatar` blob,
  `uDateCreation` datetime DEFAULT NULL,
  PRIMARY KEY (`uId`),
  UNIQUE KEY `uPseudo_UNIQUE` (`uPseudo`),
  UNIQUE KEY `uEmail_UNIQUE` (`uEmail`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;



CREATE TABLE `tbuserprofil` (
  `uId` int(10) unsigned NOT NULL,
  `pId` int(10) unsigned NOT NULL,
  `upDateDebut` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uId`,`pId`),
  KEY `fk_tbUserProfil_tbProfil1_idx` (`pId`),
  CONSTRAINT `fk_tbUserProfil_tbProfil1` FOREIGN KEY (`pId`) REFERENCES `tbprofil` (`pId`) ON UPDATE CASCADE,
  CONSTRAINT `fk_tbUserProfil_tbUser` FOREIGN KEY (`uId`) REFERENCES `tbuser` (`uId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* ------------------------- INSERTION DATA  ------------------------- */

-- tbUser

INSERT INTO `tbUser` (`uId`, `uPseudo`, `uEmail`, `uSemence`, `uMdp`, `uQuestion`, `uReponse`, `uAvatar`, `uDateCreation`) VALUES (1, 'ano', 'ano@ici.be', MD5(UNIX_TIMESTAMP()), MD5(CONCAT(MD5(UNIX_TIMESTAMP()),'anonyme')), NULL, NULL, NULL, NULL);
INSERT INTO `tbUser` (`uId`, `uPseudo`, `uEmail`, `uSemence`, `uMdp`, `uQuestion`, `uReponse`, `uAvatar`, `uDateCreation`) VALUES (2, 'acti', 'acti@ici.be', MD5(UNIX_TIMESTAMP()), MD5(CONCAT(MD5(UNIX_TIMESTAMP()),'activation')), NULL, NULL, NULL, NULL);
INSERT INTO `tbUser` (`uId`, `uPseudo`, `uEmail`, `uSemence`, `uMdp`, `uQuestion`, `uReponse`, `uAvatar`, `uDateCreation`) VALUES (3, 'memb', 'memb@ici.be', MD5(UNIX_TIMESTAMP()), MD5(CONCAT(MD5(UNIX_TIMESTAMP()),'membre')), NULL, NULL, NULL, NULL);
INSERT INTO `tbUser` (`uId`, `uPseudo`, `uEmail`, `uSemence`, `uMdp`, `uQuestion`, `uReponse`, `uAvatar`, `uDateCreation`) VALUES (4, 'réact', 'réact@ici.be', MD5(UNIX_TIMESTAMP()), MD5(CONCAT(MD5(UNIX_TIMESTAMP()),'réactivation')), NULL, NULL, NULL, NULL);
INSERT INTO `tbUser` (`uId`, `uPseudo`, `uEmail`, `uSemence`, `uMdp`, `uQuestion`, `uReponse`, `uAvatar`, `uDateCreation`) VALUES (5, 'mdpp', 'mdpp@ici.be', MD5(UNIX_TIMESTAMP()), MD5(CONCAT(MD5(UNIX_TIMESTAMP()),'mdp-perdu')), NULL, NULL, NULL, NULL);
INSERT INTO `tbUser` (`uId`, `uPseudo`, `uEmail`, `uSemence`, `uMdp`, `uQuestion`, `uReponse`, `uAvatar`, `uDateCreation`) VALUES (6, 'modo', 'modo@ici.be', MD5(UNIX_TIMESTAMP()), MD5(CONCAT(MD5(UNIX_TIMESTAMP()),'modérateur')), NULL, NULL, NULL, NULL);
INSERT INTO `tbUser` (`uId`, `uPseudo`, `uEmail`, `uSemence`, `uMdp`, `uQuestion`, `uReponse`, `uAvatar`, `uDateCreation`) VALUES (7, 'sAdmin', 'sAdmin@ici.be', MD5(UNIX_TIMESTAMP()), MD5(CONCAT(MD5(UNIX_TIMESTAMP()),'sous-administrateur')), NULL, NULL, NULL, NULL);
INSERT INTO `tbUser` (`uId`, `uPseudo`, `uEmail`, `uSemence`, `uMdp`, `uQuestion`, `uReponse`, `uAvatar`, `uDateCreation`) VALUES (8, 'admin', 'admin@ici.be', MD5(UNIX_TIMESTAMP()), MD5(CONCAT(MD5(UNIX_TIMESTAMP()),'administrateur')), NULL, NULL, NULL, NULL);

COMMIT;

-- tbProfil

INSERT INTO `tbProfil` (`pId`, `pNom`, `pAbrev`, `pIcon`, `pEstStatus`) VALUES (DEFAULT, 'anonyme', 'ano', NULL, NULL);
INSERT INTO `tbProfil` (`pId`, `pNom`, `pAbrev`, `pIcon`, `pEstStatus`) VALUES (DEFAULT, 'activation', 'acti', NULL, 1);
INSERT INTO `tbProfil` (`pId`, `pNom`, `pAbrev`, `pIcon`, `pEstStatus`) VALUES (DEFAULT, 'membre', 'memb', NULL, NULL);
INSERT INTO `tbProfil` (`pId`, `pNom`, `pAbrev`, `pIcon`, `pEstStatus`) VALUES (DEFAULT, 'réactivation', 'réact', NULL, 1);
INSERT INTO `tbProfil` (`pId`, `pNom`, `pAbrev`, `pIcon`, `pEstStatus`) VALUES (DEFAULT, 'mdp-perdu', 'mdpp', NULL, 1);
INSERT INTO `tbProfil` (`pId`, `pNom`, `pAbrev`, `pIcon`, `pEstStatus`) VALUES (DEFAULT, 'modérateur', 'modo', NULL, NULL);
INSERT INTO `tbProfil` (`pId`, `pNom`, `pAbrev`, `pIcon`, `pEstStatus`) VALUES (DEFAULT, 'sous-administrateur', 'sAdmin', NULL, NULL);
INSERT INTO `tbProfil` (`pId`, `pNom`, `pAbrev`, `pIcon`, `pEstStatus`) VALUES (DEFAULT, 'administrateur', 'admin', NULL, NULL);

COMMIT;

-- tbUserProfil


INSERT INTO `tbUserProfil` (`uId`, `pId`, `upDateDebut`) VALUES (1, 1, NOW());
INSERT INTO `tbUserProfil` (`uId`, `pId`, `upDateDebut`) VALUES (2, 2, NOW());
INSERT INTO `tbUserProfil` (`uId`, `pId`, `upDateDebut`) VALUES (2, 3, NOW());
INSERT INTO `tbUserProfil` (`uId`, `pId`, `upDateDebut`) VALUES (3, 3, NOW());
INSERT INTO `tbUserProfil` (`uId`, `pId`, `upDateDebut`) VALUES (4, 3, NOW());
INSERT INTO `tbUserProfil` (`uId`, `pId`, `upDateDebut`) VALUES (4, 4, NOW());
INSERT INTO `tbUserProfil` (`uId`, `pId`, `upDateDebut`) VALUES (5, 3, NOW());
INSERT INTO `tbUserProfil` (`uId`, `pId`, `upDateDebut`) VALUES (5, 5, NOW());
INSERT INTO `tbUserProfil` (`uId`, `pId`, `upDateDebut`) VALUES (6, 3, NOW());
INSERT INTO `tbUserProfil` (`uId`, `pId`, `upDateDebut`) VALUES (6, 6, NOW());
INSERT INTO `tbUserProfil` (`uId`, `pId`, `upDateDebut`) VALUES (7, 3, NOW());
INSERT INTO `tbUserProfil` (`uId`, `pId`, `upDateDebut`) VALUES (7, 6, NOW());
INSERT INTO `tbUserProfil` (`uId`, `pId`, `upDateDebut`) VALUES (7, 7, NOW());
INSERT INTO `tbUserProfil` (`uId`, `pId`, `upDateDebut`) VALUES (8, 3, NOW());
INSERT INTO `tbUserProfil` (`uId`, `pId`, `upDateDebut`) VALUES (8, 6, NOW());
INSERT INTO `tbUserProfil` (`uId`, `pId`, `upDateDebut`) VALUES (8, 7, NOW());
INSERT INTO `tbUserProfil` (`uId`, `pId`, `upDateDebut`) VALUES (8, 8, NOW());

COMMIT;
