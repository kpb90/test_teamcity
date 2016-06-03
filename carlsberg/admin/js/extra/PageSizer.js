/*
 * Ext.ux.grid.PageSizer
 * 
 * Dynamically sets the PageSize config of a PagingToolbar
 * adapted for 3.0.0 Marcin Krzyzanowski
 */

Ext.namespace("Ext.ux.grid");

Ext.ux.grid.PageSizer = function(config){        
    Ext.apply(this, config);
};



Ext.extend(Ext.ux.grid.PageSizer, Ext.util.Observable, {

    /**
     * @cfg {Array} sizes
     * An array of pageSize choices to populate the comboBox with
     */

    sizes: [[10],[25],[50]],

    /**
     * @cfg {String} beforeText
     * Text to display before the comboBox
     */

    beforeText: 'Show',

    /**
     * @cfg {String} afterText
     * Text to display after the comboBox
     */

    afterText: 'records at a time',

    /**
     * @cfg {String} emptyText
     * Text to display if valye is empty
     */

    emptyText: 'never',

    /**
     * @cfg {Mixed} addBefore
     * Toolbar item(s) to add before the PageSizer
     */

    addBefore: '-',

    /**
     * @cfg {Mixed} addAfter
     * Toolbar item(s) to be added after the PageSizer
     */

    addAfter: null,

    init: function(PagingToolbar){
        this.PagingToolbar  = PagingToolbar;
        this.store = PagingToolbar.store;
        PagingToolbar.on("render", this.onRender, this);

    },

	update: function(c){
        this.PagingToolbar.pageSize = parseInt(c.getValue());
        //alert(this.PagingToolbar.pageSize);
        this.PagingToolbar.doLoad(this.PagingToolbar.cursor); //due to bug in 3.0.0
    },

    onRender: function(){

		var config = {
				maskRe: /^\d*$/,
				store: new Ext.data.SimpleStore({
				fields: ['autoRefresh'],
				data : this.sizes
			}),		
			displayField:'autoRefresh',
			value: this.PagingToolbar.pageSize,
			typeAhead: false,
			mode: 'local',
			emptyText: this.emptyText,
			triggerAction: 'all',
			selectOnFocus:false,
			enableKeyEvents: true,
			width:50,
			listeners: {
				scope: this,
				'keyup': function(cmb,e) {
				    var key = e.getKey(); 
					switch (key) { 
					    case Ext.EventObject.ENTER:
					        this.update(cmb);
					}
				},
				'select': function(cmb) {
					this.update(cmb);
				}
			}
		};


		Ext.apply(config,this.comboCfg)
		
		var combo = new Ext.form.ComboBox(config);
		if (this.addBefore) {this.PagingToolbar.add(this.addBefore)};
				
		this.PagingToolbar.add(this.beforeText,combo,this.afterText);		
		
		if (this.addAfter) {this.PagingToolbar.add(this.addAfter)};
	}

})