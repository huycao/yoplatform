<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
		
		<!-- text fonts -->
		{{ HTML::style("http://fonts.googleapis.com/css?family=Open+Sans:400,300") }}
		{{ HTML::style("{$assetURL}css/bootstrap.min.css") }}
		{{ HTML::style("{$assetURL}css/font-awesome.min.css") }}

		<style type="text/css">
			.login-panel {
			    margin-top: 25%;
			}
		</style>
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		{{ HTML::script("{$assetURL}js/html5shiv.js") }}
		{{ HTML::script("{$assetURL}js/respond.min.js") }}
		<![endif]-->
        {{ HTML::script("{$assetURL}js/vendor/modernizr-2.6.2.min.js") }}
    </head>
    <body>

	    <div class="container">
	        <div class="row">
	            <div class="col-md-4 col-md-offset-4">
	                <div class="login-panel panel panel-primary">
	                    <div class="panel-heading">
	                        <h3 class="panel-title">Please Sign In</h3>
	                    </div>
	                    <div class="panel-body">
		            		{{ Form::open(array('role'=>'form')) }}
	                            <fieldset>
	                                <div class="form-group">
	                                    <input class="form-control" placeholder="Username" name="loginUsername" type="text" autofocus>
				                        @if( isset($validate) && $validate->has('loginUsername')  )
				                        <span class="label label-danger">{{{ $validate->first('loginUsername') }}}</span>
				                        @endif
	                                </div>
	                                <div class="form-group">
	                                    <input class="form-control" placeholder="Password" name="loginPassword" type="password" value="">
				                        @if( isset($validate) && $validate->has('loginPassword')  )
				                        <span class="label label-danger">{{{ $validate->first('loginPassword') }}}</span>
				                        @endif

				                        @if( !empty($message) )
				                        <span class="label label-danger">{{{ $message }}}</span>
				                        @endif				                        
	                                </div>
	 <!--                                <div class="checkbox">
	                                    <label>
	                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
	                                    </label>
	                                </div>
 -->	                                <!-- Change this to a button or input when using this as a form -->
	                                <button type="submit" class="btn btn-primary btn-block">Login</button>
		            			{{ Form::close() }}
	                        </form>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>

		{{ HTML::script("{$assetURL}js/vendor/jquery-1.10.2.min.js") }}
		{{ HTML::script("{$assetURL}js/plugins.js") }}
		{{ HTML::script("{$assetURL}js/bootstrap.min.js") }}

    </body>
</html>
