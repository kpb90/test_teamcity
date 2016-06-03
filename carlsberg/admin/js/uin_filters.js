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
				showFilterUIN(); 
			 }				 
		}		
	}, {
		id:'show-all-button',
		text:'Показать все',
		listeners: {
			 click: function(){
				showAllItems();
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
	}]
}) ;
