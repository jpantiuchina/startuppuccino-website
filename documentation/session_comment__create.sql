CREATE TABLE `session_comment` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `session_id` int(11) NOT NULL,
 `author_id` int(11) NOT NULL,
 `text` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
 `commented_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`),
 KEY `session_comment_session` (`session_id`),
 KEY `session_comment_author` (`author_id`),
 CONSTRAINT `session_comment_author` FOREIGN KEY (`author_id`) REFERENCES `account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
 CONSTRAINT `session_comment_session` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4