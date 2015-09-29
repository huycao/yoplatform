<div class="row mb12">
	
	<div class="col-md-12">
        <div class="part">
			<span>Conversion Report</span>
        </div>
    </div>

	<div id="filter" class="col-md-12">
		<form class="filter-form form-horizontal" id="filter" role="form">
			<div class="filter-wrapper">
				<div class="form-group col-md-4">
					<div class="">
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="form-control" name="start_date_range" value="{{ $start_date_range }}"
                                   id="start_date_range">
                            <span class="input-group-addon">to</span>
                            <input type="text" class="form-control" name="end_date_range" value="{{ $end_date_range}}"
                                   id="end_date_range">
                            <input type="hidden" name="conversion_id" value="{{$conversionID}}">
                        </div>
                    </div>
				</div>
				<div class="col-md-4">
		    		<button type="submit" class="btn btn-primary">Show</button>
				</div>
			</div>
		</form>
	</div>

</div>

<div class="box mb12">
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-condensed table-bordered">
                    <tr>
                        <td width="25%">Campaign</td>
                        <td>
                            <div class="row">
                                <div class="col-md-12">({{ $conversion->campaign->id or '-' }}) {{ $conversion->campaign->name }}</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="25%">Conversion</td>
                        <td>
                            <div class="row">
                                <div class="col-md-12">({{ $conversion->id or '-' }}) {{ $conversion->name }}</div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12">
			<div class="wrap-table">
				
			</div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
    
        $('.input-daterange').datepicker({
            todayBtn: "linked"
        });
        
        $("#dropdownMenu").click(function() {
            $("#dropdownMenuFilter").slideToggle();
        });
    });
@if (true)
	$().ready(function(){
		pagination.property.searchData =  $('.filter-form').serializeArray();
		pagination.init({
			url : "{{URL::Route('RpconversionAdvertiserManagerGetList')}}",
			defaultField : "created_at",
			defaultOrder : "desc"
		});
	});
@endif
</script>
