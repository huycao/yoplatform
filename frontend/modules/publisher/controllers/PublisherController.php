<?php
	
class PublisherController extends FrontendController
{

	/**
	* MessageBag errors
	*
	* @var Illuminate\Support\MessageBag;
	*/
	protected $errors;

	/**
	 *     Model
	 *   
	 */
	protected $model;


	public function __construct(){
		parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
		$this->model 	= new PublisherModel;
    	$this->errors 	= array();
	}

	public function getUploadPath( $dateString ){
		$filePath = PUBLISHER_TRAFFIC_REPORT_FILE_PATH.$dateString;
		newFolder($filePath);
		return $filePath;
	}

	public function register(){

		if (Request::isMethod('post'))
		{
			$this->postRegister();
		}

		$countryModel = new CountryBaseModel;
		$this->data['listCountry']	= $countryModel->getAllForm();

		$this->data['listWebsiteCategory'] 	= CategoryBaseModel::where('status', 1)->where('parent_id', 0)->where('name', '!=', 'Other')->orderBy('name','asc')->get()->toArray();
		$this->data['listLanguage'] 		= LanguageBaseModel::where('status', 1)->orderBy('name','asc')->get()->toArray();
		$this->data['listReason']			= $this->model->reason;

		$this->data['errors']	= $this->errors;
		$this->layout->content 	= View::make('register', $this->data);
	}

	public function postRegister(){
		Input::merge(array_map('trimInput', Input::all()));

		$registerRules = $this->model->getRegisterRules();
		$registerLangs = $this->model->getRegisterLangs();

		$validate 		= Validator::make(Input::all(), $registerRules, $registerLangs);

		if( $validate->passes() ){

			$insertData = array(
				'first_name'		=>	Input::get('first_name'),
				'last_name'			=>	Input::get('last_name'),
				'title'				=>	Input::get('title'),
				'company'			=>	Input::get('company'),
				'address'			=>	Input::get('address'),
				'city'				=>	Input::get('city'),
				'state'				=>	Input::get('state'),
				'postcode'			=>	Input::get('postcode'),
				'country'			=>	Input::get('country'),
				'phone'				=>	Input::get('phone'),
				'fax'				=>	Input::get('fax'),
				'email'				=>	Input::get('email'),
				'payment_to'		=>	Input::get('payment_to'),
				'site_name'			=>	Input::get('site_name'),
				'site_url'			=>	Input::get('site_url'),
				'site_description'	=>	Input::get('site_description'),
				'unique_visitor'	=>	Input::get('unique_visitor'),
				'pageview'			=>	Input::get('pageview'),
				'status'			=>	0
			);

			// check if has other language
			$languages = Input::get('languages');
			if( in_array('otherlanguage', $languages) ){
				$insertData['other_lang'] = Input::get('otherlanguage');
			}

			// check if has other category
			$category = Input::get('category');
			if( 'othercategory' == $category ){
				$insertData['other_category'] = Input::get('othercategory');
			}else{
				$insertData['category']		=	$category;
			}


			// check if has reason
			$reason = array();
			if( Input::get('reason') != NULL ){

				foreach( Input::get('reason') as $item ){
					$reason[$item] = 1;
					//check if from any blog
					if( $item == 'reasonblog' ){
						$reason['reasonblog'] = Input::get('reasonblog');
					}
					//check if form other
					if( $item == 'reasonother' ){
						$reason['reasonother'] = Input::get('reasonother');
					}
				}
				$insertData['reason'] = json_encode($reason);
			}

			// check file traffic report upload
			$file = Input::file('traffic_report_file');

			if($file->isValid()){
			   
			   	$dateString 		= date('Y/m/d');
				$destinationPath 	= $this->getUploadPath($dateString);
				$fileExtension 		= $file->getClientOriginalExtension();
				$fileName 			= time().".".$fileExtension;

				if($file->move($destinationPath, $fileName)){
					$insertData['traffic_report_file'] = $dateString.'/'.$fileName;
				}

			}

			// insert new publisher pending
			if( $publisher = $this->model->create($insertData) ){
				// insert to relation table publisher_language
				foreach( $languages as $lang ){
					PublisherLanguageBaseModel::create(array(
						'publisher_id'	=>	$publisher->id,
						'language_name'	=>	$lang
					));
				}
				Session::flash('success', 'Thank you! Your application has been submitted! Note All applications will be responded to within 5 working days from the date of submission');
				return Redirect::to('form');
			}
			
		}else{
			$this->errors = $validate->messages();
		}

		return Redirect::to('form')->withInput();


	}

}