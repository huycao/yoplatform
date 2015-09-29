var SelectApp = function(){

	var modal = $('#selectModal');
	var type = null;
	var firstRun = true;
	var keyword = null;
	var input = null;
	var parent = null;
	var self = this;
	var container = $('#selectModal .modal-body');
	var listCampaignRetargeting = [];
	var quickSearch = $('#keyword');
	var searchID = $('#search_id');
	var id = null;

	this.setListCampaignRetargeting = function(value){
		listCampaignRetargeting = value;
	}

	this.getListCampaignRetargeting = function(){
		return listCampaignRetargeting;
	}

	this.setType = function(value){
		type = value;
	}

	this.setKeyword = function(value){
		keyword = value;
	}
	
	this.setID= function(value){
		id = value;
	}

	this.setInput = function(value){
		input = value;
	}

	this.setParent = function(value){
		if( $("#"+type+"_parent_id").length ){
			parentId = $("#"+type+"_parent_id").val();
			parentEl = $("#"+parentId);
			parent = parentEl.val();
		}
	}

 	this.openModal = function(value){
 		self.setType(value);
 		self.setParent(value); 		

 		modal.modal('show');
		modal.on('hidden.bs.modal', function (e) {
	 		container.html('');
		});
		
		self.setKeyword('');
		quickSearch.val('');
		searchID.val('');
		self.setID(0);
		self.search();
	};

	this.searchByKeyword = function(value){
		self.setKeyword(value);
		self.setID(0);
		searchID.val('');
		self.search();
	};
	
	this.searchByID= function(value){
		self.setKeyword('');
		self.setID(value);
		quickSearch.val('');
		self.search();
	};

	this.search = function(){
		url = root+"tool/search";
		$.post(
			url,
			{
				parent  : parent,
				type 	: type,
				keyword : keyword,
				id      : id
			},
			function(data){
				container.html(data);
			}
		)
	};

	this.chooseData = function(id, name){
		$('#'+type).val(name);
		$('#'+type+'_id').val(id);
 		modal.modal('hide');
	}

	this.chooseDataCampaign = function(id, name, dateRange){
		$('#'+type).val(name);
		$('#'+type+'_id').val(id);
		$('#'+type+'_date').val(dateRange);
 		modal.modal('hide');
	}
    this.chooseDataCampaignRetargetingUrl = function(id, name, dateRange,url,rtype){
        $('#campaign').val(name);
        $('#campaign_id').val(id);
        $('#campaign_date').val(dateRange);
        $('#retargeting_show'+rtype).attr('checked','checked');
        $('#retargeting_url').val(url);
        modal.modal('hide');
    }
	this.chooseDataCampaignRetargeting = function(id, name){


		if( listCampaignRetargeting.indexOf(id) == -1 ){
			listCampaignRetargeting.push(id);
			var child = '<div class="campaign-retargeting-item-'+id+'">'
	                    	+'<span class="label label-info"><a onclick="removeCampaignRetargeting(\''+id+'\')" href="javascript:;"><i class="fa fa-times"></i></a>'+name+'</span>'
	                        +'<input type="hidden" class="campaign-retargeting-selected" name="campaign-retargeting-selected[]" value="'+id+'">'
	                    +'</div>';
	        $("#list-campaign-retargeting").append(child);
		}
 		modal.modal('hide');
	}


}

var Select = new SelectApp();