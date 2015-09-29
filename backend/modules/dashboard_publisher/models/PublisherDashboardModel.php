<?php
 
class PublisherDashboardModel extends PublisherBaseModel{
    function zones(){
       return $this->hasMany('SitePublisherModel', 'publisher_id');
    }
}
