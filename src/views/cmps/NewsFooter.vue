<template>
  <v-card color="yellow">
    <v-row no-gutters class="ma-0 pa-0">
      <v-col md="1">
        <v-icon>mdi-chevron-right</v-icon>
      </v-col>
      <v-col md="10">
        <marquee>
          {{newsItem.strip_text}}
        </marquee>
      </v-col>
      <v-col md="2">

      </v-col>
    </v-row>
  </v-card>
</template>
<script>

export  default {
  props:['newsItem']
}

</script>