<template>
<!--  <video-player  class="video-player-box"-->
<!--                 ref="videoPlayer"-->
<!--                 :options="{-->
<!--                               muted: false,-->
<!--                                sources: [{-->
<!--                                  type: 'video/mp4',-->
<!--                                    src: url-->
<!--                                    }],-->
<!--                                }"-->

<!--                 :playsinline="false"-->
<!--  >-->
<!--  </video-player>-->
  <video autoplay width="100%" height="300" controls>
    <source :src="url" type="video/mp4">

    Your browser does not support the video tag.
  </video>
</template>
<script>

export default {
  props:{
    url:{
      type:String
    }
  },
}
</script>