<?php
class HomeController extends FrontendController
{

	public function __construct(){
		parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
	}

	public function index(){
		$this->layout = View::make('layout.staticHome');
		$this->layout->slugMenu = 'home';		
		$this->layout->content = View::make('homepage');
	}

	public function publisher(){
		$this->layout = View::make('layout.main');		
		$this->layout->slugMenu = 'publisher';
		$this->layout->content = View::make('publisherPage');
	}

	public function advertiser(){
		$this->layout = View::make('layout.main');
		$this->layout->slugMenu = 'advertiser';		
		$this->layout->content = View::make('advertiserPage');
	}

	public function aboutUs(){
		$this->layout = View::make('layout.main');
		$this->layout->slugMenu = 'about-us';		
		$this->layout->content = View::make('aboutUsPage');
	}

	public function contactUs(){
		$this->layout = View::make('layout.main');	
		$this->layout->slugMenu = 'contact-us';	
		$this->layout->content = View::make('contactUsPage');
	}

	public function contactInfo(){
		$this->layout = View::make('layout.main');	
		$this->layout->slugMenu = '';
        $countryModel = new CountryBaseModel;
        $this->data['listCountry']	= $countryModel->getAllForm();

        $this->data['listWebsiteCategory'] 	= CategoryBaseModel::where('status', 1)->where('parent_id', 0)->where('name', '!=', 'Other')->orderBy('name','asc')->get()->toArray();
        $this->data['listLanguage'] 		= LanguageBaseModel::where('status', 1)->orderBy('name','asc')->get()->toArray();
        //$this->data['listReason']			= $this->model->reason;
        if(Request::isMethod('post')){
            $this->postContactInfo($this->data);
        }
        $this->layout->slugMenu = '';
        $this->layout->content = View::make('contactInfoPage',$this->data);
	}
    public function postContactInfo(&$data){
        $this->model = new PublisherModel;
        $Rules = $this->model->getContactInfoRules();
        $Langs = $this->model->getContactInfoLangs();

        $validate 		= Validator::make(Input::all(), $Rules, $Langs);

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
                'country_id'	    =>	Input::get('country'),
                'phone'				=>	Input::get('phone'),
                'fax'				=>	Input::get('fax'),
                'email'				=>	Input::get('email'),
                'payment_to'		=>	Input::get('payment_to'),
                'site_name'			=>	Input::get('site_name'),
                'site_url'			=>	Input::get('site_url'),
                'site_description'	=>	Input::get('site_description'),
                'status'			=>	0
            );

            // insert new publisher pending
            if( $publisher = $this->model->create($insertData) ){
                Session::flash('success', 'Thank you! Your application has been submitted! Note All applications will be responded to within 5 working days from the date of submission');
                return Redirect::to('form');
            }

        }else{
            $data['validate'] = $validate->messages();
        }
        return Redirect::to('form')->withInput();

    }

	public function video(){
		$this->layout = View::make('layout.main');	
		$this->layout->slugMenu = '';	
		$this->layout->content = View::make('videoDetailPage');
	}

	public function demoVast(){
		return View::make('runVast');
	}

	public function demoPopup(){
		return View::make('runPopup');
	}

	public function demoBalloon(){
		return View::make('runBalloon');
	}

	public function demoTVC(){
		return View::make('tvc');
	}

	public function demoPauseVast(){
		$size = Input::get('size');
		$data = ['w'=>640,'h'=>480];
		if($size){
			$sizeArr = explode('x', $size);
			$data['w'] = !empty($sizeArr[0]) ? $sizeArr[0] : 640;
			$data['h'] = !empty($sizeArr[1]) ? $sizeArr[1] : 480;
		}
		return Response::view('pauseVast', $data)->header('Content-Type', "application/xml; charset=UTF-8");
	}
    public function demoSidekick(){
        return View::make('runSidekick');
    }
}