<template>
    <div class="box-wrapper">
        <div v-if="subscribed === false">
            <h1>Subscribe to newsletter</h1>
            <p class="box-wrapper__sub-heading">Subscribe to our newsletter and get 10% discount on pineapple glasses.</p>
            <form action="subscribe.php" method="POST"></form>
            <div class="custom-input">
                <input 
                    type="email" 
                    class="custom-input__text" 
                    placeholder="Type your email address here..."
                    v-model="email"
                    @keyup="validate"
                    >
                <a href="#" class="custom-input__submit" v-on:click="submitForm"></a>
                <span class="error-message" v-if="error.length > 0">{{ error }}</span>
            </div>
            <div class="tos">
                <input class="tos__checkbox" type="checkbox" v-model="tos" @change="clicked = true; validate();">
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
        <div v-else>
            <img src="../assets/images/ic_success.svg" class="success-logo">
            <h1>Thanks for subscribing!</h1>
            <p class="box-wrapper__sub-heading">You have successfully subscribed to our email listing. Check your email for the discount code.</p>
            <div class="spacer"></div>
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
            subscribed: false,
            error: "",
            clicked: false,
            tos: false
        }
    },
    methods: {
        submitForm: function(e) {
            e.preventDefault();
            console.log(this.tos);

            this.clicked = true;
            this.validate();

            if(this.error.length < 1) {
                this.$http.get('http://localhost:8000/insert', {
                    params: {
                        email: this.email
                    }
                }).then(response => {
                    // redirect
                    console.log(response);
                    if(response.status === 200) {
                        this.subscribed = true;
                    }
                }, err => {
                    if(err.response && err.response.data && err.response.data.message) {
                        let message = err.response.data.message;
                        this.error = message.charAt(0).toUpperCase() + message.slice(1);
                    }
                });
            }
        },
        validate: function() {
            if(!this.clicked) return;

            if(this.email.length < 1) {
                this.error = "Email address is required";
            } else if(!this.validateEmail(this.email)) {
                this.error = "Please provide a valid e-mail address";  
            } else if(this.tos === false) {
                this.error = "You must accept the terms and conditions";
            } else if(this.email.substr(this.email.length - 2, 2).toLowerCase() === "co") {
                this.error = "We are not accepting subscriptions from Colombia emails";
            } else {
                this.error = "";
                this.clicked = false;
            }
        },
    },
}
</script>