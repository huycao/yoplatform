<ul id="myTabs" class="nav nav-tabs" style="margin-bottom: 10px">
    <li role="presentation" class="active"><a href="#" id="home-tab">Campaign</a></li>
    <li role="presentation" class=""><a href="{{ URL::Route($moduleRoutePrefix.'ShowPublisher') }}"  id="profile-tab" >Publisher</a></li>
</ul>
<div class="row">
    <div class="col-md-12">
        <form method="GET" action="" accept-charset="UTF-8" role="form" class="form-horizontal">
            <div class="box mb12">

                <table class="table table-striped table-hover table-condensed table-border">
                    <tbody>
                    <tr class="bg-primary">
                        <th width="5%">Campain</th>
                        <th width="25%">Flight</th>
                        <th class="text-center">Status</th>
                        <th>Inventory</th>
                        <th>Frequency</th>
                        <th>CTR</th>
                        <th class="text-center">Action</th>
                    </tr>
                    @foreach($datas as $campaign=>$campaigns)
                        <?php
                            $stt = 1;
                        ?>
                        @foreach($campaigns as $flign_name=>$flight)
                            <?php
                            $campaindata = $flight->campaign;
                            $status = $flight->getStatusInventory($flight->campaign);
                            $dailyInventory = $flight->getDailyInventory();
                            
                            
                            $flightInventory=null;
                            try{
                              $flightInventory = $totalInventories[$flight->id];
                            }catch(Exception $ex){
                              //echo ($ex);                              
                            };

                            $inventory = $sumFrequency=$sumCTR=$totalInventory = $totalFrequency= $totalCTR=0;
                            $total_inventory = ($flight->cost_type == "cpm") ? $flight->total_inventory *1000 :  $flight->total_inventory;
                            $totalCTR = $totalFrequency = 0;

                                if(isset($flightInventory['total_impression']) && isset($flightInventory['total_click'])){
                                if(trim($flight->cost_type) == "cpm"){
                                    $totalInventory = $flightInventory['total_impression'];
                                }else{
                                    $totalInventory = $flightInventory['total_click'];
                                }
                                if($flightInventory['total_unique_impression'] >0){

                                    $totalFrequency=  number_format(($flightInventory['total_impression']) / ($flightInventory['total_unique_impression']), 2);

                                }
                                if($flightInventory['total_impression']>0){
                                    $totalCTR = number_format(($flightInventory['total_click']) / ($flightInventory['total_impression'] ) * 100, 2);
                                }
                            }

                            if($dailyInventory!=0){
                                if($flight->cost_type == "cpm"){
                                    $inventory = $dailyInventory['sumImpression']+$dailyInventory['sumImpressionOver'];
                                }else{
                                    $inventory = $dailyInventory['sumClick']+$dailyInventory['sumClickOver'];
                                }

                                $sumFrequency = $dailyInventory['sumFrequency'];
                                $sumCTR = $dailyInventory['sumCTR'];
                            }
                            ?>
                            <tr>
                                @if($stt == 1)
                                <td rowspan="{{count($campaigns)}}"   id="campaign-{{$campaindata->id}}" style="vertical-align: middle;text-align: center;">
                                    <div class="data-campaign">
                                    <a href="{{ URL::Route('CampaignAdvertiserManagerShowUpdate',$campaindata->id) }}" data-toggle="popover" data-trigger="hover" data-popover-content="#c{{$campaindata->id}}" data-original-title="" title="" target="_blank">
                                    <span class="text-campaign">({{$campaindata->id}}) {{ substr($campaindata->name,0,15)."..."}}</span></a></div>
                                    <div id="c{{$campaindata->id}}" class="hidden">
                                        <div class="popover-heading">({{$campaindata->id}}) {{$campaindata->name}}</div>
                                        <div class="popover-body">
                                            ({{$campaindata->id}}) {{$campaindata->name}}
                                        </div>
                                    </div>
                                </td>
                                @endif
                                <?php $stt++;?>
                                <td class="">
                                    <a href="#" tabindex="0" data-toggle="popover" data-trigger="hover" data-popover-content="#a{{$flight->id}}" data-original-title="" title="">({{$flight->id}}) {{$flight->name}}</a>
                                    <!-- Content for Popover #2 -->
                                    <div id="a{{$flight->id}}" class="hidden">
                                        <div class="popover-heading">({{$flight->id}}) {{$flight->name}}</div>
                                        <div class="popover-body">
                                            <p><b>Cost Type:</b> {{strtoupper($flight->cost_type)}}</p>

                                            <p><b>Total Inventory:</b> {{ number_format($flight->total_inventory)}}</p>

                                            <p><b>Flight Date:</b> </p>
                                            <?php
                                            $flight_date = json_decode($flight->date);?>
                                            @foreach($flight_date as $date)
                                                <p>{{$date->start}} -&gt; {{$date->end}}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($status['status'] == 'play')
                                        <span class="label label-success" data-toggle="popover" data-trigger="hover"
                                              data-popover-content="#status{{$flight->id}}"><span
                                                    class="  glyphicon glyphicon-play"></span></span>
                                    @else
                                        <span class="label label-danger" data-toggle="popover" data-trigger="hover"
                                              data-popover-content="#status{{$flight->id}}"><span
                                                    class="  glyphicon glyphicon-stop"></span></span>
                                        @endif
                                                <!-- Content for Popover #2 -->
                                        <div id="status{{$flight->id}}" class="hidden">
                                            <div class="popover-heading">({{ $flight->id}}) {{ $flight->name}}</div>
                                            <div class="popover-body">
                                                {{ trans($status['msg']) }}
                                            </div>
                                        </div>
                                </td>

                                <td>
                                    <div class="txt-data">Today: {{ number_format($inventory)}} / {{number_format($flight->daily_inventory)}}</div>
                                    <div class="txt-data">Total: {{ number_format($totalInventory)}} / {{ number_format($total_inventory)}}</div>
                                </td>
                                <td>
                                    <div class="txt-data">Today: {{$sumFrequency}}</div>
                                    <div class="txt-data">Total: {{$totalFrequency}}</div>
                                </td>
                                <td>
                                    <div class="txt-data">Today: {{$sumCTR}}</div>
                                    <div class="txt-data">Total: {{$totalCTR}}</div>
                                </td>
                                <td align="center">
                                    <span class="status_flight @if($flight->status == 0) off @endif" data-flight="{{$flight->id}}"><i class="fa @if($flight->status == 0) fa-toggle-off @else fa-toggle-on @endif"></i> @if($flight->status == 0) Off @else On @endif</span>
                                    &nbsp;&nbsp;
                                    <span class="viewwebsite" data-ad="{{$flight->ad_id}}" data-campaign="{{$campaindata->id}}" data-flight="{{$flight->id}}"><i class="fa fa-sitemap"></i> Sites </span>
                                    &nbsp;&nbsp;
                                    <a href="{{ URL::Route('FlightAdvertiserManagerShowUpdate',$flight->id) }}" target="_blank" class="edit_flight"><i class="fa fa-pencil-square-o"></i> Edit</a>
                                </td>
                            </tr>

                        @endforeach
                    @endforeach
                    </tbody></table>

            </div>
        </form>
    </div>
