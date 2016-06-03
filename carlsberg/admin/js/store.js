var roleStore = new Ext.data.SimpleStore({
	id:0,
	fields: ['id', 'name'],
	data: [							
		['4', 'Администратор'],
		['3', 'Директор'],
		['2', 'Менеджер'],
		['1', 'Сотрудник']
	]
});

var orgStore = new Ext.data.SimpleStore({
	id:0,
	fields: ['id', 'name'],
	data: [							
		['1', 'СРНУ'],		
		['2', 'Монт'],
		['3', 'Энет']		
	]
});

var typeStore = new Ext.data.SimpleStore({
	id:0,
	fields: ['id', 'name'],
	data: [							
		['1', 'Обслуживание'],		
		['2', 'Работы']		
	]
});

var clientTypeStore = new Ext.data.SimpleStore({
	id:0,
	fields: ['id', 'name'],
	data: [							
		['1', 'Клиент'],		
		['2', 'Поставщик'],
		['3', 'Подрядчик']		
	]
});

var paymentTypeStore = new Ext.data.SimpleStore({
	id:0,
	fields: ['id', 'name'],
	data: [							
		['1', 'Доходы'],		
		['2', 'Расходы']			
	]
});

var paymentSubTypeStore = new Ext.data.SimpleStore({
	id:0,
	fields: ['id', 'name', 'type'],
	data: [							
		['1', 'Обслуживание', '1'],		
		['2', 'Поверки', '1'],
		['3', 'Работы', '1'],
		['4', 'Другое', '1'],
		['5', 'Работы', '2'],
		['6', 'Поверки', '2'],
		['7', 'Услуги банка', '2'],
		['8', 'Налоги', '2'],
		['9', 'Свои затраты', '2'],
		['10', 'Подрядчики', '2'],
					
	]
});