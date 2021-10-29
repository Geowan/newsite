<template>
  <v-container>
    <v-card class="about">
      <v-toolbar>
        Add a news text
      </v-toolbar>
      <v-card-text>
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
        <v-btn color="primary" @click="saveDataM()">Save</v-btn>
      </v-card-actions>

    </v-card>
  </v-container>

</template>
<script>
import {openDB} from "idb";

export default {
  data:()=>({
    form:{
      title:'',
      subtitle:'',
      images:'',
      videos:[{url:''}]
    },
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
    async saveDataM(){
      let valid =  await this.$refs.form.validate();
      if(valid){

        localStorage.setItem('strip_text', this.strip_text);
        var savedNews  = JSON.parse(localStorage.getItem("news") || "[]");
        savedNews.push(this.form);
        localStorage.setItem("news", JSON.stringify(savedNews));
      }

    },
    getFormData(){
      var savedNews  = JSON.parse(localStorage.getItem("news") || "[]");
      this.totalNews = savedNews.length;

      this.strip_text = localStorage.getItem('strip_text');
    }
  }
}
</script>
