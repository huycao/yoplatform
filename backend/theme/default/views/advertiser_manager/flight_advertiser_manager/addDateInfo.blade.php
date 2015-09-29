<div class="modal fade bs-website-modal" id="dateInfo" tabindex="-1" role="dialog" aria-labelledby="websiteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">{{trans('text.close')}}</span></button>
                <h4 class="modal-title" id="DateInfoLabel">
                    Setup times for running flight                    
                </h4>
            </div>
            <div class="modal-body">
                <form id="formAddDateInfo" class="form-horizontal form-cms" role="form">

				    <div class="row">
				        <div class="col-md-12">
				        	<label class="col-md-3 control-label"></label>
							<div class="col-md-8">
                        		<ul class="errors-list" id='message'>
                        		</ul>
                        	</div>
		                    <div id="formAddDateInfoMessage" class="col-xs-10 col-xs-offset-2"></div>
							<input type="hidden" id="mode" name="mode" value="{{$mode}}">
			                <input type="hidden" id="index" name="index" value="{{$index}}">

		                    <!-- DATE -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Flight will run <i class="fa fa-calendar"></i></label>
                                <div class="col-md-6">
                                    <div class='input-group date' id='date_picker'>
                                    <span class="input-group-addon">From</span>
                                    <input type="text" class="form-control" id="add_start_date_range" class="form-control" value="" name="add_start_date_range">
                                    <span class="input-group-addon">to</span>
                                    
                                    <input type="text" class="form-control" id="add_end_date_range" class="form-control" value="" name="add_end_date_range">
                                   
                                    </div>
                                </div>
                                    
                            </div>  
		                    
		                    <!-- DAY -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Number of days to run flight</label>
                                <div class="col-md-8">
                                    <input type="text" class="no-border" id="add_day" value="" name="add_day" readonly>
                                </div>
                            </div>    
                
                
                            <!-- HOUR -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Hour run everyday</label>
                                <!-- <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-3">
                                        	<div class='input-group date' id='start_hour_picker'>
                                                <input type="text" id="add_start_hour" placeholder="{{trans('text.start_hour')}}" class="form-control" value="{{{ $item->start_hour or Input::get('start_hour') }}}" name="add_start_hour">
                                            	<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class='input-group date' id='end_hour_picker'>
                                                <input type="text" id="add_end_hour" class="form-control" placeholder="{{trans('text.end_hour')}}" value="{{{ $item->end_hour or Input::get('end_hour') }}}" name="add_end_hour">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                                            </span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                        	<input type="text" class="form-control input-sm" id="time_inventory" value="" name="time_inventory" placeholder="With inventory">
                                        </div>
                                        <div class="col-md-3">
                                            <a href="javascript:;" onclick="addTimeDetail()" class="btn btn-default btn-block btn-sm">{{trans('text.add_time')}}</a>
                                        </div>
                                    </div>
                                    <div id="list-time-range">
                                                        
                                    </div>
                                </div> -->
                                <div class="col-md-9">
                                    <div class='input-group date col-md-5 fl_left' id='hour_picker'>
                                        <span class="input-group-addon">From</span>
                                        <input type="text" class="form-control" id="add_start_hour" class="form-control" value="" name="add_start_hour">
                                        <span class="input-group-addon">to</span>
                                        
                                        <input type="text" class="form-control" id="add_end_hour" class="form-control" value="" name="add_end_hour">
                                       	
                                    </div>
                                    <div class="col-md-3">
                                    	<input type="text" class="form-control input-sm" id="time_inventory" value="" name="time_inventory" placeholder="Limit inventory">
                                    </div>
                                    <div class="col-md-2">
                                        <a href="javascript:;" onclick="addTimeDetail()" class="btn btn-default btn-block btn-sm">OK</a>
                                    </div>
                                    <div class="list-hour" id="list-time-range">
                                                        
                                    </div>
                                </div>
                            </div>	
		                    		                    
		                    <!-- DAILY INVENTORY -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Daily inventory</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-sm" id="add_daily_inventory" value="" name="add_daily_inventory">
                                </div>
                            </div>
                            
		                    <!-- FREQUENCY CAP -->
                            <div class="form-group">
                                <label class="col-xs-3 control-label">Frequency cap</label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control input-sm" id="add_frequency_cap" value="" name="add_frequency_cap">
                                </div>
                            </div>
                            
                            <!-- FREQUENCY CAP FREE -->
                            <!-- <div class="form-group">
                                <label class="col-md-3 control-label">{{trans('text.frequency_cap_free')}}</label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control input-sm" id="add_frequency_cap_free" value="" name="add_frequency_cap_free">
                                </div>
                            </div> -->                       
                            
                            <!-- FREQUENCY CAP TIME -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Frequency cap time (mins)</label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control input-sm" id="add_frequency_cap_time" value="" name="add_frequency_cap_time">
                                </div>
                            </div>
                            
                            <!-- DAILY INVENTORY -->
                            <!-- <div class="form-group">
                                <label class="col-md-3 control-label">Daily Invertory</label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control input-sm" id="add_daily_inventory" value="" name="add_daily_inventory">
                                </div>
                            </div> -->

						</div>
					</div>

                </form>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{trans('text.close')}}</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="addDateToForm()" id="btnAddDateToForm">
                    @if( $mode == 'edit' )
                        {{trans('text.edit')}}
                    @else
                        {{trans('text.add')}}
                    @endif
                </button>
            </div>

        </div>
        <script type="text/javascript"><!--
        	var index = $("#index").val();
        	var mode = $("#mode").val();
        	var start = null, end = null, startDateString = null, endDateString = null, diff, id = null, old_diff = 0;
        	var total_day = 0;
        	$('#message').html('');
        	// Truong hop them moi ngay
    		if (index == -1) {        		
    			start = $('#start_date_range').datepicker('getDate');
                end = $('#end_date_range').datepicker('getDate');
                
                startDateString = $('#start_date_range').val();
                endDateString = $('#end_date_range').val();
                
                $('#start_date_range').val('');
                $('#end_date_range').val('');
                $('#start_date_range').val('');
                $('#end_date_range').val('');
                $('.input-daterange').datepicker('remove');
                embedDatePicker();
                
                diff        = dateDiff(start, end);
        		if( !isNaN(diff) ){
                    $('#add_day').val(diff);  
                }

                if ($(".date-range").length > 0) {
                    var len = $('input[id^="diff-"]').length - 1;
                    index = $('input[id^="diff-"]:eq('+len+')').attr('id').substring(5) + 1;
                    
                } else {
        			index = 0;
                }

        		avgInventory();
            	
    		} else { 
        		//Truong hop edit     
                if (mode == 'edit') {
                	startDateString = $('#date-start-'+index).val();
                    endDateString = $('#end-start-'+index).val();
                    diff        = $('#diff-'+index).val();
                	id        = $('#diffid-'+index).val();
                	old_diff = diff;
                	if( !isNaN(diff) ){
                        $('#add_day').val(diff);  
                    }
                }             
        		
    		}
    		
    		$('#add_start_date_range').val(startDateString);
    		$('#add_end_date_range').val(endDateString);

			// Get gia daily inventory hien tai
    		function getCurrenDailyInventory(){
    			if ($('input[id^="add-time-inventory-"]').length == 0 && $('#time_inventory').val() != '') {
					return 0;
				}
    	        return ($('#add_daily_inventory').val() == '' ) ? 0 : $('#add_daily_inventory').val();
    	    }
    		
            var add_indextime = $(".add-time-range").length;
            /** Them gio moi */
            function addTimeDetail(){
                var startTimeString = $('#add_start_hour').val();
                var endTimeString   = $('#add_end_hour').val();
                var time_inventory   = $('#time_inventory').val();
                var currentDailyInventory = getCurrenDailyInventory();
                
                $("#list-time-range").append(createTimeDetailRange(add_indextime,startTimeString, endTimeString, time_inventory));
				if (time_inventory != '') {
					$('#add_daily_inventory').val(parseInt(currentDailyInventory) + parseInt(time_inventory));
				}
				
                $('#add_start_hour').val('');
                $('#add_end_hour').val('');
                $('#time_inventory').val('');
                add_indextime++;
            }
            /** Xoa gio da chon */
            function removeAddTime(index){
                var diff = $('#add-time-end-'+index);
                var time_daily_inventory =  $('#add-time-inventory-'+index).val();
                var currentDailyInventory = getCurrenDailyInventory();
                if ('' != time_daily_inventory) {
					$('#add_daily_inventory').val(parseInt(currentDailyInventory) - parseInt(time_daily_inventory));
                }
				
                diff.parent().remove();
                
                add_indextime--;
            }
            /** Check neu co add gio thi khong cho nhap dail inventory
            	Nguoc lai thi duoc nhap
             */
            function checkDailyInventory() {
            	if ($('input[id^="add-time-inventory-"]').length > 0) {
					$('#add_daily_inventory').attr('readonly', true);
				} else {
					$('#add_daily_inventory').attr('readonly', false);
				}
            }

            /** Tao view hien thi gio them moi */
            function createTimeDetailRange(i,start, end, inventory){
                return '<div class="time-range">'
                        +'<span class="label label-info"><a onclick="removeAddTime(\''+i+'\')" href="javascript:;"><i class="fa fa-times"></i> </a>'+start+' -> '+end+'</span> Limit inventory: ' + inventory
                        +'<input type="hidden" id="add-time-start-'+i+'" name="add_time_start['+i+']" value="'+start+'">'
                        +'<input type="hidden" id="add-time-end-'+i+'" name="add_time_end['+i+']" value="'+end+'">'
                        +'<input type="hidden" id="add-time-inventory-'+i+'" name="add_time_inventory['+i+']" value="'+inventory+'">'
                        +'</div>';
            }

            /** Chuyen chuoi sang date */
            function parseDate(string) {
				var part = string.split('-');
				return new Date(part[2], part[1]-1, part[0]);
            }

            /** Add thong tin da nhap vao parent form */
            function addDateToForm() {
            	startDateString = $('#add_start_date_range').val();
                endDateString = $('#add_end_date_range').val();
                var frequency_cap = $('#add_frequency_cap').val();
                var frequency_cap_time = $('#add_frequency_cap_time').val();
                var daily_invertory = $('#add_daily_inventory').val();

                var message = validate(startDateString, endDateString, daily_invertory);
                $('#message').html(message);
                if (message != '') {
					return;
				}
                start = parseDate(startDateString);
                end = parseDate(endDateString);
                diff = dateDiff(start, end);
                if( !isNaN(diff) ){
                    $('#add_day').val(diff);  
                }
                
                var currentDate = getCurrentDate();
                var days = parseInt(currentDate) - old_diff + parseInt(diff);
                setDate(days);
                
                var time_start = $('input[id^="add-time-start-"]');
                var time_end = $('input[id^="add-time-start-"]');
				if (mode == 'copy') {
					index = $(".date-range").length;
				}
        		var result = createDateRange(index,startDateString, endDateString, diff, frequency_cap, frequency_cap_time, time_start, time_end, daily_invertory, id);
				if ($('#diff-'+index).length > 0) {
					$('#diff-'+index).parent().replaceWith(result);
				} else {
                	$("#list-date-range").append(result); 
				}
                $('#start_date_range').val('');
                $('#end_date_range').val('');
            	
            	$('#dateInfo').modal('hide');
            } 

            /** Validate thong tin da nhap */
            function validate(startDate, endDate, daily_invertory) {
				var message = '';
				if (startDate == '') {
					message += '<li>Please select start date</li>';
				}

				if (endDate == '') {
					message += '<li>Please select end date</li>';
				}

				if (daily_invertory == '' || parseInt(daily_invertory) < 0) {
					message += '<li>Please enter daily inventory</li>';
				}

				return message;
            }

            /** Tao view hien thi tai parent form */
            function createDateRange(i,start, end, diff, frequency_cap, frequency_cap_time, time_start, time_end, daily_inventory, id){	
                var result = '<div class="date-range">'
                        +'<span class="label label-info"><a onclick="removeDate(\''+i+'\')" href="javascript:;" title="Delete"><i class="fa fa-times"></i></a> <a onclick="Flight.getAddDateInfo(\'edit\',\''+i+'\')" href="javascript:;" title="Edit"><i class="fa fa-pencil-square-o"></i></a> <a onclick="Flight.getAddDateInfo(\'copy\',\''+i+'\')" href="javascript:;" title="Copy"><i class="fa fa-clipboard"></i></a> '+start+' -> '+end+'</span>'
                        +'<input type="hidden" id="date-start-'+i+'" name="date['+i+'][start]" value="'+start+'">'
                        +'<input type="hidden" id="end-start-'+i+'" name="date['+i+'][end]" value="'+end+'">'
                        +'<input type="hidden" id="diff-'+i+'" name="date['+i+'][diff]" value="'+diff+'">'
                        +'<input type="hidden" id="frequency-cap-'+i+'" name="date['+i+'][frequency_cap]" value="'+frequency_cap+'">'
                        
                result += '<input type="hidden" id="frequency-cap-time-'+i+'" name="date['+i+'][frequency_cap_time]" value="'+frequency_cap_time+'">';
                result += '<input type="hidden" id="daily-inventory-'+i+'" name="date['+i+'][daily_inventory]" value="'+daily_inventory+'">';
				
				if (id != null) {
					result += '<input type="hidden" id="diffid-'+i+'" name="date['+i+'][id]" value="'+id+'">';
				}

                result += '<div class="sub_form">';
            	result += '<div class="form-group">';
                result += '<label class="col-xs-4 fw_normal">Hour will run flight</label>';
                
            	var j = 0;
            	result += '<div class="col-xs-8 pl0">';
                time_start.each(function(){
                	result += '<input type="hidden" id="time-start-'+i+'-'+j+'" name="date['+i+'][time]['+j+'][start]" value="'+$(this).val()+'">';
                	var end_time_name = $(this).attr('name').replace('start', 'end');
                	var time_inventory_name = $(this).attr('name').replace('add_time_start', 'add_time_inventory');
					
                	var end_time = $('input[name="'+end_time_name+'"]').val();
                	var time_inventory = $('input[name="'+time_inventory_name+'"]').val();
                	result += '<input type="hidden" id="time-end-'+i+'-'+j+'" name="date['+i+'][time]['+j+'][end]" value="'+end_time+'">';
                	result += '<input type="hidden" id="time-inventory-'+i+'-'+j+'" name="date['+i+'][time]['+j+'][time_inventory]" value="'+time_inventory+'">';
        			if (0 == j) {
                		result += '<div>: '+$(this).val()+' -> '+end_time+'.&nbsp;&nbsp;&nbsp;&nbsp;Limit inventory: <span class="show_time_inventory">'+time_inventory+'</span></div>';
        			} else {
        				result += '<div>&nbsp;&nbsp;'+$(this).val()+' -> '+end_time+'.&nbsp;&nbsp;&nbsp;&nbsp;Limit inventory: <span class="show_time_inventory">'+time_inventory+'</span></div>';
        			}	
                	j++;
                });
                
                result += '</div></div>';
                result += '<div class="form-group">';
                result += '<label class="col-xs-4 fw_normal">Daily inventory</label>';
                result += '<div class="show_daily_inventory col-xs-8 pl0">: '+daily_inventory+'</div>';
                result += '</div>';
                result += '<div class="form-group">';
                result += '<label class="col-xs-4 fw_normal">Frequency cap</label>';
                result += '<div class="col-xs-8 pl0">: '+frequency_cap+'</div>';
                result += '</div>';
                result += '<div class="form-group">';
                result += '<label class="col-xs-4 fw_normal">Frequency cap time (mins)</label>';
                result += '<div class="col-xs-8 pl0">: '+frequency_cap_time+'</div>';
                result += '</div>';                
                result += '</div>';                
                result += '</div>';
                
                return result;
            }
			//dd-mm-yyyy
            function dateDiffString(startString, endString) {
				var start = new Date(startString.substring(6,10), startString.substring(3,5) - 1, startString.substring(0,2));
				var end = new Date(endString.substring(6,10), endString.substring(3,5) - 1, endString.substring(0,2));
				var diff = dateDiff(start, end);
				return isNaN(diff)?0:diff;
            }

            function avgInventory() {       
                var hasTime = $('input[id^="add-time-"]').length;
                if (hasTime <= 0) {    
                	var totalInventory = parseInt($('#total_inventory').val());
                	var avgInventory = 0;
                	if (!isNaN(totalInventory)) {
                    	var subInventory = 0;
                    	var remainInventory = 0;
                		$('input[id^="date-start-"]').each(function(){
                			var startDate = $(this).val();
                        	var index = $(this).attr('id').substring("date-start-".length);
                        	var endDate = $('#end-start-'+index).val();
                        	var dInventory = $('#daily-inventory-'+index).val();
                        	
                        	subInventory += dInventory * dateDiffString(startDate, endDate);
                        }); 
                        
                		remainInventory = (totalInventory>subInventory) ? (totalInventory-subInventory) : 0;
                    	
    					var totalDay = parseInt($('#day').val());
    					totalDay = isNaN(totalDay) ? 0 : totalDay;
    					if (diff > 0) {
    						avgInventory = Math.ceil(remainInventory/(diff));
    						$('#add_daily_inventory').val(avgInventory);
    					}
                	}
            	}
            }
        
            $().ready(function(){                
                $('#add_start_hour').datetimepicker({
                    pickDate: false,
                    useSeconds: false,
                    format: 'HH:mm'
                });
                
                $('#add_end_hour').datetimepicker({
                    pickDate: false,
                    useSeconds: false,
                    format: 'HH:mm'
                });

                $('#add_start_date_range').datetimepicker({
                	pickTime: false,
                	format: "DD-MM-YYYY"
                    
                });

                $('#add_end_date_range').datetimepicker({
                	pickTime: false,
                	format: "DD-MM-YYYY"
                });

                var arrCheck = [];

                $('.date').on("dp.show", function(e) {
                    var time_picker = $(this).attr('id');
                    var time_input = null;
                    if ("start_hour_picker" == time_picker) {
						time_input = $('#add_start_hour').val();
                    } else if ("end_hour_picker" == time_picker) {
						time_input = $('#add_end_hour').val();
                    }
                	var widget = $('#loadAddDateInfo').find('.bootstrap-datetimepicker-widget');
					var i = 0;
					
                	widget.each(function() {
                		if($(this).css("display")=="block" && arrCheck.indexOf(i) < 0){
        	          		var left = $(this).css("left");
                	        var top = $(this).css("top");
                	        left = parseFloat(left.substring(0, left.length-2));
                	        top = parseFloat(top.substring(0, top.length-2));
                	        left -= 60;
                	        top -= 30;
                	        $(this).css({"left": (left)+ "px"});
                	        $(this).css({"top": (top)+ "px"});
                	        arrCheck[i] = i;
                	    }
                	    i++;
                	});
                });
				
                $('.date').on("dp.hide", function(e) {
                	arrCheck = [];
                });

                if (mode == 'edit' || mode == 'copy') {
                	var j = 0;
                    $('input[id^="time-start-'+index+'"]').each(function(){
                    	var startTimeString = $(this).val();
                    	var name = $(this).attr('name').replace('start', 'end');
                    	var time_inventory_name = name.replace('end', 'time_inventory');
                    	var endTimeString = $('input[name="'+name+'"]').val();

                    	var time_inventory = $('input[name="'+time_inventory_name+'"]').val();
                    	$("#list-time-range").append(createTimeDetailRange(add_indextime,startTimeString, endTimeString, time_inventory));
                        j++;
                        add_indextime++;
                    });   

                    $('#add_daily_inventory').val($('#daily-inventory-'+index).val());
                }
                
				/*if (startDateString == '' || endDateString == '') {
					$('#DateInfoLabel').html(startDateString+' -> '+endDateString);
				} else {
					$('#DateInfoLabel').html('Add Date');
				}*/
                
                $('#add_frequency_cap').val($('#frequency-cap-'+index).val());
                $('#add_frequency_cap_time').val($('#frequency-cap-time-'+index).val());
                //$('#add_daily_inventory').val($('#daily-inventory-'+index).val());
                
            })
        
        --></script>
                
    </div>
</div>

