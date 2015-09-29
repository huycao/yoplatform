<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="col-md-2">{{trans('text.list_flight')}}</label>
            <div class="col-md-10">
                <a href="javascript:;" id="save-btn" class="btn btn-default">Save Priority</a>
                <div id="loadFlightList">
                    {{ View::make('flightList', array('listFlightWebsite' => $listFlightWebsite) )->render(); }}
                </div>
            </div>
        </div>
    </div>
</div>

<div id="loadFlightModal"></div>

{{ HTML::script("{$assetURL}js/jquery-ui.min.js") }}
{{ HTML::script("{$assetURL}js/jquery.mjs.nestedSortable.js") }}

<script type="text/javascript">
        
    var wrapper = $("#loadPublisherList");
    var publisherId = {{ $data->id }};

    function removeFlight(id){
        $("#flight-"+id).remove();
    }

    $(document).ready(function(){

        $('#save-btn').click(function () {
            serialized = $('ol.sortable').nestedSortable('serialize'); 
            $.post(
                "{{ URL::Route('PublisherAdvertiserManagerSaveOrder') }}",
                serialized,
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



