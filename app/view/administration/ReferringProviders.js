/**
 * GaiaEHR (Electronic Health Records)
 * Copyright (C) 2013 Certun, LLC.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

Ext.define('App.view.administration.ReferringProviders', {
	extend: 'Ext.grid.Panel',
	xtype: 'referringproviderspanel',
	requires: [

	],
	title: i18n('referring_providers'),

	initComponent: function(){
		var me = this;

		Ext.apply(me, {
			store: Ext.create('App.store.administration.ReferringProviders', {
				autoSync: false
			}),
			columns: [
				{
					width: 200,
					text: i18n('name'),
					sortable: true,
					renderer:function(v, meta, record){
						return record.data.title + ' ' + record.data.fname + ' ' + record.data.mname + ' ' + record.data.lname;
					}
				},
				{
					flex: 1,
					text: i18n('email'),
					sortable: true,
					dataIndex: 'email'
				},
				{
					flex: 1,
					text: i18n('phone_number'),
					sortable: true,
					dataIndex: 'phone_number'
				},
				{
					flex: 1,
					text: i18n('cell_number'),
					sortable: true,
					dataIndex: 'cel_number'
				},
				{
					flex: 1,
					text: i18n('aditional_info'),
					sortable: true,
					dataIndex: 'notes'
				},
				{
					text: i18n('active'),
					sortable: true,
					dataIndex: 'active',
					renderer: me.boolRenderer
				}
			],
			plugins: [
				me.formEditing = Ext.create('App.ux.grid.RowFormEditing', {
					clicksToEdit: 1,
					items: [
						{
							xtype: 'fieldcontainer',
							fieldLabel: i18n('first_middle_last'),
							labelWidth: 130,
							labelAlign: 'right',
							layout: {
								type: 'hbox',
								defaultMargins: {
									top: 0,
									right: 5,
									bottom: 0,
									left: 0
								}
							},
							msgTarget: 'under',
							items: [
								{
									width: 50,
									xtype: 'mitos.titlescombo',
									name: 'title'
								},
								{
									width: 150,
									xtype: 'textfield',
									name: 'fname',
									allowBlank: false
								},
								{
									width: 100,
									xtype: 'textfield',
									name: 'mname'
								},
								{
									width: 150,
									xtype: 'textfield',
									name: 'lname',
									allowBlank: false
								}
							]
						},
						{
							xtype: 'fieldcontainer',
							layout: {
								type: 'hbox',
								defaultMargins: {
									top: 0,
									right: 5,
									bottom: 0,
									left: 0
								}
							},
							items: [
								{
									xtype: 'textfield',
									name: 'email',
									fieldLabel: i18n('email'),
									labelWidth: 130,
									labelAlign: 'right'
								},
								{
									xtype: 'textfield',
									fieldLabel: i18n('taxonomy'),
									labelWidth: 130,
									labelAlign: 'right',
									name: 'taxonomy'
								}
							]
						},
						{
							xtype: 'fieldcontainer',
							layout: {
								type: 'hbox',
								defaultMargins: {
									top: 0,
									right: 5,
									bottom: 0,
									left: 0
								}
							},
							items: [
								{
									xtype: 'textfield',
									fieldLabel: i18n('upin'),
									labelWidth: 130,
									labelAlign: 'right',
									name: 'upin'
								},
								{
									xtype: 'textfield',
									fieldLabel: i18n('npi'),
									labelWidth: 130,
									labelAlign: 'right',
									name: 'npi'
								}
							]
						},
						{
							xtype: 'fieldcontainer',
							layout: {
								type: 'hbox',
								defaultMargins: {
									top: 0,
									right: 5,
									bottom: 0,
									left: 0
								}
							},
							items: [
								{
									xtype: 'textfield',
									fieldLabel: i18n('lic'),
									labelWidth: 130,
									labelAlign: 'right',
									name: 'lic'
								},
								{
									xtype: 'textfield',
									fieldLabel: i18n('ssn'),
									labelWidth: 130,
									labelAlign: 'right',
									name: 'ssn'
								}
							]
						},
						{
							xtype: 'fieldcontainer',
							layout: {
								type: 'hbox',
								defaultMargins: {
									top: 0,
									right: 5,
									bottom: 0,
									left: 0
								}
							},
							items: [
								{
									xtype: 'textfield',
									fieldLabel: i18n('phone_number'),
									labelWidth: 130,
									labelAlign: 'right',
									name: 'phone_number'
								},
								{
									xtype: 'textfield',
									fieldLabel: i18n('fax_number'),
									labelWidth: 130,
									labelAlign: 'right',
									name: 'fax_number'
								}

							]
						},
						{
							xtype: 'fieldcontainer',
							layout: {
								type: 'hbox',
								defaultMargins: {
									top: 0,
									right: 5,
									bottom: 0,
									left: 0
								}
							},
							items: [
								{
									xtype: 'textfield',
									fieldLabel: i18n('cell_number'),
									labelWidth: 130,
									labelAlign: 'right',
									name: 'cel_number'
								},
								{
									xtype: 'checkbox',
									fieldLabel: i18n('active'),
									labelWidth: 130,
									labelAlign: 'right',
									name: 'active'
								}

							]
						},
						{
							height: 50,
							xtype: 'textareafield',
							name: 'notes',
							width: 600,
							fieldLabel: i18n('notes'),
							labelWidth: 130,
							labelAlign: 'right',
							emptyText: i18n('additional_info')
						}
					]
				})
			],
			dockedItems: [
				{
					xtype: 'toolbar',
					dock: 'top',
					items: [
						'->',
						{
							xtype: 'button',
							text: i18n('referring_provider'),
							iconCls: 'icoAdd',
							itemId: 'referringProviderAddBtn',
						}
					]
				}
			]
		});

		me.callParent(arguments);

	}

});
