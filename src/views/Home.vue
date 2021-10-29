<template>
  <v-container class="home">
   <v-alert v-if="news.length === 0" type="error"> Currently there are no added news yet</v-alert>
    <v-card v-else>
      <marquee>
        {{strip_text}}
      </marquee>
      <v-card-text>
        {{newsItem}}
      </v-card-text>
      <v-divider></v-divider>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn small outlined v-if="step > 1" @click="step--"><v-icon left>mdi-arrow-left</v-icon> Back</v-btn>
        <v-btn v-if="step !== news.length" small outlined @click="step++">Next  <v-icon right>mdi-arrow-right</v-icon></v-btn>
      </v-card-actions>
    </v-card>
  </v-container>
</template>

<script>
// @ is an alias to /src

export default {
  name: 'Home',
  data:()=>({
    news:[],
    step:1,
    strip_text:''
  }),
  computed:{
    newsItem(){
      return this.news[this.step -1];
    }
  },
  mounted() {
    this.news  = JSON.parse(localStorage.getItem("news") || "[]");
    this.strip_text = localStorage.getItem('strip_text');
  }
}
</script>
