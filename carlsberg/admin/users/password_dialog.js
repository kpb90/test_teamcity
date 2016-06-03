var pwdUserIdField = new Ext.form.Hidden({
	id:'pwd-user-id'
});

var editPwdField = new Ext.form.TextField({
	id:'user-edit-pwd',		
	inputType:'password',
	fieldLabel: 'Пароль',		
	maxLength:30,
	width:200	
});
	
var editConfPwdField = new Ext.form.TextField({
	id:'user-edit-conf-pwd',
	inputType:'password',
	fieldLabel: 'Подтверждение',
	maxLength:30,			
	width:200		
});

var pwdUserPanel = new Ext.Panel({	
	layout:'form',
	border:false,	
	bodyStyle:'padding:10px;background-color:white',
	labelWidth: 110,	
	items:[editPwdField,  editConfPwdField, pwdUserIdField]       
});

var pwdUserDialog = new Ext.Window({
	width: 350,
	height:135,
	title:'Установка пароля',
	layout: 'fit',
	constrain: true,
	modal:true,
	bodyStyle:'background-color:white;',
	buttonAlign:'center',
	items: pwdUserPanel,
	closeAction:'hide',
	resizable: false,
	buttons:[{
		text:'Сохранить',
		handler:editUserPassword
	}, {
		text:'Отмена',			
		handler: function() {
			pwdUserDialog.hide();
		}
	}]		 		
});	

function editUserPassword() {
	var id = pwdUserIdField.getValue();
	var pwd = editPwdField.getValue();
	var confPwd = editConfPwdField.getValue();
	
	var message = '';
	message = addFieldToMessage(message, pwd, 'Пароль');
	message = addFieldToMessage(message, confPwd, 'Подтверждение');
	
	if(message) {
		message = 'Не введены поля: ' + message;
		showErrorMessage(message);
		return;
	}
	if(pwd != confPwd) {
		message =  'Поля Пароль и Подтверждение не совпадают';
		showErrorMessage(message);
		return;
	}
	Ext.Ajax.request({ 		
		url:'users/controller.php', 
		params:{'task':'changePassword',
				'id':id,
				'pwd':pwd
				}, 					 
		method:'POST',										 
		callback: function (options, success, response) {			 				 	
			var json = Ext.util.JSON.decode(response.responseText);																
			if(json.result == 'success') {
				pwdUserDialog.hide();				
			} else {	
				var errorCode = json.code;
				var message = getErrorMessage(errorCode);
				if(message) {
					showErrorMessage(message);					
				}				
			}			
		 }, 
		 failure:function(response,options){
			showErrorMessage('Нет соединения с сервером');
		}	
	});										
}

function showPasswordDialog() {
	var grid = Ext.getCmp('users-list');
	var record = grid.getSelectionModel().getSelected();
	if(record) {				
		var id = record.get('id');
		pwdUserIdField.setValue(id);
		editPwdField.setValue('');
		editConfPwdField.setValue('');
		pwdUserDialog.show();	
	}
}

