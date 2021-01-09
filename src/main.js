import Vue from 'vue'
import App from './App.vue'

import axios from 'axios';
import VueAxios from 'vue-axios';
Vue.use(VueAxios, axios);

Vue.mixin({
  methods: {
    validateEmail: function(email) {
      const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(String(email).toLowerCase());
    },
  },
})

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
}).$mount('#app')
