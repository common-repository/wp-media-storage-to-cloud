import Vue from 'vue';
import dataModule from '../../store/data';
import RegisterStoreModule from '@/utils/registerModule';
import { mapGetters } from 'vuex';

Vue.component('AWS', {
    template: '#w2cloud-module-aws',
    mixins: [ RegisterStoreModule ],
    created: function () {
      this.registerStoreModule('dataModule', dataModule);
    },
    data() {

        return {
          aws_client_id: "",
          aws_client_secret: "",
          aws_bucket: "",
          aws_region: ""
        };
    },
    computed: {
        ...mapGetters({
            awsauthcheck: 'dataModule/awsAuthValidation',
        }),
    },
    mounted: function () {
      this.$store.dispatch('dataModule/awsAuthValidation');
    },
    methods: {
      AWS_Authorize(evt) {
        if (this.aws_client_id == "" || this.aws_client_secret == "" || this.aws_bucket == "" || this.aws_region == "") {
          this.$bvToast.toast("Fill up all required fields" , {
              title: 'Error',
              variant: 'error',
              autoHideDelay: 5000,
          });
          return;
        }
        let loader = Vue.$loading.show();
        this.$store.dispatch('dataModule/awsAuth',
            {
                'aws_client_id' : this.aws_client_id,
                'aws_client_secret' : this.aws_client_secret,
                'aws_bucket' : this.aws_bucket,
                'aws_region' : this.aws_region
            }
        ).then(r=>{
          loader.hide();
          if (r.status == 'success') {
            this.$store.dispatch('dataModule/awsAuthValidation');
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
      AWS_Edit(evt) {
        if (this.awsauthcheck == 'ready') {
          this.$store.commit('dataModule/AWSAUTHEDIT', {status:'notready'});
        }
      },
    }
});
