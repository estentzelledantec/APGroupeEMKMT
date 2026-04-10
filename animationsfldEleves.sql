-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 10 avr. 2026 à 07:44
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
  `nonce` varchar(255) DEFAULT NULL,
  `mdphasher` char(65) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `emel` (`emel`),
  KEY `STATUT` (`STATUT`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `administration`
--

INSERT INTO `administration` (`ID`, `tel`, `emel`, `STATUT`, `nonce`, `mdphasher`) VALUES
(1, '0202020202', 'pascal.prune@gmail.com', 4, NULL, '$2y$10$f9jBnznu9U8ZH.skvYLaIunmVCZGc0ueqJhPu6MY1tgY7D2IbkkWu'),
(2, '0202020202', 'tanguy.reautuspas@gmail.com', 3, NULL, '$2y$10$3fvHfth2frf3oSqc.RDkhuveeLHk.dmvXV9sqAAi8F3ak0foBXE6C'),
(3, '0202020202', 'christian.qarantetroi@gmail.com', 2, NULL, '$2y$10$.OLF47zCRVf8GZf3VSwSqullVGEx7JL5FaSy2qW35LD4o9jHiYzKi');

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
  `nonce` varchar(255) DEFAULT NULL,
  `mdphasher` char(65) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `emel` (`emel`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `animateur`
--

INSERT INTO `animateur` (`ID`, `nom`, `prenom`, `tel`, `emel`, `nonce`, `mdphasher`) VALUES
(1, 'pierre', 'myrtille', '0202020202', 'pierre.myrtille@gmail.com', NULL, '$2y$10$1CbdTlShFHnpaEsgWcZrK.timoj0.5NwtTBXt9knuAfvcZyohRwTO'),
(2, 'nathalie', 'lopez', '0202020202', 'nathalie.lopez@gmail.com', NULL, '$2y$10$2OrS0sGIAfoSGvO0UUG4UO.YvQY4GioFEguyTdQhfH2t6F.QbBt6O');

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
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `animation`
--

INSERT INTO `animation` (`ID`, `Titre`, `DateHeureDeb`, `DateHeureFin`, `nbreMin`, `nbreMax`, `materiel`, `commentaire`, `annulation`, `idTheme`, `idAnimateur`, `idLieu`) VALUES
(1, 'tarte aux fraises', '2023-12-23 10:00:00', '2023-12-23 12:00:00', 10, 20, 'spatule', 'fruits de saison', 0, 1, 2, 3),
(2, 'buche au chocolat', '2023-12-24 11:00:00', '2023-12-24 12:00:00', 5, 30, 'charlotte', 'trois chocolats différents', 0, 1, 2, 2),
(3, 'mare pour les oiseaux', '2023-12-30 13:30:00', '2023-12-30 15:00:00', 10, 30, 'pelle', 'Biodiversité au lycée', 0, 2, 1, 1),
(4, 'Atelier de test', '2026-04-03 15:51:29', '0000-00-00 00:00:00', 0, 0, '', '', 0, 1, NULL, NULL),
(5, 'Conférence de test', '2026-03-23 15:51:29', '0000-00-00 00:00:00', 0, 0, '', '', 0, 1, NULL, NULL),
(6, 'Tournoi de Foot', '2026-04-01 14:00:00', '0000-00-00 00:00:00', 0, 0, '', '', 0, 1, NULL, NULL),
(7, 'Atelier Peinture', '2026-04-02 10:00:00', '0000-00-00 00:00:00', 0, 0, '', '', 0, 2, NULL, NULL),
(8, 'Cours de Cuisine Italienne', '2026-04-03 18:30:00', '0000-00-00 00:00:00', 0, 0, '', '', 0, 3, NULL, NULL),
(9, 'Conférence Cyber-sécurité', '2026-04-05 09:00:00', '0000-00-00 00:00:00', 0, 0, '', '', 0, 4, NULL, NULL),
(10, 'Sortie Piscine', '2026-04-06 15:00:00', '0000-00-00 00:00:00', 0, 0, '', '', 0, 1, NULL, NULL),
(11, 'Initiation Poterie', '2026-04-08 14:00:00', '0000-00-00 00:00:00', 0, 0, '', '', 0, 2, NULL, NULL),
(12, 'Dégustation de Fromages', '2026-04-10 19:00:00', '0000-00-00 00:00:00', 0, 0, '', '', 0, 3, NULL, NULL),
(13, 'Workshop Python SIO', '2026-04-12 13:30:00', '0000-00-00 00:00:00', 0, 0, '', '', 0, 4, NULL, NULL),
(14, 'Match de Basket', '2026-04-15 17:00:00', '0000-00-00 00:00:00', 0, 0, '', '', 0, 1, NULL, NULL),
(15, 'Exposition Photo', '2026-04-17 11:00:00', '0000-00-00 00:00:00', 0, 0, '', '', 0, 2, NULL, NULL),
(16, 'Atelier Sushi', '2026-04-20 18:00:00', '0000-00-00 00:00:00', 0, 0, '', '', 0, 3, NULL, NULL),
(17, 'Hackathon Inter-BTS', '2026-04-22 08:00:00', '0000-00-00 00:00:00', 0, 0, '', '', 0, 4, NULL, NULL),
(18, 'Randonnée Forêt', '2026-04-25 09:00:00', '0000-00-00 00:00:00', 0, 0, '', '', 0, 1, NULL, NULL),
(19, 'Cours de Dessin BD', '2026-04-27 14:30:00', '0000-00-00 00:00:00', 0, 0, '', '', 0, 2, NULL, NULL),
(20, 'Concours de Pâtisserie', '2026-04-30 15:00:00', '0000-00-00 00:00:00', 0, 0, '', '', 0, 3, NULL, NULL),
(21, 'Réparation PC Solidaire', '2026-05-02 10:00:00', '0000-00-00 00:00:00', 0, 0, '', '', 0, 4, NULL, NULL),
(22, 'Yoga et Détente', '2026-05-04 18:00:00', '0000-00-00 00:00:00', 0, 0, '', '', 0, 1, NULL, NULL),
(23, 'Théâtre d’Impro', '2026-05-06 20:00:00', '0000-00-00 00:00:00', 0, 0, '', '', 0, 2, NULL, NULL),
(24, 'Barbecue de Printemps', '2026-05-10 12:00:00', '0000-00-00 00:00:00', 0, 0, '', '', 0, 3, NULL, NULL),
(25, 'Installation Linux', '2026-05-12 14:00:00', '0000-00-00 00:00:00', 0, 0, '', '', 0, 4, NULL, NULL);

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
(1, 1, 0),
(2, 2, 0),
(3, 3, 1),
(3, 1, 1),
(1, 3, 0),
(1, 2, 0),
(1, 5, 0),
(1, 6, 0),
(1, 7, 0),
(1, 4, 0),
(1, 8, 0),
(1, 9, 0),
(1, 10, 0),
(1, 11, 0),
(1, 12, 0),
(1, 13, 0),
(1, 14, 0),
(1, 15, 0),
(1, 16, 0),
(1, 17, 0);

-- --------------------------------------------------------

--
-- Structure de la table `inscrit`
--

DROP TABLE IF EXISTS `inscrit`;
CREATE TABLE IF NOT EXISTS `inscrit` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `tel` char(10) NOT NULL,
  `emel` varchar(50) NOT NULL,
  `STATUT` int DEFAULT NULL,
  `classe` varchar(255) DEFAULT NULL,
  `mdphasher` char(65) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `emel` (`emel`),
  KEY `STATUT` (`STATUT`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `inscrit`
--

INSERT INTO `inscrit` (`ID`, `nom`, `prenom`, `tel`, `emel`, `STATUT`, `classe`, `mdphasher`) VALUES
(1, '28MSkKs8y08yoE/0xsAXAY5oQBqJAwDH9VRw5dbtv1VWUvRh0y2GXJSNhRWJE6/p', 'gkfNGbD2Mmlim2ZYS5LsVEULMn4xzMNIfpXp+ZPU94vf6983ZouV54sVyPHFLA==', '0202020202', 'Marina.rolhomme@gmail.com', 1, 'HHb2WmXcWFt5CjBi9BFUcbNqGl8OQmqvFPLYJEFyafjqd7o0N3M4wOk5xw==', '$2y$10$vY3/PVABMLXg7n2jjIbGFuey090dJrcoO6QYJd9bf6wY4lZQi0Gqq'),
(2, 'louis', 'dubois', '0202020202', 'louis.dubois@gmail.com', 5, NULL, '$2y$10$Nj2Gl7d8Hp.88r15t4qds.pdmAmxVdATPF99Rh0yCFznzQmUUnixu'),
(3, 'mathieu', 'dupin', '0202020202', 'mathieu.dupin@gmail.com', 6, NULL, '$2y$10$BZV55/6anveCHOD32JlF1.I0X2UgNzm1vrk6Jz.Bl76jbjzBssx/e');

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `theme`
--

INSERT INTO `theme` (`ID`, `libelle`) VALUES
(1, 'patisserie'),
(2, 'refugeLPO'),
(3, 'Jeux Vidéo & E-Sport'),
(4, 'Sport et Santé'),
(5, 'Arts et Culture'),
(6, 'Nouvelles Technologies');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
