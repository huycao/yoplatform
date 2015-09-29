<div class="box mb12">

	<div class="head">
		<a href="javascript:;" class="btn-filter" data-toggle="collapse" data-target="#filter"><i class="fa fa-chevron-circle-down"></i> Filter</a>
	</div>

	<div id="filter" class="collapse content">
		<form class="filter-form form-horizontal" id="filter" role="form">
			<div class="filter-wrapper">
				<div class="row">
					<div class="col-xs-12">
						<table class="table">
							<tr>
								<td width="50%">
									<span class="lbl">{{trans('text.keywords')}}</span>
									<div>
										<input type="text" class="form-control w25p input-sm display-in-bl" name="search['keyword']">
						                {{ 
						                    Form::select(
						                        'search[\'field\']', 
						                        array(
													'username'	=>	'Username',
													'site_url'	=>	'Site Url',
													'company'	=>	'Company'
						                        ),
						                        "", 
						                        array('class'=>'input-sm')
						                    ) 
						                }}										
									</div>
								</td>
							</tr>
						</table>
					</div>
			
				</div>
				<div class="row">
					<div class="col-xs-6">
			    		<button type="submit" class="btn btn-default btn-sm filter-button">{{trans('text.search')}}</button>
					</div>
			    </div>
			</div>
		</form>
	</div>
</div>

@include('partials.show_list')