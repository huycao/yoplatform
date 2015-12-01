CREATE TABLE `pt_audience` (
  `audience_id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text,
  `last_editor` varchar(100) DEFAULT NULL,
  `audience_update` datetime NOT NULL,
  PRIMARY KEY (`audience_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

