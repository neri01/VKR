/* eslint-disable */
<template>
  <div class="home-menu">
    <div class="home-menu__left">
      <div
        class="bluda first"
        id="sup"
        :class="{ active: activeGrope == 'first' }"
      >
        <div class="block-name">
          <h2>супы</h2>
          <router-link to="/menu#sup" class="btn arrow">Перейти</router-link>
        </div>
        <ul class="list_first hidden-sm" id="first">
          <li
            v-for="(bluda, index) of pervoe"
            :key="bluda.name"
            :data-price="bluda.price"
            :data-img="bluda.img"
            :data-item="bluda"
            @mouseover="loadImage($event, bluda)"
            @click="onClickBlock(index, $event)"
            :class="{ active: eventIndex === index }"
          >
            {{ bluda.name }}
          </li>
        </ul>
        <VueSlickCarousel
          class="list_first first_slide visible-sm"
          ref="c2"
          :asNavFor="this.$refs.c1"
          :slidesToShow="show"
          :focusOnSelect="true"
        >
          <div
            v-for="bluda of pervoe"
            :key="bluda.name"
            :data-price="bluda.price"
            :data-img="bluda.img"
            @mouseover="loadImage($event)"
          >
            {{ bluda.name }}
          </div>
        </VueSlickCarousel>
        <VueSlickCarousel
          class="visible-sm list_first-img"
          ref="c1"
          :asNavFor="this.$refs.c2"
          :focusOnSelect="true"
        >
          <div class="slider" v-for="bluda of pervoe" :key="bluda.name">
            <div class="img-mobile">
              <img
                :src="'/assets/menu/' + bluda.img"
                alt="img-menu"
                class="media"
              />
            </div>
            <div class="block-price-mobile visible-sm">
              <span class="price">{{ bluda.price }} ₽</span>
              <button class="btn" :data-item="bluda" @click="addToCart(bluda)">
                Купить
              </button>
            </div>
          </div>
        </VueSlickCarousel>
      </div>
      <div
        class="bluda second"
        id="vtoroe"
        :class="{ active: activeGrope == 'second' }"
      >
        <div class="block-name">
          <h2>второе</h2>
          <router-link to="/menu#vtoroe" class="btn arrow">Перейти</router-link>
        </div>
        <ul class="list_first" id="second">
          <li
            v-for="(bluda, index) of vtoroe.slice(0, n)"
            :key="bluda.name"
            :data-price="bluda.price"
            :data-img="bluda.img"
            :data-item="bluda"
            @mouseover="loadImage($event, bluda)"
            @click="onClickBlock(index, $event)"
            :class="{ active: eventIndex2 === index }"
          >
            {{ bluda.name }}
          </li>
          <li>
            <span
              class="read-more"
              @click="
                n = 100;
                showMore = false;
              "
              v-show="vtoroe.length > 4 && showMore"
            >
              показать все
            </span>
          </li>
        </ul>
        <div class="visible-sm img-mobile">
          <img :src="itemImgMobile2" alt="img-menu" class="media" />
        </div>
        <div class="block-price-mobile visible-sm">
          <span class="price">{{ priceMobile2 }} ₽</span>
          <button class="btn" @click="addToCart($event)">Купить</button>
        </div>
      </div>

      <div
          class="bluda garnir"
          id="garn"
          :class="{ active: activeGrope == 'garnir' }"
      >
        <div class="block-name">
          <h2>гарниры</h2>
          <router-link to="/menu#garnir" class="btn arrow">Перейти</router-link>
        </div>
        <ul class="list_first hidden-sm" id="garnir">
          <li
              v-for="(bluda, index) of garnir"
              :key="bluda.name"
              :data-price="bluda.price"
              :data-img="bluda.img"
              :data-item="bluda"
              @mouseover="loadImage($event, bluda)"
              @click="onClickBlock(index, $event)"
              :class="{ active: eventIndex === index }"
          >
            {{ bluda.name }}
          </li>
        </ul>
        <VueSlickCarousel
            class="list_first first_slide visible-sm"
            ref="c2"
            :asNavFor="this.$refs.c1"
            :slidesToShow="show"
            :focusOnSelect="true"
        >
          <div
              v-for="bluda of garnir"
              :key="bluda.name"
              :data-price="bluda.price"
              :data-img="bluda.img"
              @mouseover="loadImage($event)"
          >
            {{ bluda.name }}
          </div>
        </VueSlickCarousel>
        <VueSlickCarousel
            class="visible-sm list_first-img"
            ref="c1"
            :asNavFor="this.$refs.c2"
            :focusOnSelect="true"
        >
          <div class="slider" v-for="bluda of garnir" :key="bluda.name">
            <div class="img-mobile">
              <img
                  :src="'/assets/menu/' + bluda.img"
                  alt="img-menu"
                  class="media"
              />
            </div>
            <div class="block-price-mobile visible-sm">
              <span class="price">{{ bluda.price }} ₽</span>
              <button class="btn" :data-item="bluda" @click="addToCart(bluda)">
                Купить
              </button>
            </div>
          </div>
        </VueSlickCarousel>
      </div>

      <div
          class="bluda salade"
          id="salade"
          :class="{ active: activeGrope == 'salade' }"
      >
        <div class="block-name">
          <h2>салаты</h2>
          <router-link to="/menu#sup" class="btn arrow">Перейти</router-link>
        </div>
        <ul class="list_first hidden-sm" id="list_salade">
          <li
              v-for="(bluda, index) of salade"
              :key="bluda.name"
              :data-price="bluda.price"
              :data-img="bluda.img"
              :data-item="bluda"
              @mouseover="loadImage($event, bluda)"
              @click="onClickBlock(index, $event)"
              :class="{ active: eventIndex === index }"
          >
            {{ bluda.name }}
          </li>
        </ul>
        <VueSlickCarousel
            class="list_first first_slide visible-sm"
            ref="c2"
            :asNavFor="this.$refs.c1"
            :slidesToShow="show"
            :focusOnSelect="true"
        >
          <div
              v-for="bluda of salade"
              :key="bluda.name"
              :data-price="bluda.price"
              :data-img="bluda.img"
              @mouseover="loadImage($event)"
          >
            {{ bluda.name }}
          </div>
        </VueSlickCarousel>
        <VueSlickCarousel
            class="visible-sm list_first-img"
            ref="c1"
            :asNavFor="this.$refs.c2"
            :focusOnSelect="true"
        >
          <div class="slider" v-for="bluda of salade" :key="bluda.name">
            <div class="img-mobile">
              <img
                  :src="'/assets/menu/' + bluda.img"
                  alt="img-menu"
                  class="media"
              />
            </div>
            <div class="block-price-mobile visible-sm">
              <span class="price">{{ bluda.price }} ₽</span>
              <button class="btn" :data-item="bluda" @click="addToCart(bluda)">
                Купить
              </button>
            </div>
          </div>
        </VueSlickCarousel>
      </div>

      <div
          class="bluda napitki"
          id="napitki"
          :class="{ active: activeGrope == 'napitki' }"
      >
        <div class="block-name">
          <h2>напитки</h2>
          <router-link to="/menu#sup" class="btn arrow">Перейти</router-link>
        </div>
        <ul class="list_first hidden-sm" id="list_napitki">
          <li
              v-for="(bluda, index) of napitki"
              :key="bluda.name"
              :data-price="bluda.price"
              :data-img="bluda.img"
              :data-item="bluda"
              @mouseover="loadImage($event, bluda)"
              @click="onClickBlock(index, $event)"
              :class="{ active: eventIndex === index }"
          >
            {{ bluda.name }}
          </li>
        </ul>
        <VueSlickCarousel
            class="list_first first_slide visible-sm"
            ref="c2"
            :asNavFor="this.$refs.c1"
            :slidesToShow="show"
            :focusOnSelect="true"
        >
          <div
              v-for="bluda of napitki"
              :key="bluda.name"
              :data-price="bluda.price"
              :data-img="bluda.img"
              @mouseover="loadImage($event)"
          >
            {{ bluda.name }}
          </div>
        </VueSlickCarousel>
        <VueSlickCarousel
            class="visible-sm list_first-img"
            ref="c1"
            :asNavFor="this.$refs.c2"
            :focusOnSelect="true"
        >
          <div class="slider" v-for="bluda of napitki" :key="bluda.name">
            <div class="img-mobile">
              <img
                  :src="'/assets/menu/' + bluda.img"
                  alt="img-menu"
                  class="media"
              />
            </div>
            <div class="block-price-mobile visible-sm">
              <span class="price">{{ bluda.price }} ₽</span>
              <button class="btn" :data-item="bluda" @click="addToCart(bluda)">
                Купить
              </button>
            </div>
          </div>
        </VueSlickCarousel>
      </div>

    </div>
    <div class="home-menu__img hidden-sm">
      <div class="block-img">
        <img :src="itemImg" alt="img-menu" class="media" />
      </div>
      <div class="block-price">
        <span class="price">{{ price }} ₽</span>
        <button
          class="btn"
          :data-item="item"
          :disabled="btnDisabled"
          @click="addToCart($event)"
        >
          Купить
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import VueSlickCarousel from "vue-slick-carousel";
import "vue-slick-carousel/dist/vue-slick-carousel.css";
//import axios from "axios";
//import {HTTP} from "@/http_common";

