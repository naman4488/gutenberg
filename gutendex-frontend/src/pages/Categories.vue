<template>
  <div class="container my-4">
    <h1 class="mb-4 fw-bold">Categories</h1>

    <div class="row">
      <div
        v-for="(category, index) in categories"
        :key="index"
        class="col-md-4 mb-3"
      >
        <RouterLink
          :to="`/books?subject=${encodeURIComponent(category)}`"
          class="text-decoration-none d-block p-2 category-item"
        >
          • {{ category }}
        </RouterLink>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const categories = ref([])

onMounted(async () => {
  try {
    const res = await axios.get('http://127.0.0.1:8000/api/categories')
    categories.value = res.data.categories
  } catch (err) {
    console.error('Category fetch error', err)
  }
})
</script>

<style>
.category-item {
  color: #0d6efd;
  font-size: 1.1rem;
}

.category-item:hover {
  background: #f0f8ff;
  border-radius: 6px;
  padding-left: 10px;
}
</style>
