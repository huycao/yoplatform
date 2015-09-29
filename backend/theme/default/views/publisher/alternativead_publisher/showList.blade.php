<div class="row mb12">
	<div class="col-md-12">
		<a href="{{ URL::Route($moduleRoutePrefix.'ShowCreate') }}" class="btn btn-default btn-sm">Create</a>
	</div>
</div>
<div class="box">
	<div class="head">Alternative Ad</div>
	<div class="content wrap-table"></div>	
</div>

<script type="text/javascript">
    $().ready(function () {
        pagination.init({
            url: "{{{ $defaultURL }}}get-list",
            defaultField: "{{{ $defaultField }}}",
            defaultOrder: "{{{ $defaultOrder }}}"
        });
    });
</script>