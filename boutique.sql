-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : database
-- Généré le : jeu. 16 sep. 2021 à 14:31
-- Version du serveur :  5.7.34
-- Version de PHP : 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `boutique`
--

-- --------------------------------------------------------

--
-- Structure de la table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `civility` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `line1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postalcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `line2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `timestamp` bigint(20) DEFAULT NULL,
  `real_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(13, 'homme'),
(14, 'femme'),
(15, 'enfant');

-- --------------------------------------------------------

--
-- Structure de la table `color`
--

CREATE TABLE `color` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `color`
--

INSERT INTO `color` (`id`, `product_id`, `name`) VALUES
(558, 203, '#34415e'),
(559, 203, '#848184'),
(560, 204, '#33342d'),
(561, 204, '#c2252a'),
(562, 205, '#ffffff'),
(563, 206, '#e5e5e5'),
(564, 207, '#ffffff'),
(565, 208, '#000000'),
(566, 209, '#100f11'),
(567, 209, '#34323f'),
(568, 210, '#5d6d84'),
(569, 211, '#95794d'),
(570, 212, '#0d0d0d'),
(571, 213, '#161834'),
(572, 214, '#930e1d'),
(573, 215, '#fdfdfe'),
(574, 216, '#b9b4b2'),
(575, 217, '#0d0d0d'),
(576, 218, '#101010'),
(577, 219, '#e9e9e9'),
(578, 220, '#2c2c2c'),
(579, 221, '#004e31'),
(580, 222, '#26395b'),
(581, 223, '#474748');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id`, `color_id`, `url`) VALUES
(549, 558, 'bdec55106d30-5fe7c2381900f.jpeg'),
(550, 558, 'ecc2dc1bbe1a-5fe7c2381b081.jpeg'),
(551, 559, '7acb6f9c4589-5fe7c2381e197.jpeg'),
(552, 559, '252e608a5fe3-5fe7c2381fcfc.jpeg'),
(553, 560, '8db2da9b1962-5fe7c41e3b77e.jpeg'),
(554, 561, '067033304ff3-5fe7c41e3c72e.jpeg'),
(555, 562, '01d6d14a38d2-5fe7c4eb73a02.jpeg'),
(556, 562, '01d6d14a38d2-5fe7c4eb748c2.jpeg'),
(557, 563, '444fd17c1a53-5fe7c5dda2b44.jpeg'),
(558, 563, '444fd17c1a53-5fe7c5dda486c.jpeg'),
(559, 564, '4ad1ec2d6271-5fe7c7fc1aca4.jpeg'),
(560, 564, NULL),
(561, 565, '658ec3583de5-5fe7c8f3a7fcd.jpeg'),
(562, 566, 'cd9f540379c2-5fe7ca5e1053f.jpeg'),
(563, 567, '8796c1f68212-5fe7ca5e11294.jpeg'),
(564, 568, '60f9ea4e54bc-5fe7cafb27220.jpeg'),
(565, 569, '6d644b6536a3-5fe7cf98e0ea5.jpeg'),
(566, 569, '8a8e8e95749d-5fe7cf98e1d4c.jpeg'),
(567, 570, '00c63c0f4a63-5fe7cc8cd0cc9.jpeg'),
(568, 571, '3e1267b5e4a0-5fe7cd8351ca6.jpeg'),
(569, 572, '9a341e51c5cc-5fe7ce09c2b56.jpeg'),
(570, 572, '9a341e51c5cc-5fe7ce09c3994.jpeg'),
(571, 573, '17bd2e3594d8-5fe7ce7b09840.jpeg'),
(572, 574, '851fcea83ae3-5fe7cec957f2d.jpeg'),
(573, 575, '34842fbf3d00-5fe7d15911ddc.jpeg'),
(574, 576, '80efd90c20b5-5fe7d1decb122.jpeg'),
(575, 577, '1d7325ecd13c-5fe7d26365716.jpeg'),
(576, 578, 'd082b7b153c4-5fe7d2a735f32.jpeg'),
(577, 579, 'popular4-5ff6431351645.png'),
(578, 580, 'popular3-5ff641dcc59eb.png'),
(579, 581, 'popular5-5ff6421f0de98.png');

-- --------------------------------------------------------

