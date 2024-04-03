-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03/04/2024 às 23:38
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `frete`
--

CREATE TABLE `frete` (
  `id_frete` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `placa` varchar(255) NOT NULL,
  `cor` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `peso` int(11) NOT NULL,
  `oculta` char(1) DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `frete`
--

INSERT INTO `frete` (`id_frete`, `user_id`, `placa`, `cor`, `estado`, `peso`, `oculta`) VALUES
(3, 1, 'GWR2134', 'AZUL', 'MT', 500, 'N'),
(4, 2, 'HRSET78', 'ROXO', 'GO', 213, 'N'),
(6, 2, 'abc@a', 'VERMEIO', 'GO', 213, 'N'),
(7, 2, 'SUJ2901', 'amarelo', 'MT', 435, 'N');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pesagem`
--

CREATE TABLE `pesagem` (
  `id_pesagem` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `talhao_id` int(11) NOT NULL,
  `frete_id` int(11) NOT NULL,
  `ano` int(11) NOT NULL,
  `produto` char(1) NOT NULL,
  `peso_bruto` int(11) NOT NULL,
  `hora` timestamp NULL DEFAULT NULL,
  `desconto` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pesagem`
--

INSERT INTO `pesagem` (`id_pesagem`, `user_id`, `talhao_id`, `frete_id`, `ano`, `produto`, `peso_bruto`, `hora`, `desconto`) VALUES
(24, 1, 1, 3, 24, 'S', 123, '2024-03-28 18:08:23', 3),
(25, 1, 1, 3, 24, 'S', 1000, '2024-04-03 21:09:22', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `talhoes`
--

CREATE TABLE `talhoes` (
  `id_talhao` int(11) NOT NULL,
  `area` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `talhoes`
--

INSERT INTO `talhoes` (`id_talhao`, `area`, `user_id`) VALUES
(1, 150, 1),
(2, 175, 1),
(3, 138, 1),
(4, 65, 1),
(5, 135, 1),
(6, 116, 1),
(7, 175, 1),
(8, 215, 1),
(9, 70, 1),
(10, 100, 1),
(11, 123, 1),
(12, 84, 1),
(13, 35, 1),
(14, 147, 1),
(15, 80, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` char(1) NOT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id_user`, `nome`, `email`, `usuario`, `senha`, `tipo`, `data`) VALUES
(1, 'Rafael Coelho', 'rcoelho@hotmail', 'rafa', '123', '1', '2024-03-13 15:44:52'),
(2, 'test', 'test1', 'test', 'test', '1', '2024-03-14 14:26:24');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `frete`
--
ALTER TABLE `frete`
  ADD PRIMARY KEY (`id_frete`);

--
-- Índices de tabela `pesagem`
--
ALTER TABLE `pesagem`
  ADD PRIMARY KEY (`id_pesagem`);

--
-- Índices de tabela `talhoes`
--
ALTER TABLE `talhoes`
  ADD PRIMARY KEY (`id_talhao`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `frete`
--
ALTER TABLE `frete`
  MODIFY `id_frete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `pesagem`
--
ALTER TABLE `pesagem`
  MODIFY `id_pesagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `talhoes`
--
ALTER TABLE `talhoes`
  MODIFY `id_talhao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
