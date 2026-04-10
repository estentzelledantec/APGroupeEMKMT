-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 10 avr. 2026 à 07:46
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `animationsfld`
--

-- --------------------------------------------------------

--
-- Structure de la table `administration`
--

DROP TABLE IF EXISTS `administration`;
CREATE TABLE IF NOT EXISTS `administration` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `tel` char(10) NOT NULL,
  `emel` varchar(50) NOT NULL,
  `STATUT` int DEFAULT NULL,
  `mdphasher` char(65) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `emel` (`emel`),
  KEY `STATUT` (`STATUT`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `administration`
--

INSERT INTO `administration` (`ID`, `tel`, `emel`, `STATUT`, `mdphasher`) VALUES
(1, '0202020202', 'pascal.prune@gmail.com', 4, '$2y$10$oG2UOku6eRNMZenDiwzMYeu9gmc7kkyNZ0E6a7yQMqtNFggSdI5qW'),
(2, '0202020202', 'tanguy.reautuspas@gmail.com', 3, '$2y$10$dhJ0mPfckwLB49QsC32x/u3FBpuzmLVuiVH4D0kST8LL8kWEE4Y2e'),
(3, '0202020202', 'christian.qarantetroi@gmail.com', 2, '$2y$10$tLebph4EIqwQ5uayAV5J/.Mze4dsOwn3VeDliJfOePlC5cpmHE3Du');

-- --------------------------------------------------------

--
-- Structure de la table `animateur`
--

DROP TABLE IF EXISTS `animateur`;
CREATE TABLE IF NOT EXISTS `animateur` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `tel` char(10) NOT NULL,
  `emel` varchar(50) NOT NULL,
  `mdphasher` char(65) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `emel` (`emel`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `animateur`
--

INSERT INTO `animateur` (`ID`, `nom`, `prenom`, `tel`, `emel`, `mdphasher`) VALUES
(1, 'pierre', 'myrtille', '0202020202', 'pierre.myrtille@gmail.com', '$2y$10$En260T..8Cy9PkHD.xCLUOGMeUS/piOMc5lDEz961IFyqw5vlAZii'),
(2, 'nathalie', 'lopez', '0202020202', 'nathalie.lopez@gmail.com', '$2y$10$ZcUs.CZN8a0O6LDU2dkIueZKPHBAQhh5pjo.5d5MwpJ5w5D.6mBQq');

-- --------------------------------------------------------

--
-- Structure de la table `animation`
--

DROP TABLE IF EXISTS `animation`;
CREATE TABLE IF NOT EXISTS `animation` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Titre` varchar(70) NOT NULL,
  `DateHeureDeb` datetime NOT NULL,
  `DateHeureFin` datetime NOT NULL,
  `nbreMin` int NOT NULL,
  `nbreMax` int NOT NULL,
  `materiel` varchar(250) NOT NULL,
  `commentaire` varchar(360) NOT NULL,
  `annulation` tinyint(1) DEFAULT '0',
  `idTheme` int DEFAULT NULL,
  `idAnimateur` int DEFAULT NULL,
  `idLieu` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `idTheme` (`idTheme`),
  KEY `idAnimateur` (`idAnimateur`),
  KEY `idLieu` (`idLieu`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `animation`
--

INSERT INTO `animation` (`ID`, `Titre`, `DateHeureDeb`, `DateHeureFin`, `nbreMin`, `nbreMax`, `materiel`, `commentaire`, `annulation`, `idTheme`, `idAnimateur`, `idLieu`) VALUES
(1, 'tarte aux fraises', '2023-12-23 10:00:00', '2023-12-23 12:00:00', 10, 20, 'spatule', 'fruits de saison (fraises, framboise)', 0, 1, 2, 3),
(2, 'buche au chocolat', '2023-12-24 11:00:00', '2023-12-24 12:00:00', 5, 30, 'charlotte', 'trois chocolats différents', 0, 1, 2, 2),
(4, 'mare pour les oiseaux', '2023-12-30 13:30:00', '2023-12-30 15:00:00', 10, 30, 'pelle', 'Biodiversité au lycée', 0, 2, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

DROP TABLE IF EXISTS `inscription`;
CREATE TABLE IF NOT EXISTS `inscription` (
  `id_inscrit` int NOT NULL,
  `id_animation` int NOT NULL,
  `presence` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_inscrit`,`id_animation`),
  KEY `id_animation` (`id_animation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`id_inscrit`, `id_animation`, `presence`) VALUES
(1, 1, 1),
(2, 2, 0),
(3, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `inscrit`
--

DROP TABLE IF EXISTS `inscrit`;
CREATE TABLE IF NOT EXISTS `inscrit` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `tel` char(10) NOT NULL,
  `emel` varchar(50) NOT NULL,
  `STATUT` int DEFAULT NULL,
  `classe` char(3) DEFAULT NULL,
  `mdphasher` char(65) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `emel` (`emel`),
  KEY `STATUT` (`STATUT`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `inscrit`
--

INSERT INTO `inscrit` (`ID`, `nom`, `prenom`, `tel`, `emel`, `STATUT`, `classe`, `mdphasher`) VALUES
(1, 'Marina', 'rolhomme', '0202020202', 'Marina.rolhomme@gmail.com', 1, '203', '$2y$10$MU19wQIhZSm6zOb6uvDMAOmgY6VKBBqf2.CkJiqhcTnPYXQNCuWJi'),
(2, 'louis', 'dubois', '0202020202', 'louis.dubois@gmail.com', 5, NULL, '$2y$10$mLNSHR0U7xxahTT3lo3FXueIAlSdvv1rz5AYB0c3Soo0NW3e90IlG'),
(3, 'mathieu', 'dupin', '0202020202', 'mathieu.dupin@gmail.com', 6, NULL, '$2y$10$hFGpZXic0EnuhQx2e1E0x.koEi2j8x7jQTc1t/UqUuIGJnCASGt8C');

-- --------------------------------------------------------

--
-- Structure de la table `lieu`
--

DROP TABLE IF EXISTS `lieu`;
CREATE TABLE IF NOT EXISTS `lieu` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `batiment` char(2) NOT NULL,
  `numsalle` int NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `lieu`
--

INSERT INTO `lieu` (`ID`, `batiment`, `numsalle`) VALUES
(1, 'LB', 113),
(2, 'LB', 103),
(3, 'LE', 4);

-- --------------------------------------------------------

--
-- Structure de la table `statut`
--

DROP TABLE IF EXISTS `statut`;
CREATE TABLE IF NOT EXISTS `statut` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `statut`
--

INSERT INTO `statut` (`ID`, `libelle`) VALUES
(1, 'eleve'),
(2, 'gestionnaireAnimation'),
(3, 'viescolaire'),
(4, 'administration'),
(5, 'professeur'),
(6, 'agentregion');

-- --------------------------------------------------------

--
-- Structure de la table `theme`
--

DROP TABLE IF EXISTS `theme`;
CREATE TABLE IF NOT EXISTS `theme` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `theme`
--

INSERT INTO `theme` (`ID`, `libelle`) VALUES
(1, 'patisserie'),
(2, 'refugeLPO');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
