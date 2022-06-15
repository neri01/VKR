/* eslint-disable */
<template>
  <header class="header" :class="{ 'menu-opened': isMenuOpened }">
    <div class="container">
      <div class="header__links">
        <router-link
          to="/"
          class="header__logo"
          aria-label="Переход на главную страницу"
        >
          <img
            class="hidden-xs"
            src="/assets/logo.svg"
            alt="Логотип"
            aria-hidden="true"
          />
          <img
            class="visible-xs"
            src="/assets/logo.svg"
            alt="Логотип"
            aria-hidden="true"
          />
        </router-link>
      </div>
      <div class="tel hidden-xs">
        <span>+7 900 000 99 00</span>
      </div>
      <nav class="header-menu hidden-xs">
        <ul class="header-menu__list">
          <li class="header-menu__item">
            <router-link to="/menu" class="header-menu__link">
              меню
            </router-link>
          </li>
          <li class="header-menu__item">
            <router-link to="/registration" class="header-menu__link">
              личный кабинет
            </router-link>
          </li>
          <li class="header-menu__item">
            <router-link to="/login" class="header-menu__link">
              вход
            </router-link>
          </li>
          <li class="header-menu__item cart-menu" :class="{ active: active }">
            <router-link to="/cart" class="header-menu__link">
              корзина ({{ totalItem }})
            </router-link>
            <cart-mini />
          </li>
        </ul>
      </nav>
      <button
        class="header__hamburger visible-xs"
        :class="{ active: isMenuOpened }"
        @click="isMenuOpened = !isMenuOpened"
      >
        <span></span>
        <span></span>
        <span></span>
      </button>
      <div class="header-popup" v-if="isMenuOpened">
        <div class="header-popup__content">
          <nav>
            <ul class="header-popup__menu">
              <li class="header-menu__item">
                <router-link to="/menu" class="header-menu__link">
                  меню
                </router-link>
              </li>
              <li class="header-menu__item">
                <router-link to="/login" class="header-menu__link">
                  вход
                </router-link>
              </li>
              <li class="header-menu__item">
                <router-link to="/registration" class="header-menu__link">
                  как заказать
                </router-link>
              </li>
              <li class="header-menu__item">
                <router-link to="/cart" class="header-menu__link">
                  корзина ({{ totalItem }})
                </router-link>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </header>
</template>
<script>
import CartMini from "@/components/blocks/cartMini";

function readCookie(name) {
  var name_cook = name+"=";
  var spl = document.cookie.split(";");
  for(var i=0; i<spl.length; i++) {
    var c = spl[i];
    while(c.charAt(0) == " ") {
      c = c.substring(1, c.length);
    }
    if(c.indexOf(name_cook) == 0) {
      return c.substring(name_cook.length, c.length);
    }
  }
  return null;
}

function check_user() {
  let temp_hash = readCookie("hash");
  let temp_phone = readCookie("phone");
  if (temp_hash && temp_phone) {
    var param = new FormData();
    param.append("phone", temp_phone);
    param.append("hash", temp_hash);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', "http://localhost/SimpleKithen/back/connectors/check_login.php", false);
    xhr.send(param);
    var data;
    if (xhr.status != 200) {
      data = (xhr.status + ': ' + xhr.statusText);
    } else {
      data = JSON.parse(xhr.responseText);
    }
    return data;
  }
};


export default {
  name: "BaseHeader",
  props: {
    "data-header": {
      type: Array,
      default() {
        return [];
      },
    },
  },
  computed: {
    totalItem() {
      let totali = 0;
      for (let item of this.$store.state.cart) {
        totali += item.quantity;
      }
      return totali;
    },
  },
  components: { CartMini },
  data() {
    return {
      isMenuOpened: false,
      active: false,
      privateKey: "",
      publicKey: "",
      token_md5: "",
    };
  },
  methods: {
    async fetchData() {
    },
  },
  mounted() {
    this.fetchData();
  },
  check_login: function(){
  if (!check_user()) {
  alert("перед переходом в личный кабинет необходимо зарегистрироваться");
  location.assign("/login")
  console.log(check_user());
}}
};
</script>
<style lang="scss" scoped>
@import "../../styles/helpers/variables";

