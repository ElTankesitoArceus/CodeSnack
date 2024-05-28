/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./Frontend/*/*.{html,php}"],
    theme: {
      extend: {
        fontFamily: {
          customFont: ['lexend-deca', "sans-serif"],
          customFont: ['montserrat', "sans-serif"]
        },
      },
    },
    plugins: [],
  }
