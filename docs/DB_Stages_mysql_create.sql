CREATE TABLE `Etudiant` (
	`id_etud` int NOT NULL AUTO_INCREMENT,
	`id_util` int NOT NULL,
	`id_form` int NOT NULL,
	`option` enum NOT NULL,
	`promo` int NOT NULL,
	PRIMARY KEY (`id_etud`)
);

CREATE TABLE `Stage` (
	`id_stage` int NOT NULL AUTO_INCREMENT,
	`id_resp` int NOT NULL,
	`id_etud` int NOT NULL,
	`id_form` int NOT NULL,
	`id_ent` int NOT NULL,
	`id_adr` int NOT NULL,
	`sujet` varchar(255) NOT NULL,
	`intitule` varchar(255),
	`option` enum NOT NULL,
	`promo` int NOT NULL,
	`annee` int NOT NULL,
	`duree` int NOT NULL,
	`gratification` bool NOT NULL,
	`poste` varchar(255) NOT NULL,
	`recap` varchar(255),
	`theme` varchar(255),
	`contratPro` bool NOT NULL,
	`commentaire` varchar(1024),
	PRIMARY KEY (`id_stage`)
);

CREATE TABLE `Entreprise` (
	`id_ent` int NOT NULL AUTO_INCREMENT,
	`nom` varchar(255) NOT NULL UNIQUE,
	`nomResp` varchar(255),
	`tel` int,
	`mail` varchar(255),
	`embauche` bool NOT NULL,
	PRIMARY KEY (`id_ent`)
);

CREATE TABLE `Adresse` (
	`id_adr` int NOT NULL AUTO_INCREMENT,
	`id_ent` int NOT NULL,
	`id_pays` int(255) NOT NULL,
	`adresse` varchar(255) NOT NULL,
	`adresse_suite` varchar(255),
	`codepostal` int,
	`ville` varchar(255) NOT NULL,
	`latitude` int NOT NULL,
	`longitude` int NOT NULL,
	PRIMARY KEY (`id_adr`)
);

CREATE TABLE `Responsable` (
	`id_resp` int NOT NULL AUTO_INCREMENT,
	`nom` varchar(255) NOT NULL,
	`prenom` varchar(255) NOT NULL,
	`mail` varchar(255),
	`tel` int,
	`id_util` int NOT NULL,
	PRIMARY KEY (`id_resp`)
);

CREATE TABLE `Formation` (
	`id_form` int NOT NULL AUTO_INCREMENT,
	`annee` enum NOT NULL,
	`filiere` enum NOT NULL,
	PRIMARY KEY (`id_form`)
);

CREATE TABLE `Pays` (
	`id_pays` int NOT NULL AUTO_INCREMENT,
	`pays` varchar(255) NOT NULL UNIQUE,
	PRIMARY KEY (`id_pays`)
);

CREATE TABLE `Responsable_Formation` (
	`id_form` bigint NOT NULL AUTO_INCREMENT,
	`id_resp` int NOT NULL,
	PRIMARY KEY (`id_form`,`id_resp`)
);

CREATE TABLE `Stage_MotCle` (
	`id_stage` int NOT NULL AUTO_INCREMENT,
	`motCle` varchar(255) NOT NULL UNIQUE,
	PRIMARY KEY (`id_stage`)
);

CREATE TABLE `Utilisateur` (
	`id_util` int NOT NULL AUTO_INCREMENT,
	`username` varchar(255) NOT NULL UNIQUE,
	`mdp` varchar(255) NOT NULL,
	`nom` varchar(255) NOT NULL,
	`prenom` varchar(255) NOT NULL,
	`civilite` enum NOT NULL,
	PRIMARY KEY (`id_util`)
);

CREATE TABLE `Utilisateur_Droit` (
	`id_util` int NOT NULL,
	`droit` enum NOT NULL,
	PRIMARY KEY (`id_util`)
);

ALTER TABLE `Etudiant` ADD CONSTRAINT `Etudiant_fk0` FOREIGN KEY (`id_util`) REFERENCES `Utilisateur`(`id_util`);

ALTER TABLE `Etudiant` ADD CONSTRAINT `Etudiant_fk1` FOREIGN KEY (`id_form`) REFERENCES `Formation`(`id_form`);

ALTER TABLE `Stage` ADD CONSTRAINT `Stage_fk0` FOREIGN KEY (`id_resp`) REFERENCES `Responsable`(`id_resp`);

ALTER TABLE `Stage` ADD CONSTRAINT `Stage_fk1` FOREIGN KEY (`id_etud`) REFERENCES `Etudiant`(`id_etud`);

ALTER TABLE `Stage` ADD CONSTRAINT `Stage_fk2` FOREIGN KEY (`id_form`) REFERENCES `Formation`(`id_form`);

ALTER TABLE `Stage` ADD CONSTRAINT `Stage_fk3` FOREIGN KEY (`id_ent`) REFERENCES `Entreprise`(`id_ent`);

ALTER TABLE `Stage` ADD CONSTRAINT `Stage_fk4` FOREIGN KEY (`id_adr`) REFERENCES `Adresse`(`id_adr`);

ALTER TABLE `Adresse` ADD CONSTRAINT `Adresse_fk0` FOREIGN KEY (`id_ent`) REFERENCES `Entreprise`(`id_ent`);

ALTER TABLE `Adresse` ADD CONSTRAINT `Adresse_fk1` FOREIGN KEY (`id_pays`) REFERENCES `Pays`(`id_pays`);

ALTER TABLE `Responsable` ADD CONSTRAINT `Responsable_fk0` FOREIGN KEY (`id_util`) REFERENCES `Utilisateur`(`id_util`);

ALTER TABLE `Responsable_Formation` ADD CONSTRAINT `Responsable_Formation_fk0` FOREIGN KEY (`id_form`) REFERENCES `Formation`(`id_form`);

ALTER TABLE `Responsable_Formation` ADD CONSTRAINT `Responsable_Formation_fk1` FOREIGN KEY (`id_resp`) REFERENCES `Responsable`(`id_resp`);

ALTER TABLE `Stage_MotCle` ADD CONSTRAINT `Stage_MotCle_fk0` FOREIGN KEY (`id_stage`) REFERENCES `Stage`(`id_stage`);

ALTER TABLE `Utilisateur_Droit` ADD CONSTRAINT `Utilisateur_Droit_fk0` FOREIGN KEY (`id_util`) REFERENCES `Utilisateur`(`id_util`);

