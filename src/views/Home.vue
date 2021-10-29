<template>
  <v-container class="home">
   <v-alert v-if="news.length === 0" type="error"> Currently there are no added news yet</v-alert>
    <v-card v-else>
      News details
    </v-card>
  </v-container>
</template>

<script>
// @ is an alias to /src

export default {
  name: 'Home',
  data:()=>({
    news:[]
  }),
  mounted() {
    this.news  = JSON.parse(localStorage.getItem("news") || "[]");

  }
}
</script>
