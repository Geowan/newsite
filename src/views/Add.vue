<template>
  <v-container>
    <v-card class="about">
      <v-toolbar>
        Add a news text
      </v-toolbar>
      <v-card-text>
        step at:
        {{currentStep}}
        <v-form ref="form" v-model="validForm" lazy-validation>
          <v-row>
            <v-col md="2">
              <h3>  News no {{totalNews+1}}</h3>
            </v-col>
            <v-col md="10">
              <v-text-field :rules="requiredRule" outlined dense v-model="strip_text" label="News Strip text"/>
            </v-col>
          </v-row>
          <v-row>
            <v-col md="12">
              <v-text-field :rules="requiredRule" outlined dense v-model="form.title" label="News title"/>
            </v-col>
            <v-col md="12">
              <v-text-field :rules="requiredRule" outlined dense v-model="form.subtitle" label="News subtitle"/>
            </v-col>
            <v-col md="12">
              <v-row>
                <v-col md="6">
                  <v-textarea v-model="form.images" :rules="requiredRule" outlined dense label="Paste image links here separated by a comma"></v-textarea>
                </v-col>
                <v-col md="6">
                  <v-card class="pa-3 mb-0 pb-0" v-for="(video,key) in form.videos" :key="key">
                    <v-row>
                      <v-col md="8">
                        <v-text-field :rules="requiredRule" outlined dense v-model="video.url" label="Video url"/>
                      </v-col>
                      <v-col md="4" class="d-flex ma-0 pa-0">
                        <v-btn @click="form.videos.push({url:''})" text :ripple="false"><v-icon>mdi-plus</v-icon></v-btn>
                        <v-btn text :ripple="false" @click="form.videos.splice(form.videos.indexOf(video),1)"
                               v-if="form.videos.length >0"><v-icon>mdi-close</v-icon></v-btn>
                      </v-col>
                    </v-row>
                  </v-card>
                </v-col>
              </v-row>
            </v-col>
          </v-row>

        </v-form>
       </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="primary" small @click="saveDataM()">{{currentStep != null?'Update':'Save'}} News</v-btn>
        <v-btn class="mr-2" small outlined @click="reset()">Reset data</v-btn>

        <v-btn small outlined :disabled="totalNews.length === 0 || !currentStep" @click="onBack()">Back</v-btn>
        <v-btn small outlined @click="onNext()">Next</v-btn>

        <v-btn small outlined @click="onFirst()">First</v-btn>
        <v-btn small outlined @click="onLast()">Last</v-btn>

        <v-btn small outlined @click="emptyDb()">Empty database</v-btn>
        <v-spacer></v-spacer>

      </v-card-actions>

    </v-card>
  </v-container>

</template>
<script>
import {openDB} from "idb";
import axios from "axios";

export default {
  data:()=>({
    form:{
      id:'',
      title:'',
      subtitle:'',
      images:'',
      videos:[{url:''}]
    },
    news:[],
    currentStep:null,
    requiredRule: [
      v => !!v || 'This is required',
    ],
    validForm:true,
    strip_text:'',
    totalNews:0
  }),
  mounted(){
    this.getFormData();
  },
  methods:{
    reset(){
      this.form.title = "";
      this.form.images = '';
      this.form.subtitle  = '';
      this.form.videos = [{url:''}];
      this.strip_text = '';

    },
    onFirst(){
      this.currentStep = 0;
      this.setFormData();
    },

    onLast(){
      this.currentStep = this.news.length;
      this.setFormData();
    },

    onNext(){
      if(!this.currentStep){
        this.currentStep = 0;
        return;
      }
      if(this.currentStep !== this.news.length){
        this.currentStep ++;
        this.setFormData();
      }


    },

    onBack(){
      if(!this.currentStep){
        return;
      }
      if(this.currentStep !== 0){
        this.currentStep --;
        this.setFormData();
      }
    },

    emptyDb(){

      var item = confirm("do you want to empty the database");
      if(item){
        axios
            .post('https://newsite.soradius.com/data.php',[]);

        window.location.reload();
      }
    },
    async saveDataM(){
      let valid =  await this.$refs.form.validate();
      if(valid){
        var bodyFormData = new FormData();
        this.form.id = this.news.length + 1;
        bodyFormData.append('title', this.form.title);
        bodyFormData.append('subtitle', this.form.subtitle);
        bodyFormData.append('images', this.form.images);
        bodyFormData.append('id', this.form.id);
        bodyFormData.append('strip_text', this.strip_text);
        bodyFormData.append('videos', this.form.videos.map(item=>item.url));
        await axios
            .post('https://newsite.soradius.com/data.php',bodyFormData);

        this.$router.push('/');

      }

    },
    getFormData(){
      axios
          .get('https://newsite.soradius.com/data.php')
          .then((response)=>{
            this.totalNews = response.data.length;
            if(response && response.data.length > 0){
              this.news = response.data;
              this.strip_text = response.data[0].strip_text;
            }
              console.log("res is ", response);
              })
      var savedNews  = JSON.parse(localStorage.getItem("news") || "[]");
      this.totalNews = savedNews.length;

      this.strip_text = localStorage.getItem('strip_text');
    },
    setFormData(){

    }
  }
}
</script>
