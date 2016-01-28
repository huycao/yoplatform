{{ HTML::script("{$assetURL}js/chosen/chosen.jquery.min.js") }}
{{ HTML::style("{$assetURL}css/chosen/chosen.min.css") }}
{{ HTML::style("{$assetURL}css/checkbox.css") }}
<style>
  .SlectBox {
    width: 250px;
    padding: 6px 8px;
    font-size: 14px;
  }
  .SumoSelect .select-all {
    border-radius: 3px 3px 0px 0px;
    position: relative;
    border-bottom: 1px solid #ddd;
    background-color: #fff;
    padding: 8px 0px 8px 35px;
    height: 30px;
  }

  .SumoSelect label {
    margin-bottom: 0px;
    font-weight: normal;
  }
  .fb_theme .box .head a.btn-filter2 {
    text-decoration: none;
  }
  .fb_theme .btn-filter2 {
    color: #000;
    display: block;
  }

  .fb_theme .box .content {
    padding-bottom: 30px;
  }
</style>
<div class="box mb12">

  <div class="head">
    <a href="javascript:;" class="btn-filter2"><i class="fa fa-chevron-circle-down"></i> Filter</a>
  </div>

  <div id="filter" class="content">
    <form class="filter-form form-horizontal" id="filter" role="form">
      <div class="filter-wrapper">
        <div class="row">
          <div class="col-xs-12">
            <table class="table">
              <tr>
                <td width="35%">
                  <div class="col-md-12">
                    <span class="lbl">Date</span>

                    <div class="input-daterange input-group col-md-9" id="datepicker" style="float:left">
                      <input type="text" class="form-control" name="start_date_range" value=""
                             id="start_date_range">
                      <span class="input-group-addon">to</span>
                      <input type="text" class="form-control" name="end_date_range" value=""
                             id="end_date_range">
                    </div>
                  </div>

                </td>
                <td width="20%">
                  <span class="lbl">Campaign</span>
                  <div>
                    <select id="search-campaign" name="campaign" data-placeholder="Select some campaign" class="chosen-select form-control" multiple>  
                      <option value=""></option>
                      @foreach($campaigns as $id=>$name)
                      <option value="{{$id}}">{{$name}}</option>
                      @endforeach
                    </select>
                  </div>
                </td>
                <td width="20%">
                  <span class="lbl">Flight</span>
                  <div>
                    <select id="search-flight" name="flight" data-placeholder="Select some flight" class="chosen-select form-control" multiple>  
                      <option value=""></option>
                    </select>
                  </div>
                </td>
                <td width="15%">
                  <span class="lbl">Website</span>
                  <div>
                    <select id="search-website" name="webiste" data-placeholder="Select some websites" class="chosen-select form-control" multiple>  
                      <option value=""></option>

                    </select>
                  </div>
                </td>
              </tr>

            </table>
          </div>

        </div>
        <div class="col-md-12">
          <div class="">
            <button type="submit" class="btn btn-sm btn-default filter-button">Report</button>
          </div>
        </div>
      </div>
    </form>
  </div>

</div>
<script>
  $('.input-daterange').datepicker({
    format: 'yyyy-mm-dd',
    todayBtn: "linked"
  });
  var currentDate = new Date();
  $('#start_date_range').datepicker('setDate', currentDate);
  $('#end_date_range').datepicker('setDate', currentDate);

  $('#search-campaign').on('change', function () {
    $.ajax({
      type: "POST",
      url: "{{URL::Route('ToolAdvertiserManagerHQGetFlights')}}",
      data: {campaigns: $(this).val()},
      success: function (data) {
        var options = '';
        for (var ad_zone in data) {
          options += '<option value="' + ad_zone + '">' + data[ad_zone] + '</option>';
        }
        updateSelect('#search-flight', options);
        updateSelect('#search-website', '');
      }
    });
  });

  $('#search-flight').on('change', function () {
    $.ajax({
      type: "POST",
      url: "{{URL::Route('ToolAdvertiserManagerHQGetWebsites')}}",
      data: {flights: $(this).val()},
      success: function (data) {
        var options = '';
        for (var ad_zone in data) {
          options += '<option value="' + ad_zone + '">' + data[ad_zone] + '</option>';
        }
        updateSelect('#search-website', options);
      }
    });
  });

  var config = {
    '.chosen-select': {},
    '.chosen-select-deselect': {allow_single_deselect: true},
    '.chosen-select-no-single': {disable_search_threshold: 10},
    '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
    '.chosen-select-width': {width: "95%"}
  }
  for (var selector in config) {
    $(selector).chosen(config[selector]);
  }

  function updateSelect(object, option) {
    $(object).html(option);
    $(object).trigger("chosen:updated");
  }
</script>

<div class="row">
  <div class="col-xs-12">
    <div class="wrap-table">

    </div>
  </div>
</div>
<script type="text/javascript">
  $().ready(function () {
    pagination.property.searchData = $('.filter-form').serializeArray();
    pagination.init({
      url: "{{URL::Route('ToolAdvertiserManagerHQShowStats')}}",
      defaultField: "",
      defaultOrder: "",
    });
  });
</script>
