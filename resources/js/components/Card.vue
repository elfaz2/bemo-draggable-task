<template>
  <div>
      <div class="card_container"  v-on:click="$modal.show('detail-card')">
          {{ card.title }}
      </div>
      <Modal class="detail-modal" name="detail-card">
          <div class="detail_card_section">
              <div class="header_section">
                  <label>Card Detail</label>
                  <button  @click="$modal.hide('detail-card')">X</button>
              </div>
              <div class="detail_section">
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
                  <button @click="updateCard">
                      Update
                  </button>
              </div>
          </div>
      </Modal>
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
    },
    data() {
        return {
            titleRequired: false,
            descriptionRequired: false,
            form: {
                title: "",
                description: "",
            },
        }
    },
    mounted() {
        this.form.title = this.card.title
        this.form.description = this.card.description
    },
    methods: {
        async updateCard() {
            if(this.form.title !== "" && this.form.description !== "") {
                await axios.put(`/api/card/${this.card.id}`, this.form)
                this.$modal.hide('detail-card')
                this.$emit('refresh', true)
            } else  {
                this.titleRequired = !this.form.title;
                this.descriptionRequired = !this.form.description;
            }
        }
    }
}
</script>

<style lang="scss" >
.detail-modal {
    .vm--modal {
        width: 50% !important;
        height: 400px !important;
    }
}
.card_container {
    height: 70px;
    border-radius: 5px;
    box-shadow: 0 3px 10px rgb(0 0 0 / 0.3);
    margin-bottom: 14px;
    cursor: grabbing;
    background-color: rgba(255, 255, 255, .7);
}
.detail_card_section {

    .header_section {
        background-color: rgba(0, 0, 0, .3);
        height: 50px;
        padding: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .detail_section {
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
</style>
