<template>
  <div class="container mt-5">

    <h1>Search Books</h1>

    <div class="input-group mb-4">
      <input
        v-model="query"
        class="form-control"
        placeholder="Search by title or author"
      />
      <button class="btn btn-primary" @click="searchBooks">Search</button>
    </div>

    <div v-if="loading">Searching...</div>

    <div v-if="authors.length || titles.length">

      <h3>Matching Authors</h3>
      <ul>
        <li v-for="a in authors" :key="a">{{ a }}</li>
      </ul>

      <h3 class="mt-4">Matching Titles</h3>
      <ul>
        <li v-for="t in titles" :key="t">{{ t }}</li>
      </ul>

    </div>

    <div v-else-if="!loading && query">No results found.</div>

  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const query = ref('')
const authors = ref([])
const titles = ref([])
const loading = ref(false)

async function searchBooks() {
  if (!query.value.trim()) return

  loading.value = true
  const res = await axios.get(`http://127.0.0.1:8000/api/search?q=${query.value}`)

  authors.value = res.data.authors
  titles.value = res.data.titles

  loading.value = false
}
</script>
