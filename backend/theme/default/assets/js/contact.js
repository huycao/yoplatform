
var ContactApp = function(){
    var loadContactList             = $('#loadContactList');
    var loadContactModal            = $('#loadContactModal');

    this.updateContact = function(){

        $('#formUpdateContactType').val(module);
        $('#formUpdateContactTypeID').val($('#tmpTypeID').val());


        var input = $('#formUpdateContact').serializeArray();
        var url = root+"contact/update";
        $.post(
            url,
            input,
            function(data){
                $('#formUpdateContactMessage').html(data.message);
                if( data.status == true ){
                    $('#formUpdateContact')[0].reset();
                    loadContactList.html(data.view);
                }
            },
            'JSON'
        )
    }


    this.deleteContact = function(id){
        if (confirm("You want to delete?")) {
            var url = root+"contact/delete";
            $.post(
                url,
                {
                    type        : $('#formUpdateContactType').val(),
                    typeID      : $('#formUpdateContactTypeID').val(),
                    contactID   : id
                },
                function(data){
                    if( data.status == true ){
                        loadContactList.html(data.view);
                    }else if( data.message == "access-denied" ){
                        alert("Access Denied");
                    }
                }
            );
        }
    }    

    this.loadModal = function(id){
        var url = root+"contact/loadModal";
        $.post(
            url,
            {
                id : id
            },
            function(data){
                if( data.status == true ){
                    loadContactModal.html(data.view);
                    $('#contactModal').modal('show');
                }
            },
            'JSON'
        );

    } 
       
}

var Contact = new ContactApp();




