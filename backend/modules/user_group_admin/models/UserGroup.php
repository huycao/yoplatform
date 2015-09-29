<?php

class UserGroup extends Cartalyst\Sentry\Groups\Eloquent\Group {

	public function getShowField(){
		return array(
			'name'			=>	trans('text.name'),
			'created_at'	=>	trans('text.created_at'),
		);
	} 

	public function getSearchField(){ 
		return array(
			'name'		=>	trans('text.name'),
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
