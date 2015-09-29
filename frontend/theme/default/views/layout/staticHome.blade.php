<html lang="en-US" class="csstransforms csstransforms3d csstransitions skrollr ">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta property="og:title" content=""/>
	<meta property="og:description" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:video" content=""/>
	<meta property="og:type" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content="" />
	<meta name="twitter:card" content="" />
	<meta name="keywords" content=""/>
	<title>Adnetwork YoMedia</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link rel="stylesheet" id="bootstrap-css" href="{{ $assetURL }}css/bootstrap.css" type="text/css" media="all">
	<link rel="stylesheet" id="bootstrap-responsive-css" href="{{ $assetURL }}css/bootstrap-responsive.css" type="text/css" media="all">
	<link href="{{ $assetURL }}css/ddsmoothmenu.css" type="text/css" rel="stylesheet">
	
	<link rel="stylesheet" id="style-css" href="{{ $assetURL }}css/style.css" type="text/css" media="all">
	<link rel="stylesheet" id="resnavc-css" href="{{ $assetURL }}css/responsive-nav.css" type="text/css" media="all">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,800|Oswald:400,300,700" rel="stylesheet" type="text/css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="{{ $assetURL }}js/jquery.js"></script>

</head>
<body id="top" class="home">
	<div id="skrollr-body">
		@include('includes.menu')

		{{ isset($content) ? $content : '' }}

		@include('includes.footer')

		<p id="back-top">
			<a href="#top"><img alt="" src="{{ $assetURL }}/images/scrollto_top.png"></a>
		</p>

		<!--contact us-->

		<script type="text/javascript" src="{{ $assetURL }}js/bootstrap.min.js"></script>
		<script type="text/javascript" src="{{ $assetURL }}js/jquery.localscroll-1.2.7-min.js"></script>
		<script type="text/javascript" src="{{ $assetURL }}js/jquery.scrollTo-1.4.2-min.js"></script>
		<script type="text/javascript" src="{{ $assetURL }}js/jquery.isotope.min.js"></script>
		<script type="text/javascript" src="{{ $assetURL }}js/jquery.colorbox.js"></script>
		<script type="text/javascript" src="{{ $assetURL }}js/jquery.backstretch.min.js"></script>
		<script type="text/javascript" src="{{ $assetURL }}js/jbc.js"></script>
		<script type="text/javascript" src="{{ $assetURL }}js/script.js"></script>

		<!--hieu ung text chuyen dong-->
		<script type="text/javascript" src="{{ $assetURL }}js/skrollr.min.js"></script>
		<script type="text/javascript" src="{{ $assetURL }}js/scrollr-init.js"></script>

		<!-- scroll page -->
		<script src="{{ $assetURL }}js/jquery.easing.1.3.js"></script>
		<script src="{{ $assetURL }}js/scrollify.min.js"></script>

		<script type="text/javascript">
			/* <![CDATA[ */
			var slides = ["{{ $assetURL }}/images/dgm.jpg"];
			/* ]]>*/
		</script>
		<script type="text/javascript">
			/* <![CDATA[ */
			var jt = ["{{ $assetURL }}/images/small.jpg"];
			/* ]]>*/
		</script>
		<script type="text/javascript" src="{{ $assetURL }}js/backstretch-init.js"></script>
		<script>
		$(document).ready(function(){
		    //menu mobile
			$("#flip").click(function(){
		    $("#panel").slideToggle("milliseconds");});
		  
			// hide #back-top first
			$("#back-top").hide();
			
			// fade in #back-top
			$(function () {
				$(window).scroll(function () {
					if ($(this).scrollTop() > 100) {
						$('#back-top').fadeIn();
					} else {
						$('#back-top').fadeOut();
					}
				});

				// scroll body to 0px on click
				$('#back-top a').click(function () {
					$('body,html').animate({
						scrollTop: 0
					}, 800);
					return false;
				});
			});

		});
		
		

			function onScroll(event){
				
				var scrollPos = $(document).scrollTop();
				$('.nav a').each(function () {
					var currLink = $(this);
					var refElement = $(currLink.attr("href"));
					if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
						$('.nav a').removeClass("active");
						currLink.addClass("active");
					}
					/*else{
						currLink.removeClass("active");
					}*/
				});
			}
		</script>
	</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-66542423-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>