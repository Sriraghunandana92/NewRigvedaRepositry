<?php

define('DB_SCHEMA', 'CREATE DATABASE IF NOT EXISTS :db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci');

define('BASEDATA_TABLE_SCHEMA', 'CREATE TABLE `' . BASEDATA_TABLE . '` (
	`id` varchar(11) NOT NULL,
	`mandala` int(3) NOT NULL,
	`sukta` int(3) NOT NULL,
	`ashtaka` int(3) NOT NULL,
	`adhyaya` int(3) NOT NULL,
	`varga` int(3) NOT NULL,
	`anuvaka` int(3) NOT NULL,
	`rik` int(3) NOT NULL,
	`devata` varchar(1000) NOT NULL,
	`rishi` varchar(1000) NOT NULL,
	`chandas` varchar(1000) NOT NULL,
	`samhita` text NOT NULL,
	`samhitaNoSwara` text NOT NULL,
	`samhitaAux` text NOT NULL,
	`padapaatha` text NOT NULL,
	`sayanaBhashya` text NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4');

define('CONCORDANCE_TABLE_SCHEMA', 'CREATE TABLE `' . CONCORDANCE_TABLE . '` (
	`id` varchar(5) NOT NULL,
	`pada` varchar(1000) NOT NULL,
	`padaNoSwara` varchar(1000) NOT NULL,
	`occurrence` text NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4');

define('CHAR_ENCODING_SCHEMA', 'SET NAMES utf8mb4');

?>
