CREATE TABLE `category` (
`id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
`title` varchar(25) NOT NULL,
`sentence` tinytext NOT NULL,
`filename` varchar(20) NOT NULL,
`status` tinyint(1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
