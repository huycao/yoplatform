<?php

class CategoryTableSeeder extends Seeder {

	public function run(){
	    $dataInsert = array(
	        array('name'  =>  'Automotive','path'  =>  '1_'),
	        array('name'  =>  'Electronic','path'  =>  '2_'),
	        array('name'  =>  'Entertainment','path'  =>  '3_'),
	        array('name'  =>  'Event & Festival','path'  =>  '4_'),
	        array('name'  =>  'Fashion / Clothing','path'  =>  '5_'),
	        array('name'  =>  'Finance','path'  =>  '6_'),
	        array('name'  =>  'Food & Beverage','path'  =>  '7_'),
	        array('name'  =>  'Health & Beauty','path'  =>  '8_'),
	        array('name'  =>  'Institution / Organization','path'  =>  '9_'),
	        array('name'  =>  'Leisure','path'  =>  '10_'),
	        array('name'  =>  'Oil & Gas','path'  =>  '11_'),
	        array('name'  =>  'Other','path'  =>  '12_'),
	        array('name'  =>  'Portal','path'  =>  '13_'),
	        array('name'  =>  'Real Estate','path'  =>  '14_'),
	        array('name'  =>  'Retail','path'  =>  '15_'),
	        array('name'  =>  'Service','path'  =>  '16_'),
	        array('name'  =>  'Travel & Tourism','path'  =>  '17_'),
	        array('name'  =>  'Car Accessories','parent_id' =>  1,'path'      =>  '1_18_'),
	        array('name'  =>  'Vehicle','parent_id' =>  1,'path'      =>  '1_19_'),
	        array('name'  =>  'Digital, Gadget & Mobile device','parent_id' =>  2,'path'      =>  '2_20_'),
	        array('name'  =>  'Household Appliances','parent_id' =>  2,'path'      =>  '2_21_'),
	        array('name'  =>  'Broadcast & Airtime Management','parent_id' =>  3,'path'      =>  '3_22_'),
	        array('name'  =>  'Movie','parent_id' =>  3,'path'      =>  '3_23_'),
	        array('name'  =>  'Banking & Insurance','parent_id' =>  6,'path'      =>  '6_24_'),
	        array('name'  =>  'Debit, Credit & Royalty Card','parent_id' =>  6,'path'      =>  '6_25_'),
	        array('name'  =>  'Alcohol','parent_id' =>  7,'path'      =>  '7_26_'),
	        array('name'  =>  'Non-alcohol','parent_id' =>  7,'path'      =>  '7_27_'),
	        array('name'  =>  'Restaurant & Cafe','parent_id' =>  7,'path'      =>  '7_28_'),
	        array('name'  =>  'Cosmetic','parent_id' =>  8,'path'      =>  '8_29_'),
	        array('name'  =>  'Fitness Center','parent_id' =>  8,'path'      =>  '8_30_'),
	        array('name'  =>  'Therapy','parent_id' =>  8,'path'      =>  '8_31_'),
	        array('name'  =>  'Charity / Non Profit','parent_id' =>  9,'path'      =>  '9_32_'),
	        array('name'  =>  'Corporate','parent_id' =>  9,'path'      =>  '9_33_'),
	        array('name'  =>  'Education','parent_id' =>  9,'path'      =>  '9_34_'),
	        array('name'  =>  'Government','parent_id' =>  9,'path'      =>  '9_35_'),
	        array('name'  =>  'Gambling','parent_id' =>  10,'path'      =>  '10_36_'),
	        array('name'  =>  'Games','parent_id' =>  10,'path'      =>  '10_37_'),
	        array('name'  =>  'Pet','parent_id' =>  10,'path'      =>  '10_38_'),
	        array('name'  =>  'Publication','parent_id' =>  10,'path'      =>  '10_39_'),
	        array('name'  =>  'PSA (Public Service Announcement)','parent_id' =>  12,'path'      =>  '12_40_'),
	        array('name'  =>  'Publisher in-House Serving','parent_id' =>  12,'path'      =>  '12_41_'),
	        array('name'  =>  'Testing','parent_id' =>  12,'path'      =>  '12_42_'),
	        array('name'  =>  'HR / Recruitment','parent_id' =>  13,'path'      =>  '13_43_'),
	        array('name'  =>  'Online Approach','parent_id' =>  13,'path'      =>  '13_44_'),
	        array('name'  =>  'FMCG','parent_id' =>  15,'path'      =>  '15_45_'),
	        array('name'  =>  'Home Furnishing & Lifestyle','parent_id' =>  15,'path'      =>  '15_46_'),
	        array('name'  =>  'Hypermarket','parent_id' =>  15,'path'      =>  '15_47_'),
	        array('name'  =>  'Optical, Timepiece & Jewelry','parent_id' =>  15,'path'      =>  '15_48_'),
	        array('name'  =>  'Internet & Technology','parent_id' =>  16,'path'      =>  '16_49_'),
	        array('name'  =>  'Logistic & Transport','parent_id' =>  16,'path'      =>  '16_50_'),
	        array('name'  =>  'Public Utilities','parent_id' =>  16,'path'      =>  '16_51_'),
	        array('name'  =>  'Telco','parent_id' =>  16,'path'      =>  '16_52_'),
	        array('name'  =>  'Accomodation','parent_id' =>  17,'path'      =>  '17_53_'),
	        array('name'  =>  'Airlines','parent_id' =>  17,'path'      =>  '17_54_'),
	        array('name'  =>  'Place','parent_id' =>  17,'path'      =>  '17_55_')
	    );
	    
		foreach( $dataInsert as $data ){
	    	DB::table('category')->insert($data);
		}

	}

}