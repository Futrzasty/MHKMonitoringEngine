-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 26 Lis 2015, 15:35
-- Wersja serwera: 5.5.44
-- Wersja PHP: 5.4.44-0+deb7u1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Baza danych: `remote`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `hosts`
--

CREATE TABLE IF NOT EXISTS `hosts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `ip` varchar(15) COLLATE utf8_polish_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `type` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `value` decimal(10,3) DEFAULT NULL,
  `value_last` decimal(10,3) DEFAULT NULL,
  `value2` decimal(10,3) DEFAULT NULL,
  `value2_last` decimal(10,3) DEFAULT NULL,
  `last_check` timestamp NULL DEFAULT NULL,
  `last_change` timestamp NULL DEFAULT NULL,
  `probe_cmd` varchar(1000) COLLATE utf8_polish_ci DEFAULT NULL,
  `disabled` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;