-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 05 avr. 2026 à 13:33
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `agoraorm`
--

-- --------------------------------------------------------

--
-- Structure de la table `cat_tournois`
--

DROP TABLE IF EXISTS `cat_tournois`;
CREATE TABLE IF NOT EXISTS `cat_tournois` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cat_tournois`
--

INSERT INTO `cat_tournois` (`id`, `libelle`) VALUES
(1, 'Professionnel'),
(2, 'Amateur'),
(3, 'Junior'),
(4, 'Ligue Universitaire'),
(5, 'Streamer Showdown');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20260405133047', '2026-04-05 13:30:50', 130);

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

DROP TABLE IF EXISTS `genre`;
CREATE TABLE IF NOT EXISTS `genre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lib_genre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `genre`
--

INSERT INTO `genre` (`id`, `lib_genre`) VALUES
(1, 'Action'),
(2, 'Aventure'),
(3, 'Sport'),
(4, 'RPG'),
(5, 'FPS'),
(6, 'Combat'),
(7, 'Simulation'),
(8, 'Stratégie');

-- --------------------------------------------------------

--
-- Structure de la table `jeux`
--

DROP TABLE IF EXISTS `jeux`;
CREATE TABLE IF NOT EXISTS `jeux` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pegi_id` int DEFAULT NULL,
  `marque_id` int DEFAULT NULL,
  `genre_id` int DEFAULT NULL,
  `plateforme_id` int DEFAULT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  `date_parution` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3755B50D391E226B` (`plateforme_id`),
  KEY `IDX_3755B50D39C373A` (`id_pegi_id`),
  KEY `IDX_3755B50D4296D31F` (`genre_id`),
  KEY `IDX_3755B50D4827B9B2` (`marque_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `jeux`
--

INSERT INTO `jeux` (`id`, `id_pegi_id`, `marque_id`, `genre_id`, `plateforme_id`, `nom`, `prix`, `date_parution`) VALUES
(1, 1, 1, 3, 1, 'EA Sports FC 24', 69.99, '2023-09-29'),
(2, 5, 4, 1, 3, 'Red Dead Redemption 2', 39.5, '2018-10-26'),
(3, 3, 3, 2, 4, 'Zelda: Tears of the Kingdom', 59.99, '2023-05-12'),
(4, 4, 2, 1, 2, 'Assassins Creed Mirage', 49.99, '2023-10-05'),
(5, 5, 5, 4, 1, 'Elden Ring', 54.9, '2022-02-25'),
(6, 1, 3, 3, 4, 'Mario Kart 8 Deluxe', 45, '2017-04-28'),
(7, 5, 4, 1, 3, 'GTA V', 29.99, '2015-04-14'),
(8, 4, 6, 5, 3, 'Call of Duty: Modern Warfare III', 70, '2023-11-10'),
(9, 3, 7, 4, 1, 'Final Fantasy VII Rebirth', 79.99, '2024-02-29'),
(10, 4, 8, 6, 1, 'Street Fighter 6', 59.99, '2023-06-02'),
(11, 2, 3, 4, 4, 'Pokémon Violet', 44.9, '2022-11-18'),
(12, 5, 5, 1, 1, 'God of War Ragnarök', 74.5, '2022-11-09'),
(13, 3, 1, 3, 1, 'F1 23', 59.99, '2023-06-16'),
(14, 5, 2, 1, 3, 'Far Cry 6', 19.99, '2021-10-07'),
(15, 1, 3, 7, 4, 'Animal Crossing: New Horizons', 49.99, '2020-03-20');

-- --------------------------------------------------------

--
-- Structure de la table `login_trace`
--

DROP TABLE IF EXISTS `login_trace`;
CREATE TABLE IF NOT EXISTS `login_trace` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logged_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `success` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `login_trace`
--

INSERT INTO `login_trace` (`id`, `username`, `ip_address`, `message`, `logged_at`, `success`) VALUES
(1, 'Diallo', '127.0.0.1', 'Déconnexion réussie', '2026-04-05 13:31:57', 1),
(2, 'Julien', '127.0.0.1', 'Connexion réussie', '2026-04-05 13:32:09', 1);

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

DROP TABLE IF EXISTS `marque`;
CREATE TABLE IF NOT EXISTS `marque` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_marque` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`id`, `nom_marque`) VALUES
(1, 'Electronic Arts'),
(2, 'Ubisoft'),
(3, 'Nintendo'),
(4, 'Rockstar Games'),
(5, 'Sony Interactive'),
(6, 'Activision'),
(7, 'Square Enix'),
(8, 'Capcom');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_membre` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom_membre` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel_membre` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_membre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville_membre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rue_membre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cp_membre` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_USERNAME` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id`, `username`, `roles`, `password`, `nom_membre`, `prenom_membre`, `tel_membre`, `mail_membre`, `ville_membre`, `rue_membre`, `cp_membre`) VALUES
(1, 'admin', '[\"ROLE_USER\", \"ROLE_ADMIN\"]', '$2y$13$EFIrVmKAdcbrXUdXHM6gKunmm9hc1IunLZvzf5nvlqfPEOmt4jFWm', 'Lecoq', 'Lucie', '3701465988', 'userdemo0@exemple.com', 'Guyon', '5, boulevard Thibault Gaillard', '65186'),
(2, 'Diallo', '[]', '$2y$13$f8vsGbD9kZnVyKccM9sFveZUqxK9mGewuvCQ4GyPJT7aA0rlTkJqq', 'Schmitt', 'Astrid', '3788665477', 'userdemo1@exemple.com', 'Bernard', '2, impasse Alexandria Roger', '50476'),
(3, 'Morvan', '[]', '$2y$13$g9jL84R0iTB.hDsCF6iwUOxrXUwkmPTiy2VSiXqLTFwHeNWy3Z1Qq', 'Durand', 'Olivier', '3883592692', 'userdemo2@exemple.com', 'Besson', '3, rue Tanguy', '78817'),
(4, 'Charpentier', '[]', '$2y$13$3qBr46cCW11lgoAafKSrv.vAAk6zUocIGcOwvPNYZZJLtHs7HfyC6', 'Rousseau', 'Dominique', '3931921164', 'userdemo3@exemple.com', 'Pottier-sur-Marie', '37, rue Grégoire Julien', '72877'),
(5, 'Hamel', '[]', '$2y$13$17PQTrzfmXkvWlpKrwv9X.aRad6mzpit7X2RwX/I/sxW0VeRj/bby', 'Devaux', 'Renée', '3236307348', 'userdemo4@exemple.com', 'Guillaume', '236, impasse de Dos Santos', '65902'),
(6, 'Francois', '[]', '$2y$13$PR4A4sLUgQYZLVAFxJAac.iSlMkMi65MgIA11vLUP6zWm4RW7sia2', 'Paul', 'Nicole', '3537068678', 'userdemo5@exemple.com', 'Garnierdan', '13, rue de Valette', '46942'),
(7, 'Reynaud', '[]', '$2y$13$7mTrz/VjA1G.lsbI2aYXJOL1g.ED6mswhBzmC6.IcPjG4aw1arHgm', 'Bouchet', 'François', '3551267502', 'userdemo6@exemple.com', 'Charles', '43, impasse de Guyon', '52662'),
(8, 'Traore', '[]', '$2y$13$lAIwLIIYFmyUv3wunRcGgOGHFpe0SImGe9HLxb0HwnLC0GaTzOlsK', 'Baron', 'Louis', '3625159547', 'userdemo7@exemple.com', 'Briand', '229, chemin de Marechal', '63315'),
(9, 'Charrier', '[]', '$2y$13$eEv8n1S7X6E/KZdhungCGO2R433yXhbhNEtso3VRagJsR90hvck1e', 'Masson', 'Théodore', '3451285364', 'userdemo8@exemple.com', 'Remy', '77, place Poulain', '87639'),
(10, 'Didier', '[]', '$2y$13$h6.S4.dF9t7nfXY4oXkRSehGyFSTiXgchLOQoahnGCkAibCVfXf3C', 'Coste', 'Patricia', '3297388415', 'userdemo9@exemple.com', 'Blanchard', 'rue Bonneau', '52395');

