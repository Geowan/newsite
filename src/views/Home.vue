<template>
  <v-container class="home">
    <v-card v-if="loading">
      <v-progress-circular indeterminate></v-progress-circular>
    </v-card>
    <v-card @keydown.esc="onEsc()" v-else>
      <v-alert v-if="news.length === 0" type="error"> Currently there are no added news yet</v-alert>
      <v-card v-else>
        <v-card-text>
          <v-row>
            <v-col md="5">
              <breaking-news></breaking-news>

              <v-card v-if="showImage">
                <v-card-text v-if="!index">
                  <v-img
                      height="400"
                      :src="newsItem.images.replace('\n','').replace(/\s/g, '').split(',')[0]"/>

                </v-card-text>
                <v-card-text v-else>

                  <vue-gallery-slideshow :images="galleryImages"
                                         :index="index" @close="index = null" />

                </v-card-text>
              </v-card>

              <v-card v-else dark color="#ce3b3b">
                <p>
                  {{newsItem.title}}
                </p>


                <p>
                  {{newsItem.subtitle}}
                </p>
              </v-card>




            </v-col>
            <v-col md="7">

              <app-video-player :url="videoUrl"/>
            </v-col>
          </v-row>

          <news-footer :news-item="newsItem"></news-footer>

        </v-card-text>
        <div></div>
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
import VueGallerySlideshow from "./cmps/ImageGallery.vue";

import AppVideoPlayer from "./AppVideoPlayer";
import BreakingNews from "./cmps/BreakingNews";
import NewsFooter from "./cmps/NewsFooter";
export default {
  name: 'Home',
  data:()=>({
    news:[],
    step:1,
    strip_text:'',
    index:null,
    showImage:false,
    video:0,
    videoUrl:'',
    loading:false

  }),
  components:{
    BreakingNews,
    VueGallerySlideshow,
    NewsFooter,
    AppVideoPlayer
  },
  created(){
    document.addEventListener('keyup',  (evt)=> {
      if (evt.keyCode === 27) {
        this.index = null;
        this.showImage = false;
      }
    });
  },
  methods:{

    back(){
    //  this.loading = true;
      setTimeout(()=>{
        this.loading = false;
        this.showImage = true;
        this.step --;
      },10)
    },
    next(){
      //this.loading = true;
      setTimeout(()=>{
        this.loading = false;
        this.showImage = true;
        this.step ++;
      },10)
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
    },
    galleryImages(){
      return this.news[this.step -1].images.replace('\n','')
          .replace(/\s/g, '').split(',').map((item,key)=>{
            return {
              id:key+1,
              imgSrc:item
            }
          });
    }
  },
  mounted() {
    this.loading = true;
    axios
        //.get('http://127.0.0.1:8096')
        .get('https://newsite.soradius.com/data.php')
        .then((response)=>{
          this.loading = false;
          this.news = response.data
        })
  }
}
</script>
