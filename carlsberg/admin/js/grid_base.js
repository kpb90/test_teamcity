function Grid_Base(meta) {
	
	this.meta = meta;
	var page_size = 10;
	if(meta.page_size) {
		page_size = meta.page_size; 
	}
			
	this.record = Ext.data.Record.create(this.meta.fields);
	this.store = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: meta.control,
			method: 'POST'
		}), 			
		reader: new Ext.data.JsonReader({
					id: 'id',
					totalProperty: "total", 
					root: "results" 
				}, this.record),
		baseParams:{task: 'get'+meta.task},
		remoteSort:true	
	});
	
	var stores = new Object();
	
	if (meta.hasOwnProperty('stores')) {
		var meta_stores = this.meta.stores; 		
		for(i = 0; i < meta_stores.length; i++) {
			var meta_store_conf = meta_stores[i];
			var meta_store = new Ext.data.ArrayStore(meta_store_conf);
			stores[meta_store_conf.storeId] = meta_store;
		}
	}

	var checks = new Ext.grid.CheckboxSelectionModel();
	
	var table_columns = new Array();
	table_columns[0] = checks;
	var index = 1;
	var fields = this.meta.fields;
	for(i = 0; i < fields.length; i++) {
		var field = fields[i];	
			var column = null;
			if(field.type == 'bool') {
				column = {hidden: !field.visible, header: field.header, width: field.width, sortable: true, dataIndex: field.name, renderer: renderBool};
			}
			else if(field.type == 'bool_reverse') {
				column = {hidden: !field.visible, header: field.header, width: field.width, sortable: true, dataIndex: field.name, renderer: renderBool_reverse};
			}
			else if(field.type == 'checkbox') {
				column = {hidden: !field.visible, header: field.header, width: field.width, sortable: true, dataIndex: field.name, renderer: renderCheckBox};
			}
			else if(field.type == 'viewed') {
				column = {hidden: !field.visible, header: field.header, width: field.width, sortable: true, dataIndex: field.name, renderer: renderViewed};
			}
			else if(field.type == 'edit_string') {
				column = {hidden: !field.visible, header: field.header, width: field.width, sortable: true, dataIndex: field.name, renderer: rendereEdit_string};
			}
			else if(field.type == 'data') {				
				column = {hidden: !field.visible, header: field.header, width: field.width, sortable: true, dataIndex: field.name, renderer: renderDateOnly}; 
			} else if(field.type == 'int' && field.sub_type == 'box') {
				column = {hidden: !field.visible, header: field.header, width: field.width, sortable: true, dataIndex: field.name, 
						 renderer: function(data, cell, record, rowIndex, columnIndex, store) {
							var storeName = meta.fields[columnIndex - 1].store; 
						 	var target_store = stores[storeName];
							 	if(target_store) {					 							 	
						 		return getNameValue(data, target_store);
						 	} else {
						 		return "";
						 	}
						 }};
			} else if(field.sub_type == 'image') {
				 column = {hidden: !field.visible, header: field.header, width: field.width, sortable: true, dataIndex: field.name, renderer: renderImage};
			} else {
				column = {hidden: !field.visible, header: field.header, width: field.width, sortable: true, dataIndex: field.name};
			}			
			table_columns[index] = column;			
			index++;
	}	
	
	this.pagingBar = new Ext.PagingToolbar({
		pageSize: page_size,
		store: this.store,
		displayInfo: true,
		displayMsg: meta.paging_info + ' {0} - {1} из {2}',
		emptyMsg: meta.paging_mult + " не найдены"	,
		plugins: new Ext.ux.grid.PageSizer({
	      	beforeText: 'Показывать',
	      	afterText: meta.paging_show + ' на страницу',
	      	sizes: [[10],[25],[50],[100],[200],[300],[500]],
	      	comboCfg: {width: 70}
	    }) 
	});	
	
	this.grid = new Ext.grid.GridPanel({		
		id:meta.module+'-list',	
		store: this.store,	
		stripeRows: true,	
		enableColumnHide: false,
		enableColumnMove: false,
		enableHdMenu: false, 
		trackMouseOver:false,
		sm:checks,					
		columns: table_columns,
		viewConfig: {
			forceFit: true,
	        getRowClass: function(record, index) {
	            var v = record.get('viewed');
	            if (v == 1) {
	                return 'green_light';
	            }
	            else {
	            	return 'no_green_light';
	            }
	        }
	    },
		bbar: this.pagingBar, 
		tbar: [{		
			text: 'Добавить',
			id:'create-btn',		
			icon: 'images/new.gif',
			cls:"x-btn-text-icon", 
	        handler: add                                       				
		},'-', {
			id:'edit-btn',
			text: 'Редактировать',
			icon: 'images/edit.gif',
			cls:"x-btn-text-icon", 
			handler: edit,
			disabled:true
		}, '-',{
			id:'remove-btn',
			text: 'Удалить',
			icon: 'images/delete.gif',
			cls:"x-btn-text-icon", 
			handler:remove,
			disabled:true
		}],							
									 	
		height: tableHeight,
		width: tableWidth - 25
	});
	
	if(meta.hasOwnProperty('actions')) {
		var toolbar = this.grid.getTopToolbar();
		var actions = meta.actions;
		for(i = 0; i < actions.length; i++) {
			var action = actions[i];
			toolbar.addSeparator();
			toolbar.add({
				id: action.id,
				text: action.text,
				icon: 'images/'+action.icon,
				cls:"x-btn-text-icon",
				handler: eval(action.handler) 
			})
		}
		
	}
	
	this.getRecord = function() {		
		return this.record;
	}
	
	this.getStore = function() {
		return this.store;	
	}
	
	this.getGrid = function() {
		return this.grid;
	}

	this.getDialog = function() {
		return dialog;
	}
	
	var boolStore = new Ext.data.SimpleStore({
		id:0,
		fields: ['id', 'name'],
		data: [							
			['0', 'Нет'],
			['1', 'Да']
		]
	});	

	var boolStore_reverse = new Ext.data.SimpleStore({
		id:0,
		fields: ['id', 'name'],
		data: [							
			['1', 'Нет'],
			['0', 'Да']
		]
	});	
	
	this.grid.getSelectionModel().on('rowselect', function(model, rowIndex, record) {	
		
		if(typeof Ext.getCmp('photos_main-list')!='undefined'||typeof Ext.getCmp('comments-list')!='undefined')
		{
			viewed(rowIndex);
		}
		
		if (Ext.getCmp('edit-btn'))
		{
			Ext.getCmp('edit-btn').enable();	
		}
		
		if (Ext.getCmp('remove-btn'))
		{
			Ext.getCmp('remove-btn').enable();
		}
	});

	this.grid.on('dblclick', function() {	
		edit();		
	});
	
	var controls = new Array();
	var fields = this.meta.fields;
	var width = meta.dialog_width - 150;
	var index = 0;		
	var fileUpload = false;
	
	
	var idField = new Ext.form.Hidden({
		id:'id',
		trequred: false
	});		
	
	
	for(i = 0; i < fields.length; i++) {
		var field = fields[i];
		if(field.not_editable) {
			continue;
		}
		var component;
		if(field.type == 'string') {			
			if(field.sub_type == 'image') {
				fileUpload = true;				
				if(!field.empty_text) {
					field.empty_text = 'Выберите изображение'; 
				}
				component = new Ext.ux.form.FileUploadField({
					id: field.name,
				    emptyText: field.empty_text,
				    fieldLabel: field.header,
				    name: field.upload_name,            
				    width:width,
				    ttype: 'image',
				    buttonCfg: {
				    	text: '',    	
				        iconCls: 'upload-icon'
				     }        	
				});																
			} else if(field.sub_type == 'file') {
				fileUpload = true;
				component = new Ext.ux.form.FileUploadField({
					id: field.name,
				    emptyText: 'Выберите файл',
				    fieldLabel: field.header,
				    name: field.upload_name,            
				    width:width,
				    ttype: 'image',
				    buttonCfg: {
				    	text: '',    	
				        iconCls: 'upload-icon'
				     }        	
				});																
				
				
			} else if (field.sub_type == 'pswd') {
				component = new Ext.form.TextField({								
					fieldLabel :field.header,
					id:field.name,
					width: width,
					ttype: field.type,
					trequred: field.required,
					inputType: 'password' 
				});
			
			} else {
				component = new Ext.form.TextField({								
					fieldLabel :field.header,
					id:field.name,
					width: width,
					ttype: field.type,
					trequred: field.required 
				})		
			}		
		} else if(field.type == 'bool') {
			component =  new Ext.form.ComboBox({		
				id:field.name,
				store: boolStore,
				mode: 'local',
				fieldLabel: field.header,
				valueField: 'id',
				displayField: 'name',	
				triggerAction: 'all',	
				width:100,
				ttype: field.type,
				trequred: field.required									
			});					
		} 
			else if(field.type == 'bool_reverse') {
			component =  new Ext.form.ComboBox({		
				id:field.name,
				store: boolStore_reverse,
				mode: 'local',
				fieldLabel: field.header,
				valueField: 'id',
				displayField: 'name',	
				triggerAction: 'all',	
				width:100,
				ttype: field.type,
				trequred: field.required 										
			});					
		} 

		else if(field.type == 'text') {
			component = new Ext.form.TextArea({
				id:field.name,
				fieldLabel :field.header,				
				width: width,
				height: field.height,
				ttype: field.type,
				trequred: field.required 	
			})								
		} else if(field.type == 'int') {
			if(!field.visible && !field.sub_type) {
				continue;
			} else if(field.sub_type == 'box') {
				var target_store = stores[field.store];	
				component =  new Ext.form.ComboBox({		
					id:field.name,
					store: target_store,
					mode: 'local',
					fieldLabel: field.header,
					valueField: 'id',
					displayField: 'name',	
					triggerAction: 'all',	
					width:width,
					ttype: field.type,
					trequred: field.required 										
				});		
			}
		} else if(field.type == 'digit') {
			component = new Ext.form.NumberField({								
					fieldLabel :field.header,
					id:field.name,
					decimalPrecision : 8,
					width: width,
					ttype: field.type,
					trequred: field.required 
				})		
		} else if(field.type == 'data') {
			component = new Ext.form.DateField({	
				id:field.name,
				fieldLabel: field.header,
				format:'d.m.Y',
				ttype: field.type,
				width:100,
				trequred: field.required 		
			});
		} else if(field.type == 'rich_text') {
			component = new Ext.form.CKEditor({
				id: field.name,
				fieldLabel: field.header,
				height: field.height,
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
			}); 
		}
		controls[index] = component;
		index++;
	}
	controls[index] = idField; 		
	var mainPanel = null;
	
	if(!fileUpload) {
		mainPanel = new Ext.Panel({
			layout:'form',			
			bodyStyle:'padding:5px;background-color:white',
			border:false,
			width:350,
			height:meta.dialog_height,
			items: controls	
		});
	} else {
		mainPanel = new Ext.form.FormPanel({						
			bodyStyle:'padding:5px;background-color:white',
			border:false,
			width:350,
			height:meta.dialog_height,
			fileUpload: true,
			items: controls
		});
	}
	buttons_dialog = !meta.dialog_action ?  [{
						text:'Сохранить',
						handler:save
						}, {
						text:'Отмена',			
						handler: function() {
							dialog.hide();
						}
					}] : [{
						text:'ок',			
						handler: function() {
							dialog.hide();
						}
					}]	;
					
	var dialog = new Ext.Window({			   
		layout: 'fit',	
		autoHeight:true,
		width:meta.dialog_width,
		constrain: true,
		modal:true,
		plain:true,
		resizable: true,
		bodyStyle:'background-color:white;',
		buttonAlign:'center',
		items: mainPanel,
		closeAction:'hide',	
		buttons: buttons_dialog
	});
	
	function add() {		
		dialog.setTitle('Создание ' + meta.dialog_title);
		for(i = 0; i < controls.length; i++) {			
			if(controls[i].ttype == 'bool') {
				controls[i].setValue(1);
			} else {								
				controls[i].setValue('');
			} 
		}		
		dialog.show();	
	}
	function viewed (rowIndex)
	{
		var grid = Ext.getCmp(meta.module+'-list');
		grid.getView().getRow(rowIndex).style.backgroundColor = 'green';
		grid.getView().getRow(rowIndex).style.color = 'white';

		var photos_main_list = grid.getSelectionModel().getSelections();

		var photos_main_data = [];
		var js_photos = '';
		for (var i  = 0; i < photos_main_list.length; i ++)
		{
			if (photos_main_list[i].get('viewed')==0)
			{
				photos_main_data.push(photos_main_list[i].data);
				photos_main_list[i].set('viewed','1');
				photos_main_list[i].commit();
			}
		}

		if (photos_main_data.length>0)
		{
			js_photos = Ext.encode(photos_main_data);
			Ext.Ajax.request({ 		
					url:meta.control,  
					params:{'task':'update_viewed_photos_for_main'+meta.module+'-list', 'photos': js_photos}, 					 
					method:'POST',										 
					callback: function (options, success, response) {			 				 								
						if(response.responseText != '0') {		
							console.log ('ok');
						} else {								
							var message = "Ошибка сохранения";
							if(message) {
								showErrorMessage(message);					
							}												
						}
					 }, 
				 	failure:function(response,options){
						showErrorMessage('Ошибка связи с сервером');
					}	
				});
		}
	}
	function edit() {
		var record = Ext.getCmp(meta.module+'-list').getSelectionModel().getSelected();
		if(record) {			
			var id = record.get('id');										
			Ext.Ajax.request({ 		
				url:meta.control, 
				params:{'task':'edit'+meta.task, 'id':id}, 					 
				method:'POST',										 
				callback: function (options, success, response) {			 				 	
					var json = Ext.util.JSON.decode(response.responseText);
					for (var prop in json) {
						if (json.hasOwnProperty(prop)) {
							var comp = Ext.getCmp(prop);
							if(comp) {								
								if(comp.ttype == 'image') {									
									comp.reset();
									comp.setValue('');
								} else if(comp.ttype == 'data') { 
									var value = json[prop];
									var date = Date.parseDate(value, 'Y-m-d H:i:s');															
									comp.setValue(date);
								} else {
									comp.setValue(json[prop]);
								}
							}
						}
					}
					dialog.setTitle('Редактирование ' + meta.dialog_title);	
					dialog.show();				
				 }, 
			 	failure:function(response,options){
					showErrorMessage('Ошибка связи с сервером');
				}	
			});		
		}				
		
	}
	
	function remove() {
		var records = Ext.getCmp(meta.module+'-list').getSelectionModel().getSelections();
		if(records) {
			Ext.Msg.confirm('Удаление ' + meta.dialog_title, 'Вы действительно хотите удалить выделенные ' + meta.dialog_title + '?', function(btn){
				if(btn == 'yes'){
					deleted = [];
					for(i = 0; i < records.length; i++) {
						deleted[i] = records[i].get('id');
					}
					var removing = deleted.join(',');
					Ext.Ajax.request({ 		
						url:meta.control,  
						params:{'task':'delete'+meta.task, 'ids':removing}, 					 
						method:'POST',										 
						callback: function (options, success, response) {			 				 								
							if(response.responseText != '0') {								
								Ext.getCmp(meta.module+'-list').getStore().reload();
							} else {								
								var message = "Ошибка удаления";
								if(message) {
									showErrorMessage(message);					
								}												
							}
						 }, 
					 	failure:function(response,options){
							showErrorMessage('Ошибка связи с сервером');
						}	
					});	
				}		
			})
		}
	}
	
	function save() {

		var params = new Object();
		params.task = 'save'+meta.task;
		var message = '';
		fileUpload = false;
		var val_pswd = 'undefined';
		var val_repeat_pswd = 'undefined';
		for(i = 0; i < controls.length; i++) {
			var control = controls[i];
			var value = control.getValue();			
			if(control.trequred) {
				message = addFieldToMessage(message, value, control.fieldLabel);
			}	
			
			if(control.id == 'password') {					
				var val_pswd = value;
			}

			if(control.id == 'repeat_password') {					
				var val_repeat_pswd = value;
			}

			if(control.ttype == 'image' && value) {
				fileUpload = true;
			} else if( control.ttype == 'image' && !value) {
				fileUpload = false || fileUpload;
			} else if(control.ttype == 'data' && value) {				
				value = value.format('Y-m-d H:i:s');				
			}	
			if(!params[control.id])
				params[control.id] = value;
		}	

		if (typeof val_pswd != undefined) {
			if (val_pswd != val_repeat_pswd) {
				showErrorMessage('Парооли не совпадают');
				return;	
			}
		}
		if(message) {
			message = 'Не введены поля: ' + message;
			showErrorMessage(message);
			return;			
		}
		if(!fileUpload) {
			Ext.Ajax.request({ 		
				url:meta.control, 
				params:params, 					 
				method:'POST',										 
				callback: callback, 
				failure: failure
			});			
		} else {
			Ext.Ajax.request({ 		
				url:meta.control, 
				params:params, 					 
				method:'POST',	
				form: mainPanel.getForm().getEl().dom,
				headers: {'Content-type':'multipart/form-data'},									 
				callback: callback, 
				failure: failure
			});	
		}
	}
	
	function callback(options, success, response) {			 				 	
//		var json = Ext.util.JSON.decode(response.responseText);																
		var message = '';
		if(response.responseText == '-121') {
				message = "Такой логин уже есть в базе";
		} else if (response.responseText.indexOf('::error::') >-1 ) {
			message = response.responseText.split('::error::');
			message  = message[1];
		} else if(response.responseText != '0') {
			dialog.hide();
			Ext.getCmp(meta.module+'-list').getStore().reload();																				
		} else {						
			message = "Ошибка выполнения операции";					
		}
		if (message) {
					showErrorMessage(message);														
		}
	}
	
	function  failure(response,options){
		 showErrorMessage('Нет соединения с сервером');
	}	
	function renderCheckBox (v)
	{
		value = 0;
		if (v == 1) {
			value = 1;
		}
			return "<input class = 'light' type='checkbox'" + (value ? "checked='checked'" : "") + ">";
	}

	function renderBool_reverse(v) 
	{
		if (v == 1) {
			return 'Нет';
		} else {
		return 'Да';
		}		
	}


	
	function rendereEdit_string (v)
	{
		return "<input style = 'width:133px;text-align:center;' class = 'price' type = 'text' value = '"+v+"'";
	}
}