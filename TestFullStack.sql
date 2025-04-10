-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.27-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for tes_full_stack
CREATE DATABASE IF NOT EXISTS `tes_full_stack` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `tes_full_stack`;

-- Dumping structure for table tes_full_stack.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Dumping data for table tes_full_stack.migrations: ~0 rows (approximately)
INSERT INTO `migrations` (`version`) VALUES
	(20250409190002);

-- Dumping structure for table tes_full_stack.role
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Dumping data for table tes_full_stack.role: ~3 rows (approximately)
INSERT INTO `role` (`id`, `name`) VALUES
	(2, 'admin'),
	(3, 'editor'),
	(4, 'user');

-- Dumping structure for table tes_full_stack.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Dumping data for table tes_full_stack.user: ~16 rows (approximately)
INSERT INTO `user` (`id`, `name`, `username`, `photo`, `password`) VALUES
	(7, 'akbar update', 'akbar1407', 'uploads/profile/user_7_1744295379.png', '$2y$10$6qgHKXRzknPupvSmjmxoduMqS4rpo2NTF5c3PcdNJmPw7Br8UNXwi'),
	(9, 'update', 'akbar', NULL, '$2y$10$spll/NGgJ4e7MXvJFEuhcOPCP5utB08miQI1vwYDxFb5m9dlIkZ/q'),
	(10, 'sdd', 'akbarsdsd', NULL, '$2y$10$rVrr1dI72BtRyhn/7Ns8KORR/acuWE7r4tNiYb91pKFsCHYihnoUW'),
	(12, 'dddd', 'akbar14075', NULL, '$2y$10$ac/FWjdqyn73lfxGSo8oLuS5lTE.OpKiP00PMrv62q4QXHWrupk4G'),
	(13, 'drrre', '5555', NULL, '$2y$10$oJe8MaHU3nwQKezpzAdlsuM0l12YNoBUVMMlRCjxwqZWz2.VBl0Ka'),
	(14, '45567', '888888', NULL, '$2y$10$UWCL0zkcivtIZq49mQx28.VjwdaQHv0ylY78HQoXUexJ3H8/bE572'),
	(15, '55555', '7777777', NULL, '$2y$10$CpuO/t5w77EKqEGu5vs9NO.espdDzWUCaiZySHNBd3p9g3uGj9k6a'),
	(16, '6666', '8998776', NULL, '$2y$10$G6qzv/EFG1Xhl6NAiH2xc..ctc75qUmHXyWb0PGxeJFrIfy5LC/z2'),
	(17, '44445d', '777777', NULL, '$2y$10$8EG1HszGmH.1.ch9jwl4O.of0yFMoEKKtUJRpVWmwwWsCrGwawAxu'),
	(18, '3dfggs', '778998', NULL, '$2y$10$/wiMM6E6/EHaYGjS2dmL2./B0U8fL9ktxvLs/wxMeeSgwhGpFjYTK'),
	(19, '45677', '55555555', NULL, '$2y$10$moGRIf3xypZs7XatykaNyeZsnP0EsCe76Yaem5i6Ff.kh8yNNJ9m6'),
	(20, 'sdsd', 'tes', NULL, '$2y$10$EOxKBl9.Nfde8tXyKBypOeQjUi9PuKGlD5JPhKx4BanZ0dQGdSqFa'),
	(21, 'sdsd', 'akbar14075d', NULL, '$2y$10$G1u3VdrTpHfaj.7V256SKuybLJ5lxolXPr1FgN03bNfIQ6iHCjOdO'),
	(22, 'sdsd', 'akbar14075d33', NULL, '$2y$10$tMjHbHIz5qylBrr2sxDpj.jD3B0ciP2d9P6Xu0MC1J6UpcOhLkm/C'),
	(23, 'sdsd', 'akbar14075d338', NULL, '$2y$10$UEyAM63dy3AMO/JRzAj1z.RuuSfSDQmKtslSC0cJgS5ORcUsREYra'),
	(24, 'sdsd', 'akbar14075d3387', NULL, '$2y$10$IWTZegfuBmVbmdGQj3TngOEjRGkyoVYldQ1xxYrYf6kodcbygsgJS');

-- Dumping structure for table tes_full_stack.user_role
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(5) unsigned NOT NULL,
  `role_id` int(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Dumping data for table tes_full_stack.user_role: ~4 rows (approximately)
INSERT INTO `user_role` (`id`, `user_id`, `role_id`) VALUES
	(1, 7, 2),
	(2, 7, 4),
	(3, 24, 3),
	(4, 9, 3);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
