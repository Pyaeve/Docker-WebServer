-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.6.11-MariaDB - MariaDB Server
-- SO del servidor:              Linux
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla idesa.cuotas
CREATE TABLE IF NOT EXISTS `cuotas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `clienteID` int(11) NOT NULL,
  `lote` varchar(50) NOT NULL,
  `nro` int(11) NOT NULL,
  `precio` varchar(255) NOT NULL,
  `vencimiento` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla idesa.cuotas: ~7 rows (aproximadamente)
DELETE FROM `cuotas`;
INSERT INTO `cuotas` (`id`, `clienteID`, `lote`, `nro`, `precio`, `vencimiento`, `status`, `created_at`, `updated_at`) VALUES
	(1, 123456, '00145', 1, '150000', '2022-09-01', 1, NULL, NULL),
	(2, 135486, '00146', 2, '110000', NULL, 1, NULL, NULL),
	(3, 135486, '00147', 3, '160000', NULL, 1, NULL, NULL),
	(4, 123456, '00148', 4, '130000', '2022-10-01', 1, NULL, NULL),
	(5, 1234563, '00148', 5, '145000', NULL, 1, NULL, NULL),
	(6, 1234563, '00148', 6, '190000', '2023-01-01', 1, NULL, NULL),
	(7, 123456, '00148', 7, '190000', '2023-02-01', 0, NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
