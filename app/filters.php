<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	// header("Expires: Tue, 01 Jan 2000 00:00:00 GMT"); 
	// header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
	// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); 
	// header("Cache-Control: post-check=0, pre-check=0", false); 
	// header("Pragma: no-cache"); 
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{	
			Session::set("returnUrl", Request::path());
			return Redirect::to('/login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});


// Route::filter('ajax', function(){

// 	if (Request::ajax()){
// 		dump_exit($this->layout);
// 	}

// });

/* Backend Filter
===================================*/
	
Route::filter('notAuth', function()
{
	if( Sentry::check() )
	{
		// User is not logged in, or is not activated
		$url = Session::get('attemptedUrl');
		if( !isset($url) ){
			$section = Request::segment(2);
			switch ($section) {
				case 'admin':
					$url = URL::route('AdminDashboard');
					break;

				case 'publisher':
					$url = URL::route('PublisherDashboard');
					break;

				case 'publisher-manager':
					$url = URL::route('PublisherManagerDashboard');
					break;
				
				case 'advertiser':
					$url = URL::route('AdvertiserDashboard');
					break;
				
				case 'advertiser-manager':
					$url = URL::route('AdvertiserManagerDashboard');
					break;
				
				default:
					break;
			}
		}
		Session::forget('attemptedUrl');

		return Redirect::to($url);

	}	
});

Route::filter('basicAuth', function()
{
	if( !Sentry::check() ){
		Session::put('attemptedUrl', URL::current());
		$section = Request::segment(2);
		switch ($section) {
			case 'admin':
				return Redirect::route('AdminLogin');
				break;
			
			case 'publisher':
				return Redirect::route('PublisherLogin');
				break;

			case 'publisher-manager':
				return Redirect::route('PublisherManagerLogin');
				break;
				
			case 'advertiser':
				return Redirect::route('AdvertiserLogin');
				break;
				
			case 'advertiser-manager':
				return Redirect::route('AdvertiserManagerLogin');
				break;

		}
	}
});


Route::filter('hasPermissions', function($route, $request, $permission){

	$permission = strtolower($permission);

    if(!Sentry::getUser()->hasAccess($permission))
    {
		if (Request::ajax()){
			return "access-denied";
		}else{
			$section = Request::segment(2);
			switch ($section) {
				case 'admin':
					return Redirect::route('AdminAccess');
					break;
				
				case 'publisher':
					return Redirect::route('PublisherAccessDenied');
					break;

				case 'publisher-manager':
					return Redirect::route('PublisherManagerAccessDenied');
					break;
					
				case 'advertiser':
					return Redirect::route('AdvertiserAccessDenied');
					break;
					
				case 'advertiser-manager':
					return Redirect::route('AdvertiserManagerAccessDenied');
					break;
				}

		}
    }

});

/* End Backend Filter
===================================*/

Route::filter('1x1gif', function($route, $request, $response)
{
	$response->header("Cache-Control","no-cache,no-store, must-revalidate", true);
    $response->header("Content-Type", "image/gif"); //HTTP 1.0
});