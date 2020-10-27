/* Article */
ALTER TABLE `article` ADD CONSTRAINT `fk_article_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
ALTER TABLE `article` ADD CONSTRAINT `fk_article_updated_user_id` FOREIGN KEY (`updated_user_id`) REFERENCES `user` (`id`);
ALTER TABLE `article` ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

/* Comment */
ALTER TABLE `comment` ADD CONSTRAINT `fk_comment_article_id` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`);
ALTER TABLE `comment` ADD CONSTRAINT `fk_comment_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/* User */
ALTER TABLE `user` ADD CONSTRAINT `fk_user_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);