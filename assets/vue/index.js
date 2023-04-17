import { createApp } from 'vue'
import Vue3EasyDataTable from 'vue3-easy-data-table'
import Fruits from './Components/Fruits.vue'
import Favourites from './Components/Favourites.vue'

const app = createApp({
  components: {
    Fruits,
    Favourites
  }
})
// app.component('EasyDataTable', Vue3EasyDataTable)
app.mount('#app')
