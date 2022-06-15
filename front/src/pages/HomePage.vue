/* eslint-disable */
<template>
  <base-template>
    <h1 class="visually-hidden">Простая кухня</h1>
    <home-menu />
  </base-template>
</template>

<script>
//import axios from "axios";
import BaseTemplate from "@/templates/BaseTemplate";
import HomeMenu from "@/components/blocks/HomeMenu";

//import { HTTP } from "@/http_common";
import md5 from "md5-js";
import {HTTP} from "@/http_common";
export default {
  name: "HomePage",
  components: {
    BaseTemplate,
    HomeMenu,
  },
  data() {
    return {};
  },
  methods: {
    async fetchData() {
      const privacyKey = this.$store.getters["base/PRIVACYKEY"];
      const public_Key = this.$store.getters["base/PUBLICKEY"];
      const md5Tocken = md5(public_Key + privacyKey);

      try {
        const response = await HTTP.post("post.getFoodMenu", {
          public_key: public_Key,
          token_md5: md5Tocken,
          user_login: "testUser@example.com",
          user_pass: "testUserPass",
        });
        console.log(response.data.result);
      } catch (error) {
        console.log(error);
      }
    },
  },
  async mounted() {
    await this.fetchData();
  },
};
</script>
