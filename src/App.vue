<template>
  <div id="app">
    <div class="content">
        <NavBar />

        <SubscriptionForm />
    </div>
    <div class="background"></div>
  </div>
</template>

<script>
import './styles/main.scss';

import NavBar from './components/NavBar.vue';
import SubscriptionForm from './components/SubscriptionForm.vue';

export default {
  name: 'App',
  components: {
    NavBar, SubscriptionForm
  }
}
</script>