--
-- Structure de la table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nouveautes` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `category_id`, `sub_category_id`, `name`, `nouveautes`) VALUES
(203, 13, 37, 'Jeann Skinny', 0),
(204, 13, 38, 'Baskets Cms178', 0),
(205, 13, 38, 'Baskets 011', 0),
(206, 13, 38, 'Baskets 222', 0),
(207, 13, 38, 'Baskets 317', 0),
(208, 13, 38, 'Baskets Fgm17', 0),
(209, 14, 37, 'Jean Slim Femme', 0),
(210, 14, 37, 'Jean Femme Skinny', 0),
(211, 14, 37, 'Jogger Pant Femme Glowing', 0),
(212, 14, 37, 'Pantalon Jogging Femme', 0),
(213, 14, 38, 'Basket Femme Air 6', 0),
(214, 14, 38, 'Basket Sports Femme', 0),
(215, 14, 38, 'Basket Femme', 0),
(216, 14, 38, 'Basket Femme Classic', 0),
(217, 14, 37, 'T-Shirt Zelda', 0),
(218, 14, 37, 'T-Shirt Superman', 0),
(219, 14, 37, 'T-Shirt Minnie Mouse', 0),
(220, 14, 37, 'T-Shirt Harry Potter', 0),
(221, 13, 39, 'Montre 1', 1),
(222, 13, 39, 'Montre 2', 1),
(223, 13, 39, 'Montre 3', 1);

-- --------------------------------------------------------

--
-- Structure de la table `reset_password_request`
--

CREATE TABLE `reset_password_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sale`
--

CREATE TABLE `sale` (
  `id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `min_items` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sale`
--

INSERT INTO `sale` (`id`, `size_id`, `min_items`, `rate`, `start_date`, `end_date`) VALUES
(7, 1173, 1, 30, '2021-01-01 00:00:00', '2021-01-31 00:00:00'),
(8, 1205, 1, 50, '2021-01-07 00:00:00', '2021-02-28 00:00:00'),
(9, 1221, 2, 50, '2021-01-07 00:00:00', '2021-02-28 00:00:00'),
(10, 1170, 2, 25, '2021-06-30 00:00:00', '2021-07-25 00:00:00'),
(11, 1167, 2, 25, '2021-06-30 00:00:00', '2021-07-25 00:00:00'),
(12, 1228, 2, 50, '2021-09-09 00:00:00', '2021-09-25 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `shipping_fee`
--

CREATE TABLE `shipping_fee` (
  `id` int(11) NOT NULL,
  `min_amount` decimal(10,2) NOT NULL,
  `fee` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `shipping_fee`
--

INSERT INTO `shipping_fee` (`id`, `min_amount`, `fee`) VALUES
(1, '100.00', '6.00');

-- --------------------------------------------------------

--
-- Structure de la table `size`
--

CREATE TABLE `size` (
  `id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `size`
--

INSERT INTO `size` (`id`, `color_id`, `product_id`, `name`, `deleted`, `price`, `stock`) VALUES
(1167, 558, 203, '40', 0, '70.00', 9),
(1168, 558, 203, '42', 0, '70.00', 5),
(1169, 558, 203, '44', 0, '60.00', 0),
(1170, 559, 203, '42', 0, '70.00', 5),
(1171, 559, 203, '44', 0, '70.00', 5),
(1172, 559, 203, '46', 0, '50.00', 2),
(1173, 560, 204, '40', 0, '90.00', 1),
(1174, 560, 204, '41', 0, '90.00', 4),
(1175, 560, 204, '42', 0, '90.00', 4),
(1176, 560, 204, '43', 0, '90.00', 4),
(1177, 560, 204, '45', 0, '80.00', 2),
(1178, 561, 204, '42', 0, '80.00', 3),
(1179, 561, 204, '44', 0, '80.00', 3),
(1180, 561, 204, '45', 0, '70.00', 3),
(1181, 562, 205, '38', 0, '80.00', 10),
(1182, 562, 205, '41', 0, '80.00', 2),
(1183, 562, 205, '42', 0, '80.00', 3),
(1184, 563, 206, '42', 0, '100.00', 9),
(1185, 563, 206, '43', 0, '100.00', 0),
(1186, 563, 206, '44', 0, '90.00', 2),
(1187, 564, 207, '40', 0, '70.00', 10),
(1188, 564, 207, '41', 0, '70.00', 2),
(1189, 564, 207, '42', 0, '70.00', 3),
(1190, 564, 207, '46', 0, '50.00', 5),
(1191, 565, 208, '40', 0, '120.00', 6),
(1192, 565, 208, '41', 0, '120.00', 1),
(1193, 565, 208, '42', 0, '120.00', 0),
(1194, 565, 208, '43', 0, '120.00', 0),
(1195, 565, 208, '44', 0, '100.00', 3),
(1196, 566, 209, '36', 0, '50.00', 9),
(1197, 566, 209, '38', 0, '50.00', 2),
(1198, 566, 209, '40', 0, '50.00', 3),
(1199, 566, 209, '42', 0, '50.00', 2),
(1200, 567, 209, '40', 0, '50.00', 2),
(1201, 567, 209, '41', 0, '50.00', 10),
(1202, 568, 210, '38', 0, '60.00', 8),
(1203, 568, 210, '40', 0, '60.00', 10),
(1204, 568, 210, '42', 0, '60.00', 0),
(1205, 569, 211, '38', 0, '50.00', 3),
(1206, 569, 211, '40', 0, '50.00', 2),
(1207, 569, 211, '42', 0, '50.00', 3),
(1208, 570, 212, '38', 0, '45.00', 10),
(1209, 570, 212, '40', 0, '45.00', 10),
(1210, 570, 212, '42', 0, '45.00', 2),
(1211, 571, 213, '37', 0, '60.00', 1),
(1212, 571, 213, '38', 0, '60.00', 3),
(1213, 571, 213, '39', 0, '60.00', 4),
(1214, 571, 213, '40', 0, '60.00', 3),
(1215, 572, 214, '38', 0, '80.00', 10),
(1216, 572, 214, '40', 0, '80.00', 3),
(1217, 573, 215, '38', 0, '70.00', 10),
(1218, 573, 215, '40', 0, '70.00', 3),
(1219, 573, 215, '42', 0, '60.00', 3),
(1220, 574, 216, '38', 0, '60.00', 10),
(1221, 575, 217, '38', 0, '19.99', 5),
(1222, 576, 218, '38', 0, '19.99', 5),
(1223, 577, 219, '38', 0, '19.99', 5),
(1224, 578, 220, '38', 0, '19.99', 10),
(1225, 579, 221, '38 mm', 0, '100.00', 4),
(1226, 579, 221, '42 mm', 0, '100.00', 1),
(1227, 580, 222, '38 mm', 0, '200.00', 5),
(1228, 581, 223, '38 mm', 0, '300.00', 4);

