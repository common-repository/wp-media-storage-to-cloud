import Vue from 'vue';

Vue.component('General', {
    template: '#w2cloud-module-general',
    data() {
        return {
            select_type : '',
        };
    },

    methods: {
        general_select_type(id) {
          this.select_type = id;
        }
      }
});
