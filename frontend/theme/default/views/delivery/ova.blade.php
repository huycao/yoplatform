<config>
<ova.title>A video ad with a show stream </ova.title>
<ova.json>
{
    "player": {
        "modes": {
            "linear": {
                "controls": {
                    "visible": false
                }
            }
        }
    },
    "ads": {
        "pauseOnClickThrough": false,
        "skipAd": {
            "enabled": "true",
            "showAfterSeconds": 5
        },
        "hideLogoOnLinearPlayback": true,
        "schedule": [
	        {
                "position": "pre-roll", 
                "notice": {"show": "true","region": "AdvalueNotice","message": "<?php echo htmlentities("<p class='avlNotice' align='right'>Advertisement in _countdown_ seconds</p>") ?>"},
                "tag": "<?php echo htmlspecialchars($vast, ENT_QUOTES | ENT_XML1); ?>"
	        }
        ]
    },
    "debug":{
        "levels" : " none "
    }
}
</ova.json>
</config>
