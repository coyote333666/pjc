//	Modifications : 2019-10-25 VF


// Need this to make IE happy
// see http://soledadpenades.com/2007/05/17/arrayindexof-in-internet-explorer/
if(!Array.indexOf){
    Array.prototype.indexOf = function(obj){
	for(var i=0; i<this.length; i++){
	    if(this[i]==obj){
	        return i;
	    }
	}
	return -1;
    }
}


var chatboxManager = function() {

    // list of all opened boxes
    var boxList = new Array();
    // list of boxes shown on the page
    var showList = new Array();
    // list of first names, for in-page demo
    var nameList = new Array();

    var config = {
	width : 450, //px
	gap : 40,
	maxBoxes : 3,
	messageSent : function(dest, msg) {
		// alert(dest);
	    $("#box_" + dest).chatbox("option", "boxManager").addMsg("moi" , msg);
	}
    };

    var init = function(options) {
	$.extend(config, options)
    };


    var delBox = function(id) {
	// TODO
    };

    var getNextOffset = function() {
	return (config.width + config.gap) * showList.length;
    };

    var boxClosedCallback = function(id) {
		// close button in the titlebar is clicked
		var idx = showList.indexOf(id);
		if(idx != -1) {
			showList.splice(idx, 1);
			diff = config.width + config.gap;
			for(var i = idx; i < showList.length; i++) {
			offset = $("#" + showList[i]).chatbox("option", "offset");
			$("#" + showList[i]).chatbox("option", "offset", offset - diff);
			}
		}
		else {
			alert("should not happen: " + id);
		}
    };
	
    var addBox = function(id, user, name) {
		var idx1 = showList.indexOf(id);
		var idx2 = boxList.indexOf(id);
		if(idx1 != -1) {
			// found one in show box, do nothing
		}
		else if(idx2 != -1) {
			// exists, but hidden
			// show it and put it back to showList
			$("#"+id).chatbox("option", "offset", getNextOffset());
			var manager = $("#"+id).chatbox("option", "boxManager");
			manager.toggleBox();
			showList.push(id);
		}
		else{
			var el = document.createElement('div');
			el.setAttribute('id', id);
			$(el).chatbox({id : id,
				user : user,
				title : user.first_name + " " + user.last_name,
				hidden : false,
				width : config.width,
				offset : getNextOffset(),
				messageSent : messageSentCallback,
				boxClosed : boxClosedCallback
				});
			boxList.push(id);
			showList.push(id);
			nameList.push(user.first_name);			
			$.get(
				user.url_json, 
				{ id_from: user.user_id_from, id_to: user.user_id }, 
				function( data ) {
					for (var i = 0; i < data.length; i++){
						chatboxManager.dispatch(id,{first_name:data[i].users},data[i].messages);										
					}
				}, 'json'
			);							
		}
    };

    var messageSentCallback = function(id, user, msg) {
		var idx = boxList.indexOf(id);
		config.messageSent(nameList[idx], msg);
		
		// Debug
		//$("#log").append(id + " said: " + msg + "<br/>" + user.user_id + "<br/>");

		$.post( user.url, { to_user_id: user.user_id, chat_message: msg, action: user.action } );	
	
    };

    var dispatch = function(id, user, msg) {
	$("#" + id).chatbox("option", "boxManager").addMsg(user.first_name, msg);
    }

    return {
	init : init,
	addBox : addBox,
	delBox : delBox,
	dispatch : dispatch
    };
}();
