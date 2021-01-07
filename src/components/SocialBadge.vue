<template>
    <a href="#" class="social-logo" @click="handleClick" :class="'social-logo--' + name">
        <i class="fa" :class="logo" aria-hidden="true"></i>
    </a>
</template>

<script>
export default {
    name: "SocialBadge",
    data: function() {
        return {
            color: "",
        }
    },
    methods: {
        handleClick: function(event) {
            event.preventDefault();
        }
    },
    props: {
        "name": {
            type: String,
            default: ""
        },
    },
    computed: {
        logo: function() {
            switch(this.name) {
                case "facebook": return "fa-facebook";
                case "instagram": return "fa-instagram";
                case "twitter": return "fa-twitter";
                case "youtube": return "fa-youtube-play";
                default: 
                    console.error("Badge can't resolve logo");
                    return this.name;
            }
        }
    }
}
</script>

<style lang="scss" scoped>
.social-logo {
    width: 46px;
    height: 46px;
    border-radius: 50px;
    border: 2px solid #E2E3E4;
    display: flex;
    justify-content: center;
    align-items: center;
    display: inline-flex;
    text-decoration: none;

    &--facebook:hover {
        background-color: #4267B2;
        border: 2px solid #4267B2;
    }

    &--twitter:hover {
        background-color: #1DA1F2;
        border: 2px solid #1DA1F2;
    }

    &--instagram:hover {
        background-color: #C13584;
        border: 2px solid #C13584;
    }

    &--youtube:hover {
        background-color: #FF0000;
        border: 2px solid #FF0000;
    }

    & i {
        font-size: 16px;
        line-height: 16px;
        color: #E2E3E4;
    }

    &:active {
        background-color: #2F4A80;
        border: 2px solid #2F4A80;
    }
}
.social-logo:hover {
    cursor: pointer;
    box-shadow: 0px 20px 40px rgba(19, 24, 33, 0.3);
    
    & i {
        color: #fff;
    }
}
</style>