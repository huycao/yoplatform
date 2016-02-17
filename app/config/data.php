<?php

return array(
    'approve_status'   =>  array(
        '0' =>  'Pending',
        '1' =>  'Archived',
        '2' =>  'Disaprroved',
        '3' =>  'Approved'
    ),
	'flight_objective'     =>  array(
        'Create brand awareness',
        'Member Sign Up',
        'Contest Participation',
        'Sales lead / Convension'
    ),
    'flight_model'  =>  array(
        'cpm'   =>  'CPM',
        'cpc'   =>  'CPC',
        'cpv'   =>  'CPV',
        'cpe'   =>  'CPE',
        'cpa'   =>  'CPA'
    ),
    'flight_type'   =>  array(
        'adnetwork' =>  'Adnetwork',
        'premium'   =>  'Premium'
    ),
    'sale_status'	=>	array(
    	1 	=>	'Lead',
    	2 	=>	'Proposed - 10%',
    	3 	=>	'Proposed - 50%',
    	4 	=>	'Proposed - 90%',
    	5 	=>	'Won - Submit for Approval'
    ),
    'ad_type'    =>  array(
        'image' =>  'Image',
        'flash' =>  'Flash',
        'video' =>  'Video',
        'html'	=>  'HTML'
    ),
    'wmode' =>  array(
        'none',
        'window',
        'direct',
        'opaque',
        'transparent',
        'gpu'
    ),
    'video_linear'  => array(
        'linear'        =>  'Linear',
        'non-linear'    =>  'Non-Linear'
    ),
    'video_type_vast'  => array(
        'inline'        =>  'Inline',
        'wrapper'       =>  'Wrapper'
    ),
    'event'  => array(
        'click'        =>  'Click',
        'complete'     =>  'Complete',
        'conversion'   =>  'Conversion',
        'impression'   =>  'Impression'
    ),
    'platform'  => array(
        'pc'            =>  'PC',
        'mobile'        =>  'Mobile',
        'mobile_android'=>  'Mobile Android',
        'mobile_ios'    =>  'Mobile IOS',
        'mobile_app'    =>  'Mobile App'
    ),
    'ad_format_type'  => array(
        'static'           =>  'Static',
        'dynamic'       =>  'Dynamic'
    ),
    'event_tracking'  => array(
        //general metrics
        'impression','unique_impression','click','unique_click','ads_request','conversion',
        //TVC metrics
        'start','firstquartile','midpoint','thirdquartile','complete','pause','unpause','mute','unmute','fullscreen'
    )
);