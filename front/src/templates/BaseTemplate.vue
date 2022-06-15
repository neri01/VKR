/* eslint-disable */
<template>
  <div class="wrapper">
    <base-header />
    <main>
      <slot />
    </main>
    <base-footer />
  </div>
</template>

<script>
import BaseHeader from "@/components/base/BaseHeader";

import VueCookies from "vue-cookies";
import Vue from "vue";

Vue.use(VueCookies);

import { mapState, mapGetters } from "vuex";
import BaseFooter from "@/components/base/BaseFooter";
import { HTTP } from "@/http_common";
import md5 from "md5-js";

export default {
  name: "BaseTemplate",
  components: {
    BaseFooter,
    BaseHeader,
  },
  data() {
    return {
      user: "",
      token_md5: "",
      publicKey: "",
      privateKey: "",
      menu: "",
      header_data: "",
      footer_data: "",
    };
  },
  computed: {
    ...mapState(["base"]),
    ...mapGetters({}),
  },

  methods: {
    sent_post_req(url,formData){
      var xhr = new XMLHttpRequest();
      xhr.open('POST', url, false);
      xhr.send(formData);
      return xhr.responseText;
    },
    sent_req(url,parametr){
      var data ='';
      var xhr = new XMLHttpRequest();
      xhr.open('POST', url, false);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      data.searchParams.set('msg', parametr);
      xhr.send(data);
      if (xhr.status != 200) {
       data = ( xhr.status + ': ' + xhr.statusText );
     } else {
       data = JSON.parse( xhr.responseText );
     }
     return data;
    },
    async getData() {
      HTTP.post("post.token")
        .then(
          (response) => (
            (this.info = response.data.result),
            (this.privateKey = response.data.result.private_key),
            (this.publicKey = response.data.result.public_key),
            (this.token_md5 = this.publicKey + this.privateKey),
            HTTP.post("post.getHeaderFooterInfo", {
              public_key: this.publicKey,
              token_md5: md5(this.token_md5),
            }).then(
              (response) => (
                (this.header_data = response.data.result.header),
                (this.footer_data = response.data.result.footer)
              )
            )
          )
        )
        .catch((error) => console.log(error));
    },
  },
  mounted: function () {
    this.getData();
  },
  watch: {},
};
</script>

<style lang="scss">
@import "src/styles/styles";
</style>
