<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <nuxt-link to="/" class="navbar-brand">Frontend</nuxt-link>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <nuxt-link to="/" class="nav-link active" aria-current="page"
              >Home</nuxt-link
            >
          </li>
          <li class="nav-item">
            <nuxt-link to="/topics" class="nav-link active" aria-current="page"
              >Topics</nuxt-link
            >
          </li>
          <li class="nav-item">
            <nuxt-link to="/create" class="nav-link" aria-current="page"
              >Create</nuxt-link
            >
          </li>
        </ul>
        <form class="d-flex">
          <input
            class="form-control me-2"
            type="search"
            placeholder="Search"
            aria-label="Search"
          />
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>

        <template v-if="!authenticated">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <nuxt-link to="/login" class="nav-link" aria-current="page"
                >Login</nuxt-link
              >
            </li>
            <li class="nav-item">
              <nuxt-link to="/register" class="nav-link" aria-current="page"
                >Register</nuxt-link
              >
            </li>
          </ul>
        </template>
        <template v-if="authenticated">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" aria-current="page">{{ user.name }}</a>
            </li>
            <li class="nav-item">
              <a @click.prevent="logout" class="nav-link" aria-current="page"
                >Logout</a
              >
            </li>
          </ul>
        </template>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  methods: {
    logout() {
      this.$auth.logout();
    }
  }
};
</script>
