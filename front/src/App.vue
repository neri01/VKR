<template>
  <router-view />
</template>
<script>
import { mapActions, mapState } from "vuex";

//import Vue from "vue";
export default {
  components: {},
  data() {
    return {
      isLoaded: false,
      isHealthcare: false,
      inCookies: false,
      info: null,
      token_md5: "",
      publicKey: "",
      privateKey: "",
      menu: "",
    };
  },

  computed: {
    ...mapState("base", {
      base: (state) => state.data,
    }),
  },
  methods: {
    ...mapActions({
      fetchBase: "base/fetch",
    }),
  },
  async mounted() {
    await this.fetchBase();
    this.isLoaded = true;
    //this.getCookies();
    console.log("5", this.isHealthcare);
  },
};

</script>
