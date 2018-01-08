CREATE DATABASE `contatos2`;

USE `contatos2`;

DROP TABLE IF EXISTS `contatos`;

CREATE TABLE `contatos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empresa` varchar(100) NOT NULL,
  `servico` varchar(100) DEFAULT NULL,
  `contato` varchar(100) DEFAULT NULL,
  `funcao` varchar(100) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `ramal` varchar(10) DEFAULT NULL,
  `celular_1` varchar(20) DEFAULT NULL,
  `celular_2` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

