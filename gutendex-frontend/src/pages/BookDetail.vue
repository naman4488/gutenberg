<template>
  <div class="container py-5">
    <div v-if="loading">Loading...</div>

    <div v-else>
      <h2>{{ book.title }}</h2>
      <p class="text-muted">Downloads: {{ book.download_count }}</p>

      <h4 class="mt-3">Authors:</h4>
      <ul>
        <li v-for="a in book.authors" :key="a.id">{{ a }}</li>
      </ul>

      <h4 class="mt-4">Related Books:</h4>
      <ul>
        <li v-for="b in related" :key="b.id">
          <router-link :to="`/books/${b.id}`">{{ b.title }}</router-link>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
    import { ref, onMounted, watch } from 'vue'
    import { useRoute } from 'vue-router'
    import api from '../services/api'

    const route = useRoute()

    const book = ref(null)
    const related = ref([])
    const loading = ref(true)

    const fetchBookDetail = async () => {
        loading.value = true

        const id = route.params.id

        const bookRes = await api.getBook(id)
        book.value = bookRes.data.data

        const relatedRes = await api.getRelatedBooks(id)
        related.value = relatedRes.data.data

        loading.value = false
    }

    onMounted(() => {
        fetchBookDetail()
    })

    watch(() => route.params.id, (newId) => {
        console.log(newId, "newid");
        fetchBookDetail()
        window.scrollTo({ top: 0, behavior: "smooth" });
    });

</script>