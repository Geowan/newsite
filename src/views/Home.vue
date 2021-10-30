<template>
  <v-container class="home">
    <v-card v-if="loading">
      <v-progress-circular indeterminate></v-progress-circular>
    </v-card>
    <v-card v-else>
      <v-alert v-if="news.length === 0" type="error"> Currently there are no added news yet</v-alert>
      <v-card v-else>
        <marquee>
          {{newsItem.strip_text}}
        </marquee>

        <v-card-text>
          <v-row>
            <v-col md="8">


              <v-card v-if="showImage">
                <v-card-text v-if="!index">
                  <v-img
                      height="400"
                      :src="newsItem.images.replace('\n','').replace(/\s/g, '').split(',')[0]"/>

                </v-card-text>
                <v-card-text v-else>

                  <vue-gallery-slideshow :images="newsItem.images.replace('\n','').replace(/\s/g, '').split(',')"
                                         :index="index" @close="index = null" />

                </v-card-text>
              </v-card>
              <v-card v-else>
                <v-card-text>
                  <app-video-player :url="videoUrl"/>
                </v-card-text>

              </v-card>


            </v-col>
            <v-col md="4">

              <h3>
                {{newsItem.title}}
              </h3>

              <p>
                {{newsItem.subtitle}}
              </p>
            </v-col>
          </v-row>


        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-btn @click="index=1; showImage=true" small class="text-none" outlined>Full image slide show</v-btn>
          <v-btn @click="loadVideo(0)" small class="text-none" outlined>Video break 1</v-btn>
          <v-btn @click="loadVideo(1)" small class="text-none" outlined>Video break 2</v-btn>
          <v-spacer></v-spacer>
          <v-btn small outlined v-if="step > 1" @click="back()"><v-icon left>mdi-arrow-left</v-icon> Back</v-btn>
          <v-btn v-if="step !== news.length" small outlined @click="next()">Next  <v-icon right>mdi-arrow-right</v-icon></v-btn>
        </v-card-actions>
      </v-card>
    </v-card>

  </v-container>
</template>

<script>
// @ is an alias to /src
import axios from "axios";
import VueGallerySlideshow from 'vue-gallery-slideshow';
import AppVideoPlayer from "./AppVideoPlayer";
export default {
  name: 'Home',
  data:()=>({
    news:[],
    step:1,
    strip_text:'',
    index:null,
    showImage:true,
    video:0,
    videoUrl:'',
    loading:false

  }),
  components:{
    VueGallerySlideshow,
    AppVideoPlayer
  },
  methods:{
    back(){
      this.loading = true;
      setTimeout(()=>{
        this.loading = false;
        this.showImage = true;
        this.step --;
      },500)
    },
    next(){
      this.loading = true;
      setTimeout(()=>{
        this.loading = false;
        this.showImage = true;
        this.step ++;
      },500)
    },
    loadVideo(index){
      this.showImage = true;
      setTimeout(()=>{
        this.showImage = false;
        this.videoUrl = this.newsItem.videos.split(',')[index];
      },100)
    }
  },
  computed:{
    newsItem(){
      return this.news[this.step -1];
    }
  },
  mounted() {
    axios
        .get('https://newsite.soradius.com/data.php')
        .then(response => this.news = response.data)
  }
}
</script>
