import tailwindcss from "tailwindcss"

export const plugins = [
  tailwindcss('./tailwind.config.js'),
  require('postcss-import'),
  require('autoprefixer'),
]
