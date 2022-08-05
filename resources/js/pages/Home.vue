<template>
    <div class="home_section">
        <div class="nav">
            <div class="logo_section">Logo</div>
            <div class="nav_actions">
                <div>
                    Access Token:
                    <input v-model="filter.access_token" @change="fetchColumns" class="date_filter" type=""/>
                </div>
                <div>
                    Include Deleted
                    <input v-model="filter.deleted" @change="fetchColumns" class="deleted_filter" type="checkbox"/>
                </div>
                <div>
                    Filer by Date: <br>
                    <input v-model="filter.date" @change="fetchColumns" class="date_filter" type="date"/>
                </div>
                <button class="export_button" @click="exportDb">
                    Export
                </button>
            </div>
        </div>
        <Column v-for="column in columns" :key="column.id" :column="column" @refresh="fetchColumns"/>
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
            filter: {
                deleted: 0,
                date: "null",
                access_token: "42gA1S5"
            },
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
            const { data } = await axios.get(`/api/columns/${this.filter.access_token}/${this.filter.date?this.filter.date: "null"}/${this.filter.deleted}`)
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
        },
        async exportDb() {
            await axios.get('/api/export-db').then(function (r) {
                const url = window.URL.createObjectURL(new Blob([r.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'exported.sql'); //or any other extension
                document.body.appendChild(link);
                link.click();

                //hide loader
                i.loader = false
            });

        }
    }
}
</script>

<style lang="scss">
.disabled {
    cursor: not-allowed;
    opacity: 0.8;
}
.nav {
    position: fixed;
    width: 100%;
    height: 70px;
    background-color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;

    .logo_section {
        padding-left: 10px;
    }

    .nav_actions {
        display: flex;
        flex-direction: row;
        gap: 30px;
        padding-right: 10px;

        div {
            display: flex;
            align-items: center;
        }
    }
    .export_button {
        color: white;
        background: #24a0ed;
        width: 80px;
        height: 30px;
        border-radius: 10px;
        cursor: pointer;
    }
    .date_filter {
        height: 30px;
        border: 1px solid grey;
        border-radius: 5px;
    }
    .deleted_filter {
    }
}
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
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
