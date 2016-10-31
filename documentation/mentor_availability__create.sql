CREATE TABLE `mentor_availability` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `mentor_id` int(11) NOT NULL,
 `session_id` int(11) NOT NULL,
 `confirmed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `pitch` tinyint(1) NOT NULL DEFAULT '0',
 `pitch_approved` tinyint(1) DEFAULT NULL,
 `pitch_title` varchar(300) NOT NULL DEFAULT '',
 PRIMARY KEY (`id`),
 UNIQUE KEY `available_id` (`mentor_id`,`session_id`),
 KEY `fk_session_id_idx` (`session_id`),
 CONSTRAINT `fk_mentor_id` FOREIGN KEY (`mentor_id`) REFERENCES `account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
 CONSTRAINT `fk_session_id` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=utf8mb4