<?php

class ModulesAdminModel extends Eloquent {

	protected $table = 'modules';
	protected $fillable = array('name', 'slug', 'status');

	public function getShowField(){
		return array(
	        'name'         =>  array(
	            'label'         =>  trans('text.name'),
	            'type'          =>  'text'
	        ),
	        'status'         =>  array(
	            'label'         =>  trans('text.status'),
	            'type'          =>  'boolean'
	        ),
	        'created_at'    =>  array(
	            'label'         =>  trans('text.created_at'),
	            'type'          =>  'text'
	        )
		);
	}



	public function getSearchField(){
		return array(
			'name'			=>	trans('text.name')
		);
	}

	public function scopeSearch($query, $keyword = '', $filterBy = 0)
	{
		if( !empty($keyword) ){

			if( !empty($filterBy)  ){
				$query->where($filterBy, 'LIKE', "%{$keyword}%");
			}else{
				if( !empty($this->searchField) ){
					foreach( $this->searchField as $field => $title){
						$query->orWhere($field, 'LIKE', "%{$keyword}%");
					}
				}
			}

		}

		return $query;
	}	

}
