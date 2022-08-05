<template>
    <div class="column_container" :class="column.deleted_at ? 'deleted_column': ''">
        <div class="column_container_header">
            <label>
               {{column.title}}
            </label>
            <button v-if="!column.deleted_at" class="delete_button" @click="$modal.show(`delete-column-${column.id}`)">
                <img :src="deleteIcon" alt="Delete Column Icon">
            </button>
        </div>
        <draggable
            class="dragArea list-group"
            :list="column.cards"
            :animation="200"
            ghost-class="ghost"
            group="cards"
            @end="updateCardPosition"
        >
            <card v-for="card in column.cards" :key="card.id" :card="card" @refresh="refresh"/>
        </draggable>
        <div v-if="!column.deleted_at" class="add_card_container" @click="$modal.show(`add-card-${column.id}`)">
            Add Card
        </div>
        <Modal class="delete-modal" :name="`delete-column-${column.id}`">
            <div class="delete_column_section">
                <div class="header_section">
                    Are you sure you want to delete
                </div>
                <button @click="deleteColumn">
                    Yes
                </button>
            </div>
        </Modal>
        <Modal class="create_card_modal" :name="`add-card-${column.id}`">
            <div class="create_column_section">
                <div class="header_section">
                   <label> Create Card.</label>
                    <button  @click="$modal.hide(`add-card-${column.id}`)">X</button>
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
        },
        columns: {

        }
    },
    components: {
        Card,
        draggable
    },
    watch: {
        column: {
            handler(val){
                this.cardsLen = val.cards.length
            },
            deep: true
        },
        cardsLen(val) {
            this.updateCardPosition()
        }
    },
    data() {
        return {
            cardsLen: this.column.cards.length,
            titleRequired: false,
            descriptionRequired: false,
            col_id: "",
            form: {
              title: "",
              description: "",
              columnId: this.column.id
            },
            deleteIcon: require('../../assets/delete-icon.svg'),
            controlOnStart: true
        };
    },
    methods: {
        async deleteColumn() {
            await axios.delete(`/api/column/${ this.column.id }`)
            this.$modal.hide(`delete-column-${ this.column.id }`)
            this.refresh()
        },
        async createCard() {
            if(this.form.title !== "" && this.form.description !== "") {
                this.form.columnId = this.column.id
                await axios.post(`/api/card`, this.form)
                this.$modal.hide(`add-card-${this.column.id}`)
                this.refresh()
            } else  {
                this.titleRequired = !this.form.title;
                this.descriptionRequired = !this.form.description;
            }
        },
        async updateCardPosition() {
            const { cards, id } =  this.column
            await axios.post('/api/update-card-position/', { cards, column_id: id })
        },
        refresh() {
            this.$emit('refresh', true)
            this.form.title = this.form.description = ""
        }
    }
}
</script>

<style lang="scss">
.deleted_column {
    background-color: rgba(255, 22, 22, 0.2) !important;
    cursor: not-allowed;
}
.ghost {
    opacity: 0.5;
    background: #F7FAFC;
    border: 1px solid #4299e1;
}
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
    overflow-y: scroll;
    &_header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 300px;
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

        .header_section {
            background-color: rgba(0, 0, 0, .3);
            height: 50px;
            padding-top: 20px;
            padding-left: 20px;
        }
    }
}
</style>
