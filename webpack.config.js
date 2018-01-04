//Based on https://github.com/tawfekov/SymfonyVue/blob/master/webpack.config.js

var Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where all compiled assets will be stored
    .setOutputPath('public/')

    // the public path used by the web server to access the previous directory
    .setPublicPath('/')

    // will create public/build/app.js and public/build/app.css
    //.addEntry('app', './assets/js/app.js')
    .addEntry('js/app', './assets/js/vue.js')

    .enableVueLoader()

    //.addStyleEntry('css/app', './assets/css/app.scss')
    // allow sass/scss files to be processed
    .enableSassLoader()

    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()

    //.enableSourceMaps(!Encore.isProduction())

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // show OS notifications when builds finish/fail
    .enableBuildNotifications()

    // create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning()
    //.enableVueLoader()
;

// export the final configuration
module.exports = Encore.getWebpackConfig();