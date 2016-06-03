var nameField = new Ext.form.TextField({
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
				showFilterUsers(); 
			 }				 
		}		
	}, {
		id:'show-all-button',
		text:'Показать все',
		listeners: {
			 click: function(){
				showAllUsers();
			 }				 
		}		
		
	}],		
	items:[{
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
	}]
}) 


function showAllUsers() {
	Ext.getCmp('filter-name').setValue('');
	Ext.getCmp('filter-phone').setValue('');
	Ext.getCmp('filter-email').setValue('');
	showFilterUsers();				
}

function showFilterUsers() {
	var grid = Ext.getCmp('users-list');
	store = grid.getStore();

	store.load({params: {					
				start: 0,
				limit:10,
				sort: 'id',
				dir: 'DESC'
	}});		
}