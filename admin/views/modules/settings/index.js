import Vue from 'vue';
import dataModule from '../../store/data';
import RegisterStoreModule from '@/utils/registerModule'
import { mapGetters } from 'vuex';

Vue.component('Setting', {
    template: '#w2cloud-module-setting',
    mixins: [ RegisterStoreModule ],
    created: function () {
      this.registerStoreModule('dataModule', dataModule);
    },
    data() {
        return {

        }
    },
    computed: {
      ...mapGetters({
          settings: 'dataModule/w2cloudGetGeneralSettings',
          active_storage_options: 'dataModule/getReadyChannels',
      }),
    },
    mounted: function () {
      this.$store.dispatch('dataModule/w2cloudGetGeneralSettings');
      this.$store.dispatch('dataModule/getReadyChannels');
    },
    methods: {
      save () {
        var settings = JSON.stringify(this.settings);
        let loader = Vue.$loading.show();
        this.$store.dispatch('dataModule/w2cloudSubmitGeneralSettings',
            {
                'settings' : settings,
            }
        ).then(r=>{
          loader.hide();
          if (r.status == 'success') {
            this.$bvToast.toast(r.message , {
                title: 'Success',
                variant: 'success',
                autoHideDelay: 5000,
            })
          }
          else {
            this.$bvToast.toast('Error occured' , {
                title: 'Error',
                variant: 'error',
                autoHideDelay: 5000,
            })
          }
        });
      },
    }
});
