<template>
  <div>
    <!-- Global Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-4">
      <div class="container">
        <RouterLink class="navbar-brand fw-bold" to="/">
          GutenDex Explorer
        </RouterLink>

        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">

            <li class="nav-item">
              <RouterLink class="nav-link" active-class="active" to="/">
                Home
              </RouterLink>
            </li>

            <li class="nav-item">
              <RouterLink class="nav-link" active-class="active" to="/books">
                Browse Books
              </RouterLink>
            </li>

            <li class="nav-item">
              <RouterLink class="nav-link" active-class="active" to="/categories">
                Browse Categories
              </RouterLink>
            </li>

            <li class="nav-item">
              <RouterLink class="nav-link" active-class="active" to="/search">
                Search
              </RouterLink>
            </li>

          </ul>
        </div>
      </div>
    </nav>

    <!-- Render Pages -->
    <RouterView />
  </div>
</template>

<script setup>
</script>

<style>
.nav-link.active {
  font-weight: bold;
  color: #0d6efd !important;
}
</style>
