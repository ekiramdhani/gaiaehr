/**
 GaiaEHR (Electronic Health Records)
 Practice.js
 Copyright (C) 2013 Certun

 This program is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

Ext.define('App.model.administration.LaboratoriesGridModel', {
    extend:'Ext.data.Model',
    table: {
        name:'laboratoriesgrid',
        engine:'InnoDB',
        autoIncrement:1,
        charset:'utf8',
        collate:'utf8_bin',
        comment:'Account'
    },
    fields:[
        { name:'id', type:'int' },
        { name:'name', type:'string' },
        { name:'transmit_method', type:'string' },
        { name:'email', type:'string' },
        { name:'address_id', type:'int' },
        { name:'line1', type:'string' },
        { name:'line2', type:'string' },
        { name:'city', type:'string' },
        { name:'state', type:'string' },
        { name:'zip', type:'string' },
        { name:'plus_four', type:'string' },
        { name:'country', type:'string' },
        { name:'address_full', type:'string' },
        { name:'phone_id', type:'int' },
        { name:'phone_country_code', type:'string' },
        { name:'phone_area_code', type:'string' },
        { name:'phone_prefix', type:'string' },
        { name:'phone_number', type:'string' },
        { name:'phone_full', type:'string' },
        { name:'fax_id', type:'int' },
        { name:'fax_area_code', type:'string' },
        { name:'fax_prefix', type:'string' },
        { name:'fax_number', type:'string' },
        { name:'fax_full', type:'string' },
        { name:'active', type:'bool' }
    ],
    proxy:{
        type:'direct',
        api:{
            read:Practice.getLaboratories,
            create:Practice.addLaboratory,
            update:Practice.updateLaboratory
        }
    }
});