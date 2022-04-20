-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2022 at 10:00 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestionale`
--

-- --------------------------------------------------------

--
-- Table structure for table `armadietti`
--

CREATE TABLE `armadietti` (
  `ID_Armadietto` int(5) NOT NULL,
  `nomeArmadietto` varchar(40) NOT NULL,
  `ripiani` int(1) DEFAULT NULL,
  `numPorte` int(1) DEFAULT NULL,
  `larghezza` int(2) DEFAULT NULL,
  `lunghezza` int(2) DEFAULT NULL,
  `altezza` int(2) DEFAULT NULL,
  `ID_Locale` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `componenti`
--

CREATE TABLE `componenti` (
  `ID_Componente` int(5) NOT NULL,
  `nomeComp` varchar(40) NOT NULL,
  `sigla` varchar(30) DEFAULT NULL,
  `catalogo` varchar(50) DEFAULT NULL,
  `rifCatalogo` varchar(30) DEFAULT NULL,
  `valore` decimal(10,2) DEFAULT NULL,
  `umValore` varchar(10) DEFAULT NULL,
  `valore2` decimal(10,2) DEFAULT NULL,
  `umValore2` varchar(10) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `immagine` varchar(255) DEFAULT NULL,
  `quantitaMin` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `giacenze`
--

CREATE TABLE `giacenze` (
  `ID_Giacenza` int(5) NOT NULL,
  `posizione` varchar(30) DEFAULT NULL,
  `nomeCassetto` varchar(30) DEFAULT NULL,
  `quantita` int(4) NOT NULL,
  `prezzoPrecedente` decimal(7,2) DEFAULT NULL,
  `prezzoUltimoAcquisto` decimal(7,2) DEFAULT NULL,
  `fornitore` varchar(50) DEFAULT NULL,
  `numeroFattura` varchar(30) DEFAULT NULL,
  `dataUltimoAcquisto` date DEFAULT NULL,
  `ID_Armadietto` int(5) DEFAULT NULL,
  `ID_Componente` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `locali`
--

CREATE TABLE `locali` (
  `ID_Locale` int(5) NOT NULL,
  `locale` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `locali`
--

INSERT INTO `locali` (`ID_Locale`, `locale`) VALUES
(1, 'provaLocale');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID_User` int(5) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `mail` varchar(76) NOT NULL,
  `liv` tinyint(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID_User`, `nome`, `cognome`, `mail`, `liv`) VALUES
(2, 'martim', 'jorgesalati', 'jorgesalati.martim@darzo.net', 1),
(4, 'salati', 'jorgemartim', 'jorgemartim.salati@darzo.net', 1),
(5, 'salati', 'jorge', 'prof.jorge.salati@darzo.net', 5),
(6, 'salati', 'jorgesalati', 'jorgesalati.salati@darzo.net', 1),
(9, 'hhshs', 'mmma', 'mmma.hhshs@darzo.net', 1),
(13, 'don', 'john', 'john.don@darzo.net', 10),
(14, 'safgh', 'sshdf', 'sshdf.safgh@darzo.net', 1),
(15, 'sajhjassa', 'nshhsaj', 'nshhsaj.sajhjassa@darzo.net', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `armadietti`
--
ALTER TABLE `armadietti`
  ADD PRIMARY KEY (`ID_Armadietto`),
  ADD KEY `ID_Locale` (`ID_Locale`);

--
-- Indexes for table `componenti`
--
ALTER TABLE `componenti`
  ADD PRIMARY KEY (`ID_Componente`);

--
-- Indexes for table `giacenze`
--
ALTER TABLE `giacenze`
  ADD PRIMARY KEY (`ID_Giacenza`),
  ADD KEY `ID_Armadietto` (`ID_Armadietto`),
  ADD KEY `ID_Componente` (`ID_Componente`) USING BTREE;

--
-- Indexes for table `locali`
--
ALTER TABLE `locali`
  ADD PRIMARY KEY (`ID_Locale`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID_User`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `armadietti`
--
ALTER TABLE `armadietti`
  MODIFY `ID_Armadietto` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `componenti`
--
ALTER TABLE `componenti`
  MODIFY `ID_Componente` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `giacenze`
--
ALTER TABLE `giacenze`
  MODIFY `ID_Giacenza` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locali`
--
ALTER TABLE `locali`
  MODIFY `ID_Locale` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID_User` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `armadietti`
--
ALTER TABLE `armadietti`
  ADD CONSTRAINT `armadietti_ibfk_1` FOREIGN KEY (`ID_Locale`) REFERENCES `locali` (`ID_Locale`);

--
-- Constraints for table `giacenze`
--
ALTER TABLE `giacenze`
  ADD CONSTRAINT `giacenze_ibfk_1` FOREIGN KEY (`ID_Armadietto`) REFERENCES `armadietti` (`ID_Armadietto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
