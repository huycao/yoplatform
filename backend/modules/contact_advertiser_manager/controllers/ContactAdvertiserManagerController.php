<?php

class ContactAdvertiserManagerController extends AdvertiserManagerController 
{

	public function __construct(ContactAdvertiserManagerModel $model) {
		parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
		$this->model = $model;
	}	

	/**
	 * Store a newly created resource in storage.
	 * @param  array Form Data
	 * @return Response
	 */
	public function update(){
		if( Request::ajax() ){

			$status 	= FALSE;
			$message 	= NULL;
			$view 		= NULL;

			// check validate
			$validate 		= Validator::make(Input::all(), $this->model->getUpdateRules(), $this->model->getUpdateLangs());
			if( $validate->passes() ){
				$updateData = array(
					'status'		=>	1,
					'name'			=>	Input::get('name'),
					'email'			=>	Input::get('email'),
					'phone'			=>	Input::get('phone'),
					'fax'			=>	Input::get('fax'),
					'updated_by'	=>	$this->user->id
				);

				$id = Input::get('id');
				$type 		= Input::get('type');
				$typeID 	= Input::get('typeID');

				if( $id == 0 ){
					$updateData['created_by']	= $this->user->id;

					if( $item = $this->model->create($updateData) ){
						// create relationship field

						$contactList = $item->storeRelation($type, $typeID);

						$status		= TRUE;
						$message 	= View::make('partials.show_messages', array('message'=>trans('contact::message.create_success')))->render();
						$view 		= View::make('contactList', array('contactList'=>$contactList))->render();
					}
				}else{
					$item = $this->model->find($id);
					if( $item ){
						$this->model->where("id",$id)->update($updateData);
						$status		= TRUE;
						$message 	= View::make('partials.show_messages', array('message'=>trans('contact::message.update_success')))->render();
						$view 		= View::make('contactList', array('contactList'=>$item->{$type}->first()->contact))->render();
					}

				}

			}else{
				$message 	= View::make('partials.show_messages', array('errors'=>$validate->messages()))->render();
			}

			return Response::json(array(
				'status'	=>	$status,
				'message'	=>	$message,
				'view'		=>	$view
			));

		}
	}


	/**
	 * Remove the specified resource from storage.
	 * @param  string 	$type 		name table belongs to contact
	 * @param  integer 	$typeID 	id of type
	 * @param  integer 	$contactID 	id of type
	 * @return Response
	 */	
	public function delete(){

		if( Request::ajax() ){

			$type 		= Input::get('type');
			$typeID 	= Input::get('typeID');
			$contactID 	= Input::get('contactID');

			$status 	= FALSE;
			$view 		= NULL;

			$contact = $this->model->find($contactID);
			if( $contactList = $contact->deleteRelation($type, $typeID)){
				$status = TRUE;
				$view 	= View::make('contact_advertiser_manager.contactList', array('contactList'=>$contactList))->render();
			}

			return Response::json(array(
				'status'	=>	$status,
				'view'		=>	$view
			));

		}
	}

	/**
	 *     Load Modal Add/Edit Contact
	 *     @param  integer 	$id 	id of Contact
	 *     @return Response
	 */
	public function loadModal(){
		if( Request::ajax() ){

			$id = Input::get('id');

			$status 	= TRUE;
			$view 		= NULL;

			$contactData = null;
			if( $id !=0 ){
				$contactData = $this->model->find($id);
			}

			return Response::json(array(
				'status'	=>	$status,
				'view'		=>	View::make('contactModal', array('contactData'=>$contactData))->render()
			));

		}
	}


}
