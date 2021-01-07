import Vue from 'vue'
import App from './App.vue'
import ajax from 'ajax';

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
  ajax
}).$mount('#app')
