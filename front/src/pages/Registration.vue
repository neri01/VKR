<template>
  <base-template>
    <h1 class="visually-hidden">Простая кухня</h1>
    <form class="login" v-if="!viewFormCode">
      <div class="left-col">
        <p>
          укажите данные для курьера
        </p>
        <label class="labels">имя</label>
        <input
            v-model="first_name"
            type="first_name"
            class="text"
            id="first_name"
            name="first_name"
        />
        <label class="labels">фамилия</label>
        <input
            v-model="second_name"
            type="second_name"
            class="text"
            id="second_name"
            name="second_name"
        />
        <label class="labels">отчество</label>
        <input
            v-model="last_name"
            type="last_name"
            class="text"
            id="last_name"
            name="last_name"
        />
        <div class="block-btn">
          <button v-on:click.prevent="set_data" type="submit" class="arrow">сохранить</button>
        </div>
      </div>
      <div class="right-col">
        <p>адреса для доставки</p>
        <label class="labels">адрес доставки</label>
        <input
            v-model="address"
            type="address"
            class="text"
            id="address"
            name="address"
        />
        <button v-on:click.prevent="logout" type="submit" class="arrow">выйти</button>
      </div>
    </form>
    <form
        class="login code"
        v-if="viewFormCode && !role"
        @submit="code"
    >
      <div class="right-col pr-0 h-100">
        <div class="content">
          <p class="mb-40">введите код из смс</p>
          <input type="text" class="text" v-model="codeSms" name="codeSms" />
          <span class="error" v-if="!this.codeSms">Вы ввели неверный код</span>
          <button type="submit" class="arrow">подтвердить</button>
          <div class="time">
            <span>
              <span class="timer">0 : {{ currentTime }}</span>
              Код не пришел?
            </span>
            <button class="no-border">отправить еще раз</button>
          </div>
        </div>
      </div>
    </form>
    <form class="login" v-if="role" @submit.prevent="role">
      <div
          class="left-col role"
          :class="{ active: activeCorp }"
          @click="
          activeCorp = true;
          activePerson = false;
        "
      >
        <h3>корпоративный</h3>
        <form class="role" v-if="activeCorp">
          <p class="mini">
            Ваш заказ будет доставлен в промежутке с 12.00 до 14.00 в
            организацию “Интрес” по адресу:
          </p>
          <select>
            <option>Петровская, 28</option>
          </select>
          <button type="submit" class="arrow">перейти</button>
        </form>
      </div>
      <div
          class="right-col role"
          :class="{ active: activePerson }"
          @click="
          activePerson = true;
          activeCorp = false;
        "
      >
        <h3>персональный</h3>
        <form class="role" v-if="activePerson">
          <p class="mini">
            Ваш заказ будет доставлен в промежутке с 12.00 до 14.00 по адресу:
          </p>
          <select>
            <option>Петровская, 28</option>
          </select>
        </form>
      </div>
    </form>
  </base-template>
</template>

<script>
import BaseTemplate from "@/templates/BaseTemplate";
import Vue from "vue";
import VueMask from "v-mask";
import Store from "@/store/store";

Vue.use(VueMask);


function get_user(phone,hash){
  var param = new FormData();
  param.append("phone", phone);
  param.append("hash", hash);
  var xhr = new XMLHttpRequest();
  xhr.open('POST', "http://localhost/SimpleKithen/back/connectors/get_user_data.php", false);
  xhr.send(param);
  var data;
  if (xhr.status != 200) {
    data = ( xhr.status + ': ' + xhr.statusText );
  } else {
    data = JSON.parse( xhr.responseText );
  }
  return data;
};


export default {
  name: "Registration",
  components: {
    BaseTemplate,
  },
  data() {
    return {
      inputPhoneModel: "",
      codeSms: "",
      check: false,
      role: false,
      errorTel: false,
      errorCheck: false,
      viewFormCode: false,
      activePerson: false,
      activeCorp: false,
      currentTime: 60,
      address: Store.state.user["address"],
      first_name: Store.state.user["first_name"],
      second_name: Store.state.user["second_name"],
      last_name: Store.state.user["last_name"],

    };
  },
  destroyed() {
    this.stopTimer();
  },
  methods: {
    logout: function() {
      Store.state.user = {};
      this.address = "";
      this.first_name = "";
      this.second_name = "";
      this.last_name = "";
    },
    set_data: function(){
      var param = new FormData();
      param.append("first_name", this.first_name);
      param.append("second_name", this.second_name);
      param.append("last_name", this.last_name);
      param.append("phone", Store.state.user["phone"]);
      param.append("hash", Store.state.user["user_hash"]);
      param.append("address", this.address);
      var xhr = new XMLHttpRequest();
      xhr.open('POST', "http://localhost/SimpleKithen/back/connectors/set_user_data.php", false);
      xhr.send(param);
      Store.state.user = get_user(Store.state.user["phone"],Store.state.user["user_hash"]);
    },
    login: function (e) {
      if (this.inputPhoneModel && this.check) {
        this.viewFormCode = true;
        this.startTimer();
      }
      if (!this.inputPhoneModel) {
        this.errorTel = true;
      }
      if (!this.check) {
        this.errorCheck = true;
      }

      e.preventDefault();
    },
    code: function (e) {
      if (this.codeSms) {
        this.role = true;
      }
      e.preventDefault();
    },
    startTimer() {
      this.timer = setInterval(() => {
        this.currentTime--;
      }, 1000);
    },
    stopTimer() {
      clearTimeout(this.timer);
    },
  },
  watch: {
    currentTime(time) {
      if (time === 0) {
        this.stopTimer();
      }
    },
  },
};

</script>

