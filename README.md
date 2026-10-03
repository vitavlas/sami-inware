# InWare

InWare is a simple warehouse management system (WMS) built with plain PHP and MySQL. The application allows users to add, edit, view and delete products, as well as see low-stock warnings when the quantity of a product is running low.  

The project was developed as a practical PHP learning project without any frameworks.

## ✨ Features

- Product management. (Add, edit, view, and delete products).
- Low-stock monitoring
- Database design with MySQL table relationships using foreign keys
- Simple URL-based routing
- User input validation
- Wrong user input handling
- Error/success messages
- Basic protection against SQL injection
- User authentication
- Different user roles. (Admin-only product modification and deletion).

## 🧱 Project Structure

The project uses `index.php` as a simple front controller.

```
INWARE/
├── config/
│   ├── database.php
│   ├── helpers.php
│   └── routes.php
├── img/
│   └── warehouse-bg-wide.jpg
├── includes/
│   ├── card.php
│   ├── footer.php
│   ├── login.php
│   ├── main.php
│   └── sidebar.php
├── views/
│   ├── add_item.php
│   ├── delete_item.php
│   ├── edit_item.php
│   ├── home.php
│   ├── logout.php
│   └── product_details.php
├── .htaccess
├── favicon-32x32.png
├── favicon.svg
├── index.php
├── main.css
├── README.fi.md
└── README.md
```

### Main Components

- index.php — application entry point
- main.css — application styles
- config/ — project configuration (db connection, routes, helper functions etc.)
- includes/ — reusable page components
- views/ — application pages

## ⚙️ Settings

### Database

The application uses MySQL with the following tables: categories, products and users.

