Ext.onReady(function() {
	
	Ext.BLANK_IMAGE_URL = 'ext/resources/images/default/s.gif';

	var loginField = new Ext.form.TextField({
		id:'user-start-login',
		fieldLabel: 'Логин',
		width:115,
		listeners: {
		 	specialkey: function(field, el){
                    if (el.getKey() == Ext.EventObject.ENTER)
                        Ext.getCmp('login-button').fireEvent('click')
             }
		}	
	});
	
	var pwdField = new Ext.form.TextField({
		id:'user-start-pwd',
		inputType:'password',
		fieldLabel: 'Пароль',		
		width:115,
		listeners: {
		 	specialkey: function(field, el){
                    if (el.getKey() == Ext.EventObject.ENTER)
                        Ext.getCmp('login-button').fireEvent('click')
             }
		}				
	});
	
	
	var loginForm = new Ext.form.FormPanel({						
		border:false,
		labelWidth: 55,
		buttonAlign:'center',
		layout:'form',			
		bodyStyle:'padding:10px 20px;background-color: RGB(195,212,250);',
		items:[{
  					xtype: 'box',
  					cls: 'label-style',
  					autoEl: {cn: 'Авторизация'}
				},
		 loginField, pwdField],
		 buttons:[{
			id:'login-button',			
			text:'OK',			
			listeners: {
				 click: function(){
				 	processLogin();
				 }
			}					
		 }]       	
	});
	
	var mainForm = new Ext.Panel({
		width: 220,
		height: 130,
		layout:'fit',
		renderTo:'login-form',
		bodyStyle:'background-color: RGB(195,212,250);', 
		items:loginForm 
	})
	
	function processLogin() {
		var login = loginField.getValue();
		var pwd = pwdField.getValue();
		var task = 'login';
		Ext.Ajax.request({ 		
			url:'users/controller.php', 
			params:{'task':'login',
					'login':login,
					'pwd':pwd					
					}, 					 
			 method:'POST',										 
			 callback: function (options, success, response) {			 				 																			
				var json = Ext.util.JSON.decode(response.responseText);				
				if(json.result == '1') {								
					var query_search = document.location.search.split("&amp;").join("&");
					var query = getQueryParams(query_search);
					if (query['user_hash']&&query['manager_hash']&&query['order_hash']) {
						document.location = 'orders.php?user_hash='+query['user_hash']+'&manager_hash='+query['manager_hash']+'&order_hash='+query['order_hash'] + (query['approve'] ? '&approve='+query['approve']:'');
					} else {
						document.location = 'orders.php';
					}
					
				
				} else {
					Ext.MessageBox.show({
						title:'Ошибка',
						msg:'Неправильный логин или пароль',
						buttons:Ext.MessageBox.OK,					           					           
						icon:Ext.MessageBox.ERROR
					});																									
							
				}
			 }, 
			 failure:function(response,options){
				 showErrorMessage('Невозможно подключиться к серверу');
			}	
		});		
	}

});  

