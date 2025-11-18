<template>
  <div class="container py-4">

    <h1 class="mb-4 fw-bold">Browse Books</h1>

    <!-- FILTERS PANEL -->
    <div class="card p-4 mb-4 shadow-sm">

      <!-- Title Filter -->
      <div class="row g-3">

        <div class="col-md-6">
          <label class="fw-semibold mb-1">Search by Title</label>
          <input v-model="filters.title" class="form-control" placeholder="Enter book title...">
        </div>

        <!-- Author Filter -->
        <div class="col-md-6">
          <label class="fw-semibold mb-1">Author</label>
          <input v-model="filters.author" class="form-control" placeholder="Author name...">
        </div>

        <!-- Subject Filter -->
        <div class="col-md-6">
          <label class="fw-semibold mb-1">Subject</label>
          <input v-model="filters.subject" class="form-control" placeholder="Subject keyword...">
        </div>

        <!-- Bookshelf Filter -->
        <div class="col-md-6">
          <label class="fw-semibold mb-1">Bookshelf</label>
          <input v-model="filters.bookshelf" class="form-control" placeholder="Bookshelf name...">
        </div>

        <!-- Language Filter -->
        <div class="col-md-6">
          <label class="fw-semibold mb-1">Language</label>
          <select v-model="filters.language" class="form-select">
            <option value="">All Languages</option>
            <option v-for="lang in languageList" :key="lang" :value="lang">
              {{ lang }}
            </option>
          </select>
        </div>

        <!-- Format Filter -->
        <div class="col-md-6">
          <label class="fw-semibold mb-1">Format</label>
          <select v-model="filters.format" class="form-select">
            <option value="">All Formats</option>
            <option value="text/plain">Plain Text</option>
            <option value="application/pdf">PDF</option>
            <option value="text/html">HTML</option>
            <option value="image/jpeg">Images</option>
          </select>
        </div>

        <div class="col-md-3">
          <label class="fw-semibold">Sort By</label>
          <select v-model="filters.sort" class="form-select">
            <option value="">Default</option>
            <option value="title_asc">Title A → Z</option>
            <option value="title_desc">Title Z → A</option>
            <option value="downloads_desc">Downloads High → Low</option>
            <option value="downloads_asc">Downloads Low → High</option>
          </select>
        </div>

      </div>

      <!-- Action Buttons -->
      <div class="mt-4 d-flex gap-2">
        <button class="btn btn-primary px-4" @click="applyFilters">Apply Filters</button>
        <button class="btn btn-secondary px-4" @click="resetFilters">Reset</button>
      </div>

    </div>

    <div v-if="loading" class="text-center my-4">
  <div class="spinner-border text-primary" role="status"></div>
  <p class="mt-2 fw-semibold">Loading books...</p>
</div>

    <!-- BOOK CARDS -->
    <div class="row g-4">
      <div v-for="book in books" :key="book.id" class="col-md-4">
        <div class="card shadow-sm p-4 h-100">

          <h5 class="fw-bold">{{ book.title }}</h5>

          <p class="text-muted small mb-2">
            Downloads: <strong>{{ book.download_count ?? 'N/A' }}</strong>
          </p>

          <button class="btn btn-primary mt-auto" @click="viewDetails(book.id)">
            View Details
          </button>
        </div>
      </div>
    </div>

    <!-- PAGINATION -->
    <nav v-if="meta.total > 0" class="d-flex justify-content-center my-4">

      <ul class="pagination">
        
        <!-- Prev Button -->
        <li class="page-item" :class="{ disabled: !links.prev }">
          <button class="page-link" @click="changePage(meta.current_page - 1)" :disabled="!links.prev">
            Prev
          </button>
        </li>

        <!-- First Page -->
        <li class="page-item" :class="{ active: meta.current_page === 1 }">
          <button class="page-link" @click="changePage(1)">1</button>
        </li>

        <!-- Dots before -->
        <li v-if="meta.current_page > 4" class="page-item disabled">
          <span class="page-link">…</span>
        </li>

        <!-- Middle Pages -->
        <li v-for="page in middlePages" :key="page"
            class="page-item"
            :class="{ active: meta.current_page === page }">
          <button class="page-link" @click="changePage(page)">
            {{ page }}
          </button>
        </li>

        <!-- Dots after -->
        <li v-if="meta.current_page < meta.last_page - 3" class="page-item disabled">
          <span class="page-link">…</span>
        </li>

        <!-- Last Page -->
        <li class="page-item" :class="{ active: meta.current_page === meta.last_page }">
          <button class="page-link" @click="changePage(meta.last_page)">
            {{ meta.last_page }}
          </button>
        </li>

        <!-- Next Button -->
        <li class="page-item" :class="{ disabled: !links.next }">
          <button class="page-link" @click="changePage(meta.current_page + 1)" :disabled="!links.next">
            Next
          </button>
        </li>

      </ul>

    </nav>


  </div>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from "vue";
import axios from "axios";
import { useRouter, useRoute } from "vue-router";
import api from '../services/api'

const router = useRouter();
const route = useRoute()

const books = ref([]);
const meta = reactive({
  current_page: 1,
  per_page: 21,
  total: 0,
});
const links = reactive({
  next: null,
  prev: null,
});

// ALL FILTER VARIABLES
const filters = reactive({
  title: "",
  author: "",
  subject: route.query.subject || "",
  bookshelf: "",
  language: "",
  format: "",
  sort: "",   // ⭐ sorting added here
});


// LANGUAGE DROPDOWN LIST (from your DB)
const languageList = ["en", "fr", "de", "es", "it"];

const fetchBooks = async (page = 1) => {
  
  const params = { page };

  // SEND ONLY NON-EMPTY FILTERS
  Object.keys(filters).forEach(key => {
    if (filters[key] !== "" && filters[key] !== null) {
      params[key] = filters[key];
    }
  });


  const res = await axios.get("http://127.0.0.1:8000/api/books", { params });

  books.value = res.data.data;
  Object.assign(meta, res.data.meta);
  Object.assign(links, res.data.links);
};

const applyFilters = () => fetchBooks(1);

const resetFilters = () => {
  filters.title = "";
  filters.author = "";
  filters.subject = "";
  filters.bookshelf = "";
  filters.language = "";
  filters.format = "";
  fetchBooks(1);
};

const middlePages = computed(() => {
  const pages = [];
  const current = meta.current_page;
  const last = meta.last_page;

  const start = Math.max(2, current - 2);
  const end = Math.min(last - 1, current + 2);

  for (let i = start; i <= end; i++) {
    pages.push(i);
  }

  return pages;
});


const changePage = (page) => {
  if (page < 1 || page > meta.last_page) return;
  fetchBooks(page);
};


const goToPage = (page) => {
  if (page >= 1 && page <= totalPages.value) fetchBooks(page);
};

const totalPages = computed(() =>
  Math.ceil(meta.total / meta.per_page)
);

const viewDetails = (id) => {
  router.push(`/books/${id}`);
};

onMounted(() => fetchBooks(1));
</script>

<style scoped>
.card:hover {
  transform: translateY(-4px);
  transition: 0.2s;
}
</style>