```sql
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 03, 2026 at 07:33 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inware`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES
(1, 'Metallimateriaalit', '2026-09-26 14:46:16'),
(2, 'Rakennustarvikkeet', '2026-09-26 14:46:16'),
(3, 'Työturvallisuus', '2026-09-26 14:46:16'),
(4, 'Toimistotekniikka', '2026-09-26 14:46:16'),
(5, 'Toimisto', '2026-09-26 14:46:16');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `category_id` int DEFAULT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_products_categories` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `category_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Teräslevy', 'Vahva teräslevy yleisiin metallitöihin, rakentamiseen ja valmistukseen.', 1, 18, 42.50, '2026-09-15 18:26:25', '2026-09-26 14:58:49'),
(2, 'Metalliputki rosteri 6m', 'Kestävä metalliputki erilaisiin rakennus- ja metallityöprojekteihin.', 1, 12, 24.90, '2026-09-15 18:26:25', '2026-09-26 14:58:49'),
(3, 'Metalliruuvi', 'Kestävä metalliruuvi yleisiin kiinnitystöihin ja metallirakenteisiin.', 1, 150, 0.20, '2026-09-15 18:26:25', '2026-09-26 20:34:15'),
(4, 'Mutteri', 'Metallinen mutteri tavallisiin kiinnitys- ja asennustöihin.', 1, 200, 0.15, '2026-09-15 18:26:25', '2026-09-26 14:58:49'),
(5, 'Hitsauskone HWD Welding', 'Helppokäyttöinen hitsauskone pieniin ja keskikokoisiin hitsaustöihin.', 1, 3, 349.00, '2026-09-15 18:26:25', '2026-09-26 14:58:49'),
(6, 'Vasara', 'Perinteinen vasara rakennus-, asennus- ja korjaustöihin.', 2, 14, 18.90, '2026-09-15 18:26:25', '2026-09-26 14:58:49'),
(7, 'Ruuvimeisseli', 'Kätevä ruuvimeisseli yleisiin asennus- ja korjaustöihin.', 2, 25, 9.90, '2026-09-15 18:26:25', '2026-09-26 14:58:49'),
(8, 'Porakone Milwaukee', 'Tehokas porakone poraamiseen ja ruuvaamiseen erilaisissa materiaaleissa.', 2, 5, 129.00, '2026-09-15 18:26:25', '2026-09-26 14:58:49'),
(9, 'Mittanauha 5m', 'Kätevä mittanauha tarkkoihin mittauksiin rakennus- ja asennustöissä.', 2, 18, 12.50, '2026-09-15 18:26:25', '2026-09-26 14:58:49'),
(10, 'Työhanskat', 'Kestävät työhanskat suojaavat käsiä erilaisissa työtehtävissä ja tarjoavat hyvän otteen työkaluista.', 3, 30, 6.90, '2026-09-15 18:26:25', '2026-09-26 14:58:49'),
(11, 'Suojalasit', 'Suojalasit silmien suojaamiseen pölyltä ja pieniltä kappaleilta.', 3, 12, 8.90, '2026-09-15 18:26:25', '2026-09-26 14:58:49'),
(12, 'Suojakypärä', 'Kestävä suojakypärä pään suojaamiseen työympäristössä.', 3, 6, 14.90, '2026-09-15 18:26:25', '2026-09-26 14:58:49'),
(13, 'Kannettava tietokone Lenovo ThinkPad', 'Monipuolinen kannettava tietokone toimisto- ja työskentelykäyttöön.', 4, 4, 799.00, '2026-09-15 18:26:25', '2026-09-26 14:58:49'),
(14, 'Näyttö Dell', 'Laadukas näyttö päivittäiseen toimisto- ja tietokonetyöskentelyyn.', 4, 7, 189.00, '2026-09-15 18:26:25', '2026-09-26 14:58:49'),
(15, 'Näppäimistö Dell', 'Langallinen näppäimistö päivittäiseen toimisto- ja tietokonetyöskentelyyn.', 4, 15, 39.90, '2026-09-15 18:26:25', '2026-09-26 14:58:49'),
(16, 'Hiiri Logitech', 'Helppokäyttöinen hiiri päivittäiseen tietokoneen käyttöön.', 4, 20, 24.90, '2026-09-15 18:26:25', '2026-09-26 14:58:49'),
(17, 'Tulostin HP', 'Luotettava tulostin tavallisten toimistoasiakirjojen tulostamiseen.', 4, 3, 159.00, '2026-09-15 18:26:25', '2026-09-26 14:58:49'),
(18, 'Tulostuspaperi Canon A4', 'Valkoinen A4-tulostuspaperi päivittäiseen toimisto- ja tulostuskäyttöön.', 5, 40, 5.90, '2026-09-15 18:26:25', '2026-09-26 14:58:49'),
(19, 'Kuulokkeet Jabra', 'Mukavat kuulokkeet toimistotyöhön, verkkokokouksiin ja musiikin kuunteluun.', 4, 8, 49.90, '2026-09-15 18:26:25', '2026-09-26 14:58:49'),
(20, 'USB-C kaapeli', 'Kätevä USB-kaapeli laitteiden yhdistämiseen ja tiedonsiirtoon.', 4, 22, 8.90, '2026-09-15 18:26:25', '2026-09-26 14:58:49'),
(24, 'Kulmahiomakone', 'Tehokas kulmahiomakone metallin leikkaamiseen, hiontaan ja viimeistelyyn. Sopii hyvin erilaisiin metalli- ja rakennustöihin.', 2, 6, 119.58, '2026-09-26 14:07:36', '2026-09-26 14:58:49'),
(25, 'Kuulosuojaimet', 'Mukavat kuulosuojaimet suojaavat kuuloa meluisissa työympäristöissä. Sopivat esimerkiksi rakennus-, korjaus- ja tuotantotöihin.', 3, 16, 7.90, '2026-09-26 14:15:23', '2026-09-26 14:58:49'),
(26, 'Alumiinilevy', 'Kevyt ja kestävä alumiinilevy erilaisiin rakennus-, korjaus- ja metallityöprojekteihin.', 1, 14, 35.90, '2026-09-26 14:15:23', '2026-09-26 14:58:49'),
(28, 'Rullamitta', 'Tarkka ja kestävä mittausväline rakennus- ja asennustöihin. Helppo käyttää erilaisten etäisyyksien mittaamiseen.', 2, 98, 16.90, '2026-09-26 14:15:23', '2026-09-26 14:58:49'),
(29, 'Työkalupakki', 'Tilava työkalupakki työkalujen ja pienten tarvikkeiden säilyttämiseen ja kuljettamiseen työmaalla tai työpajassa.', 2, 7, 39.90, '2026-09-26 14:15:23', '2026-09-28 21:51:07'),
(30, 'Hengityssuojain', 'Suojaava hengityssuojain vähentää pölyn ja muiden pienten hiukkasten pääsyä hengitysteihin erilaisissa työympäristöissä.', 3, 20, 12.90, '2026-09-26 14:15:23', '2026-09-26 14:58:49'),
(31, 'Webkamera', 'Helppokäyttöinen webkamera verkkokokouksiin, etätyöhön ja videopuheluihin. Sopii hyvin päivittäiseen toimistokäyttöön.', 4, 9, 59.90, '2026-09-26 14:15:23', '2026-09-26 14:58:49'),
(32, 'Kupariputki', 'Kestävä kupariputki erilaisiin asennus-, rakennus- ja teknisiin käyttötarkoituksiin.', 1, 18, 16.90, '2026-09-26 14:19:20', '2026-09-26 14:58:49'),
(34, 'Valkotaulu', 'Helposti pyyhittävä valkotaulu kokouksiin, suunnitteluun ja muistiinpanoihin. Selkeä ja käytännöllinen kirjoituspinta helpottaa ideoiden, tehtävien, suunnitelmien ja tärkeiden asioiden esittämistä. Valkotaulu sopii erinomaisesti toimistoihin, neuvottelutiloihin, koulutuksiin ja erilaisiin työympäristöihin. Sen avulla voidaan nopeasti kirjata muistiinpanoja, havainnollistaa prosesseja ja pitää tärkeät asiat näkyvillä koko työskentelyn ajan. Taulu on helppo puhdistaa käytön jälkeen, joten sitä voidaan käyttää uudelleen päivittäin.', 5, 5, 79.49, '2026-09-26 20:35:48', '2026-09-28 21:18:49'),
(35, 'Turvakengät', 'Vahvistetut turvakengät suojaamaan jalkoja työympäristön riskeiltä. Kestävät ja mukavat turvakengät sopivat erilaisiin työtehtäviin, joissa jalkojen suojaaminen ja hyvä käyttömukavuus ovat tärkeitä. Vankka rakenne auttaa suojaamaan jalkoja kolhuilta ja muilta työympäristön aiheuttamilta riskeiltä. Hyvin istuva rakenne tukee jalkoja työpäivän aikana ja tekee kengistä sopivat pitkäaikaiseen käyttöön. Turvakengät soveltuvat esimerkiksi rakennustyömaille, varastoihin, tuotantotiloihin ja muihin vaativiin työympäristöihin.', 3, 55, 300.00, '2026-09-28 21:17:48', '2026-09-28 21:17:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'Matti', 'Virtanen', 'matti', '$2y$10$TAfIOKwrR5xNDzhwj6YMmOy7oikZrTHDgO9EadOUlvueJZvNHFK6G', 'user', '2026-09-17 21:26:17'),
(2, 'Laura', 'Korhonen', 'laura', '$2y$10$TAfIOKwrR5xNDzhwj6YMmOy7oikZrTHDgO9EadOUlvueJZvNHFK6G', 'user', '2026-09-17 21:26:17'),
(3, 'Antti', 'Nieminen', 'antti', '$2y$10$TAfIOKwrR5xNDzhwj6YMmOy7oikZrTHDgO9EadOUlvueJZvNHFK6G', 'admin', '2026-09-17 21:26:17');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
```

### Database Connection

Update the database connection settings in config/database.php according to **your** local MySQL environment.

## 🚀 Getting Started

The project can be run using a local environment such as WAMP.

1. Clone the repository [https://github.com/vitavlas/sami-inware.git](https://github.com/vitavlas/sami-inware.git).
2. Create a MySQL database named `inware`.
3. Import the SQL file as described in **Settings → Database**.
4. Open the project through your local web server.

## 💡 Notes

### Languages

[English](README.md) | [Suomi](README.fi.md)