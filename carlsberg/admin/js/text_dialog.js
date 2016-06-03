var text_controller = '';
var text_task = '';

var textDialog = new Ext.Window({			   
		layout: 'fit',	
		autoHeight:true,
		width: 620,
		constrain: true,
		modal:true,
		plain:true,
		resizable: true,
		bodyStyle:'background-color:white;',
		buttonAlign:'center',		
		items: [{			
			id: 'shops_text_editor',
  			height: 530,
  			width: 600,			
			xtype:'ckeditor',					
			CKConfig: { 							
				toolbar:[ 
					['Source','-','Templates'],
					['Cut','Copy','Paste','PasteText','PasteFromWord'],
					['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],							
					['NumberedList','BulletedList','-','Outdent','Indent', 'Link','Unlink','Anchor'],																
					['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar'],
					['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock', 'TextColor','BGColor', 'ShowBlocks'],								
					['Bold','Italic','Underline','Strike','-','Subscript','Superscript','Styles','Format','Font','FontSize']																								
				],
				enterMode: CKEDITOR.ENTER_BR,
				shiftEnterMode : CKEDITOR.ENTER_P  
			}			
		}, {
			id:'text-id',
			xtype:'hidden'
		}],
		closeAction:'hide',	
		buttons:[{
			text:'Сохранить',
			handler:saveText
			}, {
			text:'Отмена',			
			handler: function() {
				textDialog.hide();
			}
	}]
});

function saveText() {
	var id = Ext.getCmp('text-id').getValue();
	var text = Ext.getCmp('shops_text_editor').getValue();
	Ext.Ajax.request({ 		
		url:text_controller, 
		params:{'task':text_task, 'id':id, 'text':text}, 					 
		method:'POST',										 
		callback: function (options, success, response) {			 				 	
			if(response.responseText != '0') {	
				textDialog.hide();				
			} else {
				showErrorMessage("Ошибка сохранения");
			}
		 }, 
	 	failure:function(response,options){
			showErrorMessage('Ошибка связи с сервером');
		}	
	});	
	
}