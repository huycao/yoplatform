<?php

class Menus extends Eloquent {

	protected $table = 'menus';
	protected $fillable = array('name', 'slug', 'module_id', 'icon', 'status');

	public function getUpdateRules(){
		return array(
			"name"			=>	"required"
		);
	}

	public function getUpdateLangs(){
		return array(
			"name.required"		=>	trans('menu::validation.name.required')
		);
	}

	public function getShowField(){
		return array(
	        'order'         =>  array(
	            'label'         =>  trans('menu::field.order'),
	            'type'          =>  'text'
	        ),        
	        'name'         =>  array(
	            'label'         =>  trans('menu::field.name'),
	            'type'          =>  'text'
	        ),
	        'slug'         =>  array(
	            'label'         =>  trans('menu::field.slug'),
	            'type'          =>  'text'
	        ),
	        'icon'         =>  array(
	            'label'         =>  trans('menu::field.icon'),
	            'type'          =>  'text'
	        ),
	        'status'         =>  array(
	            'label'         =>  trans('menu::field.status'),
	            'type'          =>  'boolean'
	        ),
	        'created_at'    =>  array(
	            'label'         =>  trans('menu::field.created_at'),
	            'type'          =>  'text'
	        )
		);
	}



	public function getSearchField(){
		return array(
			'name'			=>	trans('menu::field.name')
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

	public static function scopeGetList($query){
		return $query->where('status', 1)->orderBy('order', 'asc')->orderBy('created_at', 'asc')->get()->toArray();
	}

}
