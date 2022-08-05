<template>
    <div class="home_section">
        <Header/>
        <Column v-for="(column, index) in columns" :key="index" :column="column"/>
        <div class="add_column_container">
            Add Column
        </div>
    </div>
</template>

<script>
import Column from "../components/Column";
import draggable from "vuedraggable";
import Header from "../components/Header";
export default {
    name: "Home",
    components: {
        Header,
        Column,
        draggable
    },
    data() {
        return {
            columns: []
        };
    },
    async mounted() {
        await this.fetchColumns()
    },
    methods: {
        async fetchColumns() {
            const { data } = await axios.get('/api/columns', )
            this.columns = data.data
        },
    }
}
</script>

<style lang="scss" scoped>
.home_section {
    display: flex;
    gap: 20px;
    overflow-x: scroll;
    .add_column_container {
        margin-top: 120px;
        background-color: rgba(255, 255, 255, .7);
        border-radius: 10px;
        width: 200px;
        height: 80px;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px dashed black;
        cursor: pointer;
    }
}
</style>
