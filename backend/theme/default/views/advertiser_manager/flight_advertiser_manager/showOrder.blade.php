<?= HTML::script("{$assetURL}js/jquery-ui.min.js") ?>
<?= HTML::script("{$assetURL}js/jquery.mjs.nestedSortable.js") ?>
<div id="result"></div>
<ol class="sortable">

    @if( !empty($data) )
    @foreach( $data as $ad )
    <li id="menu-{{$ad->id}}"><div>{{{$ad->adinfo->name}}}</div></li>                 
    @endforeach
    @endif
</ol>
<button id="save-btn" type="button" class="btn btn-primary">Save</button>
<a href="{{URL::Route('FlightAdvertiserManagerShowList')}}" class="btn btn-primary">Cancel</a>
<script type="text/javascript">

    $(document).ready(function () {

        $('ol.sortable').nestedSortable({
            forcePlaceholderSize: true,
            handle: 'div',
            items: 'li',
            opacity: .6,
            placeholder: 'placeholder',
            tolerance: 'pointer',
            toleranceElement: '> div',
            maxLevels: 2,
        });

        $('#save-btn').click(function () {
            serialized = $('ol.sortable').nestedSortable('serialize'); 
            $.post(
                    "{{ URL::Route('FlightAdvertiserManagerSaveOrder') }}",
                    serialized
                    ,
                    function (data) {
                       if(data == "TRUE"){
                           $('#result').html('<div class="alert alert-success" role="alert">Save successfull!!.</div>');
                       }else{
                           $('#result').html('<div class="alert alert-danger" role="alert">Save Error!!.</div>');
                       }
                    }
            )
        })

    });

</script>