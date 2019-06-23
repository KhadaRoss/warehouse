-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 17. Jun 2019 um 00:55
-- Server-Version: 10.1.40-MariaDB
-- PHP-Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `warehouse`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fields`
--

CREATE TABLE `fields` (
  `id` int(9) NOT NULL,
  `shelfId` int(9) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `products`
--

CREATE TABLE `products` (
  `id` int(9) NOT NULL,
  `fieldId` int(9) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `productGroup` varchar(255) DEFAULT NULL,
  `comment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shelves`
--

CREATE TABLE `shelves` (
  `id` int(9) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `strings`
--

CREATE TABLE `strings` (
  `id` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `language` enum('de','en') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `string` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `strings`
--

INSERT INTO `strings` (`id`, `language`, `string`) VALUES
('AUTHENTICATION_FAILED', 'de', 'Login fehlgeschlagen'),
('DELETE_FIELD_HEADLINE', 'de', 'Fach löschen?'),
('DELETE_FIELD_MESSAGE_1', 'de', 'Soll das ausgewählte Fach wirklich gelöscht werden?\r\n'),
('DELETE_FIELD_MESSAGE_2', 'de', 'Die Produkte innerhalb des Fachs werden ebenfalls gelöscht.'),
('DELETE_NO', 'de', 'Abbrechen'),
('DELETE_SHELF_HEADLINE', 'de', 'Schrank löschen?'),
('DELETE_SHELF_MESSAGE_1', 'de', 'Soll der derzeitige Schrank wirklich gelöscht werden?\r\n'),
('DELETE_SHELF_MESSAGE_2', 'de', 'Die Produkte innerhalb des Schranks werden ebenfalls gelöscht.'),
('DELETE_YES', 'de', 'Löschen'),
('ERROR', 'de', 'Fehler'),
('FIELD', 'de', 'Fach'),
('FIELD_DELETE', 'de', 'Fach löschen'),
('FIELD_NEW', 'de', 'Neues Fach anlegen'),
('LOGIN', 'de', 'Einloggen'),
('LOGOUT', 'de', 'Ausloggen'),
('NEW', 'de', 'Neuen Schrank anlegen'),
('NEW_PRODUCT', 'de', 'Produkt hinzufügen'),
('PASSWORD', 'de', 'Passwort'),
('PRODUCT_ADD_HEADER', 'de', 'Produkt hinzufügen'),
('PRODUCT_COMMENT', 'de', 'Beschreibung'),
('PRODUCT_DATE', 'de', 'Verfallsdatum'),
('PRODUCT_GROUP', 'de', 'Gruppe'),
('PRODUCT_INFORMATION', 'de', 'Produktinformationen'),
('PRODUCT_NAME', 'de', 'Bezeichnung'),
('PRODUCT_NO', 'de', 'Abbrechen'),
('PRODUCT_QUANTITY', 'de', 'Menge'),
('PRODUCT_UPDATE_YES', 'de', 'Übernehmen'),
('PRODUCT_YES', 'de', 'Hinzufügen'),
('SEARCH', 'de', 'Produkt suchen'),
('SEARCH_HEADLINE', 'de', 'Suchergebnisse für'),
('SHELF', 'de', 'Schrank'),
('TITLE', 'de', 'Warenlager'),
('USERNAME', 'de', 'Benutzername'),
('WAREHOUSE', 'de', 'Warenlager');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `userId` int(9) NOT NULL,
  `username` varchar(255) COLLATE utf8_bin NOT NULL,
  `passwordHash` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`userId`, `username`, `passwordHash`) VALUES
(1, 'test', '$2y$10$NxCFhs7gG2bqscqJPHUMj.4thIGIPulcoDYulHAAWZ5nsh.shTLg2');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `shelves`
--
ALTER TABLE `shelves`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `strings`
--
ALTER TABLE `strings`
  ADD PRIMARY KEY (`id`,`language`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `fields`
--
ALTER TABLE `fields`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT für Tabelle `products`
--
ALTER TABLE `products`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `shelves`
--
ALTER TABLE `shelves`
  MODIFY `id` int(9) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
