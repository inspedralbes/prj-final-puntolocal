<template>
    <div id="producto" :data-testid="testId" style="background-color: blue;">
        <div id="contain-image">
            <img :src="img">
            <div id="contain-fav"></div>
        </div>
    </div>
</template>

<style scoped>
#producto{
    width: 100%;
    height: 220px;
    display: flex;
    flex-direction: column;
}
#contain-image{
    width: 100%;
    height: 160px;
    position: relative;
    background-color: gray;
}
#contain-fav{
    position: absolute;
    top: 10px;
    right: 10px;
    width: 30px;
    height: 30px;
    background-color: red;
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
        // required: true,
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