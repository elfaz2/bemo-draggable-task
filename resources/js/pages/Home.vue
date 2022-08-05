<template>
    <div class="home_section">
        <Header/>
        <Column v-for="(column, index) in columns" :key="index" :column="column" @refresh="fetchColumns"/>
        <div class="add_column_container" @click="$modal.show('add-column')">
            Add Column
        </div>
        <Modal class="create_column_modal" name="add-column">
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
                    <button @click="createColumn">
                        Submit
                    </button>
                </div>
            </div>
        </Modal>
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
            columns: [],
            titleRequired: false,
            form: {
                title: ""
            }
        };
    },
    async mounted() {
        await this.fetchColumns()
    },
    methods: {
        async fetchColumns() {
            const { data } = await axios.get('/api/columns')
            this.columns = data.data
        },
        async createColumn() {
            if(this.form.title !== "") {
                await axios.post('/api/column', this.form)
                this.$modal.hide('add-column')
                await this.fetchColumns()
            } else {
                this.titleRequired = true
            }
        }
    }
}
</script>

<style lang="scss">
.create_column_modal {
    .vm--modal {
        width: 50% !important;
        height: 250px !important;
    }
}
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
    .create_column_section {
        .header_section {
            background-color: rgba(0, 0, 0, .3);
            height: 50px;
            padding-top: 20px;
            padding-left: 20px;
        }

        .form_section {
            padding: 20px;
            .required_field {
                color: red;
            }
            input {
                height: 30px;
            }
            input, textarea {
                width: 100%;
                border: 1px solid black;
                border-radius: 5px;
                margin-top: 10px;
            }
            button {
                width: 70px;
                height: 35px;
                background-color: cornflowerblue;
                border-radius: 5px;
                color: white;
                position: absolute;
                bottom: 10px;
                left: 10px;
                cursor: pointer;
            }
        }
    }
}
</style>
