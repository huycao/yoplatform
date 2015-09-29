//Yomedia Pause Ad for jwplayer 6 javascript setup sample code
jwplayer('player_id').setup({
    primary:"flash",
    file: "{{ STATIC_URL }}public/video/pub-video.mp4",
    plugins: {
        "{{ STATIC_URL }}public/flash/jwplayer6/yomedia_pause_6.swf": {
            urlvast : "{{ LINK_VAST."?ec=0&wid=$wid&zid=$zid" }}"
        }
    }
});

//Yomedia Pause Ad for jwplayer 6 javascript setup sample code
jwplayer('player_id').setup({
    primary:"flash",
    file: "{{ STATIC_URL }}public/video/pub-video.mp4",
    plugins: {
        "{{ STATIC_URL }}public/flash/jwplayer5/yomedia_pause_5.swf": {
            urlvast : "{{ LINK_VAST."?ec=0&wid=$wid&zid=$zid" }}"
        }
    }
});