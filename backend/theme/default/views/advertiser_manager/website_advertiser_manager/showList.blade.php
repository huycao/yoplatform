<div class="row">
    <div class="col-xs-12">
		<button type="button" class="btn btn-primary btn-filter btn-sm pull-left" data-toggle="collapse" data-target="#filter">Filter</button>
    </div>
</div>
<hr>
<div id="filter" class="collapse">
	<form class="filter-form form-horizontal" id="filter" role="form">
		<div class="filter-wrapper">
			<div class="row">
				<div class="col-xs-12">

				</div>
		
			</div>
			<div class="row">
				<div class="col-xs-6">
		    		<button type="submit" class="btn btn-sm btn-primary filter-button">Submit</button>
				</div>
		    </div>
		</div>
	</form>
<hr>
</div>
<div id="loadSelectModal">
    @include("partials.select")
</div>


@include('partials.show_list')