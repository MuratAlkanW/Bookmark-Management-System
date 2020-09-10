
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


DROP TABLE IF EXISTS `bookmark`;
CREATE TABLE IF NOT EXISTS `bookmark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) COLLATE utf8mb4_turkish_ci NOT NULL,
  `url` varchar(512) COLLATE utf8mb4_turkish_ci NOT NULL,
  `note` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `owner` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category` varchar(256) COLLATE utf8mb4_turkish_ci NOT NULL,
  `shareStatus` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;



INSERT INTO `bookmark` (`id`, `title`, `url`, `note`, `owner`, `created`, `category`) VALUES
(72, 'Free 3D Models', 'https://www.cgtrader.com/free-3d-models', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, nostrum? Molestiae ullam incidunt quos fuga repellendus quo officia hic numquam quis quaerat illum velit nulla, tempora aliquam reprehenderit, dolore maiores.', 74, '2020-05-06 15:29:11', 'Graphic Design'),
(73, 'Yamaha Recent Motorbike Prices', 'https://www.yamaha-motor.eu/tr/tr/Deneyim/', 'A reprehenderit officiis mollitia tempora perferendis corrupti non nihil porro ipsa consequuntur error impedit similique pariatur commodi laudantium placeat, saepe quasi voluptas?\r\nDolorum, architecto! Autem laborum numquam voluptatum esse voluptatibus omnis minus reiciendis consequatur exercitationem, adipisci dolorum veritatis voluptates consequuntur sit illo voluptas, ipsa labore atque ratione hic? Ex cumque similique tempora.\r\nAd obcaecati dolor reiciendis delectus dicta ea, dolorem a porro, error', 74, '2020-05-06 15:51:53', 'Vehicle'),
(74, 'PHP Reference Page', 'http://www.php.net', 'This site is the main page for php functions.', 74, '2020-05-06 15:52:26', 'Web'),
(75, 'Learn about Material Design and our Project Team', 'https://materializecss.com/preloader.html', 'Created and designed by Google, Material Design is a design language that combines the classic principles of successful design along with innovation and technology. Google\'s goal is to develop a system of design that allows for a unified user experience across all their products on any platform.', 74, '2020-05-06 15:53:23', 'Web'),
(76, 'The new way to improve your programming skills while having fun and getting noticed', 'https://www.codingame.com/start', 'At CodinGame, our goal is to let programmers keep on improving their coding skills by solving the World\'s most challenging problems, learn new concepts, and get inspired by the best developers.', 74,'2020-05-06 15:54:50', 'Gaming'),
(77, 'Unity ', 'https://unity.com/', 'Create, operate, and monetize your interactive and immersive experiences with the world’s most widely used real-time development platform.', 74, '2020-05-06 15:56:26', 'Gaming'),
(78, 'WebGL Fundamentals', 'https://webglfundamentals.org/', 'WebGL (Web Graphics Library) is often thought of as a 3D API. People think \"I\'ll use WebGL and magic I\'ll get cool 3d\". In reality WebGL is just a rasterization engine. It draws points, lines, and triangles based on code you supply. Getting WebGL to do anything else is up to you to provide code to use points, lines, and triangles to accomplish your task.', 74, '2020-05-06 15:57:32', 'Web'),
(79, 'Exploring ES6', 'https://exploringjs.com/es6/', 'Free book for ES6', 74, '2020-05-06 15:58:49', 'Web'),
(80, 'Clara.io for 3D Modelling', 'https://clara.io/learn/user-guide/modeling/modeling_basics', 'Modeling is the process of creating 3D geometric meshes that will eventually be textured, animated, and rendered in your final product.', 74, '2020-05-06 15:59:53', 'Modelling');



DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8mb4_turkish_ci NOT NULL,
  `email` varchar(256) COLLATE utf8mb4_turkish_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `bday` date DEFAULT NULL,
  `profile` varchar(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;



INSERT INTO `user` (`id`, `name`, `email`, `password`, `bday`, `profile`) VALUES
(72, 'Mustafa Kurnaz', 'mkurnaz@gmail.com', '$2y$10$Z/7F3o4vNOmx2y/pwtDFwuV2f2QmGBSc.I7qPpM6kzVfL.i/XfnoW', NULL, 'default.jpg'),
(73, 'Özge Canlı', 'canli@one.com', '$2y$10$hlYrJq3Beaaks3ZrwogfHuwLyjLDhZsdJDNghhLsTRs97E1BlVGim', NULL, 'default.jpg'),
(74, 'John Vue', 'john@one.com', '$2y$10$ZT1zUTSywDs4xy5BBWS5C.tcLUyBDTWGj7Okacua36m60oYQUFW8S', NULL, 'default.jpg');



ALTER TABLE `bookmark`
  ADD CONSTRAINT `bookmark_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `user` (`id`);
COMMIT;
