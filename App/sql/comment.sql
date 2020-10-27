CREATE TABLE `comment` (
`id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
`content` text NOT NULL,
`article_id` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`created_at` datetime NOT NULL,
`status` tinyint(3)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
