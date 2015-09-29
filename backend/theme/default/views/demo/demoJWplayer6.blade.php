<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>VAST VALIDATE - JWPLAYER 6</title>
    <link rel="stylesheet" href="{{URL::to('/backend/theme/default/assets/css/normalize.css')}}">
    <link rel="stylesheet" href="{{URL::to('/backend/theme/default/assets/css/bootstrap-default.min.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::to('/backend/theme/default/assets/css/font-awesome.min.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::to('/frontend/theme/default/assets/css/main.css')}}">
    <link rel="stylesheet" href="{{URL::to('/backend/theme/default/assets/css/demo-vast.css')}}">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/backend/theme/default/assets/js/jwplayer6/jwp6.js')}}"></script>
    <script type="text/javascript" src="//www.googletagservices.com/tag/js/gpt.js"></script>
</head>

<body>
<div class="container">
    <h1 class="center">VAST VALIDATE - JWPLAYER 6 | YOMEDIA SYSTEM</h1>
    <div class="input_vast">
        <h3>TEST YOUR AD TAG</h3>
          <div class="form-group">
            <label class="radio-inline type_vast active" for="vast_tag"><input checked="checked" type="radio" name="type_vast" value="vast_tag">Enter VAST ad tag URL </label>
            <input type="url" class="form-control select_type_vast" id="vast_tag" name="vast_tag" placeholder="Enter VAST tag URL"/>
          </div>
          <div class="form-group">
            <label class="radio-inline type_vast" for="vast_xml"><input type="radio" name="type_vast" value="vast_xml">Enter VAST XML</label>
            <textarea class="form-control select_type_vast" name="vast_xml" id="vast_xml" disabled="disabled" ></textarea>
          </div>
          <div class="form-group row">
            <div class="col-md-2">
                <label class="radio-inline">Creative Type</label>
            </div>
            <div class="col-md-10">
                <input type="radio" name="linear" value="1" check="checked"> Linear
                <input type="radio" name="linear" value="0"> Non-Linear
            </div>
            <div class="clear"></div>
          </div>
          <button type="submit" class="btn btn-info submit-vast">Submit</button>
    </div>


    <div class="fleft player">
        <h3 class="center">ADS REVIEW</h3>
        <div id="player"></div>
    </div>
    <div class="fleft category">
        <div class="fleft event_btn">
            <h4 class="center">EVENTS</h3>
            <button class="btn btn-default" type="button" id="evt_impression">Impression</button>
            <button class="btn btn-default" type="button" id="evt_start">Start</button>
            <button class="btn btn-default" type="button" id="evt_first_quartile">First Quartile</button>
            <button class="btn btn-default" type="button" id="evt_midpoint">Midpoint</button>
            <button class="btn btn-default" type="button" id="evt_third_quartile">Third Quartile</button>
            <button class="btn btn-default" type="button" id="evt_complete">Complete</button>
            <button class="btn btn-default" type="button" id="evt_create_view">Creative View</button>
        </div>
        <div class="fleft control_btn">
            <h4 class="center">CONTROLS</h3>
            <button class="btn btn-info" type="button" id="btn_f5" onclick="addPlayer()">Reload Player</button> 
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<script>
var player = 'player';
var adTag = "";
var vastXML = '';
function addPlayer(){
    console.log(adTag);
    $('.event_btn .btn').removeClass('btn-success');
    jwplayer(player).setup(
    {
        debug: true,
        file:"{{URL::to('/backend/theme/default/assets/video')}}/pub-video.mp4",
        image:"{{URL::to('/backend/theme/default/assets/video')}}/traintracks480.jpg",
        autostart:false,    
        width:640,
        height:400,
        aspectratio:"16:9",
        stretching:"fill",
        primary:"flash",
        advertising:{
            client:"vast",
            admessage: 'This advertisement ends in XX seconds.',
            tag: adTag
        }
    });

    jwplayer(player).onAdImpression(adImpression);
    jwplayer(player).onAdComplete(adComplete);
    jwplayer(player).onAdTime(adTime);

}

function adImpression(){
    $('.event_btn .btn').removeClass('btn-success');
    $('#evt_impression').addClass('btn-success');
}
function adComplete(){
    $('#evt_complete').addClass('btn-success');
}
function adTime(ad){
    if(ad.position < 1 && !$('#evt_start').hasClass('btn-success')){
        $('#evt_start').addClass('btn-success');
    }
    percent = ad.position / ad.duration * 100;
    if(percent > 25 && !$('#evt_first_quartile').hasClass('btn-success')){
        $('#evt_first_quartile').addClass('btn-success');
    }
    if(percent > 50 && !$('#evt_midpoint').hasClass('btn-success')){
        $('#evt_midpoint').addClass('btn-success');
    }
    if(percent > 75 && !$('#evt_third_quartile').hasClass('btn-success')){
        $('#evt_third_quartile').addClass('btn-success');
    }
}

$(document).ready(function(){
    addPlayer();

    //radio click
    $('.type_vast').click(function(){
        var $this = $(this);
        if(!$this.hasClass('active')){
            $('.type_vast').removeProp('checked','checked'); 
            $this.find('input').prop('checked','checked'); 
            $('.select_type_vast').prop('disabled','disabled');
            $this.parent().find('.select_type_vast').removeProp('disabled');
            $('.type_vast').removeClass('active');
            $this.addClass('active');
        }
    });

    //submit click
    $('.submit-vast').click(function(){
        adTag = '';
        vastXML = '';
        if($('#vast_xml').prop('disabled')){
            adTag = $('#vast_tag').val();
        }
        else{
            parser = new DOMParser();
            adTag = parser.parseFromString( $('#vast_xml').val().trim(),"text/xml");
        }
        addPlayer();
    })
})
</script>

</body>



</html>
