-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : mariadb:3306
-- Généré le : mar. 19 sep. 2023 à 13:58
-- Version du serveur : 10.7.3-MariaDB-1:10.7.3+maria~focal
-- Version de PHP : 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `domasym`
--
CREATE DATABASE IF NOT EXISTS `domasym` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
USE `domasym`;

-- --------------------------------------------------------

--
-- Structure de la table `people`
--

CREATE TABLE `people` (
  `id` int(10) NOT NULL,
  `firstname` varchar(100) NOT NULL DEFAULT '',
  `lastname` varchar(100) NOT NULL DEFAULT '',
  `views` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `people`
--

INSERT INTO `people` (`id`, `firstname`, `lastname`, `views`) VALUES
(1, 'Alan', 'Turing', 1250000);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `people`
--
ALTER TABLE `people`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