</div>
<script>
    $(function () {
        $("[data-toggle=popover]").popover({
            html: true,
            content: function () {
                var content = $(this).attr("data-popover-content");
                return $(content).children(".popover-body").html();
            },
            title: function () {
                var title = $(this).attr("data-popover-content");
                return $(title).children(".popover-heading").html();
            }
        });
        $(".viewwebsite").click(function(){
            var $sitelists = $(this).attr("siteload");
            var $flight = $(this).attr('data-flight');
            var $campaign = $(this).attr('data-campaign');
            var $ad = $(this).attr('data-ad');

            if($sitelists != "1") {
                var $tr = $(this).parent().parent();
                $tr.after(function () {
                    return '<tr class="website-'+$flight+'"><td  colspan="6" class="text-center"><img src="{{$assetURL}}img/loading-d.GIF">Loading...</td></tr>';
                });
                $("#campaign-" + $campaign).attr('rowspan', parseInt($("#campaign-" + $campaign).attr('rowspan')) + $('.website-'+$flight).length);
                var $myelement = $(this);

                $.ajax({
                     url:'{{URL::route("ToolAdvertiserManagerPreviewFlightWebsite")}}',
                    data:{flight:$flight,ad:$ad,campaign:$campaign},
                    method:"POST",
                    success:function(data){
                        $("#campaign-" + $campaign).attr('rowspan', parseInt($("#campaign-" + $campaign).attr('rowspan')) - $('.website-'+$flight).length);
                        $('.website-'+$flight).remove();
                        if(data != ""){
                            $tr.after(function () {
                                return data;
                            });
                            $("#campaign-" + $campaign).attr('rowspan', parseInt($("#campaign-" + $campaign).attr('rowspan')) + $('.website-'+$flight).length);
                            $myelement.attr("siteload",1);
                            $myelement.html('<i class="fa fa-sitemap"></i> Hide Sites');
                        }
                    },
                });
            }else{
                if($(".website-" + $flight).css("display") !="none"){
                    $(this).html('<i class="fa fa-sitemap"></i> Sites');
                    $(".website-" + $flight).css("display","none");
                    $("#campaign-" + $campaign).attr('rowspan', parseInt($("#campaign-" + $campaign).attr('rowspan')) - $('.website-'+$flight).length);

                }else{
                    $(this).html('<i class="fa fa-sitemap"></i> Hide Sites');
                    $(".website-" + $flight).css("display","");
                    $("#campaign-" + $campaign).attr('rowspan', parseInt($("#campaign-" + $campaign).attr('rowspan')) + $('.website-'+$flight).length);

                }

            }
        });
        $(".status_flight").click(function(){
           var $flight = $(this).attr('data-flight');
           var $element = $(this);
           if($(this).hasClass("off")){
               var status = 0;
           }else{
               var status = 1;
           }
           var url = root+"flight/change-status";
           $.post(url,
                   {
                        id : $flight,
                        status : status,
                        type : "ok"
                    },
                    function(data){
                        if( data != "fail" ){
                            if(data == "0"){
                                $element.addClass("off");
                                $element.html('<i class="fa fa-toggle-off"></i> Off');
                            }else{
                                $element.removeClass("off");
                                $element.html('<i class="fa fa-toggle-on"></i> On');
                            }
                        }
                    }
            );

        });
    });
</script>