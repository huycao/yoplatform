<?php
 
class UserDashboardModel extends User{
    public function publisher() {
        return $this->belongsTo('PublisherDashboardModel','publisher_id');
    }    
}
