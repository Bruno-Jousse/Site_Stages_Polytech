ALTER TABLE `Etudiant` DROP FOREIGN KEY `Etudiant_fk0`;

ALTER TABLE `Etudiant` DROP FOREIGN KEY `Etudiant_fk1`;

ALTER TABLE `Stage` DROP FOREIGN KEY `Stage_fk0`;

ALTER TABLE `Stage` DROP FOREIGN KEY `Stage_fk1`;

ALTER TABLE `Stage` DROP FOREIGN KEY `Stage_fk2`;

ALTER TABLE `Stage` DROP FOREIGN KEY `Stage_fk3`;

ALTER TABLE `Stage` DROP FOREIGN KEY `Stage_fk4`;

ALTER TABLE `Adresse` DROP FOREIGN KEY `Adresse_fk0`;

ALTER TABLE `Adresse` DROP FOREIGN KEY `Adresse_fk1`;

ALTER TABLE `Responsable` DROP FOREIGN KEY `Responsable_fk0`;

ALTER TABLE `Responsable_Formation` DROP FOREIGN KEY `Responsable_Formation_fk0`;

ALTER TABLE `Responsable_Formation` DROP FOREIGN KEY `Responsable_Formation_fk1`;

ALTER TABLE `Stage_MotCle` DROP FOREIGN KEY `Stage_MotCle_fk0`;

ALTER TABLE `Utilisateur_Droit` DROP FOREIGN KEY `Utilisateur_Droit_fk0`;

DROP TABLE IF EXISTS `Etudiant`;

DROP TABLE IF EXISTS `Stage`;

DROP TABLE IF EXISTS `Entreprise`;

DROP TABLE IF EXISTS `Adresse`;

DROP TABLE IF EXISTS `Responsable`;

DROP TABLE IF EXISTS `Formation`;

DROP TABLE IF EXISTS `Pays`;

DROP TABLE IF EXISTS `Responsable_Formation`;

DROP TABLE IF EXISTS `Stage_MotCle`;

DROP TABLE IF EXISTS `Utilisateur`;

DROP TABLE IF EXISTS `Utilisateur_Droit`;

