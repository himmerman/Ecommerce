-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 18, 2015 at 02:21 PM
-- Server version: 5.5.42-37.1
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kingbeng_techpro`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `id` int(11) NOT NULL,
  `streetAddress` varchar(65) NOT NULL,
  `city` varchar(65) NOT NULL,
  `zip` varchar(5) NOT NULL,
  `state` varchar(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `streetAddress`, `city`, `zip`, `state`) VALUES
(19, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `content` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL,
  `firstName` varchar(45) NOT NULL,
  `lastName` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) DEFAULT NULL,
  `lastLoggedIn` datetime DEFAULT NULL,
  `address_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `firstName`, `lastName`, `email`, `password`, `lastLoggedIn`, `address_id`) VALUES
(19, '', '', '', NULL, NULL, 19);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL,
  `productCode` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` text,
  `photo` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `price` int(11) unsigned NOT NULL COMMENT 'Price in cents',
  `sale_price` int(11) unsigned DEFAULT NULL,
  `is_on_sale` tinyint(1) DEFAULT '0',
  `quantity` int(11) unsigned NOT NULL,
  `height` decimal(10,1) unsigned DEFAULT NULL,
  `width` decimal(10,1) unsigned DEFAULT NULL,
  `depth` decimal(10,2) unsigned DEFAULT NULL,
  `createdBy` int(11) NOT NULL,
  `featured` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `productCode`, `name`, `description`, `photo`, `tags`, `price`, `sale_price`, `is_on_sale`, `quantity`, `height`, `width`, `depth`, `createdBy`, `featured`) VALUES
(153, '1618L', '16" X 18" - Large', '<p>The 16″X18″ bag is perfect for laptops, power inverters, battery chargers, diffusers, power tool, etc... This Faraday bag features an outstanding 38-pound puncture resistance.</p>\n\n<p>The multiple layer construction provides full protection against ESD, EMI/RFI and tribocharging. Electrical Properties <strong>*EMI Shielding (MIL-B-81705-Rev-C): >40 db Between 1 & 10 GHz</strong></p>\n\n<p>It has always been the suggestion of Tech Protect to <strong>nest</strong> or place one bag inside of the other to give optimal protection against EMPs and Super EMPs.</p>\n\n<p>*Resistivity-Conductive Metal Layer (ASTM D-257): <2 Ohms/sq. in. avg. *Surface Resistivity (both surfaces) (ASTM I-257 @ 12% RH): <10 12 Ohms. sq. in. *Static Decay (FTMS 101C, Method 4046.1 5000 to 0 Volts): <0.05 Seconds *Capacitive Probe Test (High Voltage Discharge) – (EIA-std 541/Appendix E-1 KV): <8 Volts *Charge Generation-nominal (Modified incline plane Avg. nC/sq.in.):Teflon: -0.09 Quartz: +0.10 Physical Properties </p>\n\n<p><strong>*Total Thickness: 7.0 mils</strong> *Light Transmission (ASTM D-1003-77) <.01% </p>\n\n<p>*Tensile Strength (ASTM D882-83 Method A) 735 lbs. *Tear Strength: (D1004-66 – Notched) MD: 5.8 lbs.TD: 7.5 lbs. *Burst Strength (FTMS 101-C Method 2007 1a) >130 psi *Puncture Strength (FTMS 101-C Method A) >38 lbs. </p>\n\n<p>*Elongation (ASTM D822-83 Method A) MD: 40%TD: 74% *Heat Seal Strength (ASTM D-1876-72 Vertrod Sealer) >11 lbs./in width MVTR (ASTM F-1249 @ 100°F 100sq. in./24 hrs) <.0006 gms OTR (@ 100% Oxygen 100 sq. in./24 hrs) ASTM </p>\n\n<p>Because our Faraday Bag utilizes the most current metalizing technology, its moisture barrier performance exceeds foil laminates for low Moisture Vapor Transmission Rate (MVTR), particularly after flexing. In other words whatever you place in the bag and seal properly is going to stay dry also! </p>\n\n', 'http://techprotectbag.com/assets/images/products/1618L.jpg', '', 1795, 0, 0, 10, '18.0', '16.0', '0.00', 2, 0),
(154, '2030EL', '20" x 30"  Extra Large', '<p>The 20″X30″ bag is perfect for your laptop(all sizes), gaming systems, power tools, portable solar panels, portable solar generator, digital wheat grinders, large emergency radios, etc... This Faraday bag features an outstanding 38-pound puncture resistance.</p>\n\n<p>The multiple layer construction provides full protection against ESD, EMI/RFI and tribocharging. Electrical Properties <strong>*EMI Shielding (MIL-B-81705-Rev-C): >40 db Between 1 & 10 GHz</strong></p>\n\n<p>It has always been the suggestion of Tech Protect to <strong>nest</strong> or place one bag inside of the other to give optimal protection against EMPs and Super EMPs.</p>\n\n<p>*Resistivity-Conductive Metal Layer (ASTM D-257): <2 Ohms/sq. in. avg. *Surface Resistivity (both surfaces) (ASTM I-257 @ 12% RH): <10 12 Ohms. sq. in. *Static Decay (FTMS 101C, Method 4046.1 5000 to 0 Volts): <0.05 Seconds *Capacitive Probe Test (High Voltage Discharge) – (EIA-std 541/Appendix E-1 KV): <8 Volts *Charge Generation-nominal (Modified incline plane Avg. nC/sq.in.):Teflon: -0.09 Quartz: +0.10 Physical Properties </p>\n\n<p><strong>*Total Thickness: 7.0 mils</strong> *Light Transmission (ASTM D-1003-77) <.01% </p>\n\n<p>*Tensile Strength (ASTM D882-83 Method A) 735 lbs. *Tear Strength: (D1004-66 – Notched) MD: 5.8 lbs.TD: 7.5 lbs. *Burst Strength (FTMS 101-C Method 2007 1a) >130 psi *Puncture Strength (FTMS 101-C Method A) >38 lbs. </p>\n\n<p>*Elongation (ASTM D822-83 Method A) MD: 40%TD: 74% *Heat Seal Strength (ASTM D-1876-72 Vertrod Sealer) >11 lbs./in width MVTR (ASTM F-1249 @ 100°F 100sq. in./24 hrs) <.0006 gms OTR (@ 100% Oxygen 100 sq. in./24 hrs) ASTM </p>\n\n<p>Because our Faraday Bag utilizes the most current metalizing technology, its moisture barrier performance exceeds foil laminates for low Moisture Vapor Transmission Rate (MVTR), particularly after flexing. In other words whatever you place in the bag and seal properly is going to stay dry also! </p>\n\n', 'http://techprotectbag.com/assets/images/products/2030EL.png', '', 2095, 0, 0, 10, '30.0', '20.0', '0.00', 2, 0),
(155, '3238XXL', '32" x 38" XX-LARGE', '<p>The 32″X38″ bag is perfect for flat panel T.V’s (26″ shown in picture), computers, monitors, DVD/Blu Ray Players, small gas and diesel generators, medium solar generators, small solar panels and all accessories. This Faraday bag features an outstanding 38-pound puncture resistance.</p>\n\n<p>The multiple layer construction provides full protection against ESD, EMI/RFI and tribocharging. Electrical Properties <strong>*EMI Shielding (MIL-B-81705-Rev-C): >40 db Between 1 & 10 GHz</strong></p>\n\n<p>It has always been the suggestion of Tech Protect to <strong>nest</strong> or place one bag inside of the other to give optimal protection against EMPs and Super EMPs.</p>\n\n<p>*Resistivity-Conductive Metal Layer (ASTM D-257): <2 Ohms/sq. in. avg. *Surface Resistivity (both surfaces) (ASTM I-257 @ 12% RH): <10 12 Ohms. sq. in. *Static Decay (FTMS 101C, Method 4046.1 5000 to 0 Volts): <0.05 Seconds *Capacitive Probe Test (High Voltage Discharge) – (EIA-std 541/Appendix E-1 KV): <8 Volts *Charge Generation-nominal (Modified incline plane Avg. nC/sq.in.):Teflon: -0.09 Quartz: +0.10 Physical Properties </p>\n\n<p><strong>*Total Thickness: 7.0 mils</strong> *Light Transmission (ASTM D-1003-77) <.01% </p>\n\n<p>*Tensile Strength (ASTM D882-83 Method A) 735 lbs. *Tear Strength: (D1004-66 – Notched) MD: 5.8 lbs.TD: 7.5 lbs. *Burst Strength (FTMS 101-C Method 2007 1a) >130 psi *Puncture Strength (FTMS 101-C Method A) >38 lbs. </p>\n\n<p>*Elongation (ASTM D822-83 Method A) MD: 40%TD: 74% *Heat Seal Strength (ASTM D-1876-72 Vertrod Sealer) >11 lbs./in width MVTR (ASTM F-1249 @ 100°F 100sq. in./24 hrs) <.0006 gms OTR (@ 100% Oxygen 100 sq. in./24 hrs) ASTM </p>\n\n<p>Because our Faraday Bag utilizes the most current metalizing technology, its moisture barrier performance exceeds foil laminates for low Moisture Vapor Transmission Rate (MVTR), particularly after flexing. In other words whatever you place in the bag and seal properly is going to stay dry also! </p>\n', 'http://techprotectbag.com/assets/images/products/3238XXL.png', '', 4495, 0, 0, 10, '38.0', '32.0', '0.00', 2, 1),
(156, '816MD', '8" x 16" - Medium', '<p>The 8″X16″ bag is perfect for remotes, walkie talkies, flashlights and video cameras. This Faraday bag features an outstanding 38-pound puncture resistance.</p>\n\n<p>The multiple layer construction provides full protection against ESD, EMI/RFI and tribocharging. Electrical Properties <strong>*EMI Shielding (MIL-B-81705-Rev-C): >40 db Between 1 & 10 GHz</strong></p>\n\n<p>It has always been the suggestion of Tech Protect to <strong>nest</strong> or place one bag inside of the other to give optimal protection against EMPs and Super EMPs.</p>\n\n<p>*Resistivity-Conductive Metal Layer (ASTM D-257): <2 Ohms/sq. in. avg. *Surface Resistivity (both surfaces) (ASTM I-257 @ 12% RH): <10 12 Ohms. sq. in. *Static Decay (FTMS 101C, Method 4046.1 5000 to 0 Volts): <0.05 Seconds *Capacitive Probe Test (High Voltage Discharge) – (EIA-std 541/Appendix E-1 KV): <8 Volts *Charge Generation-nominal (Modified incline plane Avg. nC/sq.in.):Teflon: -0.09 Quartz: +0.10 Physical Properties </p>\n\n<p><strong>*Total Thickness: 7.0 mils</strong> *Light Transmission (ASTM D-1003-77) <.01% </p>\n\n<p>*Tensile Strength (ASTM D882-83 Method A) 735 lbs. *Tear Strength: (D1004-66 – Notched) MD: 5.8 lbs.TD: 7.5 lbs. *Burst Strength (FTMS 101-C Method 2007 1a) >130 psi *Puncture Strength (FTMS 101-C Method A) >38 lbs. </p>\n\n<p>*Elongation (ASTM D822-83 Method A) MD: 40%TD: 74% *Heat Seal Strength (ASTM D-1876-72 Vertrod Sealer) >11 lbs./in width MVTR (ASTM F-1249 @ 100°F 100sq. in./24 hrs) <.0006 gms OTR (@ 100% Oxygen 100 sq. in./24 hrs) ASTM </p>\n\n<p>Because our Faraday Bag utilizes the most current metalizing technology, its moisture barrier performance exceeds foil laminates for low Moisture Vapor Transmission Rate (MVTR), particularly after flexing. In other words whatever you place in the bag and seal properly is going to stay dry also! </p>\n\n', 'http://techprotectbag.com/assets/images/products/816MD.png', '', 895, 0, 0, 10, '16.0', '8.0', '0.00', 2, 0),
(157, '88sm', '8" x 8" - Small', '<p>The 8″X8″ bag is perfect for your cell phones, ipods, MP3, thumbdrives, GPS, hard drives, HAM Radios with antenna removed, red dot gun sights, LED flashlights, smaller cameras, etc... This Faraday bag features an outstanding 38-pound puncture resistance. </p>\n\n<p>The multiple layer construction provides full protection against ESD, EMI/RFI and tribocharging. Electrical Properties <strong>*EMI Shielding (MIL-B-81705-Rev-C): >40 db Between 1 & 10 GHz</strong></p>\n\n<p>It has always been the suggestion of Tech Protect to <strong>nest</strong> or place one bag inside of the other to give optimal protection against EMPs and Super EMPs.</p>\n\n<p>*Resistivity-Conductive Metal Layer (ASTM D-257): <2 Ohms/sq. in. avg. *Surface Resistivity (both surfaces) (ASTM I-257 @ 12% RH): <10 12 Ohms. sq. in. *Static Decay (FTMS 101C, Method 4046.1 5000 to 0 Volts): <0.05 Seconds *Capacitive Probe Test (High Voltage Discharge) – (EIA-std 541/Appendix E-1 KV): <8 Volts *Charge Generation-nominal (Modified incline plane Avg. nC/sq.in.):Teflon: -0.09 Quartz: +0.10 Physical Properties </p>\n\n<p><strong>*Total Thickness: 7.0 mils</strong> *Light Transmission (ASTM D-1003-77) <.01% </p>\n\n<p>*Tensile Strength (ASTM D882-83 Method A) 735 lbs. *Tear Strength: (D1004-66 – Notched) MD: 5.8 lbs.TD: 7.5 lbs. *Burst Strength (FTMS 101-C Method 2007 1a) >130 psi *Puncture Strength (FTMS 101-C Method A) >38 lbs. </p>\n\n<p>*Elongation (ASTM D822-83 Method A) MD: 40%TD: 74% *Heat Seal Strength (ASTM D-1876-72 Vertrod Sealer) >11 lbs./in width MVTR (ASTM F-1249 @ 100°F 100sq. in./24 hrs) <.0006 gms OTR (@ 100% Oxygen 100 sq. in./24 hrs) ASTM </p>\n\n<p>Because our Faraday Bag utilizes the most current metalizing technology, its moisture barrier performance exceeds foil laminates for low Moisture Vapor Transmission Rate (MVTR), particularly after flexing. In other words whatever you place in the bag and seal properly is going to stay dry also! </p>\n', 'http://techprotectbag.com/assets/images/products/88sm.jpg', '', 695, 0, 0, 10, '8.0', '8.0', '0.00', 2, 0),
(158, 'MVP', 'Mega Value pack', '<div>The Mega Value Pack is the best deal that we offer. At a combined value of $100, these items are a steal for only $79.95! This is a perfect solution for nesting bags to make sure you have the highest amount of protection possible.</div>\n<p></p>\n<h4>What’s included?</h4>\n<div><strong>1 XXL</strong> – The 32″x38″ bag is perfect for flat panel T.V’s (26″ shown in picture), computers, computer monitors, and all accessories.</div>\n<div><strong>1 XL</strong> – The 20″x30″ bag is perfect for your laptop(all sizes), gaming systems, radios and extra accessories.</div>\n<div><strong>1 Large </strong>- The 16″x18″ bag fits all of your medium sized items.</div>\n<div><strong>1 Medium</strong> – The 8″x16″ bag is perfect for remotes, walkie talkies, flashlights and video cameras.</div>\n<div><strong>1 Small</strong> – The 8″X8″ bag is perfect for your cell phones, ipods, MP3, thumbdrives, GPS and smaller cameras.</div>\n<p></p>\n<h4> Specifications</h4>\n<p>The multiple layer construction provides full protection against ESD, EMI/RFI and tribocharging. Electrical Properties <strong>*EMI Shielding (MIL-B-81705-Rev-C): >40 db Between 1 & 10 GHz</strong></p>\n\n<p>It has always been the suggestion of Tech Protect to <strong>nest</strong> or place one bag inside of the other to give optimal protection against EMPs and Super EMPs.</p>\n\n<p>*Resistivity-Conductive Metal Layer (ASTM D-257): <2 Ohms/sq. in. avg. *Surface Resistivity (both surfaces) (ASTM I-257 @ 12% RH): <10 12 Ohms. sq. in. *Static Decay (FTMS 101C, Method 4046.1 5000 to 0 Volts): <0.05 Seconds *Capacitive Probe Test (High Voltage Discharge) – (EIA-std 541/Appendix E-1 KV): <8 Volts *Charge Generation-nominal (Modified incline plane Avg. nC/sq.in.):Teflon: -0.09 Quartz: +0.10 Physical Properties </p>\n\n<p><strong>*Total Thickness: 7.0 mils</strong> *Light Transmission (ASTM D-1003-77) <.01% </p>\n\n<p>*Tensile Strength (ASTM D882-83 Method A) 735 lbs. *Tear Strength: (D1004-66 – Notched) MD: 5.8 lbs.TD: 7.5 lbs. *Burst Strength (FTMS 101-C Method 2007 1a) >130 psi *Puncture Strength (FTMS 101-C Method A) >38 lbs. </p>\n\n<p>*Elongation (ASTM D822-83 Method A) MD: 40%TD: 74% *Heat Seal Strength (ASTM D-1876-72 Vertrod Sealer) >11 lbs./in width MVTR (ASTM F-1249 @ 100°F 100sq. in./24 hrs) <.0006 gms OTR (@ 100% Oxygen 100 sq. in./24 hrs) ASTM </p>\n\n<p>Because our Faraday Bag utilizes the most current metalizing technology, its moisture barrier performance exceeds foil laminates for low Moisture Vapor Transmission Rate (MVTR), particularly after flexing. In other words whatever you place in the bag and seal properly is going to stay dry also! </p>\n', 'http://techprotectbag.com/assets/images/products/MVP.png', '', 7995, 0, 0, 10, '0.0', '0.0', '0.00', 2, 1),
(159, 'VP', 'Value Pack', '<div>The Value Pack is one of the best packages that we offer. At a combined value of almost $44, these items are a steal for only $34.95! This is a perfect solution for nesting bags to make sure you have the highest amount of protection possible.</div>\n<p></p>\n<h4>What’s included?</h4>\n<div><strong>1 XL</strong> – The 20″x30″ bag is perfect for your laptop (all sizes), gaming systems, radios and extra accessories.</div>\n<div><strong>1 Medium</strong> – The 8″x16″ bag is perfect for remotes, walkie talkies, flashlights and video cameras.</div>\n<div><strong>2 Small</strong> – The 8″X8″ bag is perfect for your cell phones, ipods, MP3, thumbdrives, GPS and smaller cameras.</div>\n<p></p>\n<h4> Specifications</h4>\n<p>The multiple layer construction provides full protection against ESD, EMI/RFI and tribocharging. Electrical Properties <strong>*EMI Shielding (MIL-B-81705-Rev-C): >40 db Between 1 & 10 GHz</strong></p>\n\n<p>It has always been the suggestion of Tech Protect to <strong>nest</strong> or place one bag inside of the other to give optimal protection against EMPs and Super EMPs.</p>\n\n<p>*Resistivity-Conductive Metal Layer (ASTM D-257): <2 Ohms/sq. in. avg. *Surface Resistivity (both surfaces) (ASTM I-257 @ 12% RH): <10 12 Ohms. sq. in. *Static Decay (FTMS 101C, Method 4046.1 5000 to 0 Volts): <0.05 Seconds *Capacitive Probe Test (High Voltage Discharge) – (EIA-std 541/Appendix E-1 KV): <8 Volts *Charge Generation-nominal (Modified incline plane Avg. nC/sq.in.):Teflon: -0.09 Quartz: +0.10 Physical Properties </p>\n\n<p><strong>*Total Thickness: 7.0 mils</strong> *Light Transmission (ASTM D-1003-77) <.01% </p>\n\n<p>*Tensile Strength (ASTM D882-83 Method A) 735 lbs. *Tear Strength: (D1004-66 – Notched) MD: 5.8 lbs.TD: 7.5 lbs. *Burst Strength (FTMS 101-C Method 2007 1a) >130 psi *Puncture Strength (FTMS 101-C Method A) >38 lbs. </p>\n\n<p>*Elongation (ASTM D822-83 Method A) MD: 40%TD: 74% *Heat Seal Strength (ASTM D-1876-72 Vertrod Sealer) >11 lbs./in width MVTR (ASTM F-1249 @ 100°F 100sq. in./24 hrs) <.0006 gms OTR (@ 100% Oxygen 100 sq. in./24 hrs) ASTM </p>\n', 'http://techprotectbag.com/assets/images/products/VP.png', '', 3495, 0, 0, 10, '0.0', '0.0', '0.00', 2, 1),
(160, 'HEDVD', 'Home EMProvement DVD', '<p>You’ve probably asked at one point in your life, “What is an EMP?” or “How do I protect myself from an EMP?” or “Is there anything worth saving from an EMP that I can’t live without?” All of these questions and many the other important questions that come up about EMPs and Solar Flares are addressed in this DVD: <strong>Home EMProvement.</strong></p>\n<p>In this instructional DVD made by the group <strong>Practical Preppers;</strong> you will be instructed on how to protect anything you want by multiple means to make sure that when the lights go out, yours don’t. It is full of easy solutions as well as many DIY projects to shield your items from the severe EMP threat that will no doubt happen. </p>\n', 'http://techprotectbag.com/assets/images/products/HEDVD.jpg', '', 2995, 0, 0, 30, '0.0', '0.0', '0.00', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE IF NOT EXISTS `product_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE IF NOT EXISTS `purchase` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `customer_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `shipping_cost` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `isFulfilled` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_product`
--

