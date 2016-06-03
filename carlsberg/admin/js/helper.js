Ext.BLANK_IMAGE_URL = 'ext/resources/images/default/s.gif';

if (!Ext.grid.GridView.prototype.templates) {
   Ext.grid.GridView.prototype.templates = {};
}
Ext.grid.GridView.prototype.templates.cell = new Ext.Template(
   '<td class="x-grid3-col x-grid3-cell x-grid3-td-{id} x-selectable {css}" style="{style}" tabIndex="0" {cellAttr}>',
   '<div class="x-grid3-cell-inner x-grid3-col-{id}" {attr}>{value}</div>',
   '</td>'
);
Ext.override(Ext.form.ComboBox, {
    setValue : function(v){
        var text = v;
        if(this.valueField){
            if(this.mode == 'remote' && !Ext.isDefined(this.store.totalLength)){
                this.store.on('load', this.setValue.createDelegate(this, arguments), null, {single: true});
                if(this.store.lastOptions === null){
                    var params;
                    if(this.valueParam){
                        params = {};
                        params[this.valueParam] = v;
                    }else{
                        var q = this.allQuery;
                        this.lastQuery = q;
                        this.store.setBaseParam(this.queryParam, q);
                        params = this.getParams(q);
                    }
                    this.store.load({params: params});
                }
                return;
            }
            var r = this.findRecord(this.valueField, v);
            if(r){
                text = r.data[this.displayField];
            }else if(this.valueNotFoundText !== undefined){
                text = this.valueNotFoundText;
            }
        }
        this.lastSelectionText = text;
        if(this.hiddenField){
            this.hiddenField.value = v;
        }
        Ext.form.ComboBox.superclass.setValue.call(this, text);
        this.value = v;
    }
});

function getTableHeight() {
	var height = getViewportSize().height - 75;	
	return height;
}

function getTableWidth() {
	var width = getViewportSize().width - 30;		
	return width;	
}

var tableHeight = getTableHeight();

var columns = Math.floor((tableHeight - 60) / 60) ;

var tableWidth = getTableWidth();

function getViewportSize() {
	var viewportwidth;
 	var viewportheight;
 
 // the more standards compliant browsers (mozilla/netscape/opera/IE7) use window.innerWidth and window.innerHeight
 
	 if (typeof window.innerWidth != 'undefined')
	 {
	      viewportwidth = window.innerWidth,
	      viewportheight = window.innerHeight
	 }
	 
	// IE6 in standards compliant mode (i.e. with a valid doctype as the first line in the document)
	
	 else if (typeof document.documentElement != 'undefined'
	     && typeof document.documentElement.clientWidth !=
	     'undefined' && document.documentElement.clientWidth != 0)
	 {
	       viewportwidth = document.documentElement.clientWidth,
	       viewportheight = document.documentElement.clientHeight
	 }
	 
	 // older versions of IE
	 
	 else
	 {
	       viewportwidth = document.getElementsByTagName('body')[0].clientWidth,
	       viewportheight = document.getElementsByTagName('body')[0].clientHeight
	 }
	 var size = new Object();
	 size.height = viewportheight;
	 size.width = viewportwidth;
	 	
	return size;
} 

function renderDate(data, cell, record, rowIndex, columnIndex, store) {
	date = Date.parseDate(data, "Y-m-d H:i:s");	
	var dateStr = Ext.util.Format.date(date);
	var timeStr = Ext.util.Format.date(date, 'H:i:s');
	var correctDate = dateStr + ' ' + timeStr;		
	return correctDate;	
}

function renderDateOnly(data, cell, record, rowIndex, columnIndex, store) {
	date = Date.parseDate(data, "Y-m-d H:i:s");	
	var dateStr = Ext.util.Format.date(date);		
	return dateStr;	
}

function renderBool(data, cell, record, rowIndex, columnIndex, store) {
	if(data) {
		return 'Да';
	} else {
		return 'Нет';
	}		
}

function renderImage(data, cell, record, rowIndex, columnIndex, store) {					
	if(data) {
		return '<img width="150" src="' + data + '">';
	} else {
		return '';
	}
}


function getById(store, id) {	
	var records = store.getRange();
	for(i = 0; i < records.length; i++) {
		var record = records[i]; 
		var recordId = record.get('id');
		if(recordId == id) {
			return record;
		}	
	}
}

function getNameValue(data, store) {
	if(data) {
		var record = getById(store, data);
		if(record) {
			return record.get('name');
		}
	}	
	return '';	
}

function addFieldToMessage(message, field, filedName) {
	if(!field) {
		if(message) {
			message = message + ', ' + filedName; 
		} else {
			message = filedName;
		}
	}
	return message;
}

function showErrorMessage(text) {	
	Ext.MessageBox.show({
		title:'Ошибка',
		msg:text,
		buttons:Ext.MessageBox.OK,					           					           
		icon:Ext.MessageBox.ERROR
	});																			
}

function getDatabaseDate(dateField) {
	var value = dateField.getValue();
	if(value) {
		return value.format('Y-m-d H:i:s');
	} else {
		return '';
	}
	
}


function getErrorMessage(code) {
	switch(code) {
		case 1:
			return "Ошибка связи с сервером";
		case 2:
			return "Введенный Логин уже зарегистрирован в системе на другого пользователя";				
	}
	return "";	
}
