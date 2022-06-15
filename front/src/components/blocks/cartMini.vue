<template>
  <div class="cart-mini">
    <span class="close"></span>
    <ul class="list-product">
      <li v-for="item in $store.state.cart" :key="item.name">
        <img :src="'/assets/menu/' + item.img" />
        <div class="content-cart">
          <p class="price">{{ item.totalPrice }}₽</p>
          <p class="old-price">{{ item.totalPrice }}₽</p>
          <p class="name">{{ item.name }}</p>
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
      </li>
    </ul>
    <div class="total">
      к оплате:
      <div>
        <span class="old">{{ totalPrice }}₽</span>
        <span>{{ totalPrice }}₽</span>
      </div>
    </div>
    <div class="bottom">
      <router-link to="/order" class="btn orange">
        подтвердить
      </router-link>
      <router-link to="/cart" class="btn">
        перейти в корзину
      </router-link>
    </div>
  </div>
</template>

<script>

export default {
  name: "cartMini",
  computed: {
    totalPrice() {
      let total = 0.0;

      for (let item of this.$store.state.cart) {
        total += item.totalPrice;
      }
      total = Number(total).toFixed(2);
      return total;
    },
    totalItem() {
      let totali = 0;
      for (let item of this.$store.state.cart) {
        totali += item.quantity;
      }

      return totali;
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
.cart-mini {
  position: absolute;
  top: 80px;
  right: 0;
  z-index: 5;
  width: 420px;
  background: #fff url("/assets/Rectangle.png");
  border: 2px solid #000;
  display: none;
  justify-content: flex-end;
  align-items: flex-end;
  flex-direction: column;
  .close {
    background: url("/assets/close.svg") no-repeat center;
    width: 50px;
    height: 50px;
    display: block;
    cursor: pointer;
  }
  .list-product {
    list-style: none;
    padding: 0 10px;
    margin: 0 0 5px;
    border-bottom: 2px solid $border-black;
    max-height: 400px;
    overflow: auto;
    width: 100%;
    li {
      display: flex;
      align-items: center;
      justify-content: flex-start;
      font-size: 14px;
      padding: 25px 0;
      border-bottom: 1px solid #919191;
      img {
        width: 113px;
        height: 100%;
        margin-right: 20px;
      }
      .content-cart {
        width: calc(100% - 133px);
      }
      .name {
        text-align: left;
        font-weight: 500;
        font-size: 18px;
        line-height: 17px;
        color: #161712;
        padding-top: 15px;
        margin-bottom: 20px;
      }
      .price {
        font-weight: 500;
        font-size: 18px;
        line-height: 17px;
        text-align: left;
      }
      .old-price {
        font-weight: 300;
        font-size: 14px;
        line-height: 14px;
        text-decoration-line: line-through;
        color: #161712;
        opacity: 0.6;
        text-align: left;
        padding-top: 10px;
      }
      .buttons {
        border: 1px solid #000;
        display: flex;
        justify-content: flex-start;
        height: 33px;
        .block-quantity {
          display: flex;
          justify-content: space-between;
          input {
            border: none;
            background: none;
            width: 30px;
            text-align: center;
          }
          button {
            border: none;
            padding: 0 15px;
            &.minus {
              background: url("/assets/minus.svg") no-repeat center;
            }
            &.plus {
              background: url("/assets/plus.svg") no-repeat center;
            }
          }
        }
        .deleted {
          border: 0;
          border-left: 1px solid #000;
          height: 30px;
          width: calc(100% - 90px);
          font-weight: 500;
          font-size: 18px;
          line-height: 17px;
          background: #fff;
          margin: 0;
        }
      }
    }
  }
  .total {
    display: flex;
    justify-content: flex-end;
    align-items: flex-end;
    margin: 20px 0;
    padding: 0 10px;
    div {
      width: 160px;
      text-align: right;
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      justify-content: flex-start;
      font-weight: 500;
      font-size: 18px;
      line-height: 17px;
      color: $border-black;
      span {
        font-weight: 500;
        font-size: 18px;
        line-height: 17px;
        text-align: right;
        color: $border-black;
        &.old {
          font-weight: 300;
          font-size: 14px;
          line-height: 14px;
          text-align: right;
          text-decoration-line: line-through;
          color: #161712;
          opacity: 0.6;
          padding-bottom: 10px;
        }
      }
    }
  }
  .bottom {
    padding: 0 10px;
    margin-bottom: 20px;
    width: 100%;
    .btn {
      margin: 20px auto 0;
      border: 1px solid #000;
      color: $border-black;
      font-weight: bold;
      font-size: 30px;
      line-height: 29px;
      padding: 8px 10px;
      display: block;
      width: 100%;
      &.orange {
        background: #ffbf19;
        border: 0;
      }
    }
  }
}
</style>
