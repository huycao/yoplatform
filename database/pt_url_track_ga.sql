create table pt_url_track_ga (id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, url varchar (255) NOT NULL);
alter table pt_url_track_ga add column 'active' tinyint(1) DEFAULT 0 ;
alter table pt_url_track_ga add column `run` varchar(6); 
alter table pt_url_track_ga change `url` `url` MEDIUMTEXT;
rename table pt_url_track_ga to pt_url_track_3rd;
alter table pt_url_track_3rd change `url` `url` varchar(255) NOT NULL;
alter table pt_url_track_3rd change `run` `run` varchar(3);
alter table pt_url_track_3rd add column `amount` INT(11) DEFAULT 0;
alter table pt_url_track_3rd add column `website` MEDIUMTEXT;

