CREATE TABLE `article` (
`id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
`title` varchar(50) NOT NULL,
`sentence` tinytext NOT NULL,
`content` text NOT NULL,
`filename` varchar(20) NOT NULL,
`user_id` int(11) NOT NULL,
`created_at` datetime NOT NULL,
`published_at` datetime NOT NULL,
`updated_at` datetime,
`updated_user_id` int(11),
`category_id` int(11) NOT NULL,
`status` tinyint(1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
