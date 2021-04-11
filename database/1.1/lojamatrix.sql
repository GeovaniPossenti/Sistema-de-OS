-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11-Abr-2021 às 23:25
-- Versão do servidor: 10.4.18-MariaDB
-- versão do PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `lojamatrix`
--
CREATE DATABASE IF NOT EXISTS `lojamatrix` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `lojamatrix`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nome_cliente` varchar(255) NOT NULL,
  `cpf_cliente` varchar(12) DEFAULT NULL,
  `celular_cliente` varchar(20) DEFAULT NULL,
  `telefone_cliente` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nome_cliente`, `cpf_cliente`, `celular_cliente`, `telefone_cliente`) VALUES
(1, 'Geovani', 'gdgdgdasv', 'gdaggeete', 'fdvcbbdsag'),
(2, 'GeovanTeste212', '313123', '43242342', '42424');

-- --------------------------------------------------------

--
-- Estrutura da tabela `os_pendente`
--

DROP TABLE IF EXISTS `os_pendente`;
CREATE TABLE `os_pendente` (
  `id_os_pendente` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `nome_equipamento` varchar(255) DEFAULT NULL,
  `descricao_defeito` varchar(500) DEFAULT NULL,
  `descricao_reparo` varchar(500) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `data_recebimento` date NOT NULL,
  `data_entrega_cliente` date DEFAULT NULL,
  `valor_reparo` decimal(10,2) DEFAULT NULL,
  `link_webZap` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `os_pendente`
--

INSERT INTO `os_pendente` (`id_os_pendente`, `id_cliente`, `nome_equipamento`, `descricao_defeito`, `descricao_reparo`, `status`, `data_recebimento`, `data_entrega_cliente`, `valor_reparo`, `link_webZap`) VALUES
(2, 1, 'nome', 'desc', 'desc reparo', 'status', '2021-04-07', '2021-04-07', '150.00', 'fsfsfsfsdf'),
(4, 2, 'nome 2 ', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quis vitae aliquam voluptate culpa placeat, eaque ipsa ea non veniam? Dolorum modi consequuntur recusandae rem nesciunt quasi, molestias velit corrupti debitis!', 'desc reparo 2', 'status 2', '2021-04-02', NULL, '150.00', 'https://guilhermemuller.com.br/ead/html-css-na-pratica/inserindo-texto-website');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `login_usuario` varchar(255) NOT NULL,
  `senha_usuario` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `login_usuario`, `senha_usuario`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Índices para tabela `os_pendente`
--
ALTER TABLE `os_pendente`
  ADD PRIMARY KEY (`id_os_pendente`),
  ADD KEY `fk_id_cliente` (`id_cliente`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `os_pendente`
--
ALTER TABLE `os_pendente`
  MODIFY `id_os_pendente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `os_pendente`
--
ALTER TABLE `os_pendente`
  ADD CONSTRAINT `fk_id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
