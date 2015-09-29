<?php
class AdminGetTypeContent{

	/**
	 *     instance
	 *     @var Singleton
	 */
	private static $instance;

	/**
	 *     Type of content
	 *     @var string
	 */
	public $type;

	/**
	 *     Value of content
	 *     @var string
	 */
	public $value;

	/**
	 *     make
	 *     @param string $type  type of content
	 *     @param string $field  field of content
	 *     @param string $id  	id of content  
	 *     @param string $value value of content
	 */
	public static function make( $type = "text", $field = "", $id = 0 , $value = ""){
		if ( is_null( self::$instance ) )
	    {
			self::$instance = new self();
	    }
	    $obj = self::$instance;
		$obj->type 		= $type;
		$obj->field 	= $field;
		$obj->value 	= $value;
		if ($field == 'name') {
		    $obj->value = "({$id}) {$obj->value}";
		}
		$obj->id 		= $id;
		
		return $obj->{$type}();

	}

	/**
	 *     Get type text content
	 *     @return string HTML
	 */
	public function text(){
		return "<td>".$this->value."</td>";
	}

	/**
	 *     Get type boolean content
	 *     @return [type] [description]
	 */
	public function boolean(){
		$onClick = "changeBooleanType({$this->id}, {$this->value},'{$this->field}')";
		return '<td class="'.$this->field.'-'.$this->id.'"><a href="javascript:;" onclick="'.$onClick.'"><i class="'.$this->getClassTypeBoolean($this->value).'"></i></a></td>';
	}

	public function image(){
		return '<th><img src="'.img($this->value, 90, 0, 1).'" alt=""></th>';
	}

	/**
	 *     Helper get class of boolean type
	 *     @return [type] [description]
	 */
	public static function getClassTypeBoolean($value) {
    	return ($value) ? "fa fa-check fa-check-right" : "fa fa-times fa-times-wrong";
    }

}