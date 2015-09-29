<form class="filter-form" role="form">
<div class="filter-wrapper" style="margin-bottom: 0;">
	
		<fieldset>
			<div class="row">
			    <div class="col-xs-12">
					<button type="button" class="btn btn-primary btn-sm btn-filter pull-left" data-toggle="collapse" data-target="#filter">{{trans('backend::publisher/text.filter')}}</button>
			    </div>
			</div>
			<hr>
			<div id="filter" class="collapse">
				<div class="row">
					<div class="col-sm-12">
						<div class="row">
							<div class="col-sm-3 filter-radio">
								<div class="form-group">
									<input type="radio" checked name="type-name" value="username"> {{trans('backend::publisher/text.username')}}
									<input type="radio" name="type-name" value="name"> {{trans('backend::publisher/text.name')}}
									<input type="radio" name="type-name" value="email"> {{trans('backend::publisher/text.email')}}
								</div>
							</div>
							<div class="col-sm-9">
								<div class="form-group">
									<label>{{trans('backend::publisher/text.keyword')}}</label>
									<input type="text" class="form-control input-sm" name="keyword" placeholder="Keyword">			
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
				    		<button type="submit" class="btn btn-primary btn-sm filter-button">{{trans('backend::publisher/text.submit')}}</button>
						</div>
					</div>	
			    </div>
			</div>
		</fieldset>
	
	
</div>



<div class="row">
    <div class="col-xs-12">
          <div class="tab-content" id="myTabContent">
		        <div class="wrap-table">
			
				</div>				      
		    </div>
    </div>
</div>
</form>
<script type="text/javascript">
	$().ready(function(){
		pagination.init({
			url : "{{{ $defaultURL }}}get-list",
			defaultField : "{{{ $defaultField }}}",
			defaultOrder : "{{{ $defaultOrder }}}"
		});
	});
</script>