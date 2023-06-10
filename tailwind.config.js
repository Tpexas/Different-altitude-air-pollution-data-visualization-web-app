const defaultTheme = require('tailwindcss/defaultTheme');
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    "./node_modules/flowbite/**/*.js",
    "./src/**/*.{html,js}",
    // "./node_modules/tw-elements/dist/js/**/*.js"
  ],
  theme: {
    colors:{
      aqi_green : '#00e400',
      aqi_yellow: '#ffff00',
      aqi_orange: '#ff7e00',
      aqi_red: '#ff0000',
      aqi_purple: '#8F3F97',
    },
    extend: {
      colors:{
        'rose': {100: 'rgb(255 228 230)'},
      },
    },

  },
  plugins: [
    require('flowbite/plugin'),
    // require("tw-elements/dist/plugin")
  ],
  
}
