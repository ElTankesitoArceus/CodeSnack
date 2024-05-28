CREATE DATABASE codesnack DEFAULT CHARSET = utf8mb4 DEFAULT COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `users` (
    `id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT (uuid()),
    `username` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL unique,
    `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
    `hash` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
    `profile_pic` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
;

CREATE TABLE `snippets` (
    `id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT (uuid()),
    `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
    `code` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `description` text COLLATE utf8mb4_unicode_ci,
    `created` datetime NOT NULL DEFAULT (CURRENT_DATE),
    `last_edit` datetime DEFAULT DEFAULT (CURRENT_DATE),
    `create_user` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
    `last_edit_user` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id_UNIQUE` (`id`),
    KEY `fk_snip_user` (`create_user`),
    CONSTRAINT `fk_snip_user` FOREIGN KEY (`create_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
;

CREATE TABLE `tags` ( 
    `name` VARCHAR(20) COLLATE utf8mb4_unicode_ci NOT NULL,
    `color` BINARY(3) NOT NULL,
    `id` INT AUTO_INCREMENT NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `unique_name` UNIQUE (`name`)    
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
;

CREATE TABLE `snippet_tags` ( 
    `id` INT AUTO_INCREMENT NOT NULL,
    `snippet_id` VARCHAR(36) NOT NULL,
    `tag_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `unique_tag_per_snippet` UNIQUE (`snippet_id`, `tag_id`)
);
ALTER TABLE `snippet_tags` ADD CONSTRAINT `snippet_tag_fk` FOREIGN KEY (`snippet_id`) REFERENCES `snippets` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `snippet_tags` ADD CONSTRAINT `tag_snippet_fk` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
