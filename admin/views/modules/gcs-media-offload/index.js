import Vue from 'vue';
import dataModule from '../../store/data';
import RegisterStoreModule from '@/utils/registerModule'
import { mapGetters } from 'vuex';

Vue.component('GCSSync', {
    template: '#w2cloud-module-gcsSync',
    mixins: [ RegisterStoreModule ],
    created: function () {
      this.registerStoreModule('dataModule', dataModule);
    },
    data() {
        return {
          sync_type:'all',
          sync_options: [
                      { value: 'all', text: 'Send all data to storage' },
                      { value: 'unsynced', text: 'Send unsynced data to storage' },
                    ],
          medias: [],
          index: 0,
          errormedias: [],
          uploadPercentage: 0,
          errorPercentage: 0,
          totallUpload: 0,
          max: 100,
          processRunning:'none',
          animate: true
        };
    },
    computed: {
        ...mapGetters({
            gcsauthcheck: 'dataModule/gcsAuthValidation',
        }),
    },
    mounted: function () {

      let loader = Vue.$loading.show();
      // this.$store.dispatch('dataModule/getGcsAuthData').then(r=>{
      this.$store.dispatch('dataModule/getGcsAuthData',
      {
        'type' : this.sync_type,
      }
      ).then(r=>{
        loader.hide();
        this.medias = r.message;
        this.max = this.medias.length;
      });

      this.$store.dispatch('dataModule/gcsAuthValidation');

    },
    methods: {
      sync_data_retrieve() {
        let loader = Vue.$loading.show();
        // this.$store.dispatch('dataModule/getGcsAuthData').then(r=>{
        this.$store.dispatch('dataModule/getGcsAuthData',
        {
          'type' : this.sync_type,
        }
        ).then(r=>{
          loader.hide();
          this.medias = r.message;
          this.max = this.medias.length;
        });
      },
      GCS_Sync(evt) {
        if (this.medias === undefined || this.medias.length == 0) {
            return this.$bvToast.toast('No data found to sync' , {
                title: 'Error',
                variant: 'error',
                autoHideDelay: 5000,
            });
        }
        this.processRunning = 'running';
        this.errorPercentage = 0;
        this.totallUpload = 0;
        var mediaId = this.medias;
        this.max = mediaId.length;
        this.processMedia(this.medias[this.index]);
      },
      processMedia(id) {
        this.$store.dispatch('dataModule/processMediaTransfer',
            {
                'id' : id,
            }
        ).then(r=>{
          if (r == 'error') {
            this.errormedias.push(id);
            this.errorPercentage++;
          }
          this.uploadPercentage++;
          if (this.uploadPercentage == this.max) {
            this.processRunning = 'end';
            this.totallUpload = this.max - this.errorPercentage;
            this.uploadPercentage = 0;
            this.$bvToast.toast('Process Complete' , {
                title: 'Success',
                variant: 'success',
                autoHideDelay: 5000,
            })
          }
          else {
            this.index++;
            this.processMedia(this.medias[this.index]);
          }
        });
      },
    },
});
