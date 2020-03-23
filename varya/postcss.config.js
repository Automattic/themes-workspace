const postcssFocusWithin = require('postcss-focus-within');
const postcssCustomMedia = require('postcss-custom-media');
const postcssCustomProperties = require('postcss-custom-properties');

module.exports = {
	plugins: [
    autoprefixer(),
		postcssFocusWithin(/* pluginOptions */),
		postcssCustomMedia(/* pluginOptions */),
    postcssCustomProperties({
      importFrom: [
        'assets/css/variables.css',
        'assets/css/variables-editor.css'
      ]
    })
	]
};
