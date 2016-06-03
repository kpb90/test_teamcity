var activeImage = 0;


var idField = new Ext.form.Hidden({
	id:'id-filed' 
});

var itemNameStore =  new Ext.data.Store({
	proxy: new Ext.data.HttpProxy({
		url: 'controller.php',
		method: 'POST'
	}), 			
	reader: new Ext.data.JsonReader({
				id: 'id'
			}, NameRecord),
	baseParams:{task: "getNames"},
	sortInfo:{field: 'name'}   		
});

var artStore = new Ext.data.Store({
	proxy: new Ext.data.HttpProxy({
		url: 'controller.php',
		method: 'POST'
	}), 			
	reader: new Ext.data.JsonReader({
				id: 'id'
			}, NameRecord),
	baseParams:{task: "getArticles"},
	sortInfo:{field: 'name'}   		
});


var itemNameField = new Ext.form.ComboBox({
	id:'name-text',
	editable:false,
	store: itemNameStore,
	fieldLabel: 'Название',
	valueField: 'id',
	displayField: 'name',	
	triggerAction: 'all',
	mode: 'local',
	width:250
});  

var artName =  new Ext.form.ComboBox({
	fieldLabel: 'Артикул',
	width: 83,
	editable:false,
	store: artStore,
	valueField: 'name',
	displayField: 'name',
	triggerAction: 'all',
	mode: 'local'	
});

var artNumber = new Ext.form.TextField({
	fieldLabel: '-',
	width: 83,
    maxLength: 15, // for validation
    labelSeparator: '',   
    autoCreate: {tag: 'input', type: 'text',  autocomplete: 'off', maxlength: '15'}				
});

var artPanel =  new Ext.Panel({		
	baseCls: 'x-plain',
	layout:'column',
	border:false,
	
	items:[{
		xtype:'form',
		labelWidth: 70,
		border:false,
		layout:'form',
		columnWidth:'.6',
		items:artName
	}, {
		xtype:'form',
		labelWidth: 35,
		border:false,
		layout:'form',
		columnWidth:'.4',
		items:artNumber		
	}]    	    	          	                 	        		
});
 

var descText = new Ext.form.TextArea({
	id:'comment-text',
	fieldLabel: 'Описание',
	width: 588,
	height:100 		
});

var genderBox = new Ext.form.ComboBox({
	id:'gender-box',
	editable:false,
	store: genderStore,
	fieldLabel: 'Муж/Женск',
	valueField: 'id',
	displayField: 'name',	
	triggerAction: 'all',
	mode: 'local',
	width:250
});

var modelBox = new Ext.ux.form.CheckboxCombo({                                       
	store:modelStore,
	valueField: 'id_rec',
	displayField: 'prod_item_id',
	allowBlank: true,
	fieldLabel: 'Модели',
	width: 250					                  
});

var profBox = new Ext.ux.form.CheckboxCombo({                                       
	store:profStore,
	valueField: 'id_rec',
	displayField: 'prod_item_id',
	fieldLabel: 'Должности',
	allowBlank: true,
	width: 250						                  
});

var propBox = new Ext.ux.form.CheckboxCombo({                                       
	store:propStore,
	valueField: 'id_rec',
	displayField: 'prod_item_id',
	allowBlank: true,
	fieldLabel: 'Свойства',
	width: 250					                  						                  
 });

 
var solutionsBox = new Ext.ux.form.CheckboxCombo({                                       
	store:solutionStore,
	valueField: 'id_rec',
	displayField: 'prod_item_id',
	allowBlank: true,
	fieldLabel: 'Решения',
	width: 250					                  						                  						                  
}); 

var collectionsBox = new Ext.ux.form.CheckboxCombo({                                       
	store:collectionStore,
	valueField: 'id_rec',
	displayField: 'prod_item_id',
	allowBlank: true,
	fieldLabel: 'Коллекции',
	width: 250					                  						                  						                  						                  
});

var rentBox = new Ext.form.ComboBox({
	id:'rent-box',
	editable:false,
	store: rentStore,
	fieldLabel: 'Аренда',
	valueField: 'id',
	displayField: 'name',	
	triggerAction: 'all',
	mode: 'local',
	width:250
});

