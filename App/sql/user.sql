CREATE TABLE `user` (
`id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
`pseudo` varchar(50) NOT NULL,
`password` varchar(72) NOT NULL,
`email` varchar(78) NOT NULL,
`filename` varchar(20) NOT NULL,
`created_at` datetime NOT NULL,
`last_connection` datetime NOT NULL,
`newsletter` tinyint(1) NOT NULL,
`flag` tinyint,
`banned` tinyint(1) NOT NULL,
`role_id` int(11) NOT NULL,
`token` varchar(72)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
