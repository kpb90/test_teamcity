var DRJ_orderIdField = new Ext.form.Hidden({
	id:'order-id'
});

var DRJ_emailField = new Ext.form.Hidden({
	id:'user-email'
});
var manager_DRJ_emailField = new Ext.form.Hidden({
	id:'manager-email'
});

var DRJ_commentField = new Ext.form.TextArea({
				id: 'comment-edit',
				fieldLabel :"",
				labelStyle: 'margin-top: 30px;width:0!important;margin:0!important;',
				bodyStyle:'margin-top: 60px;',			
				width: 340,
				height: 100,
				ttype: 'text'
			});

DRJ_commentField.emptyText = 'Причина отмены заявки';
DRJ_commentField.applyEmptyText();

var DRJ_infoOrderPanel =  new Ext.Panel({	
	layout:'fit',
	bodyStyle:'margin-bottom:24px;background-color:white;padding:10px;',
	labelWidth:0,	
	autoScroll: true,
	width:644,
	height:330
})

function ConfirmRejectOrder() {
	var id = DRJ_orderIdField.getValue(),
		email = DRJ_emailField.getValue(),
		manager_email = manager_DRJ_emailField.getValue(),
	    comment= DRJ_commentField.getValue(),
	    send_obj = {'task':'reject_this_order', 'id':id, 'comment':comment,'email_user':email, 'email_manager' : manager_email};
		send_confirm (send_obj);
}

function showAproveDialog (query) {
	var DRJ_approvePanel = new Ext.Panel({	
		layout:'form',
		border:false,	
		bodyStyle:'margin:10px;background-color:white;height:600px;width:600px;',
		labelWidth: 0,	
		height:200,
		items:[DRJ_orderIdField, DRJ_emailField, DRJ_infoOrderPanel]       
	});

	var DRJ_approveDialog = new Ext.Window({
		width: 680,
		height:440,
		title:'Заявка одобрена',
		layout: 'fit',
		constrain: true,
		modal:true,
		bodyStyle:'background-color:white;',
		buttonAlign:'center',
		items: DRJ_approvePanel,
		closeAction:'hide',
		resizable: false,
		buttons:[{
			text:'ок',			
			handler: function() {
				document.location.href = 'orders.php';
			}
		}]		 		
	});	
	get_data_order (query, 'aprove');
	DRJ_approveDialog.show();
}

function showRejectDialog (query) {
	showRejectDialog.query = query;
	var DRJ_rejectPanel = new Ext.Panel({	
			layout:'form',
			border:false,	
			bodyStyle:'margin:10px;background-color:white;height:600px;width:600px;',
			height:200,
			items:[DRJ_orderIdField, DRJ_emailField, DRJ_commentField, DRJ_infoOrderPanel]       
	});

	var DRJ_rejectDialog = new Ext.Window({
		width: 680,
		height:540,
		title:'Отмена заявки',
		layout: 'fit',
		constrain: true,
		modal:true,
		bodyStyle:'background-color:white;',
		buttonAlign:'center',
		items: DRJ_rejectPanel,
		closeAction:'hide',
		resizable: false,
		buttons:[{
			text:'Подтвердить',
			handler:ConfirmRejectOrder
		}, {
			text:'Отмена',			
			handler: function() {
				DRJ_rejectDialog.hide();
			}
		}]		 		
	});	
	 get_data_order (query, 'reject');
	 DRJ_rejectDialog.show();
}

function send_confirm (send_obj) {
	Ext.Ajax.request({ 		
		url:'orders/controller.php', 
		params:send_obj, 					 
		method:'POST',										 
		callback: function (options, success, response) {			 				 	
			var json = Ext.util.JSON.decode(response.responseText);		
			document.location.href = 'orders.php';
		 }, 
		 failure:function(response,options){
			showErrorMessage('Нет соединения с сервером');
		}	
	});	
}

function get_data_order (query, type) {
	query = query || false;
	var id_order = false,
		send_obj = type == 'aprove' ? {'task':'set_this_order_approve'} : {'task':'get_data_for_reject_dialog'};

	if (query === false) {
		var grid = Ext.getCmp('orders-list');
		var record = grid.getSelectionModel().getSelected();
		id_order = record.get('id');
		send_obj['id'] = id_order;
	} else {
		send_obj['user_hash'] = query['user_hash'];
		send_obj['manager_hash'] = query['manager_hash'];
		send_obj['order_hash'] = query['order_hash'];
	}

	Ext.Ajax.request({ 		
		url:'orders/controller.php', 
		params:send_obj, 					 
		method:'POST',										 
		callback: function (options, success, response) {			 				 	
			var json = Ext.util.JSON.decode(response.responseText);		
			console.log (json);
			DRJ_infoOrderPanel.body.update("<b>Данные заявки:</b>" +json.text_order);
			DRJ_emailField.setValue(json.user_email);
			manager_DRJ_emailField.setValue(json.manager_email);
			DRJ_orderIdField.setValue(json.id);
		 }, 
		 failure:function(response,options){
			showErrorMessage('Нет соединения с сервером');
		}	
	});	
}

