import Vue from 'vue';
import dataModule from '../../store/data';
import RegisterStoreModule from '@/utils/registerModule'
import { mapGetters } from 'vuex';

Vue.component('amazonMediaCheck', {
    template: '#w2cloud-module-amazonMediaCheck',
    mixins: [ RegisterStoreModule ],
    created: function () {
      this.registerStoreModule('dataModule', dataModule);
    },
    components: {
       
    },
    data() {
        return {
            spinner: true,
            active_state_1 : 0,
            active_state_2 : 0,
            active_state_3 : 0,
            state_status_1 : '',
            state_status_2 : '',
            state_status_3 : '',
        };
    },
    
    methods: {
        validation() {
            this.active_state_1 = 1;
            this.state_status_1 = 'running' + this.active_state_1;
            
            this.$store.dispatch('dataModule/awsAuthValidation').then(
                r=>{
                    if(r.status == 'success'){
                        this.state_status_1 = 'success' + this.active_state_1;
                    }else{
                        this.state_status_1 = 'failed' + this.active_state_1;
                    }
                    this.active_state_2 = 2;
                    setTimeout(() => this.mediaUpload(), 600);
                }
            );
        },
        mediaUpload(){
            this.state_status_2 = 'running' + this.active_state_2;
            this.$store.dispatch('dataModule/processAWSMediaTransfer',
                {
                    'id' : 5,
                }
            ).then(r=>{
              console.log(r);
                if(r == 'success'){
                    this.state_status_2 = 'success' + this.active_state_2;
                }else{
                    this.state_status_2 = 'failed' + this.active_state_2;
                }
                this.active_state_3 = 3;
                setTimeout(() => this.mediaDelete(), 600);
            });
        },
        mediaDelete(){
            this.state_status_3 = 'running' + this.active_state_3;
        }
        
    },
    
});
