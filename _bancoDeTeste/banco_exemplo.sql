-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.14-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para twitter_clone
CREATE DATABASE IF NOT EXISTS `twitter_clone` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `twitter_clone`;

-- Copiando estrutura para tabela twitter_clone.tweets
CREATE TABLE IF NOT EXISTS `tweets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `conteudo` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dia` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_idUsuario` (`id_usuario`),
  CONSTRAINT `fk_idUsuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela twitter_clone.tweets: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `tweets` DISABLE KEYS */;
REPLACE INTO `tweets` (`id`, `id_usuario`, `conteudo`, `dia`) VALUES
	(8, 2, 'Mais um do Jamiltão', '2021-01-15 16:28:57'),
	(13, 1, 'gougougougou', '2021-01-18 21:31:58'),
	(14, 3, 'post 1', '2021-01-18 23:03:00'),
	(15, 3, 'Lucas falando\r\n', '2021-01-18 23:03:06'),
	(16, 3, 'mais 1', '2021-01-18 23:03:12');
/*!40000 ALTER TABLE `tweets` ENABLE KEYS */;

-- Copiando estrutura para tabela twitter_clone.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela twitter_clone.usuarios: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
REPLACE INTO `usuarios` (`id`, `nome`, `email`, `senha`) VALUES
	(1, 'jorge', 'jorge@teste.com.br', '827ccb0eea8a706c4c34a16891f84e7b'),
	(2, 'Jamilton', 'jamilton@teste.com.br', '827ccb0eea8a706c4c34a16891f84e7b'),
	(3, 'lucas', 'lucas@teste.com', '827ccb0eea8a706c4c34a16891f84e7b'),
	(4, 'Maria', 'maria@teste.com.br', '827ccb0eea8a706c4c34a16891f84e7b');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

-- Copiando estrutura para tabela twitter_clone.usuario_seguindo
CREATE TABLE IF NOT EXISTS `usuario_seguindo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_seguidor` int(11) NOT NULL,
  `id_seguido` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_idSeguidor` (`id_seguidor`),
  KEY `FK_idSeguido` (`id_seguido`),
  CONSTRAINT `FK_idSeguido` FOREIGN KEY (`id_seguido`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `FK_idSeguidor` FOREIGN KEY (`id_seguidor`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela twitter_clone.usuario_seguindo: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `usuario_seguindo` DISABLE KEYS */;
REPLACE INTO `usuario_seguindo` (`id`, `id_seguidor`, `id_seguido`) VALUES
	(18, 1, 3),
	(19, 1, 2),
	(22, 3, 1),
	(23, 3, 4);
/*!40000 ALTER TABLE `usuario_seguindo` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
