<template>
  <base-template>
    <h1 class="visually-hidden">Простая кухня</h1>
    <h2 class="title">оформление заказа</h2>
    <div class="content-order">
      <div class="left-col">
        <form>
          <h3>оплата и доставка</h3>
          <label class="label">адрес доставки:</label>
          <textarea v-model="optionsAddress">
          </textarea>
          <label class="label">время доставки:</label>
          <Select :options="optionsTime" :selected="optionsTime[0].name" />
          <label class="label">комментарий:</label>
          <textarea v-model="comment"></textarea>
          <label class="label">способ оплаты:</label>
          <div class="line">
            <label class="label-checkbox" >
              <input type="radio" name="oplata" v-model="pay_type_cart"/>
              <i></i>
            </label>
            <span>онлайн на сайте</span>
          </div>
          <div class="line">
            <label class="label-checkbox">
              <input type="radio" name="oplata" v-model="pay_type_cash"/>
              <i></i>
            </label>
            <span>наличными курьеру</span>
          </div>

        </form>
      </div>
      <div class="right-col">
        <h3>
          заказ
          <a href="/cart">изменить</a>
        </h3>
        <div v-if="$store.state.cart.length > 0" class="list-products">
          <div
            class="table-rows"
            v-for="item in $store.state.cart"
            :key="item.name"

          >
            <div class="foto"><img :src="'/assets/menu/' + item.img" /></div>
            <div class="sostaav">
              <p class="name">{{ item.name }}</p>
              <p>{{ item.ingridient }}</p>
              <p class="mass">{{ item.mass }} гр.</p>
            </div>
            <div class="price">{{ item.price }} ₽</div>
            <div class="quantity">{{ item.quantity }} шт.</div>
            <div class="totle">Всего: {{ item.totalPrice }} ₽</div>
          </div>
        </div>
        <p class="sum">
          сумма:<span>{{ totalPrice }}</span>
        </p>
        <p class="total">
          к оплате:<span>{{ totalPrice }}</span>
        </p>
        <button class="btn" v-on:click="B24">оформить заказ</button>
      </div>
    </div>
  </base-template>
</template>

<script>

import Store from "@/store/store";






import BaseTemplate from "@/templates/BaseTemplate";
import Select from "@/components/blocks/select";
export default {
  name: "Order",
  data() {
    return {
      products:[],
      active1: false,
      active2: false,
      comment: "",
      pay_type_cash: false,
      pay_type_cart: true,
      optionsAddress: Store.state.user["address"],
      optionsTime: [
        {name: "с 12.00 до 13.00", value: "с 12 до 13"},
        {name: "с 13.00 до 14.00", value: "с 13 до 14"},
        {name: "с 14.00 до 15.00", value: "с 14 до 15"},
      ],
    };
  },
  components: {
    Select,
    BaseTemplate,
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
    B24: function () {
      var param = new FormData();
      let arr = [];
      Store.state.cart.forEach(element => arr.push(element.ID));
      let arr_len = [];
      Store.state.cart.forEach(element => arr_len.push(element.quantity));
      param.append("products", JSON.stringify(arr));
      param.append("products_quantity", JSON.stringify(arr_len));
      param.append("address",this.optionsAddress);
      param.append("comment", this.comment);
      param.append("name", Store.state.user.first_name);
      param.append("second_name", Store.state.user.second_name);
      param.append("last_name", Store.state.user.last_name);
      param.append("phone", Store.state.user.phone);
      param.append("hash", Store.state.user.user_hash);


      var xhr = new XMLHttpRequest();
      xhr.open('POST', "http://localhost/SimpleKithen/back/connectors/order.php", false);
      xhr.send(param);
      this.$router.push('/');
    },

    readCookie: function (name) {
      var name_cook = name + "=";
      var spl = document.cookie.split(";");
      for (var i = 0; i < spl.length; i++) {
        var c = spl[i];
        while (c.charAt(0) == " ") {
          c = c.substring(1, c.length);
        }
        if (c.indexOf(name_cook) == 0) {
          return c.substring(name_cook.length, c.length);
        }
      }
      return null;
    },
  }
};
</script>

<style lang="scss" scoped>
@import "../styles/helpers/variables";
@import "../styles/helpers/form";

.content-order {
  display: flex;
  h3 {
    font-size: 20px;
    font-weight: 300;
    line-height: 22px;
    display: flex;
    align-items: center;
    padding-bottom: 10px;
    margin-bottom: 40px;
    color: $border-black;
    border-bottom: 1px solid $border-black;
  }
  .left-col {
    width: 50%;
    min-height: calc(100vh - 385px);
    padding: 40px 100px;
    border-right: 2px solid $border-black;
    @media (max-width: 1600px){
      padding: 40px 60px;
    }
    .label {
      margin-bottom: 10px;
    }
    input{
      margin-bottom: 30px;
    }
    select {
      margin-bottom: 30px;
    }
    textarea {
      height: 50px;
      margin-bottom: 30px;
      resize: none;
    }
    .line {
      display: flex;
      justify-content: flex-start;
      align-items: center;
      margin-bottom: 10px;
      .label-checkbox {
        margin-right: 10px;
      }
      span {
        font-size: 20px;
        font-weight: 300;
        line-height: 22px;
      }
    }
  }
  .right-col {
    width: 50%;
    padding: 40px 100px;
    justify-content: space-between;
    @media (max-width: 1600px){
      padding: 40px 60px;
    }
    h3 {
      justify-content: space-between;
      margin-bottom: 15px;
      a {
        font-size: 18px;
        font-weight: 500;
        line-height: 17px;
        color: $border-black;
      }
    }
    .list-products {
      max-height: 345px;
      margin-bottom: 20px;
      overflow: auto;
      border-bottom: 2px solid $border-black;
    }
    .table-rows {
      display: inline-grid;
      grid-template-rows: 100%;
      grid-template-columns: 110px 41% 15% 10% 19%;
      align-items: center;
      width: 99%;
      padding: 20px 0;
      font-size: 20px;
      font-weight: 300;
      line-height: 19px;
      color: $border-black;
      border-bottom: 1px solid $border-black;
      @media (max-width: 1600px){
        grid-template-columns: 110px 36% 13% 14% 22%;
      }
      @media #{$sm} {
        grid-template-columns: 20% 31% 13% 14% 22%;
      }
      @media #{$xs} {
        display: flex;
        flex-wrap: wrap;
      }

      &:last-of-type {
        border-bottom: 0;
      }
      .foto {
        img {
          width: 95px;
        }
      }
      .sostaav {
        padding-right: 25px;
        font-size: 14px;
        font-weight: 300;
        line-height: 14px;
        color: $border-black;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: flex-start;
        height: 100%;
        .name {
          margin-bottom: 10px;
          font-size: 18px;
          font-weight: 500;
          line-height: 17px;
        }
      }
    }
    .sum {
      padding-bottom: 10px;
      font-size: 18px;
      font-weight: 500;
      line-height: 19px;
      border-bottom: 2px solid #919191;
      margin-bottom: 20px;
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      span {
        font-size: 22px;
        line-height: 21px;
        color: #919191;
        text-align: right;
        text-decoration-line: line-through;
      }
    }
    .total {
      font-size: 18px;
      font-weight: 500;
      line-height: 17px;
      margin-bottom: 15px;
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      span {
        font-size: 22px;
        font-weight: 500;
        line-height: 21px;
      }
    }
    .btn {
      width: 100%;
      height: 50px;
      font-size: 30px;
      font-weight: bold;
      line-height: 29px;
      background: #ffbf19;
      text-align: center;
      border: 0;
    }
  }
}
</style>
