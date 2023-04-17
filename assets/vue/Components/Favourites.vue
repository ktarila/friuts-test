<template>
  <h2>Favourite Fruits</h2>
  <Vue3EasyDataTable
    buttons-pagination
    :headers="headers"
    :items="fruits"
    :rows-per-page="10"
  >
    <template #item-action="item">
      <button
        class="btn btn-danger m-1 btn-sm"
        v-if="item.favouriteFruit"
        @click="removeFromFavourites(item)"
      >
        Remove from favourites
      </button>
    </template>
  </Vue3EasyDataTable>
</template>

<script>
import { defineComponent } from 'vue'
import Vue3EasyDataTable from 'vue3-easy-data-table'

export default defineComponent({
  components: {
    Vue3EasyDataTable
  },
  data () {
    return {
      headers: [
        { text: 'Name', value: 'name', sortable: true },
        { text: 'Calories', value: 'nutritions.calories', sortable: true },
        { text: 'Fat', value: 'nutritions.fat', sortable: true },
        { text: 'Sugar', value: 'nutritions.sugar', sortable: true },
        { text: 'Carbohydrates', value: 'nutritions.carbohydrates' },
        { text: 'Protein', value: 'nutritions.protein' },
        { text: 'action', value: 'action' }
      ],

      fruits: []
    }
  },

  async mounted () {
    const response = await fetch('/api/fruit/favourites/')
    const fruits = await response.json()
    this.fruits = fruits
  },

  methods: {
    async addToFavourites (fruit) {
      const postUrl = '/api/favourite-fruit/add/' + fruit.id
      const response = await fetch(postUrl, {
        method: 'POST'
      })
      const favFruit = await response.json()
      this.updateFruit(favFruit)
    },

    async removeFromFavourites (fruit) {
      const postUrl = '/api/favourite-fruit/remove/' + fruit.id
      const response = await fetch(postUrl, {
        method: 'POST'
      })
      const favFruit = await response.json()
      this.updateFruit(favFruit)
    },

    updateFruit (fruit) {
      for (let i = this.fruits.length - 1; i >= 0; i--) {
        if (this.fruits[i].id == fruit.id) {
          this.fruits.splice(i, 1)
          return
        }
      }
    }
  }
})
</script>

<!-- <style src="vue3-easy-data-table/dist/style.css"></style> -->
