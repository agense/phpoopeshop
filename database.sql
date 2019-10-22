-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2019 at 09:23 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mvcecom`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `id` int(11) NOT NULL,
  `username` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `fname` varchar(150) NOT NULL,
  `lname` varchar(150) NOT NULL,
  `acl` text NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`id`, `username`, `email`, `password`, `fname`, `lname`, `acl`, `deleted`) VALUES
(1, 'adm', 'adm@test.com', '$2y$10$Elb/fKKD80wdCDSDwWFfiuNkYNGGdtc8mLVWtjfSNL.OvSJGAVfHC', 'Admin', 'Admin', '[&quot;Admin&quot;,&quot;SuperAdmin&quot;]', 0);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `brand_image` varchar(255) DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand_name`, `brand_image`, `featured`) VALUES
(1, 'No Brand', NULL, 0),
(2, 'Brand Two', NULL, 0),
(3, 'Brand Three', NULL, 0),
(4, 'Brand Four', NULL, 0),
(5, 'Brand Five', NULL, 0),
(27, 'Brand Six', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_slug` varchar(255) NOT NULL,
  `parent_category_id` int(11) NOT NULL,
  `category_description` text NOT NULL,
  `category_image` varchar(255) DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `category_slug`, `parent_category_id`, `category_description`, `category_image`, `featured`, `deleted`) VALUES
(1, 'Jewelry', 'jewelry', 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ut tincidunt magna, eu dictum lorem. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. ', 'category_image_5cd071f2c6c7b.jpg', 1, 0),
(2, 'Watches', 'watches', 0, 'Quisque nec pharetra augue. Nam nisi felis, ullamcorper eu efficitur sed, pulvinar sed nisi. Integer convallis sagittis lacus, et condimentum neque malesuada in.', 'category_image_5ccad9fa3001a.jpg', 1, 0),
(3, 'Accessories', 'accessories', 0, 'Nam convallis nec dui nec convallis. Integer pulvinar, justo sed cursus imperdiet, lorem nulla dictum nisi, in sagittis magna felis sed lacus. ', 'category_image_5ccada0d974e1.jpg', 1, 0),
(4, 'Neclaces', 'neclaces', 1, '', 'category_image_5ccadb1c2ac74.jpg', 0, 0),
(5, 'Pendants', 'pendants', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus viverra lorem, et euismod lorem sodales sed. Fusce sit amet erat non neque interdum ornare ac vitae ex. Donec nunc risus, fermentum imperdiet tortor quis, mattis dignissim turpis. Duis laoreet porta elementum. Morbi dapibus lacus urna, id blandit nulla vehicula sed. Sed dignissim justo nulla. Fusce tincidunt venenatis libero. Mauris consectetur eros ex, et rutrum ligula viverra vitae. Morbi lacinia nisl ligula, sit amet blandit eros sollicitudin sed.', 'category_image_5cd07ebadc0ec.jpg', 0, 0),
(6, 'Bracelets', 'bracelets', 1, '', 'category_image_5cd07ecb68cf6.jpg', 0, 0),
(7, 'Earrings', 'earrings', 1, '', 'category_image_5cd07edaa3dc5.jpg', 0, 0),
(8, 'Rings', 'rings', 1, '', 'category_image_5ccadb6ba1136.jpg', 0, 0),
(9, 'Metal Bracelet Watches', 'metal-bracelet-watches', 2, '', 'category_image_5ccadb869b97d.jpg', 0, 0),
(10, 'Ceramic Watches', 'ceramic-watches', 2, '', 'category_image_5ccadb9f34e8b.jpg', 0, 0),
(11, 'Leather Band Watches', 'leather-band-watches', 2, '', 'category_image_5ccadbcba9023.jpg', 0, 0),
(16, 'Sunglasses', 'sunglasses', 3, '', 'category_image_5ccada749c295.jpg', 0, 0),
(17, 'Key Rings', 'key-rings', 3, '', 'category_image_5ccada890a734.jpg', 0, 0),
(18, 'Smartphone Accessories', 'smartphone-accessories', 3, '', 'category_image_5ccadaad7b822.jpg', 0, 0),
(19, 'Designer Stationary', 'designer-stationary', 3, '', 'category_image_5ccadae268b75.jpg', 0, 0),
(20, 'Sets', 'sets', 1, '', 'category_image_5ccade092e285.jpg', 0, 0),
(21, 'Slim Band Watches', 'slim-band-watches', 2, '', 'category_image_5ccadc846c1ca.jpg', 0, 0),
(22, 'Chronograph Watches', 'chronograph-watches', 2, '', 'category_image_5ccadcc2ba5fe.jpg', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `id` int(11) NOT NULL,
  `collection_name` varchar(255) NOT NULL,
  `collection_slug` varchar(255) NOT NULL,
  `collection_description` text,
  `collection_image` text,
  `collection_items` text,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `collections`
--

INSERT INTO `collections` (`id`, `collection_name`, `collection_slug`, `collection_description`, `collection_image`, `collection_items`, `deleted`) VALUES
(1, 'Collection One', 'collection-one', 'Sed in ipsum porttitor ante rhoncus blandit. Curabitur ut elit quam. Proin iaculis magna a mi semper mattis. Nam sed efficitur arcu.Vivamus ac elit vehicula, gravida libero vitae, aliquet tellus. Etiam egestas eget neque quis blandit. Morbi ac neque magna. ', 'collection_image_5d28f892504b8.jpg', '51,50,11', 0),
(9, 'Collection Two', 'collection-two', 'Praesent commodo metus sit amet enim convallis fermentum. Proin molestie eu leo volutpat ultrices. Sed rutrum felis congue, lobortis sem a, pharetra erat. Cras sagittis nibh enim, et suscipit nisi convallis vestibulum.', 'collection_image_5cd6b30c171c6.jpg', '43,37', 0);

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` int(11) NOT NULL,
  `color_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `color_name`) VALUES
(1, 'Golden'),
(2, 'Rose'),
(3, 'Silver'),
(4, 'Black'),
(5, 'Multicolor'),
(10, 'White'),
(11, 'Brown'),
(12, 'Gray'),
(13, 'Blue'),
(14, 'Red'),
(15, 'Orange');

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `material_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `material_name`) VALUES
(1, 'Silver'),
(2, 'Gold'),
(3, 'Rose Gold'),
(4, 'Stainless Steel'),
(5, 'Metal'),
(6, 'Rhodium'),
(7, 'Silver Plated'),
(8, 'Gold Plated'),
(10, 'Ceramic'),
(11, 'Leather'),
(12, 'Mixed'),
(13, 'Crystals');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_nr` varchar(255) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_billing_details` text NOT NULL,
  `order_details` text NOT NULL,
  `order_payment_amount` float NOT NULL,
  `order_tax` float NOT NULL,
  `order_status` tinyint(1) NOT NULL DEFAULT '1',
  `order_payment_status` tinyint(1) NOT NULL DEFAULT '0',
  `order_payment_method` tinyint(1) DEFAULT NULL,
  `order_payment_date` datetime DEFAULT NULL,
  `order_create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `intro` text,
  `content` text NOT NULL,
  `page_type` int(4) UNSIGNED NOT NULL DEFAULT '1',
  `in_menu` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `intro`, `content`, `page_type`, `in_menu`) VALUES
(1, 'About Us', 'about-us', 'About Our Company', '&amp;amp;lt;blockquote class=&amp;amp;quot;blockquote&amp;amp;quot;&amp;amp;gt;&amp;amp;lt;blockquote class=&amp;amp;quot;blockquote&amp;amp;quot;&amp;amp;gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur elementum fringilla porta. Phasellus rutrum efficitur lectus et scelerisque.&amp;amp;lt;/blockquote&amp;amp;gt;&amp;amp;lt;/blockquote&amp;amp;gt;&amp;amp;lt;div&amp;amp;gt;&amp;amp;lt;font color=&amp;amp;quot;#666666&amp;amp;quot; face=&amp;amp;quot;Helvetica, Open Sans, sans-serif&amp;amp;quot;&amp;amp;gt;&amp;amp;lt;span style=&amp;amp;quot;font-size: 15.2px; letter-spacing: normal;&amp;amp;quot;&amp;amp;gt; &amp;amp;lt;/span&amp;amp;gt;&amp;amp;lt;/font&amp;amp;gt;&amp;amp;lt;img src=&amp;amp;quot;/eshop/images\\page_images\\page_image_5da7ad09eda53.jpg&amp;amp;quot; style=&amp;amp;quot;width: 50%; float: left;&amp;amp;quot; class=&amp;amp;quot;note-float-left&amp;amp;quot;&amp;amp;gt;&amp;amp;lt;font color=&amp;amp;quot;#666666&amp;amp;quot; face=&amp;amp;quot;Helvetica, Open Sans, sans-serif&amp;amp;quot;&amp;amp;gt;&amp;amp;lt;span style=&amp;amp;quot;font-size: 15.2px; letter-spacing: normal;&amp;amp;quot;&amp;amp;gt;Duis posuere augue vitae accumsan faucibus. Cras nec bibendum dui, non fringilla tellus. Fusce egestas purus non metus condimentum faucibus. Ut lobortis aliquam arcu, id posuere massa congue id. Etiam imperdiet augue ipsum, et facilisis enim bibendum ut. Integer eget nisl sit amet ante cursus feugiat.&amp;amp;lt;/span&amp;amp;gt;&amp;amp;lt;/font&amp;amp;gt;&amp;amp;lt;/div&amp;amp;gt;&amp;amp;lt;div&amp;amp;gt;&amp;amp;lt;font color=&amp;amp;quot;#666666&amp;amp;quot; face=&amp;amp;quot;Helvetica, Open Sans, sans-serif&amp;amp;quot;&amp;amp;gt;&amp;amp;lt;span style=&amp;amp;quot;font-size: 15.2px; letter-spacing: normal;&amp;amp;quot;&amp;amp;gt;Etiam imperdiet augue ipsum, et facilisis enim bibendum ut. Integer eget nisl sit amet ante cursus feugiat.n metus condimentum faucibus. Ut lobortis aliquam arcu, id posuere massa congue id. Etiam imperdiet augue ipsum, et facilisis enim bibendum ut.&amp;amp;lt;/span&amp;amp;gt;&amp;amp;lt;/font&amp;amp;gt;&amp;amp;lt;/div&amp;amp;gt;&amp;amp;lt;div&amp;amp;gt;&amp;amp;lt;font color=&amp;amp;quot;#666666&amp;amp;quot; face=&amp;amp;quot;Helvetica, Open Sans, sans-serif&amp;amp;quot;&amp;amp;gt;&amp;amp;lt;span style=&amp;amp;quot;font-size: 15.2px; letter-spacing: normal;&amp;amp;quot;&amp;amp;gt; Integer eget nisl sit amet ante cursus feugiat.Etiam imperdiet augue ipsum, et facilisis enim bibendum ut. Integer eget nisl sit amet ante cursus feugiat.diet augue ipsum, et facilisis enim bibendum ut. Integer eget nisl sit amet ante cursus feugiat.&amp;amp;lt;/span&amp;amp;gt;&amp;amp;lt;/font&amp;amp;gt;&amp;amp;lt;/div&amp;amp;gt;&amp;amp;lt;div&amp;amp;gt;&amp;amp;lt;font color=&amp;amp;quot;#666666&amp;amp;quot; face=&amp;amp;quot;Helvetica, Open Sans, sans-serif&amp;amp;quot;&amp;amp;gt;&amp;amp;lt;span style=&amp;amp;quot;font-size: 15.2px; letter-spacing: normal;&amp;amp;quot;&amp;amp;gt;&amp;amp;lt;br&amp;amp;gt;&amp;amp;lt;/span&amp;amp;gt;&amp;amp;lt;/font&amp;amp;gt;&amp;amp;lt;/div&amp;amp;gt;&amp;amp;lt;div&amp;amp;gt;&amp;amp;lt;font color=&amp;amp;quot;#666666&amp;amp;quot; face=&amp;amp;quot;Helvetica, Open Sans, sans-serif&amp;amp;quot;&amp;amp;gt;&amp;amp;lt;span style=&amp;amp;quot;font-size: 15.2px; letter-spacing: normal;&amp;amp;quot;&amp;amp;gt;Etiam imperdiet augue ipsum, et facilisis enim bibendum ut. Integer eget nisl sit amet ante cursus feugiat.&amp;amp;amp;nbsp;&amp;amp;lt;/span&amp;amp;gt;&amp;amp;lt;/font&amp;amp;gt;&amp;amp;lt;span style=&amp;amp;quot;color: rgb(102, 102, 102); font-family: Helvetica, &amp;amp;quot; open=&amp;amp;quot;&amp;amp;quot; sans&amp;amp;quot;,=&amp;amp;quot;&amp;amp;quot; sans-serif;=&amp;amp;quot;&amp;amp;quot; font-size:=&amp;amp;quot;&amp;amp;quot; 15.2px;=&amp;amp;quot;&amp;amp;quot; letter-spacing:=&amp;amp;quot;&amp;amp;quot; normal;&amp;amp;quot;=&amp;amp;quot;&amp;amp;quot;&amp;amp;gt;Donec in turpis nisl. Ut ultricies suscipit quam, semper egestas leo suscipit blandit. Sed quis nulla vel risus lobortis lacinia. Maecenas ac dictum quam. Maecenas id neque orci. Pellentesque sed est laoreet, aliquet orci vitae, euismod quam. Sed pretium feugiat blandMorbi fermentum et orci vitae dictum. Proin velit purus, suscipit sit amet fermentum nec, tempus nec metus.&amp;amp;lt;/span&amp;amp;gt;&amp;amp;lt;/div&amp;amp;gt;&amp;amp;lt;div&amp;amp;gt;&amp;amp;lt;font color=&amp;amp;quot;#666666&amp;amp;quot; face=&amp;amp;quot;Helvetica, Open Sans, sans-serif&amp;amp;quot;&amp;amp;gt;&amp;amp;lt;span style=&amp;amp;quot;font-size: 15.2px; letter-spacing: normal;&amp;amp;quot;&amp;amp;gt;&amp;amp;lt;br&amp;amp;gt;&amp;amp;lt;/span&amp;amp;gt;&amp;amp;lt;/font&amp;amp;gt;&amp;amp;lt;/div&amp;amp;gt;&amp;amp;lt;div&amp;amp;gt;&amp;amp;lt;font color=&amp;amp;quot;#666666&amp;amp;quot; face=&amp;amp;quot;Helvetica, Open Sans, sans-serif&amp;amp;quot;&amp;amp;gt;&amp;amp;lt;span style=&amp;amp;quot;font-size: 15.2px; letter-spacing: normal;&amp;amp;quot;&amp;amp;gt;Duis efficitur quam et tempus consectetur. Mauris vitae nisi ac leo pharetra eleifend. Curabitur efficitur nunc ac turpis lobortis interdum. Morbi quis quam quis mauris ornare semper in sit amet eros. Sed ultrices, eros quis sollicitudin volutpat, eros turpis porta metus, vitae ultrices nisi tellus a velit. Nullam blandit elit mauris, vel vestibulum lorem lacinia eu. Donec vitae libero feugiat purus vehicula lobortis. Proin volutpat tellus a augue vulputate, eget gravida arcu mollis. Quisque varius mauris vitae dui eleifend porta. Nullam vel odio in felis sodales pretium. Phasellus fermentum sit amet urna vitae cursus.&amp;amp;lt;/span&amp;amp;gt;&amp;amp;lt;/font&amp;amp;gt;&amp;amp;lt;/div&amp;amp;gt;&amp;amp;lt;div&amp;amp;gt;&amp;amp;lt;font color=&amp;amp;quot;#666666&amp;amp;quot; face=&amp;amp;quot;Helvetica, Open Sans, sans-serif&amp;amp;quot;&amp;amp;gt;&amp;amp;lt;span style=&amp;amp;quot;font-size: 15.2px; letter-spacing: normal;&amp;amp;quot;&amp;amp;gt;&amp;amp;lt;br&amp;amp;gt;&amp;amp;lt;/span&amp;amp;gt;&amp;amp;lt;/font&amp;amp;gt;&amp;amp;lt;/div&amp;amp;gt;&amp;amp;lt;div&amp;amp;gt;&amp;amp;lt;font color=&amp;amp;quot;#666666&amp;amp;quot; face=&amp;amp;quot;Helvetica, Open Sans, sans-serif&amp;amp;quot;&amp;amp;gt;&amp;amp;lt;span style=&amp;amp;quot;font-size: 15.2px; letter-spacing: normal;&amp;amp;quot;&amp;amp;gt;Phasellus ligula massa, varius vel ultricies vitae, mollis sit amet nisi. In varius interdum metus, non mattis sapien congue in. Integer venenatis urna turpis, at viverra odio blandit sed. Vivamus auctor sed neque vel mattis. Morbi urna leo, accumsan vitae placerat eu, hendrerit vitae enim. Pellentesque quis nisi euismod, consectetur arcu elementum, bibendum tellus. Nulla tincidunt viverra dictum. Etiam interdum dignissim felis vel placerat. Nulla nibh felis, congue eget leo id, iaculis sollicitudin felis. Quisque mi lectus, laoreet ut magna vel, varius pharetra neque. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Morbi ut libero ut elit maximus aliquam gravida quis risus. Integer placerat mauris at diam viverra consectetur. Aliquam justo est, porta vitae scelerisque a, fermentum vel purus. Etiam congue sapien vitae aliquet ultrices. Curabitur in varius nibh. Maecenas ac ligula id felis finibus venenatis et vel diam. Nunc sem neque, faucibus ut nisl ut, pulvinar iaculis leo. Proin mattis elit ligula, sed dignissim ante volutpat dignissim. Etiam justo urna, mattis ut rutrum vel, varius vel risus. Nam accumsan lacus id faucibus condimentum. Morbi vitae lacus at urna rhoncus viverra a eu dolor.&amp;amp;lt;/span&amp;amp;gt;&amp;amp;lt;/font&amp;amp;gt;&amp;amp;lt;/div&amp;amp;gt;', 1, 1),
(4, 'How To Order', 'how-to-order', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum congue efficitur imperdiet. Donec hendrerit velit metus, ac egestas mi dapibus eu. Mauris egestas enim purus, ut volutpat eros consectetur quis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus iaculis cursus metus, in interdum odio ornare ac. Proin accumsan nec leo in accumsan. Duis blandit elit lacus, in efficitur libero ullamcorper non. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris nec pellentesque ante. Nam non ex ipsum. Etiam eu convallis arcu, eu suscipit quam. Donec tempus convallis elit, posuere malesuada purus elementum nec.\r\n\r\nDuis varius turpis in lacus egestas tincidunt. Fusce vitae odio mollis, placerat ligula ut, porta risus. Donec ullamcorper dictum tempus. In maximus ultrices ultrices. Duis facilisis vitae dui in tempor. Nulla pretium sem nulla, vel facilisis lectus dignissim eget. Sed vel suscipit nibh. Vestibulum non dignissim nulla.\r\n\r\nCras finibus urna eu arcu aliquet, ac volutpat elit tristique. Sed mollis scelerisque nisi eget fringilla. Etiam at malesuada leo. Fusce vitae felis sit amet nisi dapibus fringilla. Sed commodo ut dui nec volutpat. Integer tempor viverra eros nec aliquet. Suspendisse lacinia neque arcu, quis volutpat justo blandit sed. Phasellus lacinia tempus lorem vitae sollicitudin. Vivamus placerat arcu non ex dapibus eleifend. Nam dictum tortor nec ipsum fermentum faucibus. Proin euismod felis vel diam posuere, id convallis sem aliquam. Morbi gravida cursus augue nec aliquam.\r\n\r\nNunc id vulputate elit. Quisque porta tincidunt nisi, non imperdiet leo pulvinar et. Nulla eu augue dapibus sapien laoreet molestie non at mauris. Sed consequat volutpat est at sollicitudin. In vitae orci sit amet diam pretium semper a sit amet sem. Ut faucibus lectus eget felis condimentum posuere. Mauris ac lacus sapien. Proin eget sollicitudin dui, vitae ullamcorper neque. Nullam hendrerit eros et lacinia euismod.\r\n\r\nDonec faucibus lacus vitae nunc sagittis, eleifend tempor mi ultricies. Nulla malesuada eu urna vitae rutrum. Sed congue tortor diam, sed faucibus quam finibus quis. Maecenas eget ex sed enim aliquam auctor ac a nisl. Mauris eu dolor enim. Phasellus vehicula euismod arcu vitae dictum. Praesent at sapien molestie, egestas eros id, mattis quam. Nulla at lacus quis mi suscipit eleifend. Aenean gravida volutpat diam, id posuere massa cursus ac. Donec eget urna aliquam est convallis pellentesque eu at erat. Etiam efficitur suscipit felis quis sagittis. Duis est nulla, gravida elementum justo sed, porttitor molestie tellus.', 2, 1),
(5, 'Payment Methods', 'payment-methods', '', 'Duis vel ex a nisi sagittis dignissim et elementum dui. Sed porttitor nibh ut orci aliquam, ut aliquam lorem varius. Vivamus interdum pulvinar mauris id posuere. Integer facilisis mauris sit amet semper convallis. Aliquam placerat arcu non ex viverra sollicitudin. Curabitur volutpat erat nibh, tincidunt congue turpis aliquam at. Nulla vulputate nibh enim, vel condimentum nisl pharetra in. Etiam nec volutpat diam. Nulla ipsum dui, pulvinar hendrerit varius in, feugiat eget magna. Pellentesque eget enim blandit, tristique odio sit amet, lacinia elit.\r\n\r\nVestibulum eget porttitor lorem, id vulputate ex. Maecenas pharetra semper nulla, et blandit massa dapibus a. Proin et sollicitudin massa, sed finibus lacus. Proin nec mauris quam. Nunc at quam malesuada, tristique lorem eget, congue tellus. Duis sit amet leo turpis. Maecenas ultrices magna vel neque cursus, eu congue turpis faucibus. Vivamus metus urna, vestibulum eget leo ut, pellentesque consectetur tellus. Etiam feugiat mollis urna et consectetur. Curabitur faucibus interdum eleifend. Donec nisi quam, commodo vel fringilla et, auctor et metus.', 2, 1),
(6, 'Delivery', 'delivery', 'Nunc et interdum magna. Vivamus sed nisl egestas, malesuada nisi quis, euismod diam.', 'Nunc et interdum magna. Vivamus sed nisl egestas, malesuada nisi quis, euismod diam. Suspendisse potenti. Pellentesque quis iaculis lorem. Nam vestibulum orci a lorem facilisis aliquet vel eget elit. Maecenas luctus lectus a sapien consequat blandit. Vivamus faucibus massa at suscipit finibus. Cras molestie elementum enim sed ornare. Vestibulum imperdiet ligula et ex elementum elementum. Nullam ac auctor nibh, eget placerat erat. Nunc vitae metus faucibus, tincidunt nibh eget, vehicula turpis. Nam aliquam dolor metus, vehicula semper mauris euismod ac. Nunc pulvinar tristique felis in varius. Curabitur facilisis, elit sed placerat molestie, dolor metus faucibus odio, in fermentum elit orci eu turpis.\r\n\r\nAliquam pulvinar, mauris consequat mollis ornare, odio arcu accumsan sapien, ac ornare ex libero ac ligula. Nulla sit amet urna molestie, volutpat magna id, vehicula lacus. Aenean facilisis consectetur nunc. Duis pharetra tempus tempor. Praesent nec purus purus. In urna felis, tincidunt ac ante quis, vestibulum dapibus lorem. Integer consequat gravida nisl, commodo egestas tortor vehicula non. Maecenas venenatis porttitor ipsum, tempor dignissim tellus maximus ut. Cras placerat, diam at mattis dapibus, urna ipsum pharetra urna, sit amet scelerisque diam sapien sed tellus. Nunc pellentesque convallis justo in molestie. Quisque vel ex mi. Sed non mattis neque. Mauris id neque varius libero aliquet pellentesque et eu sapien. Phasellus tristique facilisis mauris molestie vulputate. Integer hendrerit at mi ac vulputate. Vivamus in erat commodo, fermentum orci eu, pulvinar lectus.\r\n\r\nAliquam erat volutpat. Aliquam eget ex pretium, molestie mauris in, ullamcorper ipsum. Proin sollicitudin massa id euismod consequat. Nunc imperdiet egestas nisi. Morbi in nisi nulla. Mauris sodales nunc at odio feugiat faucibus. Etiam faucibus metus at odio feugiat, ut ultricies dolor semper. Mauris non sem tincidunt, malesuada ipsum id, efficitur turpis. Suspendisse rutrum finibus sapien sit amet imperdiet. Nullam auctor nisl odio, eu malesuada risus laoreet et. Cras turpis ante, iaculis sit amet ex sit amet, laoreet consequat magna. Nullam non neque pretium, ullamcorper ipsum eu, auctor augue. Praesent porttitor lacus velit, ut tincidunt est luctus ut. In consequat sem in elit sagittis interdum.', 2, 1),
(7, 'Returns And Cancellations', 'returns-and-cancellations', 'Curabitur tincidunt aliquet mauris sit amet auctor. In vitae eros ultrices ante tincidunt feugiat', 'Curabitur tincidunt aliquet mauris sit amet auctor. In vitae eros ultrices ante tincidunt feugiat. Ut sit amet posuere nibh, id congue lorem. Vivamus vehicula vulputate iaculis. Ut nisl elit, aliquam a hendrerit ut, efficitur ut dui. Vivamus a diam vel neque maximus commodo sed eget ante. Nullam malesuada nisi et nisi semper, sit amet volutpat magna luctus. Proin interdum nec ex ullamcorper consequat.\r\n\r\nDonec efficitur metus sed efficitur vehicula. Mauris sit amet egestas tellus. Suspendisse potenti. Phasellus ut mollis est. Vivamus non faucibus leo. Maecenas finibus consequat velit sit amet vehicula. Integer commodo pharetra lectus sed pulvinar. Donec imperdiet in turpis vel sodales. Pellentesque et interdum purus, vel porttitor quam. Curabitur ut diam sollicitudin, placerat elit nec, elementum arcu. Morbi sit amet mi vel libero pellentesque tempor. Phasellus iaculis, est vitae sollicitudin blandit, tellus nulla suscipit lorem, ut sollicitudin nisl odio vel nulla. Nam turpis nisl, tempor et metus eget, maximus rutrum nibh. Etiam a velit vehicula, laoreet arcu quis, viverra purus.\r\n\r\nPhasellus rutrum nunc orci, vitae commodo neque rhoncus sit amet. Aliquam pulvinar nisi in elit malesuada ornare. Morbi lobortis semper tortor ac ultricies. Maecenas facilisis, lectus non sodales auctor, enim nunc vulputate eros, at pharetra quam augue id libero. Nam gravida massa vel arcu sodales, id aliquet nisl dictum. Curabitur ut quam porttitor, suscipit justo vel, consequat leo. Curabitur eget quam est. Proin vel vehicula nisl.\r\n\r\nDuis vel ex a nisi sagittis dignissim et elementum dui. Sed porttitor nibh ut orci aliquam, ut aliquam lorem varius. Vivamus interdum pulvinar mauris id posuere. Integer facilisis mauris sit amet semper convallis. Aliquam placerat arcu non ex viverra sollicitudin. Curabitur volutpat erat nibh, tincidunt congue turpis aliquam at. Nulla vulputate nibh enim, vel condimentum nisl pharetra in. Etiam nec volutpat diam. Nulla ipsum dui, pulvinar hendrerit varius in, feugiat eget magna. Pellentesque eget enim blandit, tristique odio sit amet, lacinia elit.\r\n\r\nVestibulum eget porttitor lorem, id vulputate ex. Maecenas pharetra semper nulla, et blandit massa dapibus a. Proin et sollicitudin massa, sed finibus lacus. Proin nec mauris quam. Nunc at quam malesuada, tristique lorem eget, congue tellus. Duis sit amet leo turpis. Maecenas ultrices magna vel neque cursus, eu congue turpis faucibus. Vivamus metus urna, vestibulum eget leo ut, pellentesque consectetur tellus. Etiam feugiat mollis urna et consectetur. Curabitur faucibus interdum eleifend. Donec nisi quam, commodo vel fringilla et, auctor et metus.\r\n\r\nNunc et interdum magna. Vivamus sed nisl egestas, malesuada nisi quis, euismod diam. Suspendisse potenti. Pellentesque quis iaculis lorem. Nam vestibulum orci a lorem facilisis aliquet vel eget elit. Maecenas luctus lectus a sapien consequat blandit. Vivamus faucibus massa at suscipit finibus. Cras molestie elementum enim sed ornare. Vestibulum imperdiet ligula et ex elementum elementum. Nullam ac auctor nibh, eget placerat erat. Nunc vitae metus faucibus, tincidunt nibh eget, vehicula turpis. Nam aliquam dolor metus, vehicula semper mauris euismod ac. Nunc pulvinar tristique felis in varius. Curabitur facilisis, elit sed placerat molestie, dolor metus faucibus odio, in fermentum elit orci eu turpis.', 2, 1),
(8, 'Privacy And Security', 'privacy-and-security', 'Nunc et interdum magna. Vivamus sed nisl egestas, malesuada nisi quis, euismod diam. Suspendisse potenti. Pellentesque quis iaculis lorem.', 'Nunc et interdum magna. Vivamus sed nisl egestas, malesuada nisi quis, euismod diam. Suspendisse potenti. Pellentesque quis iaculis lorem. Nam vestibulum orci a lorem facilisis aliquet vel eget elit. Maecenas luctus lectus a sapien consequat blandit. Vivamus faucibus massa at suscipit finibus. Cras molestie elementum enim sed ornare. Vestibulum imperdiet ligula et ex elementum elementum. Nullam ac auctor nibh, eget placerat erat. Nunc vitae metus faucibus, tincidunt nibh eget, vehicula turpis. Nam aliquam dolor metus, vehicula semper mauris euismod ac. Nunc pulvinar tristique felis in varius. Curabitur facilisis, elit sed placerat molestie, dolor metus faucibus odio, in fermentum elit orci eu turpis.\r\n\r\nAliquam pulvinar, mauris consequat mollis ornare, odio arcu accumsan sapien, ac ornare ex libero ac ligula. Nulla sit amet urna molestie, volutpat magna id, vehicula lacus. Aenean facilisis consectetur nunc. Duis pharetra tempus tempor. Praesent nec purus purus. In urna felis, tincidunt ac ante quis, vestibulum dapibus lorem. Integer consequat gravida nisl, commodo egestas tortor vehicula non. Maecenas venenatis porttitor ipsum, tempor dignissim tellus maximus ut. Cras placerat, diam at mattis dapibus, urna ipsum pharetra urna, sit amet scelerisque diam sapien sed tellus. Nunc pellentesque convallis justo in molestie. Quisque vel ex mi. Sed non mattis neque. Mauris id neque varius libero aliquet pellentesque et eu sapien. Phasellus tristique facilisis mauris molestie vulputate. Integer hendrerit at mi ac vulputate. Vivamus in erat commodo, fermentum orci eu, pulvinar lectus.\r\n\r\nAliquam erat volutpat. Aliquam eget ex pretium, molestie mauris in, ullamcorper ipsum. Proin sollicitudin massa id euismod consequat. Nunc imperdiet egestas nisi. Morbi in nisi nulla. Mauris sodales nunc at odio feugiat faucibus. Etiam faucibus metus at odio feugiat, ut ultricies dolor semper. Mauris non sem tincidunt, malesuada ipsum id, efficitur turpis. Suspendisse rutrum finibus sapien sit amet imperdiet. Nullam auctor nisl odio, eu malesuada risus laoreet et. Cras turpis ante, iaculis sit amet ex sit amet, laoreet consequat magna. Nullam non neque pretium, ullamcorper ipsum eu, auctor augue. Praesent porttitor lacus velit, ut tincidunt est luctus ut. In consequat sem in elit sagittis interdum.', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` float NOT NULL,
  `product_price_discounted` float DEFAULT NULL,
  `product_discount_type` tinyint(1) DEFAULT NULL,
  `product_quantity` int(11) NOT NULL DEFAULT '0',
  `product_brand_id` int(11) DEFAULT NULL,
  `product_category_id` int(6) NOT NULL DEFAULT '0',
  `product_material_id` int(6) DEFAULT NULL,
  `product_color_id` int(6) DEFAULT NULL,
  `product_featured_image` varchar(255) DEFAULT NULL,
  `product_description` text,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `product_upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_code`, `product_name`, `product_price`, `product_price_discounted`, `product_discount_type`, `product_quantity`, `product_brand_id`, `product_category_id`, `product_material_id`, `product_color_id`, `product_featured_image`, `product_description`, `featured`, `deleted`, `product_upload_date`) VALUES