var priceField = new Ext.form.NumberField({
	fieldLabel: 'Цена',
	allowNegative: false,
	allowDecimals : false
	
})

//var setBox = new Ext.ux.form.CheckboxCombo({                                       
//	store:prodStore,
//	valueField: 'id_rec',
//	displayField: 'name',
//	allowBlank: true,
//	fieldLabel: 'Комплект',
//	width: 588				                  						                  						                  						                  
//});



var PhotoRecord = new Ext.data.Record.create([
	{name: 'id'},
	{name: 'url'}		
]);

var photoStore = new Ext.data.JsonStore({
	url:'controller.php',
	method: 'POST',
	id: "id",  
	fields: ['id', 'url', 'big_url']
});



var photoTpl = new Ext.XTemplate(
	'<tpl for=".">',
		'<div class="thumb-wrap" id="{id}">',
			'<a href="javascript:;" onclick="showImage(' +  "'{big_url}'" + ');"><img src="{url}" width=55></a>',
		'</div>',
	'</tpl>'
);
photoTpl.compile();

var photoView = new Ext.DataView({
	store: photoStore,
    tpl: photoTpl,
    autoHeight:true,
	width: 500,
    multiSelect: true,   
    overClass:'x-view-over',   
    itemSelector:'div.thumb-wrap',
    emptyText: ''            
});



var photoPanel = new Ext.Panel({
	id:'images-view',
	fieldLabel:'Изображения', 
	bodyStyle:'background-color:white;',   
    width:510,
	height: 200,               
   	layout:'form',
	autoScroll: true,    
    items: [
    	 photoView
    ]
});
photoView.on('selectionchange', function(view, selections) {
	if(selections.length > 0) {
		Ext.getCmp('move-left-button').enable();
		Ext.getCmp('move-right-button').enable();
		Ext.getCmp('delete-image-button').enable();
	} else {
		Ext.getCmp('move-left-button').disable();
		Ext.getCmp('move-right-button').disable();		
		Ext.getCmp('delete-image-button').disable();
	}
});
	
 var deleteButton = new Ext.Button({
 	id: 'delete-image-button',
 	iconCls: 'delete-icon',
 	text: '',
 	tooltip:'Удалить картинку',
 	handler: deleteImage,
 	disabled:true
 });
 
 var firstButton = new Ext.Button({
 	id:'move-first-button',
 	iconCls: 'first-icon',
 	text: '',
 	tooltip:'Заглавная картинка',
 	handler: moveImageFirst,
 	disabled:true 	
 });
 
var leftButton = new Ext.Button({
 	id:'move-left-button',
	icon: 'images/left.png',
	cls:"x-btn-text-icon", 
 	text: '',
 	tooltip:'Переместить вперед',
 	handler: moveImageLeft,
 	disabled:true 	
 });
 
var rightButton = new Ext.Button({
 	id:'move-right-button',
	icon: 'images/right.png',
	cls:"x-btn-text-icon", 
 	text: '',
 	tooltip:'Переместить назад',
 	handler: moveImageRight,
 	disabled:true 	
 });
 

var uploadField = new Ext.ux.form.FileUploadField({
	id: 'fileName',
    emptyText: 'Выберете фото для загрузки',
    fieldLabel: 'Фото',
    name: 'uploadfile',            
    width:405,
    buttonCfg: {
    	text: '',    	
        iconCls: 'upload-icon'
     }, 
     listeners: {
     	fileselected: function(field, el){
		 	addImage();
        }
      }         	
});

 var fileForm =  new Ext.form.FormPanel({
	id:'fileSubmitForm',		
	baseCls: 'x-plain',
	layout:'column',
	frame: true,
	width:590,
	fileUpload: true,  
	items:[{
		border:false,
		layout:'form',
		columnWidth:'.874',
		items:uploadField
	}, {
		border:false,
		layout:'form',
		columnWidth:'.042',
		items:[deleteButton]		
	}, {
		border:false,
		layout:'form',
		columnWidth:'.043',
		items:[ leftButton]		
		
	}, {
		border:false,
		layout:'form',
		columnWidth:'.043',
		items:[ rightButton]				
	}]    	    	          	                 	        		
 	    	          	                 	        		
});
 

