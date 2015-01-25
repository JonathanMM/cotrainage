-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Client :  mysql51-34.perso
-- Généré le :  Dim 25 Janvier 2015 à 18:15
-- Version du serveur :  5.1.73-2+squeeze+build1+1-log
-- Version de PHP :  5.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `noclemain`
--

-- --------------------------------------------------------

--
-- Structure de la table `cot_desserte`
--

CREATE TABLE IF NOT EXISTS `cot_desserte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_train` int(11) NOT NULL,
  `gare` int(11) NOT NULL,
  `heure` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=152 ;

-- --------------------------------------------------------

--
-- Structure de la table `cot_gare`
--

CREATE TABLE IF NOT EXISTS `cot_gare` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Structure de la table `cot_prise_train`
--

CREATE TABLE IF NOT EXISTS `cot_prise_train` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_train` int(11) NOT NULL,
  `gare_depart` int(11) NOT NULL,
  `gare_arrive` int(11) NOT NULL,
  `voiture` int(2) NOT NULL,
  `place` int(2) NOT NULL,
  `notif` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Structure de la table `cot_train`
--

CREATE TABLE IF NOT EXISTS `cot_train` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(6) NOT NULL,
  `date` date NOT NULL,
  `type` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Structure de la table `cot_user`
--

CREATE TABLE IF NOT EXISTS `cot_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(64) NOT NULL,
  `mdp` varchar(512) NOT NULL,
  `valide` int(1) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
