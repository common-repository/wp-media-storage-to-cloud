import Vue from 'vue';
import dataModule from '../../store/data';
import RegisterStoreModule from '@/utils/registerModule';
import { mapGetters } from 'vuex';

Vue.component('Compatibility', {

    template: '#w2cloud-module-compatibility',
    mixins: [ RegisterStoreModule ],

    created: function () {
      this.registerStoreModule('dataModule', dataModule);
    },
    data() {
        return {
            compatibility_info: {},
        };
    },
    mounted: function () {
        this.$store.dispatch('dataModule/w2cloudPluginCompatibility').then(r=>{

            this.compatibility_info = r;
        });
    },

});
