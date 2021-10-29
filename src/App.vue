<template>
  <v-app id="app">
    <v-container>
      <v-toolbar dense>
        News site
        <v-spacer></v-spacer>
        <v-btn class="mr-6" text to="/">News</v-btn>
        <v-btn text to="/add">Add</v-btn>
      </v-toolbar>

      <router-view/>
    </v-container>

  </v-app>
</template>

<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#nav {
  padding: 30px;

  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>
