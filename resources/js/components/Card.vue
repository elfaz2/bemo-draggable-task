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
                       <h3> {{ card.title }} </h3>
                  </div>
                  <br>
                  <div>
                      Description:
                      <p> {{card.description }}</p>
                  </div>
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
    }
}
</script>

<style lang="scss" scoped>
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
        p, h3 {
            margin-top: 2px;
            margin-left: 20px;
        }
    }
}
</style>
