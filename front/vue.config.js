module.exports = {
  devServer: {
    proxy: {
      '^/api/': {
        target: 'http://localhost/',
        changeOrigin: true, // so CORS doesn't bite us.
      },
    },
  },
  filenameHashing: false,
  configureWebpack: {
    output: {
      filename: "js/[name].js?p=[hash:8]",
      chunkFilename: "js/[name].js?p=[hash:8]",
    },
  },

  chainWebpack: (config) => {
    const svgRule = config.module.rule("svg");

    svgRule.uses.clear();

    svgRule.use("vue-svg-loader").loader("vue-svg-loader");
  },

  css: {
    extract: {
      filename: "css/[name].css?p=[hash:8]",
      chunkFilename: "css/[id].css?p=[hash:8]",
    },
  },
};