-- --------------------------------------------------------

--
-- Structure de la table `participant`
--

DROP TABLE IF EXISTS `participant`;
CREATE TABLE IF NOT EXISTS `participant` (
  `id` int NOT NULL AUTO_INCREMENT,
  `prenom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `participant`
--

INSERT INTO `participant` (`id`, `prenom`, `nom`, `telephone`, `email`) VALUES
(1, 'Yacine', 'Benali', '0788990011', 'yacine@esport.fr'),
(2, 'Sophie', 'Vasseur', '0655443322', 'sophie.v@gmail.com'),
(3, 'Marc', 'Leblanc', '0600112233', 'm.leblanc@bbox.fr');

-- --------------------------------------------------------

--
-- Structure de la table `pegi`
--

DROP TABLE IF EXISTS `pegi`;
CREATE TABLE IF NOT EXISTS `pegi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `age` int NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `pegi`
--

INSERT INTO `pegi` (`id`, `age`, `description`) VALUES
(1, 3, 'Tous publics'),
(2, 7, 'Déconseillé aux moins de 7 ans'),
(3, 12, 'Interdit aux moins de 12 ans'),
(4, 16, 'Interdit aux moins de 16 ans'),
(5, 18, 'Adultes uniquement');

-- --------------------------------------------------------

--
-- Structure de la table `plateforme`
--

DROP TABLE IF EXISTS `plateforme`;
CREATE TABLE IF NOT EXISTS `plateforme` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lib` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `plateforme`
--

INSERT INTO `plateforme` (`id`, `lib`) VALUES
(1, 'PlayStation 5'),
(2, 'Xbox Series X'),
(3, 'PC'),
(4, 'Nintendo Switch'),
(5, 'PlayStation 4');

-- --------------------------------------------------------

--
-- Structure de la table `tournoi`
--

DROP TABLE IF EXISTS `tournoi`;
CREATE TABLE IF NOT EXISTS `tournoi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categorie_id` int DEFAULT NULL,
  `libelle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `date_creation` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_18AFD9DFBCF5E72D` (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tournoi`
--

INSERT INTO `tournoi` (`id`, `categorie_id`, `libelle`, `date`, `date_creation`) VALUES
(1, 1, 'Coupe de Printemps FC24', '2026-05-20 14:00:00', '2026-04-05 13:29:17'),
(2, 5, 'Clash des Streamers Elden Ring', '2026-06-10 20:00:00', '2026-04-05 13:29:17');

-- --------------------------------------------------------

--
-- Structure de la table `tournoi_participant`
--

DROP TABLE IF EXISTS `tournoi_participant`;
CREATE TABLE IF NOT EXISTS `tournoi_participant` (
  `tournoi_id` int NOT NULL,
  `participant_id` int NOT NULL,
  PRIMARY KEY (`tournoi_id`,`participant_id`),
  KEY `IDX_9C531479F607770A` (`tournoi_id`),
  KEY `IDX_9C5314799D1C3019` (`participant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `jeux`
--
ALTER TABLE `jeux`
  ADD CONSTRAINT `FK_3755B50D391E226B` FOREIGN KEY (`plateforme_id`) REFERENCES `plateforme` (`id`),
  ADD CONSTRAINT `FK_3755B50D39C373A` FOREIGN KEY (`id_pegi_id`) REFERENCES `pegi` (`id`),
  ADD CONSTRAINT `FK_3755B50D4296D31F` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`),
  ADD CONSTRAINT `FK_3755B50D4827B9B2` FOREIGN KEY (`marque_id`) REFERENCES `marque` (`id`);

--
-- Contraintes pour la table `tournoi`
--
ALTER TABLE `tournoi`
  ADD CONSTRAINT `FK_18AFD9DFBCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `cat_tournois` (`id`);

--
-- Contraintes pour la table `tournoi_participant`
--
ALTER TABLE `tournoi_participant`
  ADD CONSTRAINT `FK_9C5314799D1C3019` FOREIGN KEY (`participant_id`) REFERENCES `participant` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_9C531479F607770A` FOREIGN KEY (`tournoi_id`) REFERENCES `tournoi` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