.header {
  position: relative;
  background-color: $white-true;
  border-bottom: 2px solid $border-black;
  border-top: 2px solid $border-black;

  @media #{$xs} {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 10;
    width: 100%;
    border-top: none;
  }
  .container {
    display: flex;
    justify-content: flex-start;
    @media #{$sm} {
      padding: 0 10px;
    }
    @media #{$xs} {
      align-items: center;
      justify-content: space-between;
    }
  }

  &__logo {
    display: block;
    @media #{$md} {
      margin-right: 0;
    }
    @media #{$xs} {
      margin-top: 2px;
    }

    img {
      display: block;
      width: 132px;
      @media #{$md} {
        width: 91px;
      }
      @media #{$xs} {
        width: 49px;
      }
    }
  }
  .cart-menu {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    &.active,
    &:hover {
      .cart-mini {
        display: flex;
      }
    }
    span {
      display: block;
      width: 20px;
      height: 19px;
      margin-left: 5px;
      background: url("/assets/select.svg") no-repeat center top;
      background-size: contain;
      transform: rotate(0deg);
      cursor: pointer;
      &.active {
        transform: rotate(180deg);
      }
    }
  }
  .tel {
    width: calc(50% - 333px);
    border-right: 2px solid $border-black;
    display: flex;
    align-items: center;
    justify-content: center;
    @media #{$md} {
      width: calc(50% - 133px);
    }
    @media #{$sm} {
      width: calc(50% - 103px);
    }
    span {
      font-size: 20px;
      font-weight: bold;
      line-height: 19px;
      text-align: center;
      color: $border-black;
    }
  }

  &__links {
    display: flex;
    align-items: center;
    padding: 22px 100px;
    border-right: 2px solid $border-black;
    @media #{$md} {
      padding: 22px 20px;
    }
    @media #{$sm} {
      padding: 22px 10px 22px 0;
    }
    @media #{$xs} {
      padding: 0;
      border-right: 0;
    }
  }

  &__link {
    font-size: 16px;
    font-weight: bold;
    line-height: 18px;
    color: $nav-color-text;
    letter-spacing: 0.2px;

    &:hover {
      color: $blue;
    }
  }
  &__hamburger {
    display: block;
    padding: 18px;
    border: 0;
    transition: $base-transition;
    background: none;

    @media #{$xs} {
      padding: 14px;
    }

    span {
      display: block;
      width: 25px;
      height: 4px;
      background-color: $bg-black;
      transition: $base-transition;
    }

    span + span {
      margin-top: 6px;
      @media #{$xs} {
        margin-top: 4px;
      }
    }

    &.active {
      background: $white-true;

      span {
        background-color: $bg-black;

        &:first-of-type {
          transform: translateY(10px) rotate(45deg);
          @media #{$xs} {
            transform: translateY(8px) rotate(45deg);
          }
        }

        &:nth-of-type(2) {
          transform: scale(0);
        }

        &:last-of-type {
          transform: translateY(-10px) rotate(-45deg);
          @media #{$xs} {
            transform: translateY(-8px) rotate(-45deg);
          }
        }
      }
    }
  }
}

.header-menu {
  display: flex;
  width: 50%;
  align-items: center;
  @media #{$xs} {
    display: none;
  }

  a {
    color: $border-black;
    transition: $base-transition;
    font-weight: 300;
    font-size: 20px;
    line-height: 19px;
    @media #{$sm} {
      font-size: 16px;
      line-height: 15px;
    }
    &:hover {
      font-weight: bold;
    }
  }

  &__list {
    display: flex;
    justify-content: space-around;
    padding: 0;
    margin: 0;
    list-style: none;
    width: 100%;
    height: 100%;
  }
  &__item {
    width: 25%;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    @media (max-width: 1100px) {
      &:nth-last-of-type(2) {
        width: 20%;
      }
      &:last-of-type {
        width: 30%;
      }
    }
    @media #{$sm} {
      width: auto;
      &:first-of-type {
        width: auto;
        padding-left: 10px;
      }
      &:nth-last-of-type(2) {
        width: 17%;
      }
      &:last-of-type {
        width: 33%;
      }
    }
    &:last-of-type {
      margin-right: 0;
    }
    @media #{$xl} {
      width: auto !important;
    }
  }
  &__link {
    display: block;
    font-family: "Neue Machina";
    font-style: normal;
    font-weight: bold;
    font-size: 20px;
    line-height: 19px;
    color: #161712;
    &.router-link-active {
      font-weight: bold;
    }
  }
}
.header-popup {
  position: absolute;
  top: 120px;
  left: 0;
  display: none;
  width: 100%;
  padding: 20px 40px 40px;
  background: $white-true;
  border-radius: 0 0 15px 15px;
  box-shadow: 0 0 7px rgba(137, 197, 223, 0.29);
  @media #{$sm} {
    display: block;
  }
  @media #{$xs} {
    top: 50px;
    padding: 6px 15px 22px;
  }

  &__menu {
    display: block;
    padding: 0;
    margin: 0;
    list-style: none;
    li {
      margin-bottom: 10px;
      &:last-of-type {
        margin-bottom: 0;
      }
    }
  }
}
</style>
