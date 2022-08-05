<template>
    <div class="card_container">
        {{ card.title }}
    </div>
</template>

<script>
export default {
    name: "Card",
    props: {
        card: {
            type: Object,
            default: () => {}
        }
    }
}
</script>

<style lang="scss" scoped>
.card_container {
    height: 70px;
    border-radius: 5px;
    box-shadow: 0 3px 10px rgb(0 0 0 / 0.3);
    margin-bottom: 14px;
    cursor: grabbing;
    background-color: rgba(255, 255, 255, .7);
}
</style>
