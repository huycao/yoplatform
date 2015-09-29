<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <a href="javascript:;" id="add-btn" onclick="costApp.loadModal({{$id}}, 0, 0)" class="btn btn-default">Add More</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">            
            <label class="col-md-2">List Base Cost</label>
            <div id="loadListCost" class="col-md-10">
                {{ View::make('costList', array('lists' => $lists) )->render() }}
            </div>
        </div>
    </div>
</div>

<div id="loadModalCost"></div>



