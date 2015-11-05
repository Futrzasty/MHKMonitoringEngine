-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 05 Lis 2015, 15:16
-- Wersja serwera: 5.5.44
-- Wersja PHP: 5.4.44-0+deb7u1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Baza danych: `monitoring`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `http_content`
--

CREATE TABLE IF NOT EXISTS `http_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `alias` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `checked_text` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `order` int(11) DEFAULT NULL,
  `state` int(11) NOT NULL,
  `value_cur` int(11) DEFAULT NULL,
  `value_last` int(11) DEFAULT NULL,
  `last_change` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `link_bytoken`
--

CREATE TABLE IF NOT EXISTS `link_bytoken` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `link` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `token` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `order` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `last_change` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nrpe_serv`
--

CREATE TABLE IF NOT EXISTS `nrpe_serv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `host` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `alias` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `probe_type` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `order` int(11) DEFAULT NULL,
  `value0` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `value1` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `value2` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `value3` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `last_change` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ping_ipsec`
--

CREATE TABLE IF NOT EXISTS `ping_ipsec` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `ip` varchar(15) COLLATE utf8_polish_ci DEFAULT '0.0.0.0',
  `alias` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `abbr` varchar(4) COLLATE utf8_polish_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `ping_avg` decimal(10,3) DEFAULT NULL,
  `ping_last` decimal(10,3) DEFAULT NULL,
  `last_change` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `disabled` int(11) NOT NULL DEFAULT '0',
  `isp` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ping_ipsec_branches`
--

CREATE TABLE IF NOT EXISTS `ping_ipsec_branches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `host` int(11) DEFAULT NULL,
  `net_type` enum('LAN','POSTAL','PSTN','WAN') COLLATE utf8_polish_ci DEFAULT NULL,
  `net_name` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `net_address` varchar(500) COLLATE utf8_polish_ci DEFAULT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ping_ipsec_history`
--

CREATE TABLE IF NOT EXISTS `ping_ipsec_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `status` varchar(10) COLLATE utf8_polish_ci DEFAULT NULL,
  `change_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ping_other`
--

CREATE TABLE IF NOT EXISTS `ping_other` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `alias` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `ping_avg` decimal(10,3) DEFAULT NULL,
  `ping_last` decimal(10,3) DEFAULT NULL,
  `last_change` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `disabled` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ping_other_history`
--

CREATE TABLE IF NOT EXISTS `ping_other_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `status` varchar(10) COLLATE utf8_polish_ci DEFAULT NULL,
  `change_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `printer_snmp`
--

CREATE TABLE IF NOT EXISTS `printer_snmp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `host` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `alias` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `community` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `state` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  `value` varchar(500) COLLATE utf8_polish_ci DEFAULT NULL,
  `full_info` varchar(1500) COLLATE utf8_polish_ci DEFAULT NULL,
  `last_change` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `printer_snmp_details`
--

CREATE TABLE IF NOT EXISTS `printer_snmp_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `host` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `value` decimal(10,2) DEFAULT NULL,
  `value_raw` decimal(10,2) DEFAULT NULL,
  `value_max` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `router_ping`
--

CREATE TABLE IF NOT EXISTS `router_ping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `host` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `alias` varchar(500) COLLATE utf8_polish_ci DEFAULT NULL,
  `state` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  `value` decimal(10,3) DEFAULT NULL,
  `last_change` timestamp NULL DEFAULT NULL,
  `impact` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `snmp_env`
--

CREATE TABLE IF NOT EXISTS `snmp_env` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `host` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `alias` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `param` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `community` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `oid` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `order` int(11) DEFAULT NULL,
  `value` double DEFAULT NULL,
  `divider` float NOT NULL DEFAULT '1',
  `th_lo_crit` double DEFAULT NULL,
  `th_lo_warn` double DEFAULT NULL,
  `th_hi_warn` double DEFAULT NULL,
  `th_hi_crit` double DEFAULT NULL,
  `rrd_file` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  `rrd_index` int(11) DEFAULT NULL,
  `last_change` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `switch_ping`
--

CREATE TABLE IF NOT EXISTS `switch_ping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `host` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `alias` varchar(500) COLLATE utf8_polish_ci DEFAULT NULL,
  `state` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  `value` decimal(10,3) DEFAULT NULL,
  `last_change` timestamp NULL DEFAULT NULL,
  `impact` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wireless_ping`
--

CREATE TABLE IF NOT EXISTS `wireless_ping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `host` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `alias` varchar(500) COLLATE utf8_polish_ci DEFAULT NULL,
  `state` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  `value` decimal(10,3) DEFAULT NULL,
  `last_change` timestamp NULL DEFAULT NULL,
  `impact` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
