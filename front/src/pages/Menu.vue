<template>
  <base-template>
    <h1 class="visually-hidden">Простая кухня</h1>
    <div class="block-dishes" id="sup">
      <div class="title">
        <router-link to="/#sup" class="btn arrow">
          <img src="/assets/back.svg" />
        </router-link>
        <h2>Супы</h2>
      </div>
      <div class="dishe" v-for="item of pervoe" :key="item.name">
        <div class="name">{{ item.name }}</div>
        <div class="ingredients">{{ item.ingridient }}</div>
        <div class="block-price-btn">
          <div class="price_mass">
            <span class="price">{{ item.price }} ₽</span> /
            <span class="mass"> {{ item.mass }} гр.</span>
          </div>
          <button
            class="btn"
            :class="{ active: item.selected }"
            :data-item="item"
            @click="
              addToCart(item);
              $set(item, 'selected', !item.selected);
            "
          >
            заказать
          </button>
        </div>
      </div>
    </div>
    <div class="block-dishes" id="vtoroe">
      <div class="title">
        <router-link to="/#vtoroe" class="btn arrow">
          <img src="/assets/back.svg" />
        </router-link>
        <h2>Второе</h2>
      </div>
      <div class="dishe" v-for="item of vtoroe" :key="item.name">
        <div class="name">{{ item.name }}</div>
        <div class="ingredients">{{ item.ingridient }}</div>
        <div class="block-price-btn">
          <div class="price_mass">
            <span class="price">{{ item.price }} ₽</span> /
            <span class="mass"> {{ item.mass }} гр.</span>
          </div>
          <button
            class="btn"
            :class="{ active: item.selected }"
            :data-item="item"
            @click="
              addToCart(item);
              $set(item, 'selected', !item.selected);
            "
          >
            заказать
          </button>
        </div>
      </div>
    </div>
    <div class="block-dishes" id="garnir">
      <div class="title">
        <router-link to="/#garnish" class="btn arrow">
          <img src="/assets/back.svg" />
        </router-link>
        <h2>Гарнир</h2>
      </div>
      <div class="dishe" v-for="item of garnir" :key="item.name">
        <div class="name">{{ item.name }}</div>
        <div class="ingredients">{{ item.ingridient }}</div>
        <div class="block-price-btn">
          <div class="price_mass">
            <span class="price">{{ item.price }} ₽</span> /
            <span class="mass"> {{ item.mass }} гр.</span>
          </div>
          <button
              class="btn"
              :data-item="item"
              :class="{ active: item.selected }"
              @click="
              addToCart(item);
              $set(item, 'selected', !item.selected);
            "
          >
            заказать
          </button>
        </div>
      </div>
    </div>
    <div class="block-dishes" id="salade">
      <div class="title">
        <router-link to="/#garnish" class="btn arrow">
          <img src="/assets/back.svg" />
        </router-link>
        <h2>салаты</h2>
      </div>
      <div class="dishe" v-for="item of salade" :key="item.name">
        <div class="name">{{ item.name }}</div>
        <div class="ingredients">{{ item.ingridient }}</div>
        <div class="block-price-btn">
          <div class="price_mass">
            <span class="price">{{ item.price }} ₽</span> /
            <span class="mass"> {{ item.mass }} гр.</span>
          </div>
          <button
              class="btn"
              :data-item="item"
              :class="{ active: item.selected }"
              @click="
              addToCart(item);
              $set(item, 'selected', !item.selected);
            "
          >
            заказать
          </button>
        </div>
      </div>
    </div>
    <div class="block-dishes" id="napitki">
      <div class="title">
        <router-link to="/#garnish" class="btn arrow">
          <img src="/assets/back.svg" />
        </router-link>
        <h2>напитки</h2>
      </div>
      <div class="dishe" v-for="item of napitki" :key="item.name">
        <div class="name">{{ item.name }}</div>
        <div class="ingredients">{{ item.ingridient }}</div>
        <div class="block-price-btn">
          <div class="price_mass">
            <span class="price">{{ item.price }} ₽</span> /
            <span class="mass"> {{ item.mass }} гр.</span>
          </div>
          <button
              class="btn"
              :data-item="item"
              :class="{ active: item.selected }"
              @click="
              addToCart(item);
              $set(item, 'selected', !item.selected);
            "
          >
            заказать
          </button>
        </div>
      </div>
    </div>
  </base-template>