function get_data(url){
  var xhr = new XMLHttpRequest();
  xhr.open('GET', url, false);
  xhr.send();
  var data;
  if (xhr.status != 200) {
    data = ( xhr.status + ': ' + xhr.statusText );
  } else {
    data = JSON.parse( xhr.responseText );
  }
  return data;
}

let menu = get_data('http://localhost/SimpleKithen/back/connectors/get_menu.php');

export default {
  name: "HomeMenu",
  components: { VueSlickCarousel },
  mounted() {
    this.c1 = this.$refs.c1;
    this.c2 = this.$refs.c2;
    this.show = 10;
  },
  data: function () {
    return {
      itemImg: "/assets/menu/lapsha.svg",
      c1: undefined,
      c2: undefined,
      item: undefined,
      price: 0,
      eventIndex: "",
      priceMobile1: 0,
      priceMobile2: 0,
      show: 1,
      n: 4,
      showMore: true,
      hover: false,
      btnDisabled: true,
      activeGrope: "",
      eventIndex2: "",
      itemImgMobile1: "/assets/menu/lapsha.svg",
      itemImgMobile2: "/assets/menu/fele.svg",
      itemImgMobile3: "/assets/menu/potatos.svg",
      itemImgMobile4: "/assets/menu/kapusta.svg",
      token_md5: "",
      publicKey: "",
      privateKey: "",
      pervoe: menu["первое"],
      vtoroe: menu["второе"],
      garnir: menu["гарнир"],
      salade: menu["салат"],
      napitki: menu["напитки"]

    };
  },

  methods: {
    loadImage: function (event, item) {
      var targetImg = event.currentTarget.getAttribute("data-img");
      var targetPrice = event.currentTarget.getAttribute("data-price");
      let targetItem = item;
      let parentId = event.target.parentElement.id;
      var itemImgs = "/assets/menu/" + targetImg;
      if (parentId === "first") {
        this.itemImgMobile1 = itemImgs;
        this.priceMobile1 = targetPrice;
      } else if (parentId === "second") {
        this.itemImgMobile2 = itemImgs;
        this.priceMobile2 = targetPrice;
      }
      this.itemImg = itemImgs;
      this.price = targetPrice;
      this.item = targetItem;
      this.btnDisabled = false;
    },
    ActiveClass: function () {
      this.hover = true;
    },
    onClickBlock(index, event) {
      let parentId = event.target.parentElement.id;
      this.activeGrope = parentId;
      console.log(parentId);
      if (parentId === "first") {
        this.evenytIndex = index;
        this.eventIndex2 = "";
      } else if (parentId === "second") {
        this.eventIndex2 = index;
        this.eventIndex = "";
      }
    },
    addToCart(item) {
      if (this.item) {
        this.$store.commit("addToCart", this.item);
      } else {
        this.$store.commit("addToCart", item);
      }
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../../styles/helpers/variables";
.home-menu {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;

  &__left {
    width: 50%;
    border-right: 2px solid $border-black;
    max-height: calc(100vh - 186px);
    overflow: auto;
    -ms-overflow-style: none;
    scrollbar-width: none;
    &::-webkit-scrollbar {
      width: 0;
      height: 0;
    }
    @media #{$md} {
      max-height: calc(100vh - 178px);
    }
    @media #{$sm} {
      width: 100%;
      margin-right: 0;
      max-height: 100%;
      border-right: 0;
    }
    .block-name {
      width: 45%;
      @media #{$md} {
        width: 50%;
      }
      @media #{$sm} {
        padding-left: 20px;
        padding-bottom: 20px;
      }
      @media #{$xs} {
        padding-left: 0;
        width: 100%;
        text-align: center;
      }
      h2 {
        font-style: normal;
        font-weight: 500;
        font-size: 50px;
        line-height: 48px;
        color: #161712;
        margin-bottom: 20px;
        text-transform: lowercase;
        @media #{$sm} {
          font-size: 42px;
          line-height: 41px;
        }
        @media #{$xs} {
          font-size: 60px;
          line-height: 60px;
          text-align: left;
          padding-left: 20px;
          text-transform: uppercase;
        }
      }
      .btn {
        font-style: normal;
        font-weight: bold;
        font-size: 30px;
        line-height: 29px;
        text-align: center;
        color: $border-black;
        padding: 10px 30px;
        background: #ffbf19;
        border: none;
        &.arrow {
          background: #fff
            url("data:image/svg+xml,%3Csvg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cg clip-path='url(%23clip0)'%3E%3Crect x='23.04' y='24' width='24' height='0.96' transform='rotate(-90 23.04 24)' fill='%23161712'/%3E%3Crect width='24' height='0.96' fill='%23161712'/%3E%3Crect x='-0.788452' y='23.999' width='33.261' height='0.96' transform='rotate(-45 -0.788452 23.999)' fill='%23161712'/%3E%3C/g%3E%3Cdefs%3E%3CclipPath id='clip0'%3E%3Crect width='24' height='24' fill='white'/%3E%3C/clipPath%3E%3C/defs%3E%3C/svg%3E")
            no-repeat 290px center;
          width: 200px;
          color: $border-black;
          border: 1px solid $border-black;
          font-weight: normal;
          padding-left: 20px;
          text-align: left;
          text-transform: lowercase;
          display: block;
          @media #{$md} {
            width: 194px;
            background-position: 95%;
            font-size: 25px;
            line-height: 24px;
          }
          @media #{$sm} {
            width: 250px;
          }
          @media #{$xs} {
            margin: 0 auto;
            width: 95%;
            max-width: 335px;
            background-position: 95%;
          }
        }
        @media #{$xs} {
          margin: 0 auto;
          width: 95%;
          max-width: 335px;
        }
      }
    }
    ul {
      list-style: none;
      padding: 0;
      margin: 0;
      li {
        font-style: normal;
        font-weight: 300;
        font-size: 20px;
        line-height: 19px;
        color: #161712;
        margin-bottom: 12px;
        cursor: pointer;
        @media #{$md} {
          font-size: 16px;
          line-height: 15px;
        }
        &:hover,
        &.active {
          color: #ffbf19;
          font-weight: bold;
        }
      }
    }
    .bluda {
      width: 100%;
      display: flex;
      min-height: 250px;
      padding: 50px 0 0 100px;
      border-bottom: 2px solid #161712;
      background: url("/assets/Rectangle.png");
      @media #{$md} {
        padding: 20px 0 0 20px;
      }

      @media #{$sm} {
        padding: 20px 0 0;
        flex-wrap: wrap;
        width: 100%;
        .list_first {
          padding-left: 20px;
        }
      }
      &:last-of-type {
        border-bottom: 0;
      }
      &:hover,
      &.active {
        background: $border-black;
        h2,
        li {
          color: #fff;
        }
        li:hover {
          color: #ffbf19;
          font-weight: bold;
        }
      }
      .read-more {
        width: 100%;
        font-weight: 300;
        font-size: 20px;
        line-height: 19px;
        text-decoration: underline;
        &:hover {
          text-decoration: none;
        }
      }
    }
  }
  &__img {
    width: 50%;
    .block-img {
      height: 100%;
      max-height: calc(100vh - 338px);
      overflow: hidden;
      @media #{$md} {
        max-height: calc(100vh - 290px);
      }
    }
    img {
      width: 100%;
      height: 100%;
      @media #{$xs} {
        width: 100%;
      }
    }
    .block-price {
      display: flex;
      height: 150px;
      border-top: 2px solid $border-black;
      @media #{$md} {
        height: 110px;
      }
      .price {
        width: 50%;
        background: #fff;
        border-right: 2px solid $border-black;
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
        font-size: 72px;
        line-height: 70px;
        color: $border-black;
        @media #{$md} {
          height: 110px;
          font-size: 60px;
          line-height: 58px;
        }
      }
      .btn {
        width: 50%;
        height: 150px;
        background: #ffbf19;
        font-weight: bold;
        font-size: 30px;
        line-height: 29px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        &:hover {
          background: #fff;
        }
        @media #{$md} {
          height: 110px;
        }
      }
    }
  }
  .img-mobile {
    width: 100%;
    @media #{$sm} {
      max-height: 312px;
      overflow: hidden;
      border-top: 2px solid $border-black;
    }
    @media #{$xs} {
      max-height: 210px;
    }
    img {
      width: 100%;
      display: block;
    }
  }
  .block-price-mobile {
    display: flex;
    width: 100%;
    border-top: 2px solid $border-black;
    height: 50px;
    .price {
      font-weight: 500;
      font-size: 35px;
      line-height: 55px;
      text-align: center;
      letter-spacing: 0.07em;
      text-transform: uppercase;
      border-right: 2px solid $border-black;
      width: 50%;
      height: 100%;
      background: #fff;
    }
    .btn {
      font-weight: bold;
      font-size: 20px;
      line-height: 55px;
      text-align: center;
      letter-spacing: 0.07em;
      text-transform: uppercase;
      width: 50%;
      height: 100%;
      background: #ffbf19;
      border: 0;
      &:hover {
        background: #fff;
      }
    }
  }
  .slick-slider.list_first {
    width: 50%;
    @media #{$xs} {
      width: 100%;
    }
  }
  .list_first-img {
    max-width: 100vw;
    .slick-list {
      margin-top: 80px;
    }
  }
}
</style>
