SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `lieu`;
CREATE TABLE IF NOT EXISTS `lieu` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `batiment` char(2) NOT NULL,
  `numsalle` int NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `theme`;
CREATE TABLE IF NOT EXISTS `theme` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `statut`;
CREATE TABLE IF NOT EXISTS `statut` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `animateur`;
CREATE TABLE IF NOT EXISTS `animateur` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `tel` char(10) NOT NULL,
  `emel` varchar(50) UNIQUE NOT NULL,
  `mdp` varchar(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `administration`;
CREATE TABLE IF NOT EXISTS `administration` (
  `ID` int NOT NULL AUTO_INCREMENT,

  `tel` char(10) NOT NULL,
  `emel` varchar(50)  UNIQUE NOT NULL,
  `mdp` varchar(10) NOT NULL,
  `STATUT` int REFERENCES  statut(ID),
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `inscrit`;
CREATE TABLE IF NOT EXISTS `inscrit` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `tel` char(10) NOT NULL,
  `emel` varchar(50) UNIQUE NOT NULL,
  `mdp` varchar(10) NOT NULL,
  `STATUT` int REFERENCES  statut(ID),
  `classe` char(3)  ,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `animation`;
CREATE TABLE IF NOT EXISTS `animation` (
  `ID` int NOT NULL AUTO_INCREMENT,
   Titre varchar(70) NOT NULL,
  `DateHeureDeb` datetime NOT NULL,
  `DateHeureFin` datetime  NOT NULL,
  `nbreMin` int NOT NULL,
  `nbreMax` int NOT NULL,
  `materiel` varchar(250) NOT NULL,
  `commentaire` varchar(360) NOT NULL,
    `annulation` boolean default false,
  idTheme int REFERENCES  Theme(ID),
idAnimateur int REFERENCES  Animateur(ID),
idLieu int REFERENCES  lieu(ID),
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `inscription`;
CREATE TABLE IF NOT EXISTS `inscription` (
  `id_inscrit` int REFERENCES inscrit(id),
  `id_animation` int REFERENCES animation(id),
    `presence` boolean default false,
  PRIMARY KEY (id_inscrit,id_animation)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
--
-- Déchargement des données de la table `categorie`
--

INSERT INTO lieu (batiment ,  numsalle) VALUES
('LB', 113),
('LB',103),
('LE',004);


INSERT INTO theme (  libelle )VALUES
('patisserie'),('refugeLPO');


INSERT INTO statut (  libelle )VALUES
('eleve'),('gestionnaireAnimation'),('viescolaire'),('administration'), ('professeur'),('agentregion');
-- --------------------------------------------------------
INSERT INTO  animateur (nom,prenom,tel,emel,mdp) VALUES
('pierre','myrtille','020202020202', 'pierre.myrtille@gmail.com','n1s3T?98pp'),
('nathalie','lopez','020202020225', 'nathalie.lopez@gmail.com','N1s3T?98pp');

INSERT INTO  administration (tel,emel,mdp,STATUT) VALUES
('020202020247', 'pascal.prune@gmail.com','n1s3T?c298pp',4),
('020202020246', 'tanguy.reautuspas@gmail.com','n1s3P,,c298pp',3),
('020202020243', 'christian.qarantetroi@gmail.com','n1s3P,*c298pp',2);

INSERT INTO  inscrit  (nom,prenom,tel,emel,mdp,STATUT,classe) VALUES
('Marina','rolhomme','020202020237', 'Marina.rolhomme@gmail.com','n1s3T?c297pp',1,'203'),
('louis','dubois','020202020236', 'louis.dubois@gmail.com','n1s3P,,c268pp',5,NULL),
('mathieu','dupin','020202020233', 'mathieu.dupin@gmail.com','n1s3P,*c248pp',6,NULL);

INSERT INTO  animation (Titre, DateHeureDeb,DateHeureFin,nbreMin,nbreMax,materiel,commentaire,idTheme,idAnimateur,idLieu) VALUES
('tarte aux fraises','2023-12-23 10:00:00','2023-12-23 12:00:00',10, 20,'spatule','fruits de saison',1,2,3),
('buche au chocolat','2023-12-24 11:00:00','2023-12-24 12:00:00',5, 30,'charlotte','trois chocolats différents',1,2,2),
('mare pour les oiseaux','2023-12-30 13:30:00','2023-12-30 15:00:00',10, 30,'pelle','Biodiversité au lycée',2,1,1);


INSERT INTO  inscription (id_inscrit,id_animation,presence) VALUES
(1,1,1),(2,2,0),(3,3,1),(3,1,1);
--
-- Structure de la table `article`
--