</template>

<script>
import BaseTemplate from "@/templates/BaseTemplate";

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
  name: "Menu",
  data: function () {
    return {
      item: undefined,
      selected: undefined,
      pervoe: menu["первое"],
      vtoroe: menu["второе"],
      garnir: menu["гарнир"],
      salade: menu["салат"],
      napitki: menu["напитки"]
    };
  },
  components: {
    BaseTemplate,
  },
  methods: {
    addToCart(item) {
      this.item = item;
      this.$store.commit("addToCart", this.item);
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../styles/helpers/variables";
.title {
  display: flex;
  justify-content: flex-start;
  padding: 40px 100px;
  align-items: center;
  @media #{$md} {
    padding: 40px 20px;
    font-size: 35px;
    line-height: 35px;
  }
  @media #{$xs} {
    padding: 15px 20px;
  }
  a {
    margin-right: 40px;
    @media #{$xs} {
      margin-right: 20px;
      img {
        width: 74px;
      }
    }
  }
  h2 {
    font-weight: 500;
    font-size: 60px;
    line-height: 58px;
    letter-spacing: 0.07em;
    text-transform: uppercase;
    @media #{$xs} {
      font-size: 35px;
      line-height: 34px;
    }
  }
}
.dishe {
  background: #fff url("/assets/Rectangle.png");
  padding: 45px 100px;
  display: flex;
  border-bottom: 2px solid $border-black;
  align-items: flex-start;
  justify-content: space-between;
  flex-wrap: wrap;
  @media #{$md} {
    padding: 25px 20px;
  }
  @media #{$xs} {
    padding: 20px 0;
  }
  .name {
    font-weight: 500;
    font-size: 30px;
    line-height: 29px;
    color: $border-black;
    width: calc(25% - 20px);
    margin-right: 20px;
    @media #{$md} {
      font-size: 22px;
      line-height: 21px;
    }
    @media #{$sm} {
      width: calc(33% - 20px);
    }
    @media #{$xs} {
      width: 100%;
      padding: 0 10px;
      margin-bottom: 20px;
    }
  }
  .ingredients {
    font-weight: 300;
    font-size: 20px;
    line-height: 19px;
    color: $border-black;
    width: calc(35% - 20px);
    margin-right: 20px;
    @media #{$md} {
      font-size: 16px;
      line-height: 15px;
    }
    @media #{$sm} {
      width: 33%;
    }
    @media #{$xs} {
      width: 100%;
      padding: 0 10px;
      margin-bottom: 20px;
    }
  }
  .block-price-btn {
    width: calc(40% - 20px);
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: flex-start;
    @media #{$sm} {
      width: calc(33% - 20px);
    }
    @media #{$xs} {
      width: 100%;
    }
  }
  .price_mass {
    width: calc(50% - 20px);
    max-width: 415px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 300;
    font-size: 20px;
    line-height: 19px;
    text-align: center;
    color: #000000;
    margin-right: 20px;
    @media #{$sm} {
      width: 100%;
      margin-right: 0;
    }
    @media #{$xs} {
      width: 100%;
      background: #fff;
      border-top: 2px solid $border-black;
      margin-right: 0;
      padding: 25px 10px;
    }
    .price {
      font-weight: 500;
      font-size: 30px;
      line-height: 29px;
      text-align: center;
      color: $border-black;
      width: 49%;
      max-width: 208px;
      @media #{$md} {
        font-size: 22px;
        line-height: 21px;
      }
    }
    .mass {
      font-weight: 300;
      font-size: 20px;
      line-height: 19px;
      text-align: center;
      color: $border-black;
      width: 49%;
      max-width: 200px;
      @media #{$md} {
        font-size: 16px;
        line-height: 15px;
      }
    }
  }
  .btn {
    background: #ffbf19;
    padding: 10px;
    max-width: 415px;
    width: 49%;
    font-weight: bold;
    font-size: 30px;
    line-height: 29px;
    text-align: center;
    color: $border-black;
    border: none;
    &:hover {
      background: #fff;
    }
    &.active {
      background: $border-black;
      color: #fff;
    }
    @media #{$sm} {
      width: 100%;
      margin-top: 10px;
    }
    @media #{$xs} {
      width: 100%;
      margin: 0 auto;
    }
  }
}
</style>
