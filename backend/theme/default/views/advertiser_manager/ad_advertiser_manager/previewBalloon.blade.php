<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Yomedia Demo Balloon Standard</title>

    <style>

        .overlay{
            width: 100%;
            height: 100%;
            position: fixed;
            background: #000;
            opacity: 0.3;
            z-index: 1000;
            top: 0px;
            left: 0px;
        }

    </style>

</head>

<body>

<div class="container">
    <img src="/demo/vib-balloon/datviet.jpg" alt="">
    <div class="overlay"></div>
</div>

<script type="text/javascript">
    var _avlVar = _avlVar || [];
    var _avlDemo = true;
    _avlVar.push(["20", "{{trim($data->id)}}", "Balloon"]);
</script>
<script src="/public/source/advalue.js" type="text/javascript"></script>

<script type="text/javascript">

    avlHelperModule.loadAvlStyle();

    function showYoMediaPopupAd_{{trim($data->id)}}(s) {
        var eWidth = parseInt('300');
        var eHeight = parseInt('250');
        var iWidth = parseInt('300');
        var iHeight = parseInt('250');
        var sPos = 'right-bottom';

        var flash = '{{trim($data->source_url)}}';
        var impressionTrack = "";
        var clickTag = encodeURIComponent("{{trim($data->destination_url)}}");
        var clickTrack = "";
        var ff = flash + '?impression=' + impressionTrack + "&clickTrack=" + clickTrack + "&clickTag=" + clickTag;

        Default = '';

        avlInteractModule.initBalloon(
                'YoMediaBalloon', 'YoMediaBalloon_{{trim($data->id)}}', iWidth, iHeight, eWidth, eHeight, ff, Default, 'VIB', parseInt('{{trim($data->id)}}'), 'popup', 'top-down', 'transparent', 'VN', parseInt('1'), sPos
        );
        avlInteractModule.showBalloon('YoMediaBalloon', sPos, iWidth, iHeight, eWidth, eHeight, 'YoMediaBalloon_{{trim($data->id)}}', 'min', parseInt('30000'), parseInt('900000'));
    }


    function minYoMediaPopupAd_{{trim($data->id)}}() {
        var sPos = 'right-bottom';
        avlInteractModule.rectAd('YoMediaBalloon', 'top-down', sPos, 'min', parseInt('300'), parseInt('250'), parseInt('300'), parseInt('250'), parseInt('50'));
    }


    function restoreYoMediaPopupAd_{{trim($data->id)}}() {
        var sPos = 'right-bottom';
        avlInteractModule.rectAd('YoMediaBalloon', 'top-down', sPos, 'max', parseInt('300'), parseInt('250'), parseInt('300'), parseInt('250'), parseInt('50'));
    }

    function setYoMediaExpand_{{trim($data->id)}}() {
        var sPos = 'right-bottom';
        avlInteractModule.rectExpand('YoMediaBalloon', 'ex', sPos, parseInt('300'), parseInt('250'), parseInt('300'), parseInt('250'));
    }


    function setYoMediaPre_{{trim($data->id)}}() {
        var sPos = 'right-bottom';
        avlInteractModule.rectExpand('YoMediaBalloon', 'pre', sPos, parseInt('300'), parseInt('250'), parseInt('300'), parseInt('250'));
    }

    function closeYoMediaPopupAd_{{trim($data->id)}}() {
        avlInteractModule.closeAd('YoMediaBalloon', parseInt('900000'), 'showYoMediaPopupAd_{{trim($data->id)}}');
    }

    showYoMediaPopupAd_{{trim($data->id)}}(1);

</script>

</body>
</html>