(1, '98756789', 'Test Product One', 499.9, NULL, NULL, 3, 3, 5, 12, 5, 'product_featured_image_22556221920.jpg', 'Cras vehicula, lacus et fringilla molestie, mauris lorem volutpat turpis, sed hendrerit orci orci non neque. Duis a dolor sit amet ex fringilla feugiat. Curabitur rhoncus urna a lacus cursus accumsan. Quisque egestas mattis nunc sollicitudin laoreet. Maecenas et nisi et sem maximus rutrum nec vel nibh. Fusce semper pharetra nisi ut rutrum. Nulla semper sit amet risus ut elementum. Fusce odio ipsum, varius a enim quis, sagittis viverra ligula. Integer libero nisl, rutrum a pretium eget, commodo ac ex. Donec nec purus interdum, ornare ex non, dictum augue. Proin vitae interdum nisi. Nulla augue orci, blandit vitae quam sed, egestas feugiat neque. Suspendisse ut porta erat.', 1, 0, '2019-02-24 12:45:57'),
(7, '', 'Test Product Two', 3500, 3400, 1, 1, 2, 5, 2, 1, 'product_featured_image_5cc0d5abe8ee6.png', 'lorem ipsum', 1, 0, '2019-04-24 21:31:23'),
(9, '', 'Test Product Three ', 1400, NULL, NULL, 1, 5, 10, 10, 10, 'product_featured_image_5cc1d309c8f73.png', 'lorem', 0, 0, '2019-04-25 15:32:25'),
(11, '', 'Test Product Four', 1000, 900, NULL, 1, 4, 17, 12, 5, 'product_featured_image_5cc2db4a08a4a.jpg', 'lorem', 0, 0, '2019-04-26 10:19:54'),
(16, '', 'Test Product Five', 1400, NULL, NULL, 3, 5, 10, 10, 15, 'product_featured_image_5cc31bc75b3b2.png', 'lorem ipsum', 0, 0, '2019-04-26 14:55:03'),
(31, '', 'Test Product Six', 1800, NULL, NULL, 2, 5, 10, 10, 14, 'product_featured_image_5cc328f6513af.png', 'lorem', 0, 0, '2019-04-26 15:51:18'),
(36, '8264832545', 'Test Product Seven', 600.85, NULL, NULL, 3, 2, 6, 12, 5, 'product_featured_image_5cc361cc96223.jpg', 'lorem  ipsum', 1, 0, '2019-04-26 19:53:48'),
(37, '876785456', 'Test Product Eight', 15000, 14250, 2, 2, 5, 6, 12, 3, 'product_featured_image_5cc72082e434b.png', 'lorem ipsum lorem', 0, 0, '2019-04-29 15:43:21'),
(40, '287654346', 'Test Product Nine', 190, NULL, NULL, 2, 27, 6, 4, 3, 'product_featured_image_5cf236db26ab3.jpg', 'In vitae nunc at leo scelerisque suscipit quis vitae libero. In dui turpis, iaculis sed imperdiet ac, mollis id nibh. Phasellus luctus lorem dui, nec accumsan purus imperdiet vel. Cras in accumsan ipsum. Sed vel feugiat nunc. Mauris dictum, purus quis sagittis sollicitudin, enim sapien tristique velit, sed tincidunt enim massa accumsan orci. Mauris laoreet convallis vestibulum. Curabitur et tempor felis. Suspendisse efficitur quam a magna congue ornare. Fusce quis velit arcu.', 0, 0, '2019-06-01 08:27:07'),
(41, '12376543', 'Test Product Ten', 25, NULL, NULL, 2, 27, 6, 5, 3, 'product_featured_image_5cf23894ce752.jpg', 'Nulla non nibh sed libero pulvinar facilisis. Phasellus sodales purus massa, eget pulvinar lectus aliquet at. Suspendisse non finibus felis. Vestibulum ac metus et enim aliquam ornare. ', 0, 0, '2019-06-01 08:34:28'),
(42, '654378965', 'Test Product Eleven', 89.99, NULL, NULL, 2, 5, 6, 12, 5, 'product_featured_image_5cf23b67ac5cc.jpg', 'Phasellus at nisl aliquet, venenatis magna id, venenatis lacus. Proin congue nisl in dolor ullamcorper, a ultrices dui mollis. Aenean at orci at urna tempor ultricies. Integer in vestibulum purus, a faucibus diam. ', 1, 0, '2019-06-01 08:46:31'),
(43, '98654679', 'Test Product Twelve', 10600, NULL, NULL, 1, 3, 4, 1, 3, 'product_featured_image_5cf23bc398295.png', ' Donec scelerisque nisl erat, eu interdum turpis pellentesque et. Pellentesque suscipit diam ut risus consequat, ut posuere mauris vestibulum. Donec massa nibh, sollicitudin eget congue quis, tincidunt id odio. Fusce dolor mauris, ultricies ut nisl sit amet, bibendum ornare nisl. ', 1, 0, '2019-06-01 08:48:03'),
(44, '9875679', 'Test Product Thirteen', 1200, NULL, NULL, 2, 4, 8, 8, 1, 'product_featured_image_5cf23c8470dcb.jpg', 'Cras rhoncus varius turpis non molestie. In semper velit tellus. Pellentesque sit amet nibh ut odio accumsan blandit. Nam a turpis sit amet purus condimentum aliquet vel sit amet metus. Nulla facilisi. Donec vitae tellus sem. Aenean a purus a mi condimentum ultrices. Sed efficitur nulla vel molestie fringilla.', 1, 0, '2019-06-01 08:51:16'),
(45, '098756889', 'Test Product Fourteen', 899, NULL, NULL, 1, 2, 16, 12, 5, 'product_featured_image_5cf23d128b42b.jpg', 'Aliquam nec sem est. Sed posuere bibendum tellus vel luctus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Fusce viverra libero nec varius pharetra. Suspendisse potenti.', 0, 0, '2019-06-01 08:53:38'),
(46, '8764568900', 'Test Product Fifteen', 1788, 1698.6, 2, 1, 2, 16, 12, 4, 'product_featured_image_5cf23dca87b9e.jpg', '', 0, 0, '2019-06-01 08:56:42'),
(47, '298745638', 'Test Product Sixteen', 1788, 1698.6, 2, 1, 2, 16, 12, 11, 'product_featured_image_5cf23e52d705c.jpg', '', 0, 0, '2019-06-01 08:58:58'),
(49, '8264832585', 'Test Product Seventeen', 3.85, NULL, NULL, 1, 3, 4, 5, 5, '', 'lorem ipsum lorem ipsum', 0, 0, '2019-06-01 14:04:00'),
(50, '', 'Test Product Eighteen', 1400, NULL, NULL, 2, 27, 17, 12, 5, 'product_featured_image_5d28f98c603cf.jpg', 'Nunc vel diam id eros luctus consequat. Aenean odio quam, luctus sit amet tellus vitae, blandit congue mi. Vivamus ac tincidunt leo. Fusce ultricies felis eu nisl porta, eget pellentesque orci efficitur. ', 1, 0, '2019-07-12 21:20:12'),
(51, '11443313331', 'Test Product Nineteen', 2000, NULL, NULL, 2, 5, 17, 12, 5, 'product_featured_image_5d28fa15ac5fc.jpg', 'Donec a vestibulum sem, sit amet iaculis purus. Donec quis tincidunt lacus, tempor finibus leo. Aliquam nec ornare enim. Donec vestibulum ullamcorper odio sit amet interdum.', 1, 0, '2019-07-12 21:22:29');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(5) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `product_image`) VALUES
(1, 12, 'product_image_5cc2dd3f186dd.jpg'),
(3, 16, 'product_image_5cc31bc76443c.png'),
(4, 31, 'product_image_5cc328f65b7c1.png'),
(74, 36, 'product_5cc615e3ac930.jpg'),
(75, 36, 'product_5cc615e3acd18.jpg'),
(78, 36, 'product_5cc6e3cb4b5ce.jpg'),
(82, 37, 'product_5cc9fe7eb9a35.png'),
(87, 40, 'product_5cf236db2b4ec.jpg'),
(88, 40, 'product_5cf236db2b8d5.jpg'),
(89, 45, 'product_5cf23d3df1eae.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `fname` varchar(150) NOT NULL,
  `lname` varchar(150) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(35) DEFAULT NULL,
  `region` varchar(50) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `country` varchar(60) DEFAULT NULL,
  `acl` text,
  `deleted` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_session` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `whishlist`
--

CREATE TABLE `whishlist` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `items` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_slug` (`category_slug`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `collection_slug` (`collection_slug`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `whishlist`
--
ALTER TABLE `whishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `whishlist`
--
ALTER TABLE `whishlist`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
