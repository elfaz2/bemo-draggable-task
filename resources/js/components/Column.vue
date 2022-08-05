<template>
    <div class="column_container">
        <div class="column_container_header">
            Title
        </div>
        <draggable
            class="dragArea list-group"
            :list="list1"
            :clone="clone"
            :group="{ name: 'people', pull: pullFunction }"
            @start="start"
        >
            <card v-for="element in list1" :key="element.id" :card="element.name"/>
        </draggable>
        <div class="add_card_container">
            Add Card
        </div>
    </div>
</template>

<script>
import draggable from "vuedraggable";
import Card from "./Card";
export default {
    name: "Column",
    props: {
        column: {
            type: Object,
            default: () => {}
        }
    },
    components: {
        Card,
        draggable
    },
    data() {
        return {
            list1: [
                { name: "Jesus", id: 1 },
                { name: "Paul", id: 2 },
                { name: "Peter", id: 3 }
            ],
            list2: [
                { name: "Luc", id: 5 },
                { name: "Thomas", id: 6 },
                { name: "John", id: 7 }
            ],
            controlOnStart: true
        };
    },
    methods: {
        async fetchColumns() {
            const { data } = await axios.get('/api/columns', )
        },
        clone({ name }) {
            return { name, id: idGlobal++ };
        },
        pullFunction() {
            return this.controlOnStart ? "clone" : true;
        },
        start({ originalEvent }) {
            this.controlOnStart = originalEvent.ctrlKey;
        }
    }
}
</script>

<style lang="scss" scoped>
.column_container {
    margin: 120px 20px;
    padding: 10px;
    width: 300px;
    max-height: 700px;
    min-height: 100px;
    background-color: rgba(255, 255, 255, .7);
    border-radius: 10px;
    &_header {
        height: 40px;
    }
    .add_card_container {
        margin-top: 20px;
        background-color: rgba(255, 255, 255, .7);
        border-radius: 10px;
        height: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px dashed black;
        cursor: pointer;
    }
}
</style>