var propPanel = new Ext.Panel({
	autoHeight: true,		
	layout:'column',
	border:false,
	bodyStyle:'background-color:white;',
	items:[{
		border:false,
//		bodyStyle:'padding:0 0 0 5px;background-color: white;',
		layout:'form',
		labelWidth:70,
		columnWidth:'.5',
		items:[itemNameField, artPanel, genderBox, modelBox, rentBox]
	}, {
		border:false,
//		bodyStyle:'padding-left:7px;background-color: white;',
		labelWidth:70,
		layout:'form',
		columnWidth:'.5',
		items:[profBox, propBox, solutionsBox, collectionsBox, priceField, idField]		
	}]	
});


var filePanel = new Ext.form.FieldSet({
	autoHeight: true,
	width:662,
	border:true,
	bodyStyle:'padding:5px;',	
	title:'Фотографии',
	layout:'form',			
	items:[fileForm, photoPanel]	 
});

var mainPanel = new Ext.Panel({
	border: false,
	bodyStyle:'padding:5px;',
	autoHeight: true,
	labelWidth:70,
	layout:'form',
	items:[propPanel, descText, filePanel]
})

var productDialog = new Ext.Window({			   
	title:'Новый подукт',
	width: 700,
	height:590,
	layout: 'fit',
	constrain: true,
	modal:true,
	plain:true,
	bodyStyle:'background-color:white;',
	buttonAlign:'center',
	items: mainPanel,
	closeAction:'hide',
	resizable: false,
	buttons:[{
		text:'Сохранить',
		handler:saveProduct
		}, {
		text:'Отмена',			
		handler: function() {
			productDialog.hide();
		}
	}]		 	
});

function saveProduct() {
	var id = idField.getValue();
	var name = itemNameField.getValue();
	var desc = descText.getValue();
	var gender = genderBox.getValue();
	var rent = rentBox.getValue();
	var models = modelBox.getValue();
	var profs = profBox.getValue();
	var props = propBox.getValue();
	var sols = solutionsBox.getValue();
	var collections = collectionsBox.getValue();
	var artNameValue = artName.getValue();
	var artNumberValue = artNumber.getValue();
	var price = priceField.getValue();
	var art = artNameValue + '-' + artNumberValue;
	var allProps = '';
	allProps = concatProps(models, allProps);
	allProps = concatProps(profs, allProps);
	allProps = concatProps(props, allProps);
	allProps = concatProps(sols, allProps);
	allProps = concatProps(collections, allProps);
	var images = '';
	var photos = photoStore.getRange();
	var client_id = '';

	for(i = 0; i < photos.length; i++) {
		var photo = photos[i];
		if(i == 0) {			
			activeImage = photo.get('id');		
		}		 
		if(images) {
			images = images + ',' + photo.get('id'); 
		} else {
			images = photo.get('id'); 
		}
	}
	var message = '';
	message = addFieldToMessage(message, name, 'Имя');
	message = addFieldToMessage(message, artNameValue, 'Артикул (текст)');
	message = addFieldToMessage(message, artNumberValue, 'Артикул (номер)');
	
	if(message) {		
		message = 'Не выбраны поля: ' + message;
		showErrorMessage(message);
		return;
	}
	
//	var set = setBox.getValue();
	Ext.Ajax.request({ 		
			url:'controller.php', 
			params:{'task':'saveProduct',
					'id':id,
					'name':name,
					'desc':desc,
					'gender':gender,
					'props':allProps,
					'art':art, 
					'images':images,
					'main_image':activeImage,
					'rent':rent,
					'price':price 
					}, 
			method:'POST',
			callback: function (options, success, response) {			 				 	
				var json = Ext.util.JSON.decode(response.responseText);							
				if(json.result == 'success') {																
					var recId = json.id;
					try {
					if(!id) {
						var order = json.order;
						var prodRecord = new ProductRecord({
							id_rec: recId,
							ord:order,
							name: nameStore.getById(name).get('name') + ' ' + art,
							art:art,
							image: json.image,
							pg_gender: gender,
							models: models,
							profs: profs,
							props: props,
							solutions: sols,
							collections: collections,
							description: desc,
							arenda: rent,
							price: price,
							client_id: client_id
						});
						productStore.addSorted(prodRecord, recId);
						
					} else {						
						var prodRecord =  getById(productStore,id);
						var nameRecord = getNameById(name)
						prodRecord.set('name', nameRecord.get('name') + ' ' + art);
						prodRecord.set('art', art);
						prodRecord.set('image', json.image);
						prodRecord.set('pg_gender', gender);
						prodRecord.set('models', models);
						prodRecord.set('profs', profs);
						prodRecord.set('props', props);
						prodRecord.set('solutions', sols);
						prodRecord.set('collections', collections);
						prodRecord.set('description', desc);
						prodRecord.set('arenda', rent);
						prodRecord.set('price', price);
						prodRecord.set('client_id', client_id);
						productStore.commitChanges();
					}
				      } catch(err) {
				   		alert(err);
				        }

					productDialog.hide();
				}
			 }
		});	
}

