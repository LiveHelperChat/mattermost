CREATE TABLE `lhc_mm_chat` (
                               `id` bigint(20) NOT NULL AUTO_INCREMENT,
                               `ctime` bigint(20) NOT NULL,
                               `chat_id` bigint(20) NOT NULL,
                               `mm_ch_id` varchar(30) NOT NULL,
                               PRIMARY KEY (`id`),
                               KEY `ctime` (`ctime`),
                               KEY `chat_id` (`chat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `lhc_mm_user` (
                               `id` bigint(20) NOT NULL AUTO_INCREMENT,
                               `lhc_user_id` bigint(20) NOT NULL,
                               `mm_user_id` varchar(30) NOT NULL,
                               PRIMARY KEY (`id`),
                               KEY `mm_user_id` (`mm_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;