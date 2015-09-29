<div class="row">
    <div class="col-xs-12">
    	<a href="{{URL::Route('UserGroupAdminShowCreate')}}" class="btn btn-default btn-sm">Add More</a>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="table-responsive">
			<div class="wrap-table">
				
			</div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$().ready(function(){
		pagination.init({
			url : "{{{ $defaultURL }}}get-list",
			defaultField : "{{{ $defaultField }}}",
			defaultOrder : "{{{ $defaultOrder }}}"
		});
	});
</script>