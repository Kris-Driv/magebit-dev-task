<template>
    <div class="box-wrapper">
        <h1>Subscribe to newsletter</h1>
        <p class="box-wrapper__sub-heading">Subscribe to our newsletter and get 10% discount on pineapple glasses.</p>
        <form action="subscribe.php" method="POST"></form>
        <div class="custom-input">
            <input 
                type="email" 
                class="custom-input__text" 
                placeholder="Type your email address here..."
                v-model="email"
                v-on:keydown="validate"
                >
            <a href="#" class="custom-input__submit" v-on:click="submitForm">
                <img src="../assets/images/ic_arrow.svg" alt="">
            </a>
        </div>
        <div class="tos">
            <input class="tos__checkbox" type="checkbox">
            <span class="tos__text">I agree to <span class="tos__underline">terms of service</span></span>
        </div>
        <div class="socials">
            <ul class="socials-list">
                <li>
                    <SocialBadge name="facebook"/>
                </li>
                <li>
                    <SocialBadge name="instagram"/>
                </li>
                <li>
                    <SocialBadge name="twitter"/>
                </li>
                <li>
                    <SocialBadge name="youtube"/>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import SocialBadge from './SocialBadge.vue';

export default {
    name: "SubscriptionForm",
    components: {
        SocialBadge
    },
    data: function() {
        return {
            email: "",
            validated: false,
        }
    },
    methods: {
        submitForm: function() {
            this.validate();

            if(this.validated) {
                
            }
        },
        validate: function() {
            this.validated = false;
        }
    },
}
</script>