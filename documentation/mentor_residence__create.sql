CREATE TABLE `startuppuccino__mentor_residence` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `mentor_id` int(11) NOT NULL,
 PRIMARY KEY (`id`),
 CONSTRAINT `fk2_mentor_id` FOREIGN KEY (`mentor_id`) REFERENCES `startuppuccino__account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=190 DEFAULT CHARSET=utf8mb4