function addImage() {
	Ext.Ajax.request({ 		
		url:'controller.php', 
		params:{'task':'uploadImage',
				'productId':idField.getValue(),
				'timeout': 50000  
				}, 
		method:'POST',
		form:fileForm.getForm().getEl().dom,		
		waitMsg:'Сохранение...',
		headers: {'Content-type':'multipart/form-data'},
		callback: function (options, success, response) {			 				 	
			var json = Ext.util.JSON.decode(response.responseText);				
			if(json.result == 'success') {																
				var url = json.path;
				var id = json.id;
				var big_url = json.big_path;								
				
				var photoRecord = new PhotoRecord({
					id: id,
					url: encodeUrl(url),
					big_url:encodeUrl(big_url) 
				});
				photoStore.addSorted(photoRecord);
				Ext.getCmp('fileName').setValue('');
			} else {
				showErrorMessage('Не получилось загрузить картинку. Размер не должен быть > 2Мb');
			}
		 }
	});
	
}

function deleteImage() {
	var selected = photoView.getSelectedRecords();
	if(selected.length > 0 ) {
		var record = selected[0];
		var imageId = record.get('id');
		if(!(typeof(imageId)=='number')) {
			Ext.Ajax.request({ 		
				url:'controller.php', 
				params:{'task':'deleteImage',
						'id':imageId					
						}, 
				method:'POST'
			});			
		}
		photoStore.remove(record);
	}
}

function moveImageFirst() {
	var records = photoView.getSelectedRecords();
	if(records.length > 0) {
		var record = records[0];
		activeImage = record.get('id');		
		photoStore.remove(record);
		photoStore.insert(0, record);		
	}
}

function moveImageLeft() {
	var records = photoView.getSelectedRecords();
	if(records.length > 0) {
		var record = records[0];
		var index = photoStore.indexOf(record);
		if(index > 0) {
			photoStore.remove(record);
			photoStore.insert(index-1, record);
			photoView.select(record);
		}		
	}
	
}

function moveImageRight() {
	var records = photoView.getSelectedRecords();
	if(records.length > 0) {
		var record = records[0];
		var index = photoStore.indexOf(record);		
		if(index < (photoStore.getCount()-1)) {
			photoStore.remove(record);
			photoStore.insert(index+1, record);
			photoView.select(record);
		}
		
	}
}


function encodeUrl(url) {	
	if(url) {
		url = url.replace("\\", "/");
		url = url.replace(" ", "%20");			
	} 
	return url;
}

function concatProps(prop, allProps) {
	if(prop) {
		if(allProps) {
			allProps = allProps + ',';			
		}
		allProps = allProps + prop;
		return allProps;
	} else {
		return allProps;
	}
}



function showImage(url) {
    

	var add_cuenta_wnd = new Ext.Window({
		layout: 'fit',
		bodyStyle:'background-color:white;',
		width: 420,
		height: 520,
		closeAction: 'hide',
		title: 'Фото',
		expandOnShow: false,
		modal: true,
		plain: true,
		constrain: true,
		buttonAlign:'center',
		renderTo: document.body,
		bodyCfg: {      
        	tag:  'div',
        	html: '<img src=' + url + ' style=\'max-width:400px; max-height: 600px;\'>'
    	},		
		buttons:[ {
			text:'Закрыть',			
			handler: function() {
				add_cuenta_wnd.hide();
			}
		}]	
	});

	add_cuenta_wnd.show();
   }