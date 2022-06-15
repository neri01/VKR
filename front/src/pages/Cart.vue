<template>
  <base-template>
    <h1 class="visually-hidden">Простая кухня</h1>
    <h2 class="title">корзина</h2>
    <div class="block-products">
      <div class="table-title">
        <div class="foto">Товар</div>
        <div class="sostaav">Состав</div>
        <div class="price">Цена</div>
        <div class="totle">Итого</div>
        <div class="buttons"></div>
      </div>
      <div v-if="$store.state.cart.length > 0" class="list-products">
        <div
          class="table-rows"
          v-for="item in $store.state.cart"
          :key="item.name"
        >
          <basket-product :item="item"></basket-product>
        </div>
      </div>
      <div v-else class="list-products">
        <span class="no-item"> Корзина пуста </span>
      </div>
    </div>
    <div class="block-promo-pay">
      <div class="promo">
        <h3>активация промокода:</h3>
        <form>
          <input
            type="text"
            class="text"
            v-model="promoCod"
            placeholder="введите промокод"
          />
          <div class="block-btn">
            <button type="button" class="btn btn-arrow">подтвердить</button>
            <button type="button" class="btn no-border">отменить</button>
          </div>
        </form>
      </div>
      <div class="pay">
        <p>
          Итого: <span>{{ totalPrice }} </span>
        </p>
        <h4>
          К оплате: <span>{{ totalPrice }} </span>
        </h4>
        <button
          class="btn"
          :disabled="errorPay && totalPrice < minPay"
          @click="pay()"
        >
          подтвердить
        </button>
        <div class="error" v-if="errorPay && totalPrice < minPay">
          * Невозможно выполнить заказ. Минимальная сумма заказа {{ minPay }} ₽.
          Для завершения заказа добавьте в корзину товаров еще на сумму
          {{ min }} ₽.
        </div>
      </div>
    </div>
  </base-template>
</template>

