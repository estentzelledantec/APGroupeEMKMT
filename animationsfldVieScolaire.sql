-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 10 avr. 2026 à 11:14
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

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
  `mdphasher` char(255) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `emel` (`emel`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `administration`
--

INSERT INTO `administration` (`ID`, `tel`, `emel`, `STATUT`, `mdphasher`) VALUES
(1, '0202020202', 'pascal.prune@gmail.com', 4, '$2y$10$I.SVkOuvbX93a8OOVT1WgeRz8XetQSf09ndnVIfub8dHDbjuR1KnO'),
(2, '0202020202', 'tanguy.reautuspas@gmail.com', 3, '$2y$10$mOmpFaBZzwqNx3q2Lws70uAiZKm1pFsih2cKRK1qDPq/aTRyPFKwu'),
(3, '0202020202', 'christian.qarantetroi@gmail.com', 2, '$2y$10$tAMSFR1cEwJfC1e/SHrlkOwCduGt/nGYTWUlFhIZwphmmx6gWKaVC');

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
  `mdphasher` char(255) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `emel` (`emel`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `animateur`
--

INSERT INTO `animateur` (`ID`, `nom`, `prenom`, `tel`, `emel`, `mdphasher`) VALUES
(1, 'pierre', 'myrtille', '0202020202', 'pierre.myrtille@gmail.com', '$2y$10$KED1hF7UGM8q5pXH2Vq8CO3YlAbErl6apTy6g203GOKJbNu1pHH1i'),
(2, 'nathalie', 'lopez', '0202020202', 'nathalie.lopez@gmail.com', '$2y$10$1FgeEZQfFdTHEN1PoCAQNuK4sYt0H0/taDHsckATyZeXHCOWtcKdO');

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
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `animation`
--

INSERT INTO `animation` (`ID`, `Titre`, `DateHeureDeb`, `DateHeureFin`, `nbreMin`, `nbreMax`, `materiel`, `commentaire`, `annulation`, `idTheme`, `idAnimateur`, `idLieu`) VALUES
(1, 'tarte aux fraises', '2023-12-23 10:00:00', '2023-12-23 12:00:00', 10, 20, 'spatule', 'fruits de saison', 0, 1, 2, 3),
(2, 'buche au chocolat', '2023-12-24 11:00:00', '2023-12-24 12:00:00', 5, 30, 'charlotte', 'trois chocolats différents', 0, 1, 2, 2),
(3, 'mare pour les oiseaux', '2023-12-30 13:30:00', '2023-12-30 15:00:00', 10, 30, 'pelle', 'Biodiversité au lycée', 0, 2, 1, 1),
(4, 'Atelier Pâtisserie : Macarons', '2026-05-15 14:00:00', '0000-00-00 00:00:00', 0, 0, '', '', 0, 1, NULL, NULL),
(5, 'Initiation au Chiffrement', '2026-05-20 09:30:00', '0000-00-00 00:00:00', 0, 0, '', '', 0, 2, NULL, NULL),
(6, 'Conférence Cybersécurité', '2026-06-02 11:00:00', '0000-00-00 00:00:00', 0, 0, '', '', 0, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

DROP TABLE IF EXISTS `inscription`;
CREATE TABLE IF NOT EXISTS `inscription` (
  `id_inscrit` int NOT NULL,
  `id_animation` int NOT NULL,
  `presence` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_inscrit`,`id_animation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`id_inscrit`, `id_animation`, `presence`) VALUES
(1, 1, 'p6/qw1nKAiDM+q4s/gUPIupCSK4iawQnLTBLXsaea3kCLlsk1ZGXetY='),
(2, 3, '9zHxqOSfkhHTBO8NbBF4xGHv7CWlK2YkHUenEgu3brK8ZtUOyHf1O1Q='),
(3, 3, 'HFIfPU6iasgsEPSTvUNOGmHuj89TlBqiZzUv7xLDCmtK0n/vpjppifI='),
(3, 1, 'zcm4hrcmReu51OsMGjE4gYtCWQuaj16lG37sgLo3EehZAU03nh8gxsg='),
(2, 2, 'YVdiKKfF7XJQZoST3cgE+ExrjZTNe7SKZIieu8byLeiKjtF1/2P8ihU='),
(2, 1, '5zCh5Pi65tu8U1yWzMGt3XqNAzSzaDpHakB4HV/HC7Gc4Me6y+c5q24='),
(1, 2, 'oTelJ3rt8dcOzXGxD/fZDeVKHWvXAmGvXPk7nFGC8F9t8e990iSfAgk='),
(1, 3, 'GmSu03LAk6Hq+xsF3eYZ79g3FCzS2GZr8cyNXmFoMnLMR/6y6rkaW+I=');

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
  `mdphasher` char(255) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `emel` (`emel`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `inscrit`
--

INSERT INTO `inscrit` (`ID`, `nom`, `prenom`, `tel`, `emel`, `STATUT`, `classe`, `mdphasher`) VALUES
(1, 'q7EjxdiV5bAiI0kI70GMfrb1V85P2UFmSiU37QCLdakLBTMFRS', '9h/gWeuCjUGSxmU7RDvQqGa8zNz2VN6anL+F96MqHRvuuZVH+o', '0202020202', 'Marina.rolhomme@gmail.com', 1, '8G5', '$2y$10$ZLFBlVWkYlHyADmFOidP.uBwRm8sZReCSOhPOZrpVkJGydFgz4lVy'),
(2, 'louis', 'dubois', '0202020202', 'louis.dubois@gmail.com', 5, '202', '$2y$10$72dlyC.6AF3hsZWMFYTV/O2IqXIF5.UwzfV3zWDgR7eefViGmZEgG'),
(3, 'mathieu', 'dupin', '0202020202', 'mathieu.dupin@gmail.com', 6, '201', '$2y$10$tHqKTIWXb1qDgr4m2vExMOEwwlDKB8kULHDol46cw83Cr/k/Z1mtO');

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
