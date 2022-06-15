import Vue from "vue";
import Vuex from "vuex";
import base from "@/store/modules/base";
Vue.use(Vuex);

let cart = window.localStorage.getItem("cart");
let cartCount = window.localStorage.getItem("cartCount");
export default new Vuex.Store({
  state: {
    status: "",
    user: {},
    cart: cart ? JSON.parse(cart) : [],
    cartCount: cartCount ? parseInt(cartCount) : 0,
    modules: { base },

  },
  mutations: {
    addToCart(state, item) {
      console.log(item.name);
      console.log(item.price);
      let found = state.cart.find((product) => product.name == item.name);

      if (found) {
        found.quantity++;
        found.totalPrice = found.quantity * found.price;
      } else {
        state.cart.push(item);
        Vue.set(item, "quantity", 1);
        Vue.set(item, "totalPrice", item.price);
        Vue.set(item, "ID", item.ID);
      }
      state.cartCount++;
      this.commit("saveCart");
    },
    updateCart(state, item) {
      let found = state.cart.find((product) => product.name == item.name);
      found.quantity = item.quantity;
      found.totalPrice = found.quantity * found.price;
      this.commit("saveCart");
    },
    saveCart(state) {
      window.localStorage.setItem("cart", JSON.stringify(state.cart));
      window.localStorage.setItem("cartCount", state.cartCount);
    },
    removeFromCart(state, item) {
      let index = state.cart.indexOf(item);

      if (index > -1) {
        let product = state.cart[index];
        state.cartCount -= product.quantity;

        state.cart.splice(index, 1);
        this.commit("saveCart");
      }
    },
  },
  getters:{
  list_ID (state) {
    return state.cart.ID;
  },
}
});