<script>
import BaseTemplate from "@/templates/BaseTemplate";
import BasketProduct from "@/components/blocks/BasketProduct";
import Store from "@/store/store";
import router from "@/router";
export default {
  name: "Busket",
  data() {
    return {
      promoCod: "",
      errorPay: false,
      min: 0,
      minPay: 300,
    };
  },
  components: {
    BasketProduct,
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
    pay() {
      if (this.totalPrice < this.minPay) {
        this.errorPay = true;
        this.min = this.minPay - this.totalPrice;
        return false;
      } else {
        if (Store.state.user["phone"]===undefined){
        alert("авторизуйся");
          router.push("login");
        }else{
        router.push("order");
        }
      }
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../styles/helpers/variables";

.block-products {
  padding: $padding-content;
  @media #{$ll} {
    padding: 30px 20px;
  }

  .table-title {
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

    div {
      margin-right: 20px;
      padding: 20px 0;
      @media #{$xs} {
        width: 100%;
        margin-right: 0;
      }
    }
  }
  .table-title {
    @media #{$xs} {
      display: none;
    }
  }
  .price {
    @media #{$lm} {
      font-size: 18px;
    }
  }
  .no-item {
    font-weight: 500;
    font-size: 30px;
    line-height: 29px;
    color: $border-black;
    margin: 30px auto;
    display: block;
    text-align: center;
  }
}
.block-promo-pay {
  display: flex;
  width: 100%;
  border-top: 2px solid $border-black;
  @media #{$sm} {
    flex-direction: column-reverse;
  }

  .promo {
    width: 50%;
    border-right: 2px solid $border-black;
    padding: $padding-content;
    @media #{$ll} {
      padding: 30px 20px;
    }
    @media #{$sm} {
      width: 100%;
      border-right: none;
    }
    h3 {
      font-weight: 500;
      font-size: 30px;
      line-height: 29px;
      color: $border-black;
      margin-bottom: 25px;
      @media #{$lm} {
        font-size: 22px;
      }
    }

    input {
      max-width: 630px;
      width: 80%;
      height: 50px;
      background: #fff;
      border: 1px solid #000000;
      padding: 0 13px;
      font-size: 25px;
      line-height: 24px;
      color: #161712;
      margin-bottom: 25px;
      @media #{$lm} {
        width: calc(100% - 130px);
      }
      @media #{$xs} {
        width: 100%;
      }
      &::-webkit-input-placeholder {
        opacity: 0.5;
      }
      &:-ms-input-placeholder {
        opacity: 0.5;
      }
      &::-moz-placeholder {
        opacity: 0.5;
      }
    }
    .block-btn {
      display: flex;
      justify-content: space-between;
      max-width: 790px;
      align-items: flex-end;
      flex-wrap: wrap;
      .btn-arrow {
        width: 40%;
        max-width: 200px;
        border: 1px solid #000000;
        height: 50px;
        background: url("data:image/svg+xml,%3Csvg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cg clip-path='url(%23clip0)'%3E%3Crect x='23.04' y='24' width='24' height='0.96' transform='rotate(-90 23.04 24)' fill='%23161712'/%3E%3Crect width='24' height='0.96' fill='%23161712'/%3E%3Crect x='-0.788452' y='23.999' width='33.261' height='0.96' transform='rotate(-45 -0.788452 23.999)' fill='%23161712'/%3E%3C/g%3E%3Cdefs%3E%3CclipPath id='clip0'%3E%3Crect width='24' height='24' fill='white'/%3E%3C/clipPath%3E%3C/defs%3E%3C/svg%3E")
          no-repeat 98% center;
        text-align: left;
        font-size: 25px;
        line-height: 24px;
        color: $border-black;
        padding-left: 15px;
        @media #{$lm} {
          width: calc(100% - 130px);
        }
        @media #{$xs} {
          width: 100%;
          margin-bottom: 20px;
        }
      }
      .no-border {
        border: none;
        font-weight: bold;
        font-size: 20px;
        line-height: 19px;
        text-decoration-line: underline;
        color: $border-black;
        &:hover {
          text-decoration: none;
        }
      }
    }
  }
}
.pay {
  padding: $padding-content;
  width: 50%;
  @media #{$ll} {
    padding: 30px 20px;
  }
  @media #{$sm} {
    width: 100%;
    border-bottom: 2px solid $border-black;
  }
  p {
    font-weight: 300;
    font-size: 30px;
    line-height: 1;
    color: #919191;
    display: flex;
    justify-content: space-between;
    width: 100%;
    margin-bottom: 10px;
    text-transform: lowercase;
    @media #{$lm} {
      font-size: 22px;
      margin-bottom: 25px;
    }
    @media #{$xs} {
      font-size: 18px;
    }
    span {
      text-decoration-line: line-through;
    }
  }
  h4 {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    width: 100%;
    font-weight: 500;
    font-size: 30px;
    line-height: 1;
    color: $border-black;
    margin-bottom: 20px;
    text-transform: lowercase;
    @media #{$lm} {
      font-size: 22px;
      margin-bottom: 25px;
    }
    @media #{$xs} {
      font-size: 18px;
    }
    span {
      font-weight: 500;
      font-size: 80px;
      line-height: 0.9;
      display: flex;
      align-items: center;
      text-align: right;
      letter-spacing: 0.07em;
      text-transform: uppercase;
      @media #{$lm} {
        font-size: 60px;
      }
      @media #{$xs} {
        font-size: 35px;
      }
    }
  }
  .btn {
    width: 100%;
    height: 50px;
    border: none;
    background: #ffbf19;
    font-weight: bold;
    font-size: 30px;
    line-height: 29px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
  }
  .error {
    font-weight: 300;
    font-size: 14px;
    line-height: 14px;
    color: #ff1927;
    padding-top: 10px;
  }
}
</style>
