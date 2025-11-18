<template>
  <div class="home-container container text-center">

    <!-- Title -->
    <h1 class="fw-bold mb-3">Gutendex Book Explorer</h1>
    <p class="text-muted mb-4">
      Discover thousands of free public-domain eBooks from Project Gutenberg.
    </p>

    <!-- Navigation Buttons -->
    <div class="row justify-content-center mb-4">
      <div class="col-md-4 mb-2">
        <button 
          class="btn btn-primary w-100 py-3 fw-semibold"
          @click="goToBooks"
        >
          📚 Browse Books
        </button>
      </div>
      <div class="col-md-4 mb-2">
        <button 
          class="btn btn-secondary w-100 py-3 fw-semibold"
          @click="goToCategories"
        >
          📂 Browse Categories
        </button>
      </div>
    </div>

    <!-- Search Box -->
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="input-group input-group-lg">
          <input
            v-model="query"
            type="text"
            class="form-control"
            placeholder="Search Books or Authors"
            @keyup.enter="search"
          />
          <button class="btn btn-outline-primary" @click="search">
            🔍
          </button>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const query = ref("");

// Navigate to Books Page
function goToBooks() {
  router.push("/books");
}

// Navigate to Categories Page
function goToCategories() {
  router.push("/categories");
}

// Search Books
function search() {
  if (!query.value.trim()) return;
  router.push(`/search?q=${query.value}`);
}
</script>

<style scoped>
.home-container {
  min-height: 85vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
}
</style>
