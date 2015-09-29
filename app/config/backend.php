<?php

return array(
    'theme'                        =>	'default',
    'uri'                          => 	'control-panel',
    'backend_path'                 =>	URL::to('/').'/control-panel/',

    'publisher_approved'            =>  3,
    'publisher_pending'             =>  0,
    'publisher_disapproved'         =>  2,
    'publisher_archived'            =>  1,
    
    'group_admin_id'               =>	1,
    'group_publisher_manager_id'   =>	2,
    'group_advertiser_manager_id'  =>	3,
    'group_publisher_id'           =>	4,
    'group_advertiser_id'          =>	5,
    
    'group_admin_url'              =>	'admin',
    'group_publisher_manager_url'  =>	'publisher-manager',
    'group_advertiser_manager_url' =>	'advertiser-manager',
    'group_publisher_url'          =>	'publisher',
    'group_advertiser_url'         =>	'advertiser'
);