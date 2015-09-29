var pagination = {

    property : {
        urlBase         : null,
        url             : null,
        wrapper         : ".wrap-table",
        button          : ".wrap-table .pagination a",
        showNumberField : "#showNumberField",
        filterForm      : ".filter-form",
        filterStatus      : ".filter-status li",
        autoloadResult  : true,
        searchData      : [],
        oldSearchData   : [],
        showNumber      : 10,
        oldShowNumber   : 10,
        isReset         : 0
    },
    init  :   function( obj ){
        $.extend(this.property, obj);
        this.property.wrapper           = $(this.property.wrapper);
        this.property.showNumberField   = $(this.property.showNumberField);
        this.property.filterForm        = $(this.property.filterForm);
        this.property.filterStatus      = $(this.property.filterStatus);
        this.property.urlBase           = this.property.url;

        this.addEvent();
        if(this.property.autoloadResult){
            this.getResult();
        }
    },
    addEvent: function(){
        var that = this;
        
        this.property.showNumberField.change(function(){
            that.changeShow($(this).val());
        });

        if( this.property.filterForm.length > 0 ){
            this.property.filterForm.submit(function(e){
                data = $(this).serializeArray();
                that.search(data);
                e.preventDefault();
            })
        }
        // filter status publisher
        this.property.filterStatus.click(function(e) {
            status=$(this).attr('data-id');
            $('#status').val(status);
            data = that.property.filterForm.serializeArray();
            that.search(data);
            e.preventDefault();
        });
    },
    changeShow : function(number){
        this.property.showNumber = number;
        this.getResult();
    },
    sort : function(defaultField, defaultOrder){
        this.property.defaultField = defaultField;
        this.property.defaultOrder = defaultOrder;
        this.getResult();
    },
    search : function(searchData){
        this.property.searchData = searchData;
        this.getResult();
    },
    afterResult : function(){
        var button = $(this.property.button);
        var that = this;
        button.click(function(e){
            e.preventDefault();
            href = $(this).attr("href");
            that.property.url = href;
            that.getResult();
        });
        
        $('.showNumberField').change(function(e){                    
            that.changeShow($(this).val());
        });

        if( that.property.isReset ){
            that.property.url = that.property.urlBase;
        }

    },
    getResult :   function (){
        showLoading();
        this.getIsReset();

        var that = this;
        $.post(
            this.property.url,{
                isReset         : that.property.isReset,
                defaultField    : that.property.defaultField,
                defaultOrder    : that.property.defaultOrder,
                searchData      : that.property.searchData,
                showNumber      : that.property.showNumber
            },
            function(data){
                that.property.wrapper.html(data);
                that.property.oldSearchData = that.property.searchData;
                that.property.oldShowNumber = that.property.showNumber;
                that.afterResult();
                hideLoading();
            }
        )
    },
    getIsReset : function(){
        var property = this.property;
        if( ( JSON.stringify(property.oldSearchData) != JSON.stringify(property.searchData) ) || (property.oldShowNumber != property.showNumber) ){
            this.property.isReset = 1;
        }else{
            this.property.isReset = 0;
        }
    }

};


function changeBooleanType(id, value, field){
    var url = root+module+"/changeBooleanType";

    $.post(
        url,
        {
            id : id,
            field : field,
            value : value
        },
        function(data){

            if( data == "access-denied" ){
                alert("Access Denied");
            }else if( data != "fail" ){
                $("."+field+"-"+id).html( data );
            }
        }
    );

}

function deleteItem(id) {
    if (confirm("You want to delete?")) {
        var url = root+module+"/delete";
        $.post(
            url,
            {
                id : id
            },
            function(data){
                if( data == "success" ){
                    pagination.getResult();
                }else if( data == "access-denied" ){
                    alert("Access Denied");
                }
            }
        );
    }
    return false;
}

function showLoading(){
    $("#loading").stop().fadeIn();
}

function hideLoading(){
    $("#loading").stop().fadeOut();
}

function toggleContact(id){
    var el = $('.toggle-'+id);
    el.fadeToggle();
}

function checkboxToggle(obj, className){

    if(obj.checked) { // check select status
        $('.'+className).each(function() { //loop through each checkbox
            this.checked = true;  //select all checkboxes with class "checkbox1"               
        });
    }else{
        $('.'+className).each(function() { //loop through each checkbox
            this.checked = false; //deselect all checkboxes with class "checkbox1"                       
        });         
    }
}

$(window).load(function() {

    if( $('.flash-message').length ){
        $('.flash-message').slideDown('400', function() {
            $('.flash-message').delay(5000).slideUp('400');
        });   
    }
    
});

$().ready(function(){
	$('div.head a.btn-filter').click(function(){
        var down = $('div.head a.btn-filter i').hasClass('fa-chevron-circle-down');
        if (down) {
        	$('div.head a.btn-filter i').toggleClass('fa-chevron-circle-down fa-chevron-circle-up');
        } else {
        	$('div.head a.btn-filter i').toggleClass('fa-chevron-circle-up fa-chevron-circle-down');
        }
    });
});

