<div class="box">
	<form class="filter-form " role="form">
		<div class="row">
		    <div class="col-xs-12">
				<div class="bts-tabs">
				    <ul role="tablist" class="nav nav-tabs tab-campaign" id="myTab">
				        <li class="active" data-id="{{$CPM}}"><a data-toggle="tab" role="tab" href="#myTabContent"><strong>CPM ({{$countCPM}})</strong></a></li>
				        <li class="" data-id="{{$CPC}}"><a data-toggle="tab" role="tab" href="#myTabContent"><strong>CPC ({{$countCPC}})</strong></a></li>				     
				        <input type="hidden" name="id_flag" id="id_flag" value="{{$CPM}}" placeholder="">
				    </ul>
				    <div class="tab-content" id="myTabContent">
				        <div class="wrap-table">
					
						</div>				      
				    </div>
				  </div>			
		    </div>
		</div>
	</form>
</div>
<script type="text/javascript">
	$().ready(function(){
		pagination.init({
			url : "{{{ $defaultURL }}}get-list",
			defaultField : "{{{ $defaultField }}}",
			defaultOrder : "{{{ $defaultOrder }}}"
		});

		
		$('.tab-campaign li').click(function(e) {
			e.preventDefault();
			var that = this;
			id_flag=$(this).attr('data-id');
			$("#id_flag").val(id_flag);
			data = $('.filter-form').serializeArray();
            pagination.search(data);
		});
	});
</script>