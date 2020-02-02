const mix = require('laravel-mix');
mix.babelConfig({
    presets:["@babel/preset-env"],
    plugins: [["import", {
        "libraryName": "iview",
        "libraryDirectory": "src/components"
    }]]
}).webpackConfig({
    resolve:{
        mainFiles: ["index"] //index不能少
    }
})
.js('resources/admin/admin.js', 'public/admin/js')
.js('resources/app/app.js', 'public/app/js')
.js('resources/home/home.js', 'public/home/js')
.sass('resources/sass/admin.scss', 'public/admin/css')
.sass('resources/sass/app.scss', 'public/app/css')
.sass('resources/sass/home.scss', 'public/home/css')
.sass('resources/sass/common.scss', 'public/common/css')
.sass('resources/sass/layout.scss', 'public/common/css');
