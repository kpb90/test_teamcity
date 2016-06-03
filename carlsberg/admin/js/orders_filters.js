var numberField = new Ext.form.TextField({
	id:'filter-number',
	width:50,
	fieldLabel:'<nobr>№ заказа</nobr>',
	listeners: {
		specialkey: function(field, el){
        	if (el.getKey() == Ext.EventObject.ENTER)
            	Ext.getCmp('search-button').fireEvent('click')
             }
		}	
}),
nameField = new Ext.form.TextField({
	id:'filter-name',
	width:100,
	fieldLabel:'Имя',
	listeners: {
		specialkey: function(field, el){
        	if (el.getKey() == Ext.EventObject.ENTER)
            	Ext.getCmp('search-button').fireEvent('click')
             }
		}	
}),
phoneField = new Ext.form.TextField({
	id:'filter-phone',
	width:100,
	fieldLabel:'Телефон',
	listeners: {
		specialkey: function(field, el){
        	if (el.getKey() == Ext.EventObject.ENTER)
            	Ext.getCmp('search-button').fireEvent('click')
             }
		}	
}),
emailField = new Ext.form.TextField({
	id:'filter-email',
	width:100,
	fieldLabel:'email',
	listeners: {
		specialkey: function(field, el){
        	if (el.getKey() == Ext.EventObject.ENTER)
            	Ext.getCmp('search-button').fireEvent('click')
             }
		}	
});


var startFilterDate = new Ext.form.DateField({	
	id:'filter-start',
	fieldLabel:'С',
	width: 85,	
	listeners: {
		 specialkey: function(field, el){
         	if (el.getKey() == Ext.EventObject.ENTER)
            	Ext.getCmp('search-button').fireEvent('click')
         }
	}		
});
	
var endFilterDate = new Ext.form.DateField({	
	id:'filter-end',
	fieldLabel:'По',	
	width: 85,
	listeners: {
		specialkey: function(field, el){
        	if (el.getKey() == Ext.EventObject.ENTER)
            	Ext.getCmp('search-button').fireEvent('click')
         }
	}		
});


var clientField = new Ext.form.TextField({
	id:'filter-client',
	width:150,
	fieldLabel:'Клиент',
	listeners: {
		specialkey: function(field, el){
        	if (el.getKey() == Ext.EventObject.ENTER)
            	Ext.getCmp('search-button').fireEvent('click')
             }
		}	
})


var statusStore = new Ext.data.SimpleStore({
	id:0,
	fields: ['id', 'name']
});	


var filterStatusBox = new Ext.form.ComboBox({	
	id:'filter-status',
	store: statusStore,
	fieldLabel: 'Статус',
	valueField: 'id',
	displayField: 'name',	
	triggerAction: 'all',
	mode: 'local',
	width:150,		
	listeners: {
		specialkey: function(field, el){
        	if (el.getKey() == Ext.EventObject.ENTER)
            	Ext.getCmp('search-button').fireEvent('click')
             }
		}					
});

var addressField = new Ext.form.TextField({
	id:'filter-address',
	width:250,
	fieldLabel:'Адрес',
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
		labelWidth: 60,					
		bodyStyle:'background-color: RGB(195,212,250);',
		columnWidth:.15,
		layout:'form',			
		items: [numberField]				
	},{
		border:false,
		labelWidth: 30,					
		bodyStyle:'background-color: RGB(195,212,250);',
		columnWidth:.17,
		layout:'form',			
		items: [nameField]				
	},{
		border:false,
		labelWidth: 60,					
		bodyStyle:'background-color: RGB(195,212,250);',
		columnWidth:.17,
		layout:'form',			
		items: [phoneField]				
	},{
		border:false,
		labelWidth: 40,					
		bodyStyle:'background-color: RGB(195,212,250);',
		columnWidth:.17,
		layout:'form',			
		items: [emailField]				
	},{
		border:false,
		labelWidth: 30,					
		bodyStyle:'background-color: RGB(195,212,250);',
		columnWidth:.17,
		layout:'form',			
		items: [startFilterDate]				
	} ,{
		border:false,
		labelWidth: 30,
		bodyStyle:'background-color: RGB(195,212,250);',
		columnWidth:.17,
		layout:'form',				
		items: [endFilterDate]	
	}/* {
		labelWidth: 70,
		border:false,			
		bodyStyle:'background-color: RGB(195,212,250);',
		columnWidth:.25,
		layout:'form',			
		items: [filterStatusBox]
	},*/]
}) 

function showPage() {
	Ext.Ajax.request({
		url:'orders/controller.php', 
		params:{'task':'loadOrders'}, 					 
		method:'POST',										 
		callback: function (options, success, response) {			 				 																			
			var json = Ext.util.JSON.decode(response.responseText);						
			var filter = json.filter;
			if(filter.number) {
				Ext.getCmp('filter-number').setValue(filter.number);
			}
			if(filter.status) {
				Ext.getCmp('filter-status').setValue(filter.status);
			}
			if(filter.address) {
				Ext.getCmp('filter-address').setValue(filter.address);
			}
			if(filter.client) {
				Ext.getCmp('filter-client').setValue(filter.client);
			}
			if(filter.start) {
				var date = Date.parseDate(filter.start, "Y-m-d H:i:s");
				Ext.getCmp('filter-start').setValue(date);	
			}
			if(filter.end) {
				var date = Date.parseDate(filter.end, "Y-m-d H:i:s");
				Ext.getCmp('filter-end').setValue(date);					
			}
			if(filter.sort) {
				sort = filter.sort;
			}
			if(filter.dir) {
				dir = filter.dir;
			}
			showFilterOrders();			
		} 
	})
		
}

function showAllOrders() {
	Ext.getCmp('filter-number').setValue('');
	Ext.getCmp('filter-name').setValue('');
	Ext.getCmp('filter-phone').setValue('');
	Ext.getCmp('filter-email').setValue('');

	Ext.getCmp('filter-start').setValue('');
	Ext.getCmp('filter-end').setValue('');
	showFilterOrders();				
}

function showFilterOrders() {
	var grid = Ext.getCmp('orders-list');
	store = grid.getStore();

	store.load({params: {					
				start: 0,
				limit:100,
				sort: 'id',
				dir: 'DESC'
	}});		
}
