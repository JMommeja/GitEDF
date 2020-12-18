-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 18 déc. 2020 à 14:58
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `edf`
--

-- --------------------------------------------------------

--
-- Structure de la table `demande`
--

DROP TABLE IF EXISTS `demande`;
CREATE TABLE IF NOT EXISTS `demande` (
  `idDemande` int(255) NOT NULL AUTO_INCREMENT,
  `messageD` text NOT NULL,
  `dateD` date NOT NULL,
  `heureD` time NOT NULL,
  `validation` varchar(10) NOT NULL,
  `userDemandant` int(11) NOT NULL,
  `regionCible` int(11) NOT NULL,
  PRIMARY KEY (`idDemande`),
  KEY `fk_user_in_demande` (`userDemandant`),
  KEY `fk_region_in_demande` (`regionCible`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `demande`
--

INSERT INTO `demande` (`idDemande`, `messageD`, `dateD`, `heureD`, `validation`, `userDemandant`, `regionCible`) VALUES
(1, 'Je te notifie le RACR TOTAL du tronçon HTA compris entre l\'inter 246E à l\'AC4T SANT\'ANTONE, OMT 195A et l\'OMT 246E avec repontages en ligne effectués aval derivation LUTINA et amont derivation POGGIO MARINACUsur le dp HTA16MONTE du PS LUCCIANA suite INGB20-489 S 3A C 4A', '2020-12-18', '08:40:00', 'Valider', 1, 3),
(2, 'Je te demande la mise en RNE du Départ 25 LUCCIANA du Poste Source CERVIONE', '2020-12-18', '09:00:00', 'Refuser', 1, 3),
(3, 'AU PS 90kV D\'OCANA JE TE informe du  RACR DU TR 411 OACANA ET SES DÉPARTS 90kV et 20kV associés dont les limites sont; Le SA HTB TR 411 N°7711 OUVERT et le DJ HTA N°11-ARRIVÉE 1 OUVERT, selon NIP HTB 20/232', '2020-12-18', '09:04:00', 'Valider', 1, 2),
(4, 'Je te notifie la mise en conduite du tronçon HTA compris entre le DJ 16-ALESANI et  l\'inter HTA au PSSB BALDASSARIPHOT, ainsi que du 2I+P POLTRU raccordé en CA entre le DJ 16ALESANI et le PSSB BALDASSARIPHOT, dans le schéma électrique suivant : Au poste POLTRU, l\'inter DJ 16-ALESANI et l\'inter BALDASSARIPHOT sont fermés', '2020-12-18', '09:33:00', 'En cours', 1, 6),
(5, 'Je te notifie la mise en conduite de la nouvelle armoire AC3M SERMANO, avec ses câbles HTA associés, raccordée en CA entre l\'origine de la dérivation SAN NICOLAO et le PSSA SERMANO sur le Départ 16PONTE LECCIA du Poste Source CORTE selon NIP 20.crs.4070.A', '2020-12-18', '10:10:00', 'En cours', 1, 4),
(6, 'Je te notifie le RACR du tronçon HTA en AVAL de l\'inter HTA A L\'ACM MORO sur Départ 116-CAPO DI FENO du PS LORETTO', '2020-12-18', '13:41:50', 'En Cours', 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `enposte`
--

DROP TABLE IF EXISTS `enposte`;
CREATE TABLE IF NOT EXISTS `enposte` (
  `idPoste` int(11) NOT NULL AUTO_INCREMENT,
  `idRegion` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idPoste`),
  KEY `fk_user_in_enposte` (`idUser`),
  KEY `fk_region_in_enposte` (`idRegion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `fonction`
--

DROP TABLE IF EXISTS `fonction`;
CREATE TABLE IF NOT EXISTS `fonction` (
  `idFonction` int(11) NOT NULL AUTO_INCREMENT,
  `libelleFonction` varchar(20) NOT NULL,
  PRIMARY KEY (`idFonction`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `fonction`
--

INSERT INTO `fonction` (`idFonction`, `libelleFonction`) VALUES
(1, 'CEX'),
(2, 'CCO');

-- --------------------------------------------------------

--
-- Structure de la table `region`
--

DROP TABLE IF EXISTS `region`;
CREATE TABLE IF NOT EXISTS `region` (
  `idRegion` int(11) NOT NULL AUTO_INCREMENT,
  `libelleRegion` varchar(255) NOT NULL,
  PRIMARY KEY (`idRegion`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `region`
--

INSERT INTO `region` (`idRegion`, `libelleRegion`) VALUES
(1, 'BOBA : Bastia'),
(2, 'BOCPO : Corte / Ghiso'),
(3, 'BOBA : Balagne'),
(4, 'BOES : Extreme Sud '),
(5, 'BOVA : Valincu'),
(6, 'BOGA : Grand Ajaccio '),
(7, 'BO : Base Opérationnelle');

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

DROP TABLE IF EXISTS `reponse`;
CREATE TABLE IF NOT EXISTS `reponse` (
  `idReponse` int(11) NOT NULL AUTO_INCREMENT,
  `messageR` text NOT NULL,
  `dateR` date NOT NULL,
  `heureR` time NOT NULL,
  `userDemandant` int(11) NOT NULL,
  `userRepondant` int(11) NOT NULL,
  `messageDemande` int(11) NOT NULL,
  PRIMARY KEY (`idReponse`),
  KEY `fk_user_in_reponse` (`userDemandant`),
  KEY `fk_userR_in_reponse` (`userRepondant`),
  KEY `fk_demande_in_reponse` (`messageDemande`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reponse`
--

INSERT INTO `reponse` (`idReponse`, `messageR`, `dateR`, `heureR`, `userDemandant`, `userRepondant`, `messageDemande`) VALUES
(1, 'Je valide', '2020-12-18', '14:41:24', 1, 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `statut`
--

DROP TABLE IF EXISTS `statut`;
CREATE TABLE IF NOT EXISTS `statut` (
  `idStatut` int(11) NOT NULL AUTO_INCREMENT,
  `libelleStatut` varchar(20) NOT NULL,
  PRIMARY KEY (`idStatut`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `statut`
--

INSERT INTO `statut` (`idStatut`, `libelleStatut`) VALUES
(1, 'Utilisateur'),
(2, 'Administrateur');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `nomUser` text NOT NULL,
  `prenomUser` text NOT NULL,
  `matricule` text NOT NULL,
  `password` text NOT NULL,
  `idFonction` int(11) NOT NULL,
  `idStatut` int(11) NOT NULL,
  PRIMARY KEY (`idUser`),
  KEY `fk_fonction_in_user` (`idFonction`),
  KEY `fk_statut_in_user` (`idStatut`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idUser`, `nomUser`, `prenomUser`, `matricule`, `password`, `idFonction`, `idStatut`) VALUES
(1, 'a8fad4c8f5d949e0702e3339e28953d1a8c7ffbe87b44f6f7eaac3060da67154333f901fc905de95ac1ad0947d2657049210457b8acd3eac02a40e666d342aa9XPfTmJEEoKu2bvOl1jYQYPZm2BCV3vVQlnChuZ5KAZ8=', '4fdb70bdc22ff604c842a6054632740a62214306e6ac52bd990a4b0db8c1947909a512da8aec9961e603c2aeb68a933e4203b2e220a4bb010d60ece493184a62mSXLRU2DvuF2tDQZldD06fjF2N2EEE9MsOw+L8xwKfM=', '535d970871d86e9448410788f7f81c73c8bd55ca930db32009c2e27efe68b8cb4445fdf4634439d9f450a4957f69a930027b38b1a5c89d0cf7d31bec8f87bb4860qF6n83VPRC2RReVROHGBtPKeQVn1Fm0MKixvMRudw=', '$2y$10$2qIY3rlK3wXjj.emTAKh3eEPBG4F4BSJJ.CviBVz8BiSQkVFgO.fG', 2, 2);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `demande`
--
ALTER TABLE `demande`
  ADD CONSTRAINT `fk_region_in_demande` FOREIGN KEY (`regionCible`) REFERENCES `region` (`idRegion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_in_demande` FOREIGN KEY (`userDemandant`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `enposte`
--
ALTER TABLE `enposte`
  ADD CONSTRAINT `fk_region_in_enposte` FOREIGN KEY (`idRegion`) REFERENCES `region` (`idRegion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_in_enposte` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `fk_demande_in_reponse` FOREIGN KEY (`messageDemande`) REFERENCES `demande` (`idDemande`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_userR_in_reponse` FOREIGN KEY (`userRepondant`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_in_reponse` FOREIGN KEY (`userDemandant`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_fonction_in_user` FOREIGN KEY (`idFonction`) REFERENCES `fonction` (`idFonction`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_statut_in_user` FOREIGN KEY (`idStatut`) REFERENCES `statut` (`idStatut`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
