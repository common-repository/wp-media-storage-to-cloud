import Vue from 'vue';
import dataModule from '../../store/data';
import RegisterStoreModule from '@/utils/registerModule';
import { mapGetters } from 'vuex';

Vue.component('DO', {
    template: '#w2cloud-module-do',
    mixins: [ RegisterStoreModule ],
    created: function () {
      this.registerStoreModule('dataModule', dataModule);
    },
    data() {

        return {
          do_client_id: "",
          do_client_secret: "",
          do_bucket: "",
          do_region: ""
        };
    },
    computed: {
        ...mapGetters({
            doauthcheck: 'dataModule/doAuthValidation',
        }),
    },
    mounted: function () {
      this.$store.dispatch('dataModule/doAuthValidation');
    },
    methods: {
      DO_Authorize(evt) {
        if (this.do_client_id == "" || this.do_client_secret == "" || this.do_bucket == "" || this.do_region == "") {
          this.$bvToast.toast("Fill up all required fields" , {
              title: 'Error',
              variant: 'error',
              autoHideDelay: 5000,
          });
          return;
        }
        let loader = Vue.$loading.show();
        var secret = encodeURIComponent(window.btoa(this.do_client_secret));
        this.$store.dispatch('dataModule/doAuth',
            {
                'do_client_id' : this.do_client_id,
                'do_client_secret' : secret,
                'do_bucket' : this.do_bucket,
                'do_region' : this.do_region
            }
        ).then(r=>{
          loader.hide();
          if (r.status == 'success') {
            this.$store.dispatch('dataModule/doAuthValidation');
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
      DO_Edit(evt) {
        if (this.doauthcheck == 'ready') {
          this.$store.commit('dataModule/DOAUTHEDIT', {status:'notready'});
        }
      },
    }
});
