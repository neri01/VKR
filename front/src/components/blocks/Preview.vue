<template>

</template>
<script>

export default {
  name: "Preview",

  data() {
    return {
      isError: false,
    };
  },
  methods: {
    setCookies(val) {
      this.isError = !val;
      this.$emit("setCookies", val);
    },
  },
};
</script>
<style lang="scss" scoped>
@import "src/styles/helpers/variables";

.preview {
  display: flex;
  height: 100%;
  background-color: $white-true;

  &__wrap {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 50px 0;
  }

  &__logo {
    display: block;
    width: 187px;
    margin: 0 auto 48px;
  }

  &__title {
    max-width: 730px;
    margin: 0 auto 30px;
    font-size: 30px;
    font-weight: 600;
    line-height: 36px;
    color: $title-color;
    text-align: center;
    @media #{$xs} {
      font-size: 20px;
      line-height: 26px;
      letter-spacing: 0.2px;
    }
  }

  &__text {
    margin-bottom: 30px;
    font-size: 16px;
    line-height: 24px;
    text-align: center;
    letter-spacing: 0.3px;
  }

  &__btns {
    display: flex;
    align-items: center;
    justify-content: center;
    @media #{$xs} {
      flex-wrap: wrap;
    }
  }
}
</style>
