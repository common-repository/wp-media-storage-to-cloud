import Vue from 'vue';
import dataModule from '../../store/data';
import RegisterStoreModule from '@/utils/registerModule';
import { mapGetters } from 'vuex';

Vue.component('Media', {

    template: '#w2cloud-module-media',
    mixins: [ RegisterStoreModule ],
    created: function () {
      this.registerStoreModule('dataModule', dataModule);
    },
    data() {
        return {
            rating: '',
        };
    },
    mounted: function () {

    },
});
