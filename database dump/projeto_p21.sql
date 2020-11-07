-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07-Nov-2020 às 20:54
-- Versão do servidor: 10.4.14-MariaDB
-- versão do PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projeto_p21`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_dados_pessoais`
--

CREATE TABLE `tb_dados_pessoais` (
  `CPF` varchar(14) NOT NULL,
  `NOME` varchar(45) NOT NULL,
  `DT_NASC` date NOT NULL,
  `SEXO` enum('m','f') NOT NULL,
  `NATURALIDADE` varchar(20) NOT NULL DEFAULT 'Brasília/DF',
  `CARGO` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_dados_pessoais`
--

INSERT INTO `tb_dados_pessoais` (`CPF`, `NOME`, `DT_NASC`, `SEXO`, `NATURALIDADE`, `CARGO`) VALUES
('111.111.111-11', 'Rames Sousa', '1997-12-13', 'm', 'Brasília/DF', 'Programador'),
('222.222.222-22', 'Alpha', '2020-11-07', 'm', 'Teste', 'Teste'),
('333.333.333-33', 'Beta', '2020-11-07', 'f', 'Teste', 'Teste'),
('444.444.444-44', 'Charlie', '2020-11-07', 'm', 'Teste', 'Teste'),
('555.555.555-55', 'Echo', '2020-11-07', 'f', 'Teste', 'Teste'),
('666.666.666-66', 'Foxtrot', '2020-11-07', 'm', 'Teste', 'Teste'),
('777.777.777-77', 'Golf', '2020-11-07', 'f', 'Teste', 'Teste'),
('888.888.888-88', 'Hotel', '2020-11-07', 'm', 'Teste', 'Teste'),
('999.999.999-99', 'India', '2020-11-07', 'f', 'Teste', 'Teste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_foto`
--

CREATE TABLE `tb_foto` (
  `ID_FOTO` int(11) NOT NULL,
  `ARQUIVO` varchar(45) NOT NULL,
  `DATA` datetime NOT NULL,
  `ID_CPF_FOREIGN_KEY` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_foto`
--

INSERT INTO `tb_foto` (`ID_FOTO`, `ARQUIVO`, `DATA`, `ID_CPF_FOREIGN_KEY`) VALUES
(1, 'cfadb9973ec639fecc43fe00c153fb37.jpg', '2020-11-07 16:24:44', '111.111.111-11'),
(2, 'a71bf999dce6e44dac1489633f22495c.jpg', '2020-11-07 16:31:36', '222.222.222-22'),
(3, '9212caa9b29e508ff64d52c12c16c5cf.jpg', '2020-11-07 16:32:06', '333.333.333-33'),
(4, '13a8edfbb4841adb7aa720feb726d1d9.png', '2020-11-07 16:32:40', '444.444.444-44'),
(5, 'ca1905814e1e86809a020ee43bd699e2.jpg', '2020-11-07 16:33:04', '555.555.555-55'),
(6, 'a0fa90084591a699a7b25bd8208259ac.gif', '2020-11-07 16:33:28', '666.666.666-66'),
(7, '2bb392ab95d0db460fba8b1fe8003346.jpg', '2020-11-07 16:49:24', '777.777.777-77'),
(8, 'e360f18f3dcc7c4d4ceabf7473d0de6e.jpg', '2020-11-07 16:50:51', '888.888.888-88');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_telefone`
--

CREATE TABLE `tb_telefone` (
  `ID` int(11) NOT NULL,
  `NUMERO` varchar(15) NOT NULL,
  `ID_CPF_FOREIGN_KEY` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_telefone`
--

INSERT INTO `tb_telefone` (`ID`, `NUMERO`, `ID_CPF_FOREIGN_KEY`) VALUES
(1, '(61) 99168-3187', '111.111.111-11'),
(2, '(11) 11111-1111', '222.222.222-22'),
(3, '(22) 22222-2222', '333.333.333-33'),
(4, '(33) 33333-3333', '444.444.444-44'),
(5, '(44) 44444-4444', '555.555.555-55'),
(6, '(55) 55555-5555', '666.666.666-66'),
(7, '(66) 66666-6666', '777.777.777-77'),
(8, '(77) 77777-7777', '888.888.888-88'),
(9, '(00) 11', '999.999.999-99'),
(10, '(00) 22', '999.999.999-99'),
(11, '(00) 33', '999.999.999-99'),
(12, '(00) 44', '999.999.999-99'),
(13, '(00) 55', '999.999.999-99'),
(14, '(00) 66', '999.999.999-99'),
(15, '(00) 77', '999.999.999-99'),
(16, '(00) 88', '999.999.999-99'),
(17, '(00) 99', '999.999.999-99');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_dados_pessoais`
--
ALTER TABLE `tb_dados_pessoais`
  ADD PRIMARY KEY (`CPF`);

--
-- Índices para tabela `tb_foto`
--
ALTER TABLE `tb_foto`
  ADD PRIMARY KEY (`ID_FOTO`),
  ADD KEY `ID_CPF_FOREIGN_KEY` (`ID_CPF_FOREIGN_KEY`);

--
-- Índices para tabela `tb_telefone`
--
ALTER TABLE `tb_telefone`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_CPF_FOREIGN_KEY` (`ID_CPF_FOREIGN_KEY`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_foto`
--
ALTER TABLE `tb_foto`
  MODIFY `ID_FOTO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `tb_telefone`
--
ALTER TABLE `tb_telefone`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tb_foto`
--
ALTER TABLE `tb_foto`
  ADD CONSTRAINT `tb_foto_ibfk_1` FOREIGN KEY (`ID_CPF_FOREIGN_KEY`) REFERENCES `tb_dados_pessoais` (`CPF`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_telefone`
--
ALTER TABLE `tb_telefone`
  ADD CONSTRAINT `tb_telefone_ibfk_1` FOREIGN KEY (`ID_CPF_FOREIGN_KEY`) REFERENCES `tb_dados_pessoais` (`CPF`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
