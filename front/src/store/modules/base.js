import axios from "axios";
import VueCookies from "vue-cookies";
import Vue from "vue";
import {HTTP} from "@/http_common";

const baseUrl = process.env.VUE_APP_API_BASE_URL;

axios.defaults.baseURL = baseUrl;

Vue.use(VueCookies);

export default {
  namespaced: true,
  state: {
    data: [],
    sessid: "",
    usersessid: "",
    menu: [],
    socials: [],
    footerMenu: {},
    linkLibrary: {},
    user: [],
  },
  mutations: {
    SET_BASE: (state, data) => {
      state.data = data;
      state.sessid = data.session_id;
      state.footerMenu = data.footer_menu;
      state.privacyKey = data.result.private_key;
      state.publickKey = data.result.public_key;
    },
  },
  actions: {
    async fetch({ commit }) {
      try {
        const { data } = await HTTP.post("post.token");
        commit("SET_BASE", data.result);
        console.log(data.result);
      } catch (error) {
        console.log(error);
        return error;
      }
    },
  },

  getters: {
    MENU: (state) => {
      return state.menu;
    },
    SOCIALS: (state) => {
      return state.socials;
    },
    FOOTER_MENU: (state) => {
      return state.footerMenu;
    },
    LINK_LIBRARY: (state) => {
      return state.linkLibrary;
    },
    SESSID: (state) => {
      return state.sessid;
    },
    PRIVACYKEY: (state) => {
      return state.privacyKey;
    },
    PUBLICKEY: (state) => {
      return state.publicKey;
    },
    USERSESSID: (state) => {
      return state.usersessid;
    },
    USER: (state) => {
      return state.user;
    },
  },
};
