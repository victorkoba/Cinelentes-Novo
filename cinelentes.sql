-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29-Maio-2025 às 21:19
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cinelentes`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `acervos`
--

CREATE TABLE `acervos` (
  `id_acervo` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `fotos_acervo` longtext DEFAULT NULL,
  `foto_capa_acervo` longtext NOT NULL,
  `musicas` text DEFAULT NULL,
  `habilidades` text DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `edicao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `administradores`
--

CREATE TABLE `administradores` (
  `id_adm` int(11) NOT NULL,
  `email_adm` varchar(100) NOT NULL,
  `senha_adm` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `administradores`
--

INSERT INTO `administradores` (`id_adm`, `email_adm`, `senha_adm`) VALUES
(7, 'sabrina@gmail.com', '$2y$10$IBiXXyR8ha6LjgGvp7lsxeBcZHSuE9rSL/XAhrSKz3NoeIcw8eiFu'),
(13, 'p@hotmail.com', '$2y$10$8qbuw/YnTdn89xrfDgZQL.gtHQeI9utqa9t8O4DXPWkBycDN860HC'),
(18, 'testenova@gmail.com', '$2y$10$o/6YldKp9gCXsCudW.bPtOKNAcTCG0SJWCOdD.cee8kl1ThqoB/.i'),
(19, '2@hotmail.com', '$2y$10$C4BRTa2DtwgBqh9M3kvXEeFr9nhsi1a0xjAOHoZDUmr9WCrngDLTa'),
(20, 'koba@gmail.com', '$2y$10$f0Es2zo/xXxSjgTqGZ.kzeYSs0ddeTGnvkw.o2PDEasJa2SFSMi1G'),
(21, 'koba1@gmail.com', '$2y$10$4qP8uLdycJqdiTRBOVAZP.ytfdi6vifz89s8W3xMzlffzQTnJmhkO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `curtas_acervo`
--

CREATE TABLE `curtas_acervo` (
  `id_curtas` int(11) NOT NULL,
  `acervo_id` int(11) DEFAULT NULL,
  `nome_arquivo` varchar(255) DEFAULT NULL,
  `tipo_arquivo` varchar(50) DEFAULT NULL,
  `dados` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `data`
--

CREATE TABLE `data` (
  `id_data` int(11) NOT NULL,
  `dia` date NOT NULL,
  `titulo_data` varchar(200) NOT NULL,
  `descricao_data` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `data`
--

INSERT INTO `data` (`id_data`, `dia`, `titulo_data`, `descricao_data`) VALUES
(5, '2025-06-05', 'Dia Mundial do Meio Ambiente', 'Criado pela ONU em 1972, o Dia Mundial do Meio Ambiente busca chamar a atenção da população e dos governos para os problemas ambientais que afetam o planeta. É uma oportunidade para promover ações de conscientização sobre temas como desmatamento, poluição, mudanças climáticas, consumo consciente e preservação da biodiversidade. Escolas e comunidades costumam realizar palestras, mutirões de limpeza'),
(6, '2025-09-07', 'Dia da Independência do Brasil', 'Neste dia, em 1822, Dom Pedro I proclamou a independência do Brasil às margens do rio Ipiranga, em São Paulo, rompendo os laços coloniais com Portugal. A data é um símbolo da soberania nacional e é celebrada com desfiles cívico-militares, apresentações culturais e atividades que valorizam a história do país. É uma oportunidade para discutir temas como cidadania, democracia e identidade nacional.'),
(7, '2025-10-12', 'Dia das Crianças', 'Mais do que uma ocasião para dar presentes, o Dia das Crianças é um momento de celebrar a infância e reforçar o compromisso com os direitos dos pequenos: à educação, ao lazer, à saúde e ao carinho. Escolas, famílias e comunidades costumam organizar brincadeiras, festas e atividades educativas voltadas à valorização das crianças como parte fundamental da sociedade.'),
(8, '2025-11-20', 'Dia da Consciência Negra', 'A data homenageia Zumbi dos Palmares, líder do maior quilombo do Brasil, morto em 1695, e é dedicada à reflexão sobre a luta contra o racismo e à valorização da cultura afro-brasileira. Nas escolas, é comum haver rodas de conversa, exposições e apresentações culturais que promovem o respeito à diversidade e a igualdade racial.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `videos_acervo`
--

CREATE TABLE `videos_acervo` (
  `id_videos` int(11) NOT NULL,
  `acervo_id` int(11) DEFAULT NULL,
  `nome_arquivo` varchar(255) DEFAULT NULL,
  `tipo_arquivo` varchar(50) DEFAULT NULL,
  `dados` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `acervos`
--
ALTER TABLE `acervos`
  ADD PRIMARY KEY (`id_acervo`);

--
-- Índices para tabela `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id_adm`),
  ADD UNIQUE KEY `email_adm` (`email_adm`);

--
-- Índices para tabela `curtas_acervo`
--
ALTER TABLE `curtas_acervo`
  ADD PRIMARY KEY (`id_curtas`),
  ADD KEY `acervo_id` (`acervo_id`);

--
-- Índices para tabela `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id_data`);

--
-- Índices para tabela `videos_acervo`
--
ALTER TABLE `videos_acervo`
  ADD PRIMARY KEY (`id_videos`),
  ADD KEY `acervo_id` (`acervo_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `acervos`
--
ALTER TABLE `acervos`
  MODIFY `id_acervo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de tabela `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id_adm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `curtas_acervo`
--
ALTER TABLE `curtas_acervo`
  MODIFY `id_curtas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `data`
--
ALTER TABLE `data`
  MODIFY `id_data` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `videos_acervo`
--
ALTER TABLE `videos_acervo`
  MODIFY `id_videos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `curtas_acervo`
--
ALTER TABLE `curtas_acervo`
  ADD CONSTRAINT `curtas_acervo_ibfk_1` FOREIGN KEY (`acervo_id`) REFERENCES `acervos` (`id_acervo`);

--
-- Limitadores para a tabela `videos_acervo`
--
ALTER TABLE `videos_acervo`
  ADD CONSTRAINT `videos_acervo_ibfk_1` FOREIGN KEY (`acervo_id`) REFERENCES `acervos` (`id_acervo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
