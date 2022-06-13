-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 18, 2022 alle 09:05
-- Versione del server: 10.4.21-MariaDB
-- Versione PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestioneazienda`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `dipartimento`
--

CREATE TABLE `dipartimento` (
  `nome` varchar(50) NOT NULL,
  `indirizzo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `dipartimento`
--

INSERT INTO `dipartimento` (`nome`, `indirizzo`) VALUES
('Gestionale', 'Milano,20011,Via Filippo 78'),
('Inscatolamento', 'Milano,20011,Via Turati 75'),
('Smistamento', 'Milano,20011,Via Filippo 78');

-- --------------------------------------------------------

--
-- Struttura della tabella `invitato`
--

CREATE TABLE `invitato` (
  `id` int(11) NOT NULL,
  `emailutente` varchar(50) NOT NULL,
  `risposta` set('Accetto','Rifiuto') DEFAULT NULL,
  `motivazione` text DEFAULT NULL,
  `datainvito` date NOT NULL,
  `datariunione` date NOT NULL,
  `orainizio` varchar(50) NOT NULL,
  `nomesalariunione` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `invitato`
--

INSERT INTO `invitato` (`id`, `emailutente`, `risposta`, `motivazione`, `datainvito`, `datariunione`, `orainizio`, `nomesalariunione`) VALUES
(4, 'root@gmail.com', 'Accetto', NULL, '2021-12-21', '2022-05-19', '13:00', 'Sala inscatolamento'),
(5, 'root@gmail.com', 'Rifiuto', 'Motivi personali', '2021-12-24', '2021-11-17', '13:00', 'Sala gestionale'),
(46, 'federico.bruzzone@gmail.com', 'Accetto', NULL, '2022-01-07', '2022-06-01', '10:00', 'Sala gestionale'),
(47, 'francesco.rizzo@gmail.com', NULL, NULL, '2022-01-07', '2022-06-01', '10:00', 'Sala gestionale'),
(48, 'riccardo.cavalli@gmail.com', NULL, NULL, '2022-01-07', '2022-06-01', '10:00', 'Sala gestionale'),
(60, 'root@gmail.com', NULL, NULL, '2022-01-18', '2022-10-05', '10:00', 'Sala inscatolamento'),
(61, 'luca.bellani@gmail.com', NULL, NULL, '2022-01-18', '2022-10-05', '10:00', 'Sala inscatolamento'),
(62, 'riccardo.cavalli@gmail.com', NULL, NULL, '2022-01-18', '2022-10-05', '10:00', 'Sala inscatolamento');

-- --------------------------------------------------------

--
-- Struttura della tabella `riunione`
--

CREATE TABLE `riunione` (
  `data` date NOT NULL,
  `orainizio` varchar(50) NOT NULL,
  `nomesalariunione` varchar(50) NOT NULL,
  `durata` int(11) NOT NULL,
  `tema` varchar(50) NOT NULL,
  `emailutente` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `riunione`
--

INSERT INTO `riunione` (`data`, `orainizio`, `nomesalariunione`, `durata`, `tema`, `emailutente`) VALUES
('2021-11-17', '13:00', 'Sala gestionale', 20, 'Meeting Lavorativo', 'mario.rossi@gmail.com'),
('2022-01-07', '10:01', 'Sala gestionale', 1, 'prova', 'federico.bruzzone@gmail.com'),
('2022-05-19', '13:00', 'Sala inscatolamento', 3, 'Inscatolamento', 'riccardo.cavalli@gmail.com'),
('2022-06-01', '10:00', 'Sala gestionale', 1, 'Gesionale', 'root@gmail.com'),
('2022-10-05', '10:00', 'Sala inscatolamento', 30, 'Gestione inscatolamento', 'federico.bruzzone@gmail.com');

-- --------------------------------------------------------

--
-- Struttura della tabella `salariunione`
--

CREATE TABLE `salariunione` (
  `nome` varchar(50) NOT NULL,
  `capienza` int(11) NOT NULL,
  `computer` int(11) NOT NULL,
  `lavagne` int(11) NOT NULL,
  `proiettori` int(11) NOT NULL,
  `nomedipartimento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `salariunione`
--

INSERT INTO `salariunione` (`nome`, `capienza`, `computer`, `lavagne`, `proiettori`, `nomedipartimento`) VALUES
('Sala gestionale', 50, 3, 0, 6, 'Gestionale'),
('Sala inscatolamento', 3, 1, 1, 1, 'Inscatolamento'),
('Sala smistamento', 15, 2, 1, 0, 'Smistamento');

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `datanascita` date NOT NULL,
  `tipo` set('Direttore','Impiegato') DEFAULT NULL,
  `ruolo` set('Funzionario','Impiegato semplice','Capo settore') DEFAULT NULL,
  `dataruolo` date DEFAULT NULL,
  `anniservizio` int(11) DEFAULT NULL,
  `dataautorizzazione` date DEFAULT NULL,
  `emaildirettore` varchar(50) DEFAULT NULL,
  `nomedipartimento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`email`, `password`, `nome`, `cognome`, `foto`, `datanascita`, `tipo`, `ruolo`, `dataruolo`, `anniservizio`, `dataautorizzazione`, `emaildirettore`, `nomedipartimento`) VALUES
('carlo.carissimi@gmail.com', '', 'Carlo', 'Carissimi', '-', '1990-02-23', 'Impiegato', 'Impiegato semplice', NULL, NULL, NULL, NULL, 'Smistamento'),
('federico.bruzzone@gmail.com', 'federicobruzzone', 'Federico', 'Bruzzone', '-', '2000-10-01', 'Impiegato', 'Capo settore', NULL, NULL, '2021-12-07', 'root@gmail.com', 'Gestionale'),
('federico.gialli@gmail.com', '', 'Federico', 'Gialli', '', '1960-10-01', 'Direttore', NULL, '2021-10-21', 5, NULL, NULL, 'Smistamento'),
('filippo.caroni@gmail.com', '', 'Filippo', 'Caroni', '-', '2001-10-20', 'Impiegato', 'Impiegato semplice', NULL, NULL, NULL, NULL, 'Inscatolamento'),
('francesco.rizzo@gmail.com', 'francescorizzo', 'Francesco', 'Rizzo', '-', '2001-10-08', 'Impiegato', 'Capo settore', NULL, NULL, NULL, NULL, 'Inscatolamento'),
('giovanni.corallo@gmail.com', '', 'Giovanni', 'Corallo', '-', '2000-05-12', 'Impiegato', 'Impiegato semplice', NULL, NULL, NULL, NULL, 'Gestionale'),
('leonardo.tommaselli@gmail.com', '', 'Leonardo', 'Tommaselli', '-', '2004-10-31', 'Impiegato', 'Funzionario', NULL, NULL, '2021-12-30', 'root@gmail.com', 'Smistamento'),
('luca.bellani@gmail.com', 'lucabellani', 'Luca', 'Bellani', '-', '2002-08-12', 'Impiegato', 'Funzionario', NULL, NULL, NULL, NULL, 'Inscatolamento'),
('mario.rossi@gmail.com', '', 'Mario', 'Rossi', '-', '1996-10-01', 'Direttore', NULL, '2015-10-08', 5, NULL, NULL, 'Gestionale'),
('paolo.verdi@gmail.com', '', 'Paolo', 'Verdi', '-', '1998-10-16', 'Direttore', NULL, '2018-10-24', 3, NULL, NULL, 'Inscatolamento'),
('riccardo.cavalli@gmail.com', 'riccardocavalli', 'Riccardo', 'Cavalli', '-', '2000-11-10', 'Impiegato', 'Capo settore', NULL, NULL, '2021-12-29', 'root@gmail.com', 'Smistamento'),
('riccardo.dellalonga@gmail.com', '', 'Riccardo', 'Della Longa', '-', '2003-05-08', 'Impiegato', 'Funzionario', NULL, NULL, NULL, NULL, 'Gestionale'),
('root@gmail.com', 'root', 'root', 'root', '', '2000-01-25', 'Direttore', '', '2021-03-24', 5, NULL, NULL, 'Gestionale');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `dipartimento`
--
ALTER TABLE `dipartimento`
  ADD PRIMARY KEY (`nome`) USING BTREE;

--
-- Indici per le tabelle `invitato`
--
ALTER TABLE `invitato`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `datariunione` (`datariunione`,`orainizio`,`nomesalariunione`),
  ADD KEY `emailutente` (`emailutente`);

--
-- Indici per le tabelle `riunione`
--
ALTER TABLE `riunione`
  ADD PRIMARY KEY (`data`,`orainizio`,`nomesalariunione`),
  ADD KEY `nomesalariunione` (`nomesalariunione`),
  ADD KEY `emailutente` (`emailutente`);

--
-- Indici per le tabelle `salariunione`
--
ALTER TABLE `salariunione`
  ADD PRIMARY KEY (`nome`),
  ADD KEY `nomedipatimento` (`nomedipartimento`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`email`),
  ADD KEY `nomedipartimento` (`nomedipartimento`) USING BTREE;

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `invitato`
--
ALTER TABLE `invitato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `invitato`
--
ALTER TABLE `invitato`
  ADD CONSTRAINT `invitato_ibfk_1` FOREIGN KEY (`datariunione`,`orainizio`,`nomesalariunione`) REFERENCES `riunione` (`data`, `orainizio`, `nomesalariunione`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invitato_ibfk_2` FOREIGN KEY (`emailutente`) REFERENCES `utente` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `riunione`
--
ALTER TABLE `riunione`
  ADD CONSTRAINT `riunione_ibfk_1` FOREIGN KEY (`nomesalariunione`) REFERENCES `salariunione` (`nome`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `riunione_ibfk_2` FOREIGN KEY (`emailutente`) REFERENCES `utente` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `salariunione`
--
ALTER TABLE `salariunione`
  ADD CONSTRAINT `salariunione_ibfk_1` FOREIGN KEY (`nomedipartimento`) REFERENCES `dipartimento` (`nome`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `utente`
--
ALTER TABLE `utente`
  ADD CONSTRAINT `utente_ibfk_1` FOREIGN KEY (`nomedipartimento`) REFERENCES `dipartimento` (`nome`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
