CREATE TABLE IF NOT EXISTS `deposit_amounts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `amount` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `deposit_amounts` (`amount`, `status`) VALUES
(6000, 1),
(10000, 1),
(15000, 1),
(20000, 1),
(25000, 1),
(50000, 1);