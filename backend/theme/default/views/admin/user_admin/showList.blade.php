<div class="row" style="margin-bottom: 10px;">
    <div class="col-xs-2">
    	<a href="{{URL::Route('UserAdminShowCreate')}}" class="btn btn-default btn-sm">Add More</a>
    </div>
    <div class="col-xs-10">
        <form class="filter-form form-inline">
            <div class="form-group">
                <label for="txtKeyWord">Username</label>
                <input type="text" name="username" class="form-control input-sm" id="txtKeyWord" placeholder="Input keyword">
            </div>
            <div class="form-group">
                <label for="droTypeFilter">Group</label>
                <select
                    name="group"
                    class="form-control input-sm"
                    id="droTypeFilter"
                >
                    <option value="">Select group</option>
                    @if (!empty($groupList))
                    @foreach ($groupList as $aGroup)
                        <option value="{{{$aGroup->id}}}">
                        {{{$aGroup->name}}}
                        </option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label>Status:</label>
                <label class="radio-inline"><input type="radio" name="activated" id="radStatus" value="0">Inactive</label>
                <label class="radio-inline"><input type="radio" name="activated" id="radStatus" value="1">Active</label>
            </div>
            <button class="btn btn-default btn-sm">Filter</button>
        </form>
    </div>
</div>
@include('partials.show_list')