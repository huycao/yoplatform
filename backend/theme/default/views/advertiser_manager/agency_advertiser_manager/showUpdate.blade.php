<div class="part">
@include("partials.show_messages")
{{ Form::open(array('role'=>'form','class'=>'form-horizontal')) }}
    <div class="row">
        <div class="col-md-12">
                <div class="box-body">            
                    <div class="form-group form-group-sm">
                        <label class="col-md-2">{{trans('text.status')}}</label>
                        <div class="col-md-10">
                            <select class="form-control" id="status" name="status">
                                <option value="1" <?php if( isset($item->status) &&  $item->status == 1 ){ echo "selected='selected'"; }?> >{{trans('text.active')}}</option>
                                <option value="0" <?php if( isset($item->status) &&  $item->status == 0 ){ echo "selected='selected'"; }?>>{{trans('text.unactive')}}</option>
                            </select>
                        </div>
                    </div>
                    
                    <hr>
    
                    <div class="form-group form-group-sm">
                        <label class="col-md-2">{{trans('text.country')}}</label>
                        <div class="col-md-10">
                        <?php
                            $countryValue = ( isset($item->country_id) ) ? $item->country_id : Input::get('country');
                        ?>
                        {{ 
                            Form::select(
                                'country', 
                                $listCountry, 
                                $countryValue, 
                                array('class'=>'form-control','id'=>'country')
                            ) 
                        }}
                        </div>
                    </div>

                    <hr>

                    <div class="form-group form-group-sm">
                        <label class="col-md-2">{{trans('text.name')}}</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="name" value="{{{ $item->name or Input::get('name') }}}" name="name">
                        </div>
                    </div>

                    @if( !empty($id) )
                    <hr>
                    <div class="form-group form-group-sm">
                        <input type="hidden" id="tmpTypeID" value="{{$id}}" name="tmpTypeID">
                        <label class="col-md-2">{{trans('text.contact_list')}}</label>
                        <div class="col-md-10">
                            <a href="javascript:;" onclick="Contact.loadModal(0)"class="btn btn-default btn-sm">Add More</a>
                            <hr>
                            <div id="loadContactList">
                                {{View::make('contact_advertiser_manager.contactList', array('contactList'=>$item->contact))}}
                            </div>
                        </div>
                    </div>
                    @endif

                </div><!-- /.box-body -->

        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            @include("partials.save")
        </div>
    </div>
{{ Form::close() }}
</div>

@if( !empty($id) )
    <div id="loadContactModal"></div>
@endif




