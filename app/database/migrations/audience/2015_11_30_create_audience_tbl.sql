CREATE TABLE `pt_audience` (
  `audience_id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text,
  `last_editor` varchar(100) DEFAULT NULL,
  `audience_update` datetime NOT NULL,
  PRIMARY KEY (`audience_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `pt_ad`
ADD `audience_id` int(11);

 ALTER TABLE `pt_flight`
ADD `audience` varchar(250);