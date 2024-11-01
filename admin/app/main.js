import Vue from 'vue';
import Vuex from 'vuex';
import Router from 'vue-router';
import App from './App.vue';
import menuFix from './utils/admin-menu-fix';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

import { library } from '@fortawesome/fontawesome-svg-core';
import { faCoffee, faCheck, faTimes} from '@fortawesome/free-solid-svg-icons';
import { faCalendarAlt} from '@fortawesome/free-regular-svg-icons';
import { faFacebookF} from '@fortawesome/free-brands-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(faCoffee, faCheck, faCalendarAlt, faFacebookF, faTimes);
Vue.component('font-awesome-icon', FontAwesomeIcon);

import { TabsPlugin, FormRadioPlugin, CardPlugin, ModalPlugin, ButtonPlugin, CollapsePlugin,
  FormInputPlugin, FormSelectPlugin, PaginationPlugin, TooltipPlugin, ToastPlugin,
  SpinnerPlugin, FormGroupPlugin, FormTextareaPlugin, FormCheckboxPlugin, ProgressPlugin } from 'bootstrap-vue';
Vue.use(TabsPlugin);
Vue.use(CardPlugin);
Vue.use(ModalPlugin);
Vue.use(ButtonPlugin);
Vue.use(CollapsePlugin);
Vue.use(FormInputPlugin);
Vue.use(FormSelectPlugin);
Vue.use(PaginationPlugin);
Vue.use(TooltipPlugin);
Vue.use(ToastPlugin);
Vue.use(SpinnerPlugin);
Vue.use(FormGroupPlugin);
Vue.use(FormTextareaPlugin);
Vue.use(FormCheckboxPlugin);
Vue.use(ProgressPlugin);
Vue.use(FormRadioPlugin);
Vue.use(Vuex);
Vue.use(Router);

Vue.use(Loading,
  {
    color: 'black',
    loader: 'bars',
    backgroundColor: '#212529',
  }
);


window.w2cloud_obj.routeComponents.Home = {
    template: '#w2cloud-home',
    data: function() {
        return {}
    },
};

function parseRouteComponent(routes) {
    for (let i = 0; i < routes.length; i++) {
        routes[i].component = window.w2cloud_obj.routeComponents[routes[i].component];
    }
}
parseRouteComponent(window.w2cloud_obj.routes);

const router = new Router({
    routes: window.w2cloud_obj.routes,
});

let store = new Vuex.Store({
    strict: false,
});

/* eslint-disable no-new */
new Vue({
    el: '#w2cloud-root',
    router,
    store,
    render: h => h(App)
});

// fix the admin menu for the slug "vue-app"
menuFix('vue-app');
