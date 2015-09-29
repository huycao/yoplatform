<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Yomedia</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
		
		<!-- text fonts -->
		{{ HTML::style("{$assetURL}css/bootstrap-default.min.css") }}
        {{ HTML::style("{$assetURL}css/font-awesome.min.css") }}

		<!-- ace styles -->
		{{ HTML::style("{$assetURL}css/admin.css") }}
        
        {{ HTML::style("{$assetURL}css/publisher-manage.css") }}
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		{{ HTML::script("{$assetURL}js/html5shiv.js") }}
		{{ HTML::script("{$assetURL}js/respond.min.js") }}
		<![endif]-->
        <script type="text/javascript">

            var root    = "{{{ URL::to('/') }}}/{{{ Config::get('backend.uri').'/publisher-manager' }}}/";
            var assetURL =   "{{{ URL::to('/') }}}/public/";
            var module  = "{{{ Request::segment(3) }}}";

        </script>

        {{ HTML::script("{$assetURL}js/vendor/modernizr-2.6.2.min.js") }}
        {{ HTML::script("{$assetURL}js/vendor/jquery-1.10.2.min.js") }}
        {{ HTML::script("{$assetURL}js/plugins.js") }}
        {{ HTML::script("{$assetURL}js/bootstrap.min.js") }}
        {{ HTML::script("{$assetURL}js/admin.js") }}        


    </head>
    <body>        
        <!-- HEADER -->
        @include("includes.headerPublisher")
        <!-- END HEADER -->
        
        <div id="main">
            <div class="main-wrapper">
               
                <div id="right" class="col-xs-12">
                    {{ isset($content) ? $content : '' }}
                </div>
            </div>
        </div>

    </body>
</html>
