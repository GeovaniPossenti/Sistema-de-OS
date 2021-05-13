-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08-Maio-2021 às 04:19
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
  `cpf_cliente` varchar(14) DEFAULT NULL,
  `celular_cliente` varchar(20) DEFAULT NULL,
  `telefone_cliente` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nome_cliente`, `cpf_cliente`, `celular_cliente`, `telefone_cliente`) VALUES
(1, 'Manuela Nair Maya Ramos', '707.282.349-20', '(41) 99850-2782', '(41) 2817-7484'),
(2, 'Alice Vitória Ayla da Rosa', '509.469.739-03', '(41) 99317-0169', '(41) 3858-4246'),
(3, 'Isabelly Melissa Duarte', '118.298.459-26', '(41) 99236-2393', '(41) 3548-8750'),
(4, 'Gael Otávio Jesus', '306.442.789-00', '(41) 99788-3894', '(41) 3866-9326'),
(5, 'Letícia Julia Oliveira', '141.829.209-53', '(41) 99256-2346', '(41) 2533-2784'),
(6, 'Stefany Rita Ayla Corte Real', '543.809.049-11', '(41) 99155-3930', '(41) 2651-7761'),
(7, 'Luan Breno Lima', '026.171.579-89', '(41) 99291-6257', '(41) 2870-9680'),
(8, 'Francisca Maria Alícia Sales', '272.363.089-78', '(41) 99358-2868', '(41) 2557-0324'),
(9, 'Cauê Mário Heitor Lopes', '078.336.529-20', '(41) 98191-1947', '(41) 3968-6354'),
(10, 'Hugo Renato Elias Ramos', '151.153.349-84', '(41) 98287-2520', '(41) 3914-0067'),
(11, 'José Benjamin Farias', '783.970.229-53', '(41) 98191-2023', '(41) 3895-4802'),
(12, 'Malu Clara Figueiredo', '322.413.629-48', '(41) 98528-8941', '(41) 3965-0773'),
(13, 'Julio Kevin Tiago da Silva', '955.484.389-56', '(41) 99572-7545', '(41) 3992-9818'),
(14, 'Ana Catarina Fernandes', '169.632.499-89', '(41) 98610-7277', '(41) 3955-3344'),
(15, 'Elaine Sônia Aurora Alves', '854.475.299-30', '(41) 99642-5837', '(41) 3813-1625'),
(16, 'Antonella Elaine Brito', '345.988.479-72', '(41) 99958-1366', '(41) 2861-1114'),
(17, 'Betina Carolina Bruna Moura', '259.208.449-57', '(41) 99570-7697', '(41) 3910-7011'),
(18, 'Sara Lavínia Nunes', '891.261.039-23', '(41) 98792-8410', '(41) 3552-4071'),
(19, 'Edson Matheus Bernardes', '465.157.909-45', '(41) 99128-8791', '(41) 2967-1133'),
(20, 'Lavínia Rita Ramos', '323.451.229-94', '(41) 99447-8750', '(41) 3759-5275'),
(21, 'Ana Luana Pires', '892.240.129-06', '(41) 99370-7997', '(41) 3583-6125'),
(22, 'Lucas Matheus Fernando Drumond', '728.909.609-60', '(41) 99525-6366', '(41) 3560-3446'),
(23, 'Guilherme Thales Moura', '714.230.969-59', '(41) 98431-1525', '(41) 2971-4586'),
(24, 'Diego Kaique Ramos', '631.073.129-75', '(41) 98545-1285', '(41) 2810-4391'),
(25, 'Helena Débora da Silva', '927.573.609-06', '(41) 98162-0592', '(41) 3963-8348'),
(26, 'Luís Luan Moura', '006.736.329-62', '(41) 98540-2744', '(41) 3826-8140'),
(27, 'Rosângela Betina Dias', '786.226.509-28', '(41) 98232-0912', '(41) 2566-0292'),
(28, 'Sebastião Eduardo Silveira', '456.588.689-80', '(41) 99218-7910', '(41) 3559-4592'),
(29, 'Thales Gael Ricardo Nogueira', '488.596.399-05', '(41) 98361-1227', '(41) 3541-5416'),
(30, 'Alexandre Mário Raimundo da Cruz', '635.906.039-68', '(41) 99787-1190', '(41) 3653-2263'),
(31, 'Sérgio Levi Mendes', '090.103.769-90', '(41) 98493-9251', '(41) 2721-1790'),
(32, 'Alessandra Olivia Liz Moraes', '984.813.069-16', '(41) 98560-3393', '(41) 2582-0885'),
(33, 'Stella Ayla Carolina Corte Real', '148.718.049-76', '(41) 99521-4301', '(41) 3876-5285'),
(34, 'Jorge Juan Figueiredo', '358.870.209-11', '(41) 99855-1392', '(41) 2734-8974'),
(35, 'Levi Bryan Benjamin da Mata', '157.903.149-88', '(41) 99516-1191', '(41) 3854-8693'),
(36, 'Benedito Diego Sales', '459.621.719-00', '(41) 99678-1965', '(41) 3704-8354'),
(37, 'Thiago Thomas Nogueira', '843.511.619-06', '(41) 99592-5846', '(41) 3834-5937'),
(38, 'Enzo Lorenzo Ian Pinto', '634.659.409-54', '(41) 99893-0305', '(41) 3602-2643'),
(39, 'Tiago Geraldo Galvão', '868.798.009-47', '(41) 98261-4829', '(41) 2786-1656'),
(40, 'Bárbara Luiza Evelyn Peixoto', '665.826.309-46', '(41) 98563-4021', '(41) 2760-3353'),
(41, 'Kaique Lucca Teixeira', '876.410.549-00', '(41) 98198-5120', '(41) 2879-9482'),
(42, 'Sara Fernanda Aparício', '082.968.199-02', '(41) 99699-0662', '(41) 2829-0111'),
(43, 'Emanuel Luiz Danilo Fogaça', '557.246.209-87', '(41) 98499-0438', '(41) 3702-2148'),
(44, 'José Arthur Gonçalves', '174.174.519-50', '(41) 98247-7737', '(41) 3915-8784'),
(45, 'Filipe Manoel Viana', '731.989.659-18', '(41) 98266-1082', '(41) 3741-9508');

-- --------------------------------------------------------

--
-- Estrutura da tabela `os_pendente`
--

DROP TABLE IF EXISTS `os_pendente`;
CREATE TABLE `os_pendente` (
  `id_os_pendente` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `nome_equipamento` varchar(255) DEFAULT NULL,
  `descricao_defeito` varchar(255) DEFAULT NULL,
  `descricao_reparo` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `data_recebimento` date NOT NULL,
  `data_entrega_cliente` date DEFAULT NULL,
  `valor_reparo` decimal(10,2) DEFAULT NULL,
  `link_webZap` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `os_pendente`
--

INSERT INTO `os_pendente` (`id_os_pendente`, `id_cliente`, `nome_equipamento`, `descricao_defeito`, `descricao_reparo`, `status`, `data_recebimento`, `data_entrega_cliente`, `valor_reparo`, `link_webZap`) VALUES
(1, 6, 'Notebook Dell', '', 'Troca HD', 'Entregue', '2021-05-03', '2021-05-21', '250.00', 'https://api.whatsapp.com/send?phone=+5541991553930&text=Ol%C3%A1%20Stefany%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84'),
(2, 30, 'Tablet', '', 'Atualização OS', 'Aguardando', '2021-05-04', '0000-00-00', '0.00', 'https://api.whatsapp.com/send?phone=+5541997871190&text=Ol%C3%A1%20Alexandre%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84'),
(3, 2, 'Computador de mesa', '', 'Limpeza e formatação', 'Aguardando', '2021-05-04', '0000-00-00', '0.00', 'https://api.whatsapp.com/send?phone=+5541993170169&text=Ol%C3%A1%20Alice%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84'),
(4, 14, 'Celular Samsung ', '', 'Troca de tela defeituosa', 'Processando', '2021-05-04', '2021-05-08', '150.00', 'https://api.whatsapp.com/send?phone=+5541986107277&text=Ol%C3%A1%20Ana%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84'),
(5, 21, 'Celular Iphone', 'Troca da bateria', '', 'Finalizado', '2021-05-04', '2021-05-12', '500.00', 'https://api.whatsapp.com/send?phone=+5541993707997&text=Ol%C3%A1%20Ana%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84'),
(6, 16, 'Notebook Positivo', 'Substituição do teclado ', '', 'Finalizado', '2021-05-04', '0000-00-00', '600.00', 'https://api.whatsapp.com/send?phone=+5541999581366&text=Ol%C3%A1%20Antonella%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84'),
(7, 17, 'Computador de mesa', 'Upgrade de peças, instalação de OS e montagem. ', '', 'Finalizado', '2021-05-04', '0000-00-00', '200.00', 'https://api.whatsapp.com/send?phone=+5541995707697&text=Ol%C3%A1%20Betina%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84'),
(8, 9, 'Computador de mesa', 'Instalação de ssd', '', 'Finalizado', '2021-05-04', '0000-00-00', '100.00', 'https://api.whatsapp.com/send?phone=+5541981911947&text=Ol%C3%A1%20Cauê%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84'),
(9, 24, 'Notebook ', 'Troca de pasta térmica ', '', 'Aguardando', '2021-05-04', '0000-00-00', '50.00', 'https://api.whatsapp.com/send?phone=+5541985451285&text=Ol%C3%A1%20Diego%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84'),
(10, 19, 'Celular Motorola', 'Troca de tela', '', 'Aguardando', '2021-05-04', '0000-00-00', '150.00', 'https://api.whatsapp.com/send?phone=+5541991288791&text=Ol%C3%A1%20Edson%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84'),
(11, 19, 'Notebook HP', 'Manutenção', '', 'Processando', '2021-05-04', '0000-00-00', '180.00', 'https://api.whatsapp.com/send?phone=+5541991288791&text=Ol%C3%A1%20Edson%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84'),
(12, 28, 'Notebook Avell', 'Manutenção, troca de pasta térmica e troca de teclado. ', '', 'Aguardando', '2021-05-04', '0000-00-00', '1000.00', 'https://api.whatsapp.com/send?phone=+5541992187910&text=Ol%C3%A1%20Sebastião%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84'),
(13, 15, 'Celular Asus', 'Troca de tela, troca de auto-falante e troca de conector de carga ', '', 'Aguardando', '2021-05-04', '0000-00-00', '400.00', 'https://api.whatsapp.com/send?phone=+5541996425837&text=Ol%C3%A1%20Elaine%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84'),
(14, 8, 'Computador de mesa', '', 'Limpeza e formatação', 'Finalizado', '2021-05-04', '0000-00-00', '150.00', 'https://api.whatsapp.com/send?phone=+5541993582868&text=Ol%C3%A1%20Francisca%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84'),
(15, 4, 'Computador de mesa', 'Troca de placa de vídeo', '', 'Aguardando', '2021-05-04', '0000-00-00', '120.00', 'https://api.whatsapp.com/send?phone=+5541997883894&text=Ol%C3%A1%20Gael%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84'),
(16, 23, 'Placa mãe', 'Curto circuito no processador \r\n', '', 'Orçamento', '2021-05-04', '0000-00-00', '400.00', 'https://api.whatsapp.com/send?phone=+5541984311525&text=Ol%C3%A1%20Guilherme%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84'),
(17, 25, 'Placa de vídeo', '', 'Precisa fazer reballing ', 'Aguardando', '2021-05-04', '0000-00-00', '400.00', 'https://api.whatsapp.com/send?phone=+5541981620592&text=Ol%C3%A1%20Helena%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84'),
(18, 10, 'Notebook Acer', 'Não liga e não da vídeo ', '', 'Orçamento', '2021-05-04', '0000-00-00', '0.00', 'https://api.whatsapp.com/send?phone=+5541982872520&text=Ol%C3%A1%20Hugo%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84'),
(19, 28, 'Computador de mesa', '', 'Manutenção', 'Entregue', '2021-05-04', '2021-05-26', '100.00', 'https://api.whatsapp.com/send?phone=+5541992187910&text=Ol%C3%A1%20Sebastião%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84'),
(20, 12, 'Notebook', 'Não da vídeo', 'Limpeza e formatação ', 'Entregue', '2021-05-04', '2021-05-12', '150.00', 'https://api.whatsapp.com/send?phone=+5541985288941&text=Ol%C3%A1%20Malu%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84'),
(21, 11, 'Celular Xiaomi', '', 'Troca de tela', 'Entregue', '2021-05-04', '2021-05-31', '250.00', 'https://api.whatsapp.com/send?phone=+5541981912023&text=Ol%C3%A1%20José%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84');

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
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de tabela `os_pendente`
--
ALTER TABLE `os_pendente`
  MODIFY `id_os_pendente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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