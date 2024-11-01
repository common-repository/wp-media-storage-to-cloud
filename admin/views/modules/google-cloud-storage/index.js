import Vue from 'vue';
import dataModule from '../../store/data';
import RegisterStoreModule from '@/utils/registerModule';
import { mapGetters } from 'vuex';

Vue.component('GCS', {
    template: '#w2cloud-module-gcs',
    mixins: [ RegisterStoreModule ],
    created: function () {
      this.registerStoreModule('dataModule', dataModule);
    },
    data() {
        return {
          gcs_auth_data: '',
          gcs_bucket: '',
        };
    },
    computed: {
        ...mapGetters({
            gcsauthcheck: 'dataModule/gcsAuthValidation',
        }),
    },
    mounted: function () {
      let loader = Vue.$loading.show();
      this.$store.dispatch('dataModule/gcsAuthValidation');
      loader.hide();
    },
    methods: {
      GCS_Authorize(evt) {
        if (this.gcs_auth_data == "" || this.gcs_bucket == "" ) {
          this.$bvToast.toast("Fill up all required fields" , {
              title: 'Error',
              variant: 'error',
              autoHideDelay: 5000,
          });
          return;
        }
        let loader = Vue.$loading.show();
        var token = encodeURIComponent(window.btoa(this.gcs_auth_data));
        this.$store.dispatch('dataModule/gcsAuth',
            {
                'data' : token,
                'bucket' : this.gcs_bucket,
            }
        ).then(r=>{
          loader.hide();
          if (r.status == 'success') {
            this.$store.dispatch('dataModule/gcsAuthValidation');
            this.$store.dispatch('dataModule/getReadyChannels');
            this.$bvToast.toast(r.message , {
                title: 'Success',
                variant: 'success',
                autoHideDelay: 5000,
            })
          }
          else if (r.status == 'error') {
            this.$bvToast.toast( r.message, {
                title: 'Error',
                variant: 'error',
                autoHideDelay: 5000,
            })
          }
          else {
            this.$bvToast.toast('Error occured. Please check again all informations.' , {
                title: 'Error',
                variant: 'error',
                autoHideDelay: 5000,
            })
          }
        });
      },
      GCS_Edit(evt) {
        if (this.gcsauthcheck == 'ready') {
          this.$store.commit('dataModule/GCSAUTHEDIT', {status:'notready'});
        }
      },
    },
});
