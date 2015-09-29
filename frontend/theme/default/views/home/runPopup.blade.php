<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>DEMO RUN VAST</title>
    <link rel="stylesheet" href="{{URL::to('/backend/theme/default/assets/css/normalize.css')}}">
    <link rel="stylesheet" href="{{URL::to('/backend/theme/default/assets/css/bootstrap-default.min.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::to('/backend/theme/default/assets/css/font-awesome.min.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::to('/frontend/theme/default/assets/css/main.css')}}">
    <link rel="stylesheet" href="{{URL::to('/backend/theme/default/assets/css/demo-vast.css')}}">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
</head>

<body class="demo_popup">
<div class="container">
    <h1 class="center bgtext"><span>DEMO TVC POPUP</span></h1>
</div>

<script type="text/javascript">
document.write('<script type="text/javascript" src="{{URL::to("public/source/js/jwplayer5/jwp5.js")}}"><\/script>');
var _avlVar = _avlVar || [];
_avlVar.push(["20", "18", "Popup"]);
document.write('<script src="{{URL::to("public/source/advalue.js")}}" type="text/javascript"><\/script>');
</script>

</body>
</html>
