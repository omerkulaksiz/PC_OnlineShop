-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 20. Jul 2025 um 03:16
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `webtech`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bestellungen`
--

CREATE TABLE `bestellungen` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `datum` datetime DEFAULT current_timestamp(),
  `gehaeuse_typ` varchar(255) DEFAULT NULL,
  `cpu_model` varchar(255) DEFAULT NULL,
  `ram_groesse` int(11) DEFAULT NULL,
  `zubehor_json` text DEFAULT NULL,
  `gesamtpreis` decimal(10,2) DEFAULT NULL,
  `kunde_name` varchar(255) DEFAULT NULL,
  `kunde_firma` varchar(255) DEFAULT NULL,
  `kunde_zusatz` varchar(255) DEFAULT NULL,
  `kunde_plz` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `bestellungen`
--

INSERT INTO `bestellungen` (`id`, `user_id`, `datum`, `gehaeuse_typ`, `cpu_model`, `ram_groesse`, `zubehor_json`, `gesamtpreis`, `kunde_name`, `kunde_firma`, `kunde_zusatz`, `kunde_plz`) VALUES
(12, 6, '2025-07-20 03:12:24', 'Maxi Tower', 'Core i5-12600K', 4, '[{\"id\":8,\"name\":\"USB-C Dockingstation\",\"preis\":75},{\"id\":3,\"name\":\"Multifunktions-Drucker\",\"preis\":149.99}]', 548.18, 'Omer Kulaksiz', NULL, 'Hanauer Str. 51', '61169'),
(13, 6, '2025-07-20 03:14:00', 'Maxi Tower', 'Ryzen 5 5600X', 64, '[{\"id\":8,\"name\":\"USB-C Dockingstation\",\"preis\":75},{\"id\":1,\"name\":\"Gaming-Maus\",\"preis\":49.99},{\"id\":2,\"name\":\"Mechanische Tastatur\",\"preis\":89}]', 555.18, 'Omer Kulaksiz', NULL, 'Hanauer Str. 51', '61169');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cpu`
--

CREATE TABLE `cpu` (
  `cpu_id` int(11) NOT NULL,
  `cpu_bz` varchar(60) NOT NULL,
  `cpu_hs` varchar(40) NOT NULL,
  `cpu_preis` int(11) NOT NULL,
  `cpu_mram` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `cpu`
--

INSERT INTO `cpu` (`cpu_id`, `cpu_bz`, `cpu_hs`, `cpu_preis`, `cpu_mram`) VALUES
(1, 'Ryzen 5 5600X', 'AMD', 200, 128),
(2, 'Ryzen 7 5800X', 'AMD', 320, 96),
(3, 'Ryzen 9 5900X', 'AMD', 450, 256),
(4, 'Core i5-12600K', 'Intel', 230, 32),
(5, 'Core i9-12900K', 'Intel', 500, 128),
(6, 'Core i7-12700K', 'Intel', 350, 64);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `anrede` varchar(20) NOT NULL,
  `vorname` varchar(40) NOT NULL,
  `nachname` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `firmenname` varchar(40) DEFAULT NULL,
  `zusatz` varchar(40) NOT NULL,
  `plz` varchar(10) NOT NULL,
  `passwort` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `anrede`, `vorname`, `nachname`, `email`, `firmenname`, `zusatz`, `plz`, `passwort`) VALUES
(6, 'Herr', 'Omer', 'Kulaksiz', 'omer.faruk.kulaksiz@outlook.com', NULL, 'Hanauer Str. 51', '61169', '$2y$10$X2Lf37xwlNODc2q5kqkfqOZEYF1hyYkWUXN0bYUY7zl.FCKy0IJmm'),
(11, 'Herr', 'testuser', 'nachnamed', 'test@test.com', NULL, 'Hanauer Str. 51', '61169', '$2y$10$KUM88uiFEwGDhVCYLpc5CuSCiJK9K6OP2Qyxg2eNFyqpnd90PZq6.');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zubehor`
--

CREATE TABLE `zubehor` (
  `z_id` int(11) NOT NULL,
  `z_name` varchar(255) NOT NULL,
  `z_bs` varchar(255) NOT NULL,
  `z_kategorie` varchar(255) NOT NULL,
  `z_preis` decimal(10,2) NOT NULL,
  `z_bild` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `zubehor`
--

INSERT INTO `zubehor` (`z_id`, `z_name`, `z_bs`, `z_kategorie`, `z_preis`, `z_bild`) VALUES
(1, 'Gaming-Maus', 'Präzise, ergonomische Maus mit RGB-Beleuchtung', 'Eingabegerät', 49.99, 'img\\products\\extras\\mouse.png'),
(2, 'Mechanische Tastatur', 'Mechanische Tastatur mit Hintergrundbeleuchtung', 'Eingabegerät', 89.00, 'img\\products\\extras\\keyboard.avif'),
(3, 'Multifunktions-Drucker', 'Farbdrucker, Scanner und Kopierer in einem', 'Drucker', 149.99, 'img\\products\\extras\\drucker.avif'),
(4, 'Externe SSD 1TB', 'Schnelle, portable SSD mit 1TB Speicherkapazität', 'Speicher', 109.90, 'img\\products\\extras\\ssd.jpg'),
(5, 'Gehäuse-Lüfter RGB', 'Leistungsstarker, leiser Lüfter mit RGB-Licht', 'Kühlung', 15.50, 'img\\products\\extras\\lufter.png'),
(6, 'High-End Grafikkarte', 'Dedizierte Grafikkarte für Gaming & Workstation', 'Grafikkarte', 499.00, 'img\\products\\extras\\grafik.webp'),
(7, 'Gehäusefarbe Rot', 'Optionales Gehäuse in auffälligem Rot', 'Gehäuse', 39.00, 'img\\products\\extras\\red.jpg'),
(8, 'USB-C Dockingstation', 'Dockingstation mit HDMI, USB, und Netzwerkanschluss', 'Dockingstation', 75.00, 'img\\products\\extras\\dock.jpg'),
(9, 'Externe Festplatte 2TB', 'Mobile HDD mit 2TB Speicherkapazität', 'Speicher', 69.99, 'img\\products\\extras\\ssd2.jpg'),
(10, 'Kabelloser Adapter', 'WLAN/Bluetooth-Dongle für kabellose Verbindung', 'Netzwerk', 20.00, 'img\\products\\extras\\dongle.jpg');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `bestellungen`
--
ALTER TABLE `bestellungen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `cpu`
--
ALTER TABLE `cpu`
  ADD PRIMARY KEY (`cpu_id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `zubehor`
--
ALTER TABLE `zubehor`
  ADD PRIMARY KEY (`z_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `bestellungen`
--
ALTER TABLE `bestellungen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT für Tabelle `cpu`
--
ALTER TABLE `cpu`
  MODIFY `cpu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT für Tabelle `zubehor`
--
ALTER TABLE `zubehor`
  MODIFY `z_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `bestellungen`
--
ALTER TABLE `bestellungen`
  ADD CONSTRAINT `bestellungen_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
