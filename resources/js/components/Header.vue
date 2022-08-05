<template>
   <div class="nav">
       <div class="logo_section">Logo</div>
       <div class="nav_actions">
           <div>
               Include Deleted
               <input class="deleted_filter" type="checkbox"/>
           </div>
           <div>
               Filer by Date: <br>
               <input class="date_filter" type="date"/>
           </div>
           <button class="export_button">
               Export
           </button>
       </div>
   </div>
</template>

<script>
export default {
    name: "Header"
}
</script>

<style lang="scss" scoped>

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
</style>
