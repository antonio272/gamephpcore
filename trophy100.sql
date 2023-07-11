-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05-Jul-2023 às 23:42
-- Versão do servidor: 10.4.14-MariaDB
-- versão do PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `trophygames`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `games`
--

CREATE TABLE `games` (
  `game_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(128) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `lat1` decimal(9,7) NOT NULL,
  `lon1` decimal(9,7) NOT NULL,
  `lat2` decimal(9,7) NOT NULL,
  `lon2` decimal(9,7) NOT NULL,
  `vel1` int(10) NOT NULL,
  `vel2` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `games`
--

INSERT INTO `games` (`game_id`, `name`, `description`, `image`, `created_at`, `lat1`, `lon1`, `lat2`, `lon2`, `vel1`, `vel2`) VALUES
(1, 'Tomato', 'A tomato is standing at N&oslash;rreport. It wants to go to N&aelig;stved (55.232816,11.767130) to meet its family. Luckily the arrow keys can move this tomato in the desired arrow direction at a speed of 500kph. And even better, holding the spacebar will double the speed to 1,000kph. The speeds (500/1000) should be queried from a mysql database, so that we can easily change the speed. Once the tomato reaches its destination (or within a radius of 1km), the game is completed. The user&#39;s sessionID and the time it took should be stored in a mysql database, so we can look at the stats later', 'IMG-64a5b41d7dfcf6.53053050.jpeg', '2023-07-05 18:19:09', '55.6838878', '12.5730950', '55.6746686', '12.5657116', 500, 1000);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `email` varchar(252) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `image` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`user_id`, `name`, `created_at`, `email`, `password`, `is_admin`, `image`) VALUES
(1, 'administrador', '2023-07-05 18:20:56', 'admin@gamestation.com', '$2y$10$e98XYeK61OSYirpEtS7vQuVWcDXCC7EnaLLt3f0pqHQbz6lHi2h5u', 1, 'IMGP-64a5b488a266b1.17344814.jpg'),
(2, 'player1', '2023-07-05 18:25:14', 'player1@gamestation.com', '$2y$10$LC1mUiwz1b2wcKd3wcpH8expf0VUcDaH2pbllphgzwkXkvrK4KTwG', 0, 'IMGP-64a5b58a323ad9.43709115.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_play`
--

CREATE TABLE `user_play` (
  `play_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `game_id` int(10) NOT NULL,
  `start_at` timestamp NULL DEFAULT NULL,
  `finish_at` timestamp NULL DEFAULT NULL,
  `game_time` int(11) NOT NULL COMMENT 'Time in seconds'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `user_play`
--

INSERT INTO `user_play` (`play_id`, `user_id`, `game_id`, `start_at`, `finish_at`, `game_time`) VALUES
(1, 1, 1, NULL, '2023-07-05 19:19:47', 23),
(2, 2, 1, NULL, '2023-07-05 19:26:02', 24),
(3, 1, 1, NULL, '2023-07-05 19:47:00', 23);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`game_id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Índices para tabela `user_play`
--
ALTER TABLE `user_play`
  ADD PRIMARY KEY (`play_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `games`
--
ALTER TABLE `games`
  MODIFY `game_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `user_play`
--
ALTER TABLE `user_play`
  MODIFY `play_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
