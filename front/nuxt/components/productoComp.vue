<template>
    <div id="producto" :data-testid="testId">
        <div id="contain-image">
            <img :src="img">
            <span id="contain-fav">
                <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    style="position: relative; top: 5px; margin-left: 5px; margin-right: 5px;">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                    </path>
                </svg>
            </span>
        </div>
        <h3 id="title">{{ title }}</h3>
        <h2 id="price">{{ price }}€</h2>
    </div>
</template>

<style scoped>
#producto {
    width: 100%;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

#title {
    font-weight: 500;
    color: #1a1b1b;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

#price {
    font-weight: 700;
    font-size: 18px;
    margin-bottom: 0;
}

#contain-image {
    width: 100%;
    height: 160px;
    position: relative;
    display: flex;
    align-items: center;
    overflow: hidden;
    border-radius: 10px;
    border: 1px solid #dde0e2;
}

img {
    object-fit: contain;
    object-position: center;
}

#contain-fav {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 30px;
    height: 30px;
    background-color: #dde0e2;
    border-radius: 8px;
}
</style>

<script setup>
const props = defineProps({
    testId: {
        type: String,
        default: 'a',
    },
    img: {
        type: String,
        required: true,
    },
    title: {
        type: String,
        // required: true,
    },
    price: {
        type: String,
        // required: true,
    },
});
</script>