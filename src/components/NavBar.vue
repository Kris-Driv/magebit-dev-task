<template>
    <nav class="nav-bar">
        <div class="logo">
            <img :src="logoImage" class="logo__img" alt="">
            <img :src="logoText" class="logo__text" alt="">
        </div>
        <div class="nav-menu">
            <ul class="nav-list">
                <li class="nav-list__list-item">
                    <a href="#">About</a>
                </li>
                <li class="nav-list__list-item">
                    <a href="#">How it works</a>
                </li>
                <li class="nav-list__list-item">
                    <a href="#">Contact</a>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
import logoImage from '../assets/images/pineapple.png';
import logoText from '../assets/images/pineapple-text.png';

export default {
    name: "NavBar",
    data: function() {
        return {
            logoImage, logoText
        };
    }
}
</script>