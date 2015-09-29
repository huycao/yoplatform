<?php
$source ="";
$height ="580";
$destination_url ="#";
if(isset($data['ad'])){
    $source =  $data['ad']->main_source;
    $source =  $data['ad']->$source;
    $height = $data['ad']->height;
}
?>
avlHelperModule.loadAvlStyle();
function showYoMediaPopupAd_{{$data['zid']}}(s) {
    var a_{{$data['zid']}} = document.getElementById("YomediaInpage_{{$data['zid']}}");
    if(a_{{$data['zid']}} == null) {
        var content_{{$data['zid']}} = document.getElementById('{{$data['element_id']}}');
        e_{{$data['zid']}} = content_{{$data['zid']}}.childNodes;
        var p_{{$data['zid']}} = 0;
        for(var i_{{$data['zid']}}=0; i_{{$data['zid']}} < e_{{$data['zid']}}.length; i_{{$data['zid']}}++) {
            if(e_{{$data['zid']}}[i_{{$data['zid']}}].clientHeight > 0){
                p_{{$data['zid']}} = p_{{$data['zid']}}+ e_{{$data['zid']}}[i_{{$data['zid']}}].clientHeight;
            }
            if(p_{{$data['zid']}} >= (content_{{$data['zid']}}.clientHeight / 2)){
                a_{{$data['zid']}} = domManipulate.create('div', 'YomediaInpage_{{$data['zid']}}', '', ''), content_{{$data['zid']}}.insertBefore(a_{{$data['zid']}}, content_{{$data['zid']}}.childNodes[i_{{$data['zid']}}]);
                break;
            }
        }
    }
        a_{{$data['zid']}}.style.opacity = 1;
        a_{{$data['zid']}}.style.position = 'relative';
        a_{{$data['zid']}}.style.overflow = 'hidden';
        a_{{$data['zid']}}.style.zIndex  = '0';
        a_{{$data['zid']}}.style.width = screen.width + "px";
        a_{{$data['zid']}}.style.display = 'block';
        a_{{$data['zid']}}.style.visibility = 'visible';
        a_{{$data['zid']}}.style.height = '{{$height}}px';
        a_{{$data['zid']}}.style.background = 'transparent';
    var rs = '';
    if(avlInteractModule.isMobile() == true){
    rs = '<div id="advMidContent_{{$data['zid']}}" style="display: block; opacity: 1; overflow: hidden; margin: 0px auto; position: fixed; z-index: 1; bottom: 0px; left:0;right:0;max-width: 100%;background: transparent;"><a href="{{$destination_url}}" target="_blank"><img id="advImg-h" style="display: block; width: 100%; max-width: 100%;" src="{{$source}}"></a></div>';
    rs += '<div id="more-view_{{$data['zid']}}" style="opacity: 1; float: right; z-index: 3; clear: both; position: fixed; bottom: 0px; left: 0px; width: 100%; text-align: center; background: transparent;"><a href="{{$destination_url}}" target="_blank" style="color:#FFF;font-size: 1.3em">Chi tiết</a></div>';
    $('#YomediaInpage_{{$data['zid']}}').html(rs);
    $('#YomediaInpage_{{$data['zid']}}').show();
    }else {
    $('#YomediaInpage_{{$data['zid']}}').html(rs);
    $('#YomediaInpage_{{$data['zid']}}').hide();
    }

}
showYoMediaPopupAd_{{$data['zid']}}(1);