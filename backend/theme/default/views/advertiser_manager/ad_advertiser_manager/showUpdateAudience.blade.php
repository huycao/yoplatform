<div class="part">
@include("partials.show_messages")
{{ Form::open(array('enctype'=>'multipart/form-data','role'=>'form','class'=>'form-horizontal form-cms')) }}
  <div class="row">
    <div class="col-md-12">
      <!-- NAME -->
      <div class="form-group form-group-sm">
        <label class="col-md-2">Name</label>
        <div class="col-md-4">
          <input type="text" class="form-control" id="name" value="{{ $item->name }}" name="name">
        </div>
      </div>

      <!-- DESCRIPTON -->
      <div class="form-group form-group-sm">
        <label class="col-md-2">Description</label>
        <div class="col-md-4">
          <textarea class="form-control" id="description" name="description" rows="3" style="height:auto" value="{{ $item->description }}">{{ $item->description }}</textarea>
        </div>
      </div>
      <input type="hidden" value="{{$username}}" name="last_editor"/>
    </div>
  </div>
    <div class="row">
      <div class="col-md-12">
      @include("partials.save")
      </div>
  </div>
{{ Form::close() }}
</div>
