<div class="row mb12">
    <div class="col-md-4">
        <div class="box">
            <div class="head">Campaign Report</div>
            <table class="table table-striped table-hover table-condensed ">
                <tr>
                    <td width="25%">Campaign</td>
                    <td width="75%" colspan="3"><a
                    	href="{{ URL::Route($moduleRoutePrefix.'ShowView',$campaign->id) }}">{{ $campaign->name }}</a>
                    </td>
                </tr>
                <tr>
                    <td width="25%">Total Conversion</td>
                    <td width="75%" colspan="3">
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="col-md-8">
        <div id="hight-chart"></div>
    </div>
</div>


<div class="row mb12">
    <div class="col-md-12">
        
    </div>
</div>

<div class="row">
    <div class="col-md-12">

    {{
        Form::open(array(
            'role'      =>  'form',
            'class'     =>  'form-horizontal',
            'url'       =>  URL::current(),
            'method'    =>  'get'
        ))
    }}
        <div class="box mb12">
            <div class="head row-fluid">
                <div class="col-md-6">List Conversion Of Campaign</div>
            </div>
            <table class="table table-striped table-hover table-condensed ">
            	<colgroup>
            		<col width="10%">
            		<col width="40%">
            		<col width="35%">
            		<col width="15%">
            	</colgroup>
                <tr class="bg-primary">
                    <th>ID</th>
                    <th>Conversion</th>
                    <th>Source</th>
                    <th>Total conversion</th>
                </tr>

                @if(!empty($listConversionTracking))
                    @foreach($listConversionTracking as $tracking)
                        <tr>
                            <td>{{$tracking['conversion']['id']}}</td>
                            <td class="nameflight">
                            	<a href="{{URL::Route($moduleRoutePrefix.'ShowReportConversionDetail', $tracking['conversion']['id'])}}" tabindex="0">{{$tracking['conversion']['name']}}</a>
                            </td>
                            <td>{{$tracking['conversion']['source']}}</td>
                            <td class="text-center">{{number_format($tracking['total_conversion'])}}</td>
                        </tr>
                    @endforeach
                @endif
            </table>

        </div>
        
        <a href="javascript:;" class="btn btn-default btn-sm mb12" data-toggle="modal"
           data-target="#modalExport">Export</a>
    {{ Form::close() }}


    </div>
</div>
<!-- Modal Export -->
<div class="modal fade" id="modalExport" tabindex="-1" role="dialog" aria-labelledby="modalExportLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalExportLabel">Report Export</h4>
            </div>
            <div class="modal-body">
                <form id="formExport" role="form">
                    <h5>Select Conversion:</h5>
					@if(!empty($listConversionTracking))
                        @foreach($listConversionTracking as $tracking)
                            <div class="checkbox">
                            <label>
                                <input type="checkbox" name="cid[]" id="reportOption{{$tracking['conversion']['id']}}" value="{{$tracking['conversion']['id']}}">{{$tracking['conversion']['name']}}
                            </label>
                        </div>
                        @endforeach
                    @endif
                        
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="btnGetLinkReportExport" type="button" onclick="getLinkReportExport()"
                        class="btn btn-primary">Export
                </button>
                <a id="btnGetReportExport" href="javascript:;"></a>
            </div>
        </div>
    </div>
</div>


<?php echo HTML::script("{$assetURL}js/chart/highcharts.js"); ?>
<script type="text/javascript">
    $(function () {

        $('#hight-chart').highcharts({
            chart: {
                type: 'area',
                zoomType: 'xy'
            },
            title: {
                text: ''
            },
            xAxis: {
                allowDecimals: false,
                labels: {align: 'center', rotation: 300, y: 40},
                categories: {{$listDate}},
                crosshair: true
            },
            yAxis: [
                {
                    title: {
                        text: 'Conversion'
                    }
                }
            ],
            series: [{
                name: 'Conversion',
                data: {{$listConversion}}
            }]
        });

        $('#select-all').click(function (event) {  //on click
            if (this.checked) { // check select status
                $('.checkbox').each(function () { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"
                });
            } else {
                $('.checkbox').each(function () { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"
                });
            }
        });
    });

    function getLinkReportExport() {
        var formData = $("#formExport").serialize();
        var formhorizontal = $(".form-horizontal").serialize();
        var queryString = "campaign_id={{$id}}";
        var url = root + module + "/reportExportConversion?" + queryString + "&" + formData + "&" + formhorizontal;
        window.location = url;
    }
</script>
