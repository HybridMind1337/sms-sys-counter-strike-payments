
CREATE TABLE IF NOT EXISTS `banners` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `url` varchar(255) NOT NULL,
    `image` varchar(255) NOT NULL,
    `expires` int(11) NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


INSERT INTO `banners` (`id`, `name`, `url`, `image`, `expires`) VALUES
                                                                    (1, 'Webocean.INFO', 'https://webocean.info/', 'https://i.imgur.com/gOiTysP.png', 1685656676),
                                                                    (2, 'AMXX-BG', 'https://amxx-bg.info', 'http://i.imgur.com/xNPAxRj.png', 1685656717);


CREATE TABLE IF NOT EXISTS `chronology` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `amount` varchar(255) NOT NULL,
    `balance` int(11) NOT NULL,
    `date` int(11) NOT NULL,
    `type` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `flags_data` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `server_id` int(11) NOT NULL,
    `name` varchar(355) NOT NULL,
    `flags` varchar(355) NOT NULL,
    `valid` int(11) NOT NULL,
    `credits` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


INSERT INTO `flags_data` (`id`, `server_id`, `name`, `flags`, `valid`, `credits`) VALUES
                                                                                      (1, 1, 'VIP', 'abc', 30, '50'),
                                                                                      (2, 1, 'TEST', 'asf', 31, '124'),
                                                                                      (3, 6, 'TA', 'abv', 13, '125');

CREATE TABLE IF NOT EXISTS `prices_data` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(355) NOT NULL,
    `price` int(11) NOT NULL,
    `valid` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO `prices_data` (`id`, `name`, `price`, `valid`) VALUES
                                                               (1, 'banner', 25, '51'),
                                                               (2, 'unban', 50, '0'),
                                                               (3, 'ungag', 51, '0');

CREATE TABLE IF NOT EXISTS `sms_data` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `service_id` int(11) NOT NULL,
    `text` varchar(255) NOT NULL,
    `number` int(11) NOT NULL,
    `amount` varchar(255) NOT NULL,
    `credits` int(11) NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


INSERT INTO `sms_data` (`id`, `user_id`, `service_id`, `text`, `number`, `amount`, `credits`) VALUES
                                                                                                  (1, 1251, 125, 'credits', 1092, '2.40', 50),
                                                                                                  (2, 125, 125125, 'test', 1213, '4.80', 500),
                                                                                                  (3, 120, 130, 'test', 1094, '6.00', 400);

CREATE TABLE IF NOT EXISTS `transactions` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `service` varchar(355) NOT NULL,
    `balance` int(11) NOT NULL,
    `date` int(11) NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `email` varchar(355) NOT NULL,
    `admin` int(11) NOT NULL DEFAULT '0',
    `password` char(60) NOT NULL,
    `ip` int(11) NOT NULL,
    `registered_on` int(11) NOT NULL,
    `balance` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


INSERT INTO `users` (`id`, `email`, `admin`, `password`, `ip`, `registered_on`, `balance`) VALUES
    (1, 'hybridmind1337@gmail.com', 1, '$2y$10$XZQMZY1xEFyaRZzMW8MjaeVw9MImZ7aJNgK7MDmYQqS7pkhMSZ/EC', 2130706433, 1680709681, 550);
COMMIT;
