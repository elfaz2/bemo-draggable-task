<template>
    <div class="column_container">
        <div class="column_container_header">
            <label>Title</label>
            <button class="delete_button" @click="$modal.show('delete-column')"><img :src="deleteIcon" alt="Delete Column Icon"> </button>
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
        <div class="add_card_container" @click="$modal.show('add-card')">
            Add Card
        </div>
        <Modal class="delete-modal" name="delete-column">
            <div class="delete_column_section">
                <div class="header_section">
                    Are you sure you want to delete
                </div>
                <button @click="deleteColumn">
                    Yes
                </button>
            </div>
        </Modal>
        <Modal class="create_card_modal" name="add-card">
            <div class="create_column_section">
                <div class="header_section">
                    Create Column.
                </div>
                <div class="form_section">
                    <div>
                        Title:
                        <input v-model="form.title" @keydown="titleRequired = false">
                        <small class="required_field" v-if="titleRequired"> Title field is required!</small>
                    </div>
                    <br>
                    <div>
                        Description:
                        <textarea rows="5" v-model="form.description" @keydown="descriptionRequired = false"/>
                        <small class="required_field" v-if="descriptionRequired"> Description field is required!</small>
                    </div>
                    <button @click="createCard">
                        Submit
                    </button>
                </div>
            </div>
        </Modal>
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
            titleRequired: false,
            descriptionRequired: false,
            form: {
              title: "",
              description: "",
              columnId: ""
            },
            deleteIcon: require('../../assets/delete-icon.svg'),
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
        async deleteColumn() {
            await axios.delete(`/api/column/${ this.column.id }`)
            this.$modal.hide('delete-column')
            this.$emit('refresh', true)
        },
        async createCard() {
            if(this.form.title !== "" && this.form.description !== "") {
                this.form.columnId = this.column.id
                await axios.post(`/api/card`, this.form)
                this.$emit('refresh', true)
            } else  {
                this.titleRequired = !this.form.title;
                this.descriptionRequired = !this.form.description;
            }
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

<style lang="scss">
.create_card_modal {
    .vm--modal {
        width: 50% !important;
        height: 400px !important;
    }
}
.delete-modal {
    .vm--modal {
        width: 300px !important;
        height: 150px !important;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .delete_column_section {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;

        button {
            margin-top: 10px;
            width: 70px;
            height: 35px;
            background-color: cornflowerblue;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }
    }
}
.column_container {
    margin: 120px 20px;
    padding: 10px;
    width: 300px;
    max-height: 700px;
    min-height: 100px;
    background-color: rgba(255, 255, 255, .7);
    border-radius: 10px;
    &_header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        min-height: 40px;

        .delete_button {
            background-color: transparent;
            border: none;
            cursor: pointer;
        }
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