<style lang="scss" scoped>
@import "../styles/helpers/variables";
@import "../styles/helpers/form";
form.login {
  display: flex;
  &.code {
    .right-col {
      div {
        position: relative;
        .error {
          top: 125px;
          font-size: 12px;
          line-height: 12px;
          color: red;
        }
      }
    }
  }

  @media #{$xl} {
    flex-direction: column;
    min-height: calc(100vh - 335px);
  }
  p {
    font-weight: 500;
    font-size: 30px;
    line-height: 29px;
    color: $border-black;
    max-width: 760px;
    margin-bottom: 80px;
    @media #{$lm} {
      font-size: 22px;
      line-height: 21px;
    }
    &.mb-40 {
      margin-bottom: 40px !important;
      min-height: auto !important;
    }
  }
  .role {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    cursor: pointer;
    &.active {
      background: $border-black;
      color: #fff;
      h3 {
        color: #fff;
        margin-bottom: 40px;
      }
      p.mini {
        font-weight: 300;
        font-size: 20px;
        line-height: 22px;
        color: #fff;
        margin-bottom: 25px;
      }
      .arrow {
        border-color: #fff;
        background: url("data:image/svg+xml,%3Csvg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cg clip-path='url(%23clip0)'%3E%3Crect x='23.04' y='24' width='24' height='0.96' transform='rotate(-90 23.04 24)' fill='white'/%3E%3Crect width='24' height='0.96' fill='white'/%3E%3Crect x='-0.788452' y='23.999' width='33.261' height='0.96' transform='rotate(-45 -0.788452 23.999)' fill='white'/%3E%3C/g%3E%3Cdefs%3E%3CclipPath id='clip0'%3E%3Crect width='24' height='24' fill='white'/%3E%3C/clipPath%3E%3C/defs%3E%3C/svg%3E")
        no-repeat 98% center;
        color: #fff;
        width: 100%;
        max-width: 760px;
      }
      select {
        height: 50px;
        width: 100%;
        max-width: 760px;
        margin-bottom: 30px;
        font-size: 25px;
        line-height: 24px;
        color: $border-black;
      }
    }
    h3 {
      font-weight: 500;
      font-size: 50px;
      line-height: 48px;
      text-align: center;
      width: 100%;
      @media #{$xs} {
        font-size: 38px;
      }
    }
  }
  .left-col {
    width: calc(50% - 20px);
    border-right: 2px solid $border-black;
    padding: 120px 100px;
    min-height: calc(100vh - 425px);
    margin-left: 20px;
    .error {
      margin-top: -40px;
      margin-bottom: 28px;
    }
    .labels{
      font-size: 28px;
      margin-top: 5px;
      margin-bottom: 5px;

    }
    input.text {
      width: 70%;
      max-width: 760px;
      height: 50px;
      margin-bottom: 40px;
      @media #{$lm} {
        width: calc(100% - 145px);
      }
      @media #{$xl} {
        width: 100%;
        max-width: 540px;
      }
    }
    @media #{$ll} {
      padding: 60px 20px;
      p {
        min-height: 70px;
        margin-bottom: 5px;
        @media #{$xl} {
          margin-bottom: 25px;
          min-height: auto;
        }
      }
    }
    @media #{$lm} {
      min-height: calc(100vh - 313px);
    }
    @media #{$xl} {
      width: 100%;
      border-right: 0;
      min-height: 200px;
      border-bottom: 2px solid $border-black;
      padding: 40px 20px;
    }

    .block-btn {
      display: flex;
      flex-wrap: wrap;
      justify-content: flex-start;
      align-items: flex-end;
      .arrow {
        width: 70%;
        max-width: 760px;
        margin-right: 30px;
        @media #{$lm} {
          width: calc(100% - 145px);
        }
        @media #{$xl} {
          width: 100%;
          max-width: 540px;
        }
        @media #{$xs} {
          margin-bottom: 25px;
          margin-right: 0;
        }
      }
    }
  }

  .right-col {
    width: 50%;
    padding: 120px 100px;
    &.pr-0 {
      padding-right: 0;
      @media #{$lm} {
        padding-right: 20px;
      }
    }
    &.h-100 {
      min-height: calc(100vh - 385px);
      @media #{$lm} {
        min-height: calc(100vh - 337px);
      }
    }
    .error {
      width: 100%;
      position: absolute;
      top: 30px;
      left: 0;
      @media #{$xl} {
        margin-bottom: 0;
        top: auto;
        bottom: -10px;
        min-height: 10px;
        display: block;
      }
    }
    input.text {
      width: 100%;
      max-width: 850px;
      height: 50px;
      margin-bottom: 30px;
    }
    .arrow {
      width: 100%;
      max-width: 850px;

      @media #{$xs} {
        margin-bottom: 25px;
      }
    }
    @media #{$ll} {
      padding: 60px 20px;
      p {
        min-height: 90px;
        margin-bottom: 70px;
        @media #{$xl} {
          min-height: auto;
          margin-bottom: 25px;
        }
      }
    }
    @media #{$xl} {
      width: 100%;
      min-height: 358px;
      padding: 40px 20px;
    }
    div {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: flex-start;
      flex-wrap: wrap;
      max-width: 760px;
      margin-bottom: 70px;
      min-height: 50px;
      position: relative;
      @media #{$lm} {
        margin-bottom: 20px;
      }
      @media #{$xs} {
        align-items: flex-start;
      }
      label {
        margin-right: 10px;
      }
      span {
        font-weight: 300;
        font-size: 14px;
        line-height: 14px;
        color: #161712;
        max-width: calc(100% - 40px);
      }
    }
    .time {
      width: 100%;
      max-width: 850px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: 300;
      font-size: 20px;
      line-height: 22px;
      .timer {
        margin-right: 20px;
      }
    }
  }
}
</style>
