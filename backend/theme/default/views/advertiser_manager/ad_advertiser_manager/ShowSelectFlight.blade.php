@include("partials.show_messages")
{{ Form::open(array('role'=>'form','class'=>'form-horizontal form-cms')) }}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">{{trans('text.flight')}}</label>
                <div class="col-md-4">
                    <input type="hidden" id="flight_id" value="">                    
                    <input type="text" class="form-control input-sm" id="flight" value="" readonly>
                </div>
                <div class="col-md-3 text-select">
                    <a href="javascript:;" onclick="Select.openModal('flight')" class="btn btn-primary btn-block btn-sm">{{trans('text.select_flight')}}</a>
                </div>
                <div class="col-md-3 text-select">
                    <a href="javascript:;" id="btn-add-publisher" onclick="addFlight()" class="btn btn-primary btn-block btn-sm">{{trans('text.add_flight')}}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">{{trans('text.list_flight')}}</label>
                <div id="loadFlightList" class="col-md-10">
                    
                    {{ View::make('flightList', array('flightAdList' => $data->flightAd) )->render(); }}
                </div>
            </div>
        </div>
    </div>
{{ Form::close() }}

<div id="loadSelectModal">
    @include("partials.select")
</div>

<div id="loadFlightModal"></div>


<script type="text/javascript">
        
    var wrapper = $("#loadPublisherList");
    var adId = {{ $data->id }};

    function addFlight(){
        var flightId = $("#flight_id").val();
        var flightName = $("#flight").val(); 
        if( flightId != '' && flightName != '' ){
            Ad.loadModal(0, adId, flightId, flightName);
        }

    }

    function removeFlight(id){
        $("#flight-"+id).remove();
    }



</script>



