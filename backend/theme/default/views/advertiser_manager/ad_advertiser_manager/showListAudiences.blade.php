<div class="row" style="padding-bottom:4px">
    <div class="col-xs-12">
        <a href="{{ URL::Route($moduleRoutePrefix.'ShowCreateAudience',$id) }}" id="btnCreateNew" class="btn btn-primary btn-xs">
            <span class="fa fa-plus" aria-hidden="true"></span>
            Create New
        </a>
         <a href="javascript:void(0)" id="btnDelete" class="btn btn-primary btn-xs">
            <span class="fa fa-minus" aria-hidden="true"></span>
            Delete
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

        $("#btnDelete").click(function(){
            var msg = "";
           $.each($("input[name='case[]']:checked"), function(i, v){
                var selId = $(this).parents('tr:eq(0)');                
                msg +="<li>";
                msg += $(selId).find('td:eq(1)').text()+"</li>";
           })

           if(msg==""){
                text = "No audiences selected";
                $("#okbtn").hide();
           }else{
                text = "Do you want to delete following audiences: <ul>"+ msg +"</ul>";
                 $("#okbtn").show();
           }
           $("#list-audiences").html(text);
           $("#myModal").modal('show');
        })
    });

    function deleteAudiences(){
        $("#myModal").modal('hide');
        var values = [];
        $.each($("input[name='case[]']:checked"), function(i, v){
            var selId = $(this).parents('tr:eq(0)').attr('id');                
            values.push(selId);
        })
       if(values.length>0){
            $.ajax({
                type:'post',
                url:'{{ URL::Route("AdAdvertiserManagerDeleteAudiences")}}',
                data:{'ids':values},
                success: function(data){
                    alert('Delete success');
                    window.location.reload();
                }
            })
       }else{
            alert('No audience selected');
       }
    }
</script>

<!-- show popup confirm -->
<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Audiences</h4>
      </div>
      <div class="modal-body" style="overflow:hidden">
        <p class="model-mess" id="list-audiences">            
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="deleteAudiences()" id="okbtn">Ok</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->