<template>
  <div class="select" :class="{ active: open }">
    <p
      @click="
        openList = !openList;
        open = !open;
      "
    >
      {{ selectedLoc }}
    </p>
    <ul class="options" v-if="openList">
      <li
        v-for="option in options"
        :key="option.value"
        @click="
          selectOption(option);
          open = !open;
        "
      >
        {{ option.name }}
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "select",
  props: {
    options: {
      type: Array,
      default() {
        return [];
      },
    },
    selected: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      openList: false,
      open: false,
      selectedLoc: this.selected,
    };
  },
  methods: {
    selectOption(option) {
      this.selectedLoc = option.name;
      this.openList = false;
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../../styles/helpers/variables";
.select {
  position: relative;
  p {
    border: 1px solid #000000;
    height: 50px;
    width: 100%;
    background: #fff;
    display: block;
    font-size: 25px;
    line-height: 50px;
    padding-left: 10px;
    margin-bottom: 30px;
    cursor: pointer;
  }
  ul {
    width: 100%;
    border: 1px solid #000000;
    border-top: 0;
    padding: 10px;
    position: absolute;
    top: 50px;
    left: 0;
    background: #fff;
    margin: 0;
    z-index: 10;
    list-style: none;
    li {
      font-size: 25px;
      color: $border-black;
      margin-bottom: 15px;
      cursor: pointer;
    }
  }
}
</style>
