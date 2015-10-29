<?php

class PaymentRequestBaseModel extends Eloquent
{

	protected $table = 'payment_request';

	/**
	 * function name: getItems
	 */
	public function getItems($pid, $limit, $page=0, $options=array())
	{
		$query = DB::table('payment_request')->select('payment_request.*', 'users.username');
		$query->join('publisher', 'publisher.id', '=', 'payment_request.publisher_id')
			->join('users', 'publisher.user_id','=','users.id');
		if($pid!=''){
			$query->where('payment_request.publisher_id', $pid);
		}
		if(!empty($options)){
			if(!empty($options['status'])){
				$query->where('payment_request.status', $options['status']);
			}
			if(!empty($options['publisher'])){
				$query->where('users.username', 'LIKE', '%'.$options["publisher"].'%');
			}
			if(!empty($options['month'])){
				$query->whereRaw('MONTH(pt_payment_request.created_at)="'.$options['month'].'"');
			}
			if(!empty($options['year'])){
				$query->whereRaw('YEAR(pt_payment_request.created_at)="'.$options['year'].'"');
			}
		}
		if(!empty($options['field']) && !empty($options['order'])){
			$query->orderBy($options['field'], $options['order']);
		}else{
			$query->orderBy('payment_request.created_at', 'desc');
		}
		if($page > 0){
			return $query->paginate($limit);
		}else{
			return $query->take($limit)->get();
		}
	}

	public function sumAmountPublisher($options=array())
	{
		$result = array();
		$query = DB::table('payment_request')->select('payment_request.*', 'users.username');
		$query->join('publisher', 'publisher.id', '=', 'payment_request.publisher_id')
			->join('users', 'publisher.user_id','=','users.id');
		if(!empty($options)){
			if(!empty($options['status'])){
				$query->where('payment_request.status', $options['status']);
			}
			if(!empty($options['publisher'])){
				$query->where('users.username', 'LIKE', '%'.$options["publisher"].'%');
			}
			if(!empty($options['month'])){
				$query->whereRaw('MONTH(pt_payment_request.created_at)="'.$options['month'].'"');
			}
			if(!empty($options['year'])){
				$query->whereRaw('YEAR(pt_payment_request.created_at)="'.$options['year'].'"');
			}
		}
		$result['totalAmount'] = $query->sum('payment_request.amount');
		$result['totalPublisher'] = count($query->groupBy('payment_request.publisher_id')->get());
		return $result;
	}
	/**
	 * function name: sumItemsByIds
	 * return sum amount of payment request
	 */
	public function sumItemsByIds($ids)
	{
		if(!empty($ids)){
			return DB::table('payment_request')->whereIn('id', $ids)->sum('amount');
		}else{
			return 0;
		}
	}
	/*
	 * function name: updateStatus base on ids
	 * @params array of id
	 */
	public function updateStatus($ids){
		if(!empty($ids)){
			foreach($ids as $id){
				$this->updateItem($id, array('status'=>STATUS_REQUEST));
			}
		}
	}
	public function updateItem($id, $options){
		return $this->where('id', $id)->update($options);
	}
}
