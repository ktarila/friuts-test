<template>
  <h2>Fruits</h2>
  <div class="seach-form mb-1">
    <h5>Search Fruits</h5>
    <div class="row">
      <div class="col-4">
        <input
          placeholder="Fruit name"
          class="form-control"
          v-model="nameCriteria"
        />
      </div>
      <div class="col-4 ml-2">
        <input
          placeholder="Fruit family"
          class="form-control"
          v-model="familyCriteria"
        />
      </div>
    </div>
  </div>

  <Vue3EasyDataTable
    buttons-pagination
    :headers="headers"
    :items="fruits"
    :rows-per-page="10"
    :filter-options="filterOptions"
  >
    <template #item-action="item">
      <button
        class="btn btn-danger m-1 btn-sm"
        v-if="item.favouriteFruit"
        @click="removeFromFavourites(item)"
      >
        Remove {{ item.name }} from favourites
      </button>
      <button
        class="btn btn-primary m-1 btn-sm"
        v-else
        @click="addToFavourites(item)"
      >
        Add {{ item.name }} to favourites
      </button>
    </template>
  </Vue3EasyDataTable>
</template>

<script>
import { defineComponent } from 'vue'
import Vue3EasyDataTable from 'vue3-easy-data-table'
const stringSimilarity = require('string-similarity')

export default defineComponent({
  components: {
    Vue3EasyDataTable
  },
  data () {
    return {
      nameCriteria: '',
      familyCriteria: '',
      headers: [
        { text: 'Name', value: 'name', sortable: false },
        { text: 'Family', value: 'family', sortable: true },
        { text: 'Order', value: 'fruitOrder', sortable: true },
        { text: 'Genus', value: 'genus', sortable: true },
        { text: 'Calories', value: 'nutritions.calories', sortable: true },
        { text: 'Fat', value: 'nutritions.fat', sortable: true },
        { text: 'Sugar', value: 'nutritions.sugar', sortable: true },
        { text: 'Carbohydrates', value: 'nutritions.carbohydrates' },
        { text: 'Protein', value: 'nutritions.protein' },
        { text: 'Action', value: 'action' }
      ],

      fruits: []
    }
  },

  mounted () {
    this.getFruits()
  },
  computed: {
    filterOptions () {
      const filterOptionsArray = []
      filterOptionsArray.push({
        field: 'name',
        criteria: this.nameCriteria,
        comparison: (value, criteria) => {
          if (criteria == null || criteria == '') {
            return true
          }
          return stringSimilarity.compareTwoStrings(value, criteria) > 0.4
        }
      })
      filterOptionsArray.push({
        field: 'family',
        criteria: this.familyCriteria,
        comparison: (value, criteria) => {
          if (criteria == null || criteria == '') {
            return true
          }
          return stringSimilarity.compareTwoStrings(value, criteria) > 0.4
        }
      })
      return filterOptionsArray
    }
  },

  methods: {
    async getFruits () {
      const response = await fetch('/api/fruit/')
      const fruits = await response.json()
      this.fruits = fruits
    },

    async addToFavourites (fruit) {
      const postUrl = '/api/favourite-fruit/add/' + fruit.id
      const response = await fetch(postUrl, {
        method: 'POST'
      })
      const favFruit = await response.json()
      this.getFruits()
      // this.updateFruit(favFruit)
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
          this.fruits[i].favouriteFruit = fruit.favouriteFruit
          return
        }
      }
    }
  }
})
</script>

<!-- <style src="vue3-easy-data-table/dist/style.css"></style> -->
