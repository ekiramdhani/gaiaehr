Ext.define('App.store.Patients', {
    extend: 'Ext.data.DirectStore',
    requires: ['App.model.Patients'],
    config: {
        model: 'App.model.Patients',
        pageSize: 20,
        autoLoad: false,

        proxy: {
            //paramsAsHash: true,
            directFn: PoolArea.getPatientsByPoolAreaAccess,
            simpleSortMode: true
        }
    }
});