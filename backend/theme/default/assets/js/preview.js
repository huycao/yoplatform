
var PreviewApp = function(){
    var type = null;
    var id = null;

    this.setType = function(value){
		type = value;
	}
    
    this.setID = function(value){
		id = value;
	}
    
    this.getPreview = function(type, id){
    	this.setType(type);
        this.setID(id);
        var url = root+"tool/preview";
        $.post(
			url,
			{
				type 	: type,
				id		: id
			},
			function(data){
				$('#preview').html(data.view);
				$('#loadPreviewModal').modal('show');
			}
		);
    }
       
}

var Preview = new PreviewApp();




