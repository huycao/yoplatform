<div class="row">
    <div class="col-xs-12">
        <a href="{{ URL::Route($moduleRoutePrefix.'ShowCreateAudience',$id) }}" id="btnCreateNew" class="btn btn-primary btn-xs">
            <span class="fa fa-plus" aria-hidden="true"></span>
            Create New
        </a>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="wrap-table">
            
        </div>
    </div>
</div>
<script type="text/javascript">
    $().ready(function(){
        pagination.init({
            url : "{{URL::Route('AdAdvertiserManagerGetListAudiences', $id)}}",
            defaultField : "audience_update",
            defaultOrder : "asc"
        });
    });

</script>