var costApp = new function(){

    var module = root+"website/";
    var suffix = "Cost";

    var loadList             = $('#loadList'+suffix);
    var loadModal            = $('#loadModal'+suffix);

    this.loadModal = function(wid, aid, waid){
        var url = root+"website/loadModal"+suffix;
        $.post(
            url,
            {
                wid : wid,
                aid : aid,
                waid : waid
            },
            function(data){
                if( data.status == true ){
                    loadModal.html(data.view);
                    $('#modal'+suffix).modal('show');
                }
            }
        );

    } 

    this.update = function(){

        var input = $('#formUpdate'+suffix).serializeArray();

        var url = module+"update"+suffix;

        $.post(
            url,
            input,
            function(data){
                // console.log(data);
                // $('#formUpdatePublisherMessage').html(data.message);
                if( data.status == true ){
                    $('#formUpdate'+suffix)[0].reset();
                    loadList.html(data.view);
                    $('#modal'+suffix).modal('hide');
                }else{
                    $('#formUpdateMessage'+suffix).html(data.message);
                }
            },
            'JSON'
        )
    }


    this.delete = function(id){
        if (confirm("You want to delete?")) {
            var url = root+"website/deleteFlight";
            $.post(
                url,
                {
                    id : id
                },
                function(data){
                    if( data.status == true ){
                        loadList.html(data.view);
                    }else if( data.message == "access-denied" ){
                        alert("Access Denied");
                    }
                }
            );
        }
    }    

}





