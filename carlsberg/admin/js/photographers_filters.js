var UINField = new Ext.form.TextField({
	id:'UIN_photographer',
	width:120,
	fieldLabel:'UIN',
	listeners: {
		specialkey: function(field, el){
        	if (el.getKey() == Ext.EventObject.ENTER)
            	Ext.getCmp('search-button').fireEvent('click')
             }
		}	
})

var loginField = new Ext.form.TextField({
	id:'login_photographer',
	fieldLabel:'Логин',
	width: 120,	
	listeners: {
		 specialkey: function(field, el){
         	if (el.getKey() == Ext.EventObject.ENTER)
            	Ext.getCmp('search-button').fireEvent('click')
         }
	}		
});
	
var emailField = new Ext.form.TextField({	
	id:'email_photographer',
	fieldLabel:'E-mail',	
	width: 120,
	listeners: {
		specialkey: function(field, el){
        	if (el.getKey() == Ext.EventObject.ENTER)
            	Ext.getCmp('search-button').fireEvent('click')
         }
	}		
});


var cityField = new Ext.form.TextField({
	id:'city_photographer',
	width:120,
	fieldLabel:'Город',
	listeners: {
		specialkey: function(field, el){
        	if (el.getKey() == Ext.EventObject.ENTER)
            	Ext.getCmp('search-button').fireEvent('click')
             }
		}	
});

var searchPanel = new Ext.form.FormPanel({
	layout:'column',
	border:false,	
	width:1024,
	autoheight:true,	
		
	bodyStyle:'padding-top:5px;padding-left:5px;padding-right:5px;background-color: RGB(195,212,250);', 
	buttonAlign:'left',
	buttons:[{
		id:'search-button',
		text:'Найти',
		listeners: {
			 click: function(){
				showFilterOrders(); 
			 }				 
		}		
	}, {
		id:'show-all-button',
		text:'Показать все',
		listeners: {
			 click: function(){
				showAllOrders();
			 }				 
		}		
		
	}],		
	items:[{
		border:false,
		labelWidth: 80,					
		bodyStyle:'padding:0 0 0 5px;background-color: RGB(195,212,250);',
		columnWidth:.2,
		layout:'form',			
		items: [UINField]				
	}, {
		border:false,
		labelWidth: 40,					
		bodyStyle:'padding:0 0 0 5px;background-color: RGB(195,212,250);',
		columnWidth:.2,
		layout:'form',			
		items: [loginField]				
	} ,{
		border:false,
		labelWidth: 40,
		bodyStyle:'padding:0 0 0 5px;background-color: RGB(195,212,250);',
		columnWidth:.2,
		layout:'form',				
		items: [emailField]	
	}, {
		labelWidth: 70,
		border:false,			
		bodyStyle:'background-color: RGB(195,212,250);',
		columnWidth:.2,
		layout:'form',			
		items: [cityField]
	}]
}) 

function showFilterOrders() {
	var grid = Ext.getCmp('photographers-list');
	store = grid.getStore();
	store.load({params: {					
						start: 0,
						limit:40,
						sort: 'name',
						dir: 'ASC'
			}});		
}

function showPage() {
	Ext.Ajax.request({
		url:'clients/controller.php', 
		params:{'task':'getFilterData'}, 					 
		method:'POST',										 
		callback: function (options, success, response) {			 				 																			
			var json = Ext.util.JSON.decode(response.responseText);						
			var filter = json.filter;
			if(filter.client_card) {
				Ext.getCmp('client_card').setValue(filter.client_card);
			}
			if(filter.client_name) {
				Ext.getCmp('client_name').setValue(filter.client_name);
			}
			if(filter.client_email) {
				Ext.getCmp('client_email').setValue(filter.client_email);
			}
			if(filter.client_mobile) {
				Ext.getCmp('client_mobile').setValue(filter.client_mobile);
			}
			if(filter.client_phone) {
				Ext.getCmp('client_phone').setValue(filter.client_phone);
			}
			
			if(filter.client_sort) {
				sort = filter.client_sort;
			}
			if(filter.client_dir) {
				dir = filter.client_dir;
			}
			showFilterOrders();			
		} 
	})
		
}

function showAllOrders() {
	Ext.getCmp('UIN_photographer').setValue('');
	Ext.getCmp('login_photographer').setValue('');
	Ext.getCmp('email_photographer').setValue('');
	Ext.getCmp('city_photographer').setValue('');
	showFilterOrders();				
}

