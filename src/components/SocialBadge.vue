<template>
    <div class="social-logo" :class="'social-logo--' + name">
        <i class="fa" :class="logo" aria-hidden="true"></i>
    </div>
</template>

<script>
export default {
    name: "SocialBadge",
    data: function() {
        return {
            color: "",
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
                case "twitter": return require('../assets/images/ic_twitter.svg');
                case "youtube": return require('../assets/images/ic_youtube.svg');
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
}
.social-logo:hover {
    cursor: pointer;
    box-shadow: 0px 20px 40px rgba(19, 24, 33, 0.3);
    
    & img {
        fill: #fff;
    }
}
</style>