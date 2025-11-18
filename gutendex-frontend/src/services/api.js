import axios from 'axios'

const API = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
})

export default {
  getBooks(params = {}) {
    return API.get('/books', { params })
  },

  getBook(id) {
    return API.get(`/books/${id}`)
  },

  getRelatedBooks(id) {
    return API.get(`/books/${id}/related`)
  },

  searchBooks(query) {
    return API.get('/search', { params: { q: query } })
  },

  getCategories() {
    return API.get('/categories')
  },
}
