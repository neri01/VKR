import Vue from "vue";
import VueRouter from "vue-router";
import HomePage from "../pages/HomePage.vue";
import Menu from "../pages/Menu.vue";
import Login from "../pages/Login.vue";
import Registration from "../pages/Registration.vue";
import Busket from "../pages/Cart.vue";
import Order from "../pages/Order";
import VueScrollTo from "vue-scrollto";


Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Home",
    component: HomePage,
  },
  {
    path: "/menu",
    name: "Menu",
    component: Menu,
  },
  {
    path: "/login",
    name: "Login",
    component: Login,
  },
  {
    path: "/registration",
    name: "Registration",
    component: Registration,
  },
  {
    path: "/cart",
    name: "Busket",
    component: Busket,
  },
  {
    path: "/order",
    name: "Order",
    component: Order,
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (to.hash) {
      VueScrollTo.scrollTo(to.hash, 400);
      return { selector: to.hash };
    } else if (savedPosition) {
      return savedPosition;
    } else {
      return { x: 0, y: 0 };
    }
  },
});

export default router;
