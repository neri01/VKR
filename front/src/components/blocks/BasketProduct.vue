<template>
  <div class="row">
    <div class="foto"><img :src="'/assets/menu/' + item.img" /></div>
    <div class="sostaav">
      <h3>{{ item.name }}</h3>
      <p>{{ item.ingridient }}</p>
      <p class="mass">{{ item.mass }} гр.</p>
    </div>
    <div class="price">
      <span class="old-price">300 ₽</span>
      {{ item.price }} ₽
    </div>
    <div class="totle">{{ item.totalPrice }} ₽</div>
    <div class="buttons">
      <div class="block-quantity">
        <button class="minus" @click="minusQuantity(item)"></button>
        <input class="quantity" type="text" :value="item.quantity" />
        <button class="plus" @click="plusQuantity(item)"></button>
      </div>
      <button class="btn deleted" @click.prevent="removeFromCart(item)">
        удалить
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "BasketProduct",
  props: {
    item: {
      type: Object,
      required: true,
    },
  },
  computed: {
    totalPrice() {
      let total = 0.0;

      for (let item of this.$store.state.cart) {
        total += item.totalPrice;
      }

      total = Number(total).toFixed(2);
      return total;
    },
  },
  methods: {
    removeFromCart(item) {
      this.$store.commit("removeFromCart", item);
    },
    plusQuantity(item) {
      item.quantity++;
      item.totalPrice = item.price + item.totalPrice;
      this.$store.commit("updateCart", item);
      return item.totalPrice;
    },
    minusQuantity(item) {
      if (item.quantity > 0) {
        item.quantity--;
        item.totalPrice = item.totalPrice - item.price;
      }
      this.$store.commit("updateCart", item);
      return item.totalPrice;
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../../styles/helpers/variables";
.row {
  display: inline-grid;
  grid-template-rows: 100%;
  grid-template-columns: 25% 25% 10% 12% 28%;
  width: 100%;
  font-size: 20px;
  font-weight: 300;
  line-height: 19px;
  color: $border-black;
  border-bottom: 1px solid $border-black;
  align-items: center;
  @media #{$sm} {
    grid-template-columns: 20% 31% 13% 14% 22%;
  }
  @media #{$xs} {
    display: flex;
    flex-wrap: wrap;
  }
  &:last-of-type {
    border-bottom: none;
  }
  div {
    margin-right: 20px;
    padding: 20px 0;
    @media #{$xs} {
      width: 100%;
      margin-right: 0;
    }

    h3 {
      font-weight: 500;
      font-size: 30px;
      line-height: 29px;
      color: $border-black;
      margin-bottom: 20px;
      @media #{$lm} {
        font-size: 22px;
        line-height: 22px;
      }
    }

    p {
      font-weight: 300;
      font-size: 20px;
      line-height: 22px;
      color: $border-black;
      @media #{$lm} {
        font-size: 16px;
        line-height: 15px;
      }

      &.mass {
        margin-top: 40px;
        @media #{$lm} {
          margin-top: 20px;
        }
      }
    }
  }
}
.list-products {
  .price {
    font-weight: 300;
    font-size: 30px;
    line-height: 29px;
    @media #{$xs} {
      font-size: 18px;
      order: 2;
      width: 100% !important;
      display: flex;
      justify-content: flex-start;
      padding-bottom: 0 !important;
    }
    .old-price {
      font-weight: 300;
      display: flex;
      align-items: center;
      text-decoration-line: line-through;
      color: #919191;
      margin-bottom: 5px;
      @media #{$xs} {
        margin-right: 10px;
      }
    }
  }
  .totle {
    font-weight: 500;
    font-size: 30px;
    line-height: 29px;
    @media #{$xs} {
      font-size: 18px;
      padding-top: 15px !important;
      padding-bottom: 0 !important;
      &:before {
        content: "Всего: ";
      }
    }
  }
  .buttons {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin-right: 0;
    @media #{$sm} {
      flex-wrap: wrap;
    }
    @media #{$xs} {
      order: 6;
    }
  }
  .block-quantity {
    display: flex;
    justify-content: flex-start;
    border: 1px solid #000;
    border-right: 0;
    max-width: 70%;
    height: 50px;
    padding: 0;
    margin: 0;
    @media #{$sm} {
      border-right: 1px solid #000;
      border-bottom: none;
      max-width: 100%;
      justify-content: space-between;
    }
    .minus {
      width: 15px;
      height: 50px;
      padding: 0 15px;
      background: url("/assets/minus.svg") no-repeat center;
      border: none;
      @media #{$sm} {
        padding: 0 20px;
      }
    }
    input {
      background: none;
      border: none;
      width: 50px;
      height: 50px;
      font-size: 30px;
      line-height: 30px;
      display: flex;
      align-items: center;
      text-align: center;
      @media #{$lm} {
        font-size: 20px;
        line-height: 20px;
      }
      @media #{$sm} {
        width: calc(100% - 110px);
      }
    }
    .plus {
      border: none;
      width: 15px;
      height: 50px;
      padding: 0 15px;
      background: url("/assets/plus.svg") no-repeat center;
      @media #{$sm} {
        padding: 0 20px;
      }
    }
  }
  .deleted {
    background: #fff;
    border: 1px solid #000000;
    height: 50px;
    font-weight: 500;
    font-size: 30px;
    line-height: 29px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    width: calc(100% - 95px);
    max-width: 300px;
    @media #{$lm} {
      font-size: 20px;
      line-height: 20px;
    }
    @media #{$sm} {
      width: 100%;
      max-width: 100%;
    }
  }
  .totle {
    @media #{$xs} {
      order: 3;
      width: 100% !important;
    }
  }
  .sostaav {
    @media #{$xs} {
      order: 4;
      width: 100%;
    }
  }
  .foto {
    @media #{$xs} {
      order: 1;
      padding-bottom: 0 !important;
    }
    img {
      width: 420px;
      height: 150px;
      @media #{$sm} {
        height: 125px;
      }
    }
  }
}
</style>
