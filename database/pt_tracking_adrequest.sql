CREATE TABLE `pt_tracking_adrequest` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `website_id` int(11) NOT NULL,
  `publisher_ad_zone_id` int(10) unsigned DEFAULT '0',
  `hour` int(11) NOT NULL,
  `date` date NOT NULL,
  `count` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
