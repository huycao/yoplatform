<?php
$source ="";
$height ="80";
$destination_url = "#";
if(isset($data['ad'])){
    $source =  $data['ad']->main_source;
    $source =  $data['ad']->$source;
    $height = $data['ad']->height;
    if($data['ad']->destination_url!=""){
        $destination_url = $data['ad']->destination_url;
    }
}
?>
avlHelperModule.loadAvlStyle();
function showYoMediaCatFishAd_{{$data['zid']}}(s) {
    var a_{{$data['zid']}} = document.getElementById("YomediaCatfish_{{$data['zid']}}");
    if(a_{{$data['zid']}} == null) {
        a_{{$data['zid']}} = domManipulate.create('div', 'YomediaCatfish_{{$data['zid']}}', '', ''), document.body.insertBefore(a_{{$data['zid']}}, document.body.childNodes[0]);
    }
        a_{{$data['zid']}}.style.opacity = 1;
        a_{{$data['zid']}}.style.position = 'fixed';
        a_{{$data['zid']}}.style.zIndex  = '23323';
        a_{{$data['zid']}}.style.left = '0';
        a_{{$data['zid']}}.style.right = '0';
        a_{{$data['zid']}}.style.bottom = '0';
        a_{{$data['zid']}}.style.height = '{{$height}}px';
        a_{{$data['zid']}}.style.background = '#000';
    var rs = '';
    if(avlInteractModule.isMobile() == true){
    rs = '<div id="Yomedia_Catfish_Content_{{$data['zid']}}" style="display: block; opacity: 1; overflow: hidden; margin: 0px auto; position: fixed; z-index: 1; bottom: 0px; left:0;right:0;max-width: 100%;background: transparent;"><a id="banner-close" style=" width: 40px;height: 40px;background-image: url('+avlProtocal + avlDomain+'/public/close_button.png'+');position: absolute;top: 5px;right: 0;z-index: 50000;" href="javascript:;" onclick="hideYoMediaCatFishAd_{{$data['zid']}}()"></a><a href="{{$destination_url}}" target="_blank"><img id="advImg-h" style="display: block; width: 100%; max-width: 100%;" src="{{$source}}"></a></div>';
    $('#YomediaCatfish_{{$data['zid']}}').html(rs);
    $('#YomediaCatfish_{{$data['zid']}}').show();
    }else {
    $('#YomediaCatfish_{{$data['zid']}}').html(rs);
    $('#YomediaCatfish_{{$data['zid']}}').hide();
    }
}
function hideYoMediaCatFishAd_{{$data['zid']}}() {
    document.getElementById("YomediaCatfish_{{$data['zid']}}").remove();
}
showYoMediaCatFishAd_{{$data['zid']}}(1);