
var AdApp = function(){
    var loadList             = $('#loadFlightList');
    var loadModal            = $('#loadFlightModal');

    this.update = function(){

        var input = $('#formUpdateFlight').serializeArray();
        var url = root+"website/updateFlight";

        $.post(
            url,
            input,
            function(data){
                // console.log(data);
                // $('#formUpdatePublisherMessage').html(data.message);
                if( data.status == true ){
                    $('#formUpdateFlight')[0].reset();
                    loadList.html(data.view);
                    $('#flightModal').modal('hide');
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

    this.loadModal = function(id, websiteId, flightId, flightName){
        var url = root+"website/loadModal";
        $.post(
            url,
            {
                id : id,
                websiteId : websiteId,
                flightId : flightId,
                flightName : flightName
            },
            function(data){
                if( data.status == true ){
                    loadModal.html(data.view);
                    $('#flightModal').modal('show');
                }
            }
        );

    } 
       
}

var Ad = new AdApp();