CREATE TABLE IF NOT EXISTS `purchase_product` (
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE IF NOT EXISTS `shipping` (
  `id` int(11) NOT NULL,
  `price_low` float(10,2) unsigned NOT NULL,
  `price_high` float(10,2) unsigned NOT NULL,
  `shipping_price` int(11) unsigned NOT NULL COMMENT 'Shipping price in Cents'
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shipping`
--

INSERT INTO `shipping` (`id`, `price_low`, `price_high`, `shipping_price`) VALUES
(2, 5.95, 29.94, 550),
(3, 29.95, 49.99, 600),
(4, 50.00, 59.99, 700),
(5, 60.00, 69.99, 930),
(6, 70.00, 79.99, 1000),
(7, 80.00, 89.99, 1000),
(8, 90.00, 99.99, 1100),
(9, 100.00, 124.99, 1200),
(10, 125.00, 149.99, 1300),
(11, 150.00, 174.99, 1350),
(12, 175.00, 199.99, 1400),
(13, 200.00, 249.99, 1500),
(14, 250.00, 299.99, 1750),
(15, 300.00, 349.99, 2000),
(16, 350.00, 399.99, 2250),
(17, 400.00, 449.99, 2500),
(18, 450.00, 499.99, 2750),
(19, 500.00, 549.99, 3000),
(20, 550.00, 599.99, 3250),
(21, 600.00, 649.99, 3500),
(22, 650.00, 699.99, 3750),
(23, 700.00, 749.99, 4000),
(24, 750.00, 799.99, 4250),
(25, 800.00, 0.00, 4500);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `firstName` varchar(45) NOT NULL,
  `lastName` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstName`, `lastName`, `email`, `password`) VALUES
(2, 'Stuart', 'Himmer', 'himmerman@gmail.com', '4c0876d4278d5e2a74c99a17d17db94393c781d8'),
(3, 'Ben', 'Gillmore', 'bengillmore@gmail.com', '8fe38322cd1f756040b4fc88f3c314409814d724');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_address_id_idx` (`address_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`), ADD KEY `user_fk_idx` (`createdBy`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD KEY `product_id_fk_idx` (`product_id`), ADD KEY `category_id_fk_idx` (`category_id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_customer_id_idx` (`customer_id`), ADD KEY `fk_address_id_idx` (`address_id`);

--
-- Indexes for table `purchase_product`
--
ALTER TABLE `purchase_product`
  ADD KEY `fk_purchase_id_idx` (`purchase_id`), ADD KEY `fk_product_id_idx` (`product_id`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=161;
--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
ADD CONSTRAINT `cust_fk_address_id` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
ADD CONSTRAINT `user_fk` FOREIGN KEY (`createdBy`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product_category`
--
ALTER TABLE `product_category`
ADD CONSTRAINT `category_id_fk` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `cat_product_id_fk` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
ADD CONSTRAINT `fk_address_id` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `purchase_product`
--
ALTER TABLE `purchase_product`
ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `purchase_product_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
