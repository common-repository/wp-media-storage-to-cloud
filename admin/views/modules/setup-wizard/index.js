import Vue from 'vue';
import carousel from 'vue-owl-carousel';
import dataModule from '../../store/data';
import RegisterStoreModule from '@/utils/registerModule'
import { mapGetters } from 'vuex';


Vue.component('wizard', {

    template: '#w2cloud-module-wizard',
    components: { carousel },
    mixins: [ RegisterStoreModule ],
    created: function () {
      this.registerStoreModule('dataModule', dataModule);
    },
    data() {
        return {
            carousel_index: 0,
            next_btn: true,
            disabled: 'disabled',
            storageName: '',
        };
    },

    computed: {
        ...mapGetters({
            awsauthcheck: 'dataModule/awsAuthValidation',
            gcsauthcheck: 'dataModule/gcsAuthValidation',
            doauthcheck: 'dataModule/doAuthValidation',
        }),
    },

    watch: {
        awsauthcheck:function(val) {
            if(this.carousel_index == 3){
                if(val == 'notready'){
                   this.next_btn = false;
                }else{
                   this.next_btn = true;
                }
            }
        },

        gcsauthcheck:function(val) {

            if(this.carousel_index == 3){
                if(val == 'notready'){
                   this.next_btn = false;
                }else{
                   this.next_btn = true;
                }
            }
        },

        doauthcheck:function(val) {

            if(this.carousel_index == 3){
                if(val == 'notready'){
                   this.next_btn = false;
                }else{
                   this.next_btn = true;
                }
            }
        },

        carousel_index:function(val) {

            if(val == 3){
                if(this.awsauthcheck == 'notready'){
                   this.next_btn = false;

                }else if(this.gcsauthcheck == 'notready'){
                   this.next_btn = false;

                }else if(this.doauthcheck == 'notready'){
                   this.next_btn = false;

                }else{
                   this.next_btn = true;
                }
            }
        }
    },

    methods: {
        slectedStorage(storageName) {
            if(storageName == 'amazon'){
                this.storageName = storageName;
                this.next_btn = true;
            }else if(storageName == 'googleCloud'){
                this.storageName = storageName;
                this.next_btn = true;
            }else if(storageName == 'digitalOcean'){
                this.storageName = storageName;
                this.next_btn = true;
            }
        },

        changed(e){
            this.carousel_index = e.item.index;
            if (e.item.index == 5) {
              console.log(e.item.index);
              window.location.reload();
            }
            if(e.item.index == 1){
                if(this.storageName){
                   this.next_btn = true;
                }else{
                    this.next_btn = false;
                }
            }else if(e.item.index == 3){
                if(this.awsauthcheck == 'ready'){
                   this.next_btn = true;

                }else if(this.gcsauthcheck == 'ready'){
                   this.next_btn = true;

                }
                else if(this.doauthcheck == 'ready'){
                   this.next_btn = true;

                }else{
                    this.next_btn = false;
                }
            }else{
                this.next_btn = true;
            }
        }

    },

});
