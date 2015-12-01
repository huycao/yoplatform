use `yomedia`;

DROP TABLE IF EXISTS `pt_tracking_audience`;
CREATE TABLE `pt_tracking_audience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` text NOT NULL,
  `uuid` VARCHAR(32) NOT NULL,
  `bid` int(11) NOT NULL DEFAULT '0',
  `impression` int(11) NOT NULL DEFAULT '0',
  `click` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
