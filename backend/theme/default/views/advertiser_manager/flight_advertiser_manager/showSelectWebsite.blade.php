<div class="part">
@include("partials.show_messages")
{{ Form::open(array('role'=>'form','class'=>'form-horizontal form-cms')) }}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">{{trans('text.website')}}</label>
                <div class="col-md-3">
                    <input type="hidden" id="website_id" value="{{{ $item->website_id or Input::get('website_id') }}}">
                    <input type="text" class="form-control input-sm" id="website" value="{{{ $item->website->name or Input::get('website') }}}" readonly>
                </div>
                <div class="col-md-2 text-select">
                    <a href="javascript:;" onclick="addAllWebsite()" class="btn btn-default btn-block btn-sm">{{trans('text.select_all_website')}}</a>
                </div>
                <div class="col-md-2 text-select">
                    <a href="javascript:;" onclick="Select.openModal('website')" class="btn btn-default btn-block btn-sm">{{trans('text.select_website')}}</a>
                </div>
                <div class="col-md-2 text-select">
                    <a href="javascript:;" id="btn-add-website" onclick="addWebsite()" class="btn btn-default btn-block btn-sm">{{trans('text.add_website')}}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">{{trans('text.list_website')}}</label>
                <div id="loadWebsiteList" class="col-md-10">
                    {{ View::make('websiteList', array( 'flightWebsiteList' => $data->flightWebsite, 'totalInventory'=> $data->total_inventory ) )->render(); }}
                </div>
            </div>
        </div>
    </div>
{{ Form::close() }}

<div id="loadSelectModal">
    @include("partials.select")
</div>

<div id="loadWebsiteModal"></div>


<script type="text/javascript">
        
    var wrapper = $("#loadWebsiteList");
    var flightId = {{ $data->id }};

    function addWebsite(){
        var websiteId = $("#website_id").val();
        var websiteName = $("#website").val();

        if( websiteId != '' && websiteName != '' ){
            Flight.loadModal(0, flightId, websiteId, websiteName);
        }

    }

    function addAllWebsite(){
    	var agree = confirm("Do you want to select all website?");
    	if (agree) {
            var url = root+"flight/addAllWebsite";
            $.post(
                url,
                {
                    flightId : flightId
                },
                function(data){
                    if( data.status == true ){
                        $('#loadWebsiteList').html(data.view);
                    }
                }
            );
    	} else {
			return;
    	}
    }

</script>
</div>


