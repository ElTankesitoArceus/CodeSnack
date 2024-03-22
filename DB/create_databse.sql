CREATE DATABASE codesnack DEFAULT CHARSET = utf8mb4 DEFAULT COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `users` (
    `id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
    `hash` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
    `profile_pic` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci

CREATE TABLE `snippets` (
    `id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UUID()',
    `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
    `code` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `description` text COLLATE utf8mb4_unicode_ci,
    `created` datetime NOT NULL,
    `last_edit` datetime DEFAULT NULL,
    `create_user` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
    `last_edit_user` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id_UNIQUE` (`id`),
    KEY `fk_snip_user` (`create_user`),
    CONSTRAINT `fk_snip_user` FOREIGN KEY (`create_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