-- --------------------------------------------------------

--
-- Structure de la table `sub_category`
--

CREATE TABLE `sub_category` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sub_category`
--

INSERT INTO `sub_category` (`id`, `category_id`, `name`) VALUES
(37, 13, 'vêtements'),
(38, 13, 'chaussures'),
(39, 13, 'accessoires'),
(40, 14, 'vêtements'),
(41, 14, 'chaussures'),
(42, 14, 'accessoires'),
(43, 15, 'vêtements'),
(44, 15, 'chaussures'),
(45, 15, 'accessoires');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `profession` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `civility` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `line1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postalcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `id_customer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `line2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expires_at` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D4E6F81A76ED395` (`user_id`);

--
-- Index pour la table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BA388B7A76ED395` (`user_id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_665648E94584665A` (`product_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C53D045F7ADA1FB5` (`color_id`);

--
-- Index pour la table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_906517441AD5CDBF` (`cart_id`),
  ADD KEY `IDX_90651744A76ED395` (`user_id`);

--
-- Index pour la table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F52993981AD5CDBF` (`cart_id`),
  ADD KEY `IDX_F5299398498DA827` (`size_id`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D34A04AD12469DE2` (`category_id`),
  ADD KEY `IDX_D34A04ADF7BFE87C` (`sub_category_id`);

--
-- Index pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CE748AA76ED395` (`user_id`);

--
-- Index pour la table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E54BC005498DA827` (`size_id`);

--
-- Index pour la table `shipping_fee`
--
ALTER TABLE `shipping_fee`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F7C0246A7ADA1FB5` (`color_id`),
  ADD KEY `IDX_F7C0246A4584665A` (`product_id`);

--
-- Index pour la table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BCE3F79812469DE2` (`category_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT pour la table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `color`
--
ALTER TABLE `color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=582;

--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=580;

--
-- AUTO_INCREMENT pour la table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;

--
-- AUTO_INCREMENT pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sale`
--
ALTER TABLE `sale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `shipping_fee`
--
ALTER TABLE `shipping_fee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `size`
--
ALTER TABLE `size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1229;

--
-- AUTO_INCREMENT pour la table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `FK_D4E6F81A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_BA388B7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `color`
--
ALTER TABLE `color`
  ADD CONSTRAINT `FK_665648E94584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `FK_C53D045F7ADA1FB5` FOREIGN KEY (`color_id`) REFERENCES `color` (`id`);

--
-- Contraintes pour la table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `FK_906517441AD5CDBF` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`),
  ADD CONSTRAINT `FK_90651744A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F52993981AD5CDBF` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`),
  ADD CONSTRAINT `FK_F5299398498DA827` FOREIGN KEY (`size_id`) REFERENCES `size` (`id`);

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_D34A04ADF7BFE87C` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_category` (`id`);

--
-- Contraintes pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `FK_E54BC005498DA827` FOREIGN KEY (`size_id`) REFERENCES `size` (`id`);

--
-- Contraintes pour la table `size`
--
ALTER TABLE `size`
  ADD CONSTRAINT `FK_F7C0246A4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_F7C0246A7ADA1FB5` FOREIGN KEY (`color_id`) REFERENCES `color` (`id`);

--
-- Contraintes pour la table `sub_category`
--
ALTER TABLE `sub_category`
  ADD CONSTRAINT `FK_BCE3F79812469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
