<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>VAST VALIDATE - JWPLAYER 6</title>
    <link rel="stylesheet" href="{{URL::to('/backend/theme/default/assets/css/normalize.css')}}">
    <link rel="stylesheet" href="{{URL::to('/backend/theme/default/assets/css/bootstrap-default.min.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::to('/backend/theme/default/assets/css/font-awesome.min.css')}}">
    <!-- <link media="all" type="text/css" rel="stylesheet" href="{{URL::to('/frontend/theme/default/assets/css/main.css')}}"> -->
    <link rel="stylesheet" href="{{URL::to('/backend/theme/default/assets/css/demo-vast.css')}}">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/backend/theme/default/assets/js/jwplayer5/jwp5.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('/backend/theme/default/assets/js/jwplayer5/function.js?t='.time() )}}"></script>
    <script>
    var asset_url = '{{URL::to('/backend/theme/default/assets/')}}';
    var defaultObj = {
        player : 'player',
        adTag : '',
        vastXML : '',
        mediaFile : "https://www.youtube.com/watch?v=vgoGN5GIw5U",
        mediaImage:"{{URL::to('/backend/theme/default/assets/video')}}/traintracks480.jpg"
    }
    </script>
    
</head>

<body>
<div class="container">
    <h1 class="center">VAST VALIDATE - JWPLAYER 5 | YOMEDIA SYSTEM</h1>
    <div class="input_vast">
        <form class="vastValidator" action="">
            <h3>TEST YOUR AD TAG</h3>
            <div class="form-group">
                <label class="radio-inline type_vast active" for="vast_tag"><input checked="checked" type="radio" name="inputType" value="vastUrl">Enter VAST ad tag URL </label>
                <input type="url" class="form-control select_type_vast" id="vast_tag" name="urlString" placeholder="Enter VAST tag URL"/>
            </div>
            <div class="form-group">
                <label class="radio-inline type_vast" for="vast_xml"><input type="radio" name="inputType" value="vastXML">Enter VAST XML</label>
                <textarea class="form-control select_type_vast" name="xmlString" id="vast_xml" disabled="disabled" ></textarea>
            </div>
            <div class="form-group row">
                <div class="col-md-2">
                    <label class="radio-inline">Creative Type</label>
                </div>
                <div class="col-md-10">
                    <input type="radio" name="creativeType" value="linear" checked="checked"> Linear
                    <input type="radio" name="creativeType" value="nonlinear"> Non-Linear
                </div>
                <div class="clear"></div>
            </div>
            <button type="submit" class="btn btn-info submit-vast">Submit</button>
        </form>
    </div>


    <div class="fleft player">
        <h3 class="center">ADS REVIEW</h3>
        <div id="player_container">
            <div id="player"></div>
        </div>
        <h4 class="bg-primary">Error Log</h4>
        <div id="errorLog" class="text-danger"></div>
    </div>
    <div class="fleft category">
        <div class="fleft event_btn">
            <h4 class="center">EVENTS</h3>
            <button class="btn btn-default" type="button" id="evt_impression">Impression</button>
            <button class="btn btn-default" type="button" id="evt_start">Start</button>
            <button class="btn btn-default" type="button" id="evt_firstQuartile">First Quartile</button>
            <button class="btn btn-default" type="button" id="evt_midpoint">Midpoint</button>
            <button class="btn btn-default" type="button" id="evt_thirdQuartile">Third Quartile</button>
            <button class="btn btn-default" type="button" id="evt_complete">Complete</button>
        </div>
        <div class="fleft control_btn">
            <h4 class="center">COMPANION ADS</h3>
            <div class="">
                <h4 class="bg-primary">Companion Ad 300x250</h4>
                <div id="companion300x250"></div>
                <div class="clear"></div>
                <h4 class="bg-primary mt40">Companion Ad 300x60</h4>
                <div id="companion300x60"></div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <div class="ad_load_info mt20">
        <form action="">
            <legend>VAST Tag Information</legend>
            <div class="row-fluid">
                <div class="col-md-3">
                    <h4>VAST Creative Information</h4>
                </div>
                <div class="col-md-9 form-group">
                    <div class="input-group">
                      <div class="input-group-addon">Type Ad</div>
                      <input class="form-control" placeholder="" readonly="readonly" id="info_type_ad">
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="row-fluid">
                <div class="col-md-3">
                    <h4>Ad Creatives Information</h4>
                </div>
                <div class="form-group col-md-9">
                    <div class="input-group">
                      <div class="input-group-addon">Media File</div>
                      <input class="form-control" placeholder="" readonly="readonly" id="info_media_file">
                    </div>
                </div>
                <div class="col-md-3"></div>
                <div class="form-group col-md-9">
                    <div class="input-group">
                      <div class="input-group-addon">Companion Ads</div>
                      <input type="textarea" class="form-control" placeholder="" readonly="readonly">
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            
            <div class="clear"></div>
            <div class="row-fluid">
                <div class="col-md-3">
                    <h4>Event Trackers</h4>
                </div>
                <div class="form-group col-md-9" id="event_tracker_section">
                    
                </div>
                <div class="clear"></div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    setUpPlayer();
    $('form.vastValidator input[name=urlString]').bind('blur', function(evt) {
        var proto = /^http/i;
        var val = $(evt.currentTarget).val();
        if (val.length == 0) return false;
        if (proto.test($(evt.currentTarget).val()) === false) {
            $(evt.currentTarget).val('http://' + $(evt.currentTarget).val());
        }
    });

    $('form.vastValidator').submit(function(evt) {
        evt.preventDefault();
        typeVast = $('input[value=vastUrl]:checked').length ? 'url' : 'xml';
        schedule = '';
        if (typeVast == 'url') {
            tag = $('#vast_tag').val();
            typeAd = $('input[name=creativeType]:checked').val();
        } else {
            var vastXml = $('#vast_xml').val().trim();
            var xmlDom = $($.parseXML(vastXml));
            if (xmlDom.find('Creatives Creative NonLinearAds').is('*')) {
                schedule = {
                    "position": "auto",
                    "duration": "recommended:10",
                    "startTime": "00:00:03",
                    "server": {
                        "type": "Inject",
                        "tag": vastXml
                    }
                };
                $('form.vastValidator input[name=creativeType][value=nonlinear]').attr('checked', 'true');
                typeAd = 'nonlinear';
            } else {
                schedule = {
                    "position": "pre-roll",
                    "server": {
                        "tag": vastXml,
                        "type": "Inject"
                    }
                };
                $('form.vastValidator input[name=creativeType][value=linear]').attr('checked', 'true');
                typeAd = 'linear';
            }
        }
        resetInfo(true);
        setUpPlayer(tag, typeAd, schedule);
    });
    //
    $('.type_vast').click(function() {
        var $this = $(this);
        if (!$this.hasClass('active')) {
            $('.type_vast').removeProp('checked', 'checked');
            $this.find('input').prop('checked', 'checked');
            $('.select_type_vast').prop('disabled', 'disabled');
            $this.parent().find('.select_type_vast').removeProp('disabled');
            $('.type_vast').removeClass('active');
            $this.addClass('active');
        }
    });

})
    
</script>

</body>
</html>
