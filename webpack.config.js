const webpack = require('webpack');
const path = require('path');
const package = require('./package.json');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCSSPlugin = require('optimize-css-assets-webpack-plugin');
const BrowserSyncPlugin = require( 'browser-sync-webpack-plugin' );
const VueLoaderPlugin = require('vue-loader/lib/plugin');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

var glob = require("glob");
const config = require( './config.json' );

var appName = 'app';
var mode = 'development';
var entryPoint = {
    admin: glob.sync("./admin/views/modules/**/*.js").concat(['./admin/app/main.js']),
    vendor: [ 'vue', 'vuex' ],
    style: './admin/app/assets/scss/style.scss',
};

var exportPath = path.resolve(__dirname, './admin/js');

// Enviroment flag
var plugins = [];
var env = process.env.WEBPACK_ENV;

function isProduction() {
    return process.env.WEBPACK_ENV === 'production';
}

// extract css into its own file
const extractCss = new MiniCssExtractPlugin({
    filename: "../../admin/css/[name].css",
});


plugins.push( extractCss );

plugins.push(new BrowserSyncPlugin({
    proxy: {
        target: config.proxyURL
    },
    files: [
        '**/*.php'
    ],
    cors: true,
    reloadDelay: 0
} ));


plugins.push(
    new VueLoaderPlugin()
);

// Generate a 'manifest' chunk to be inlined in the HTML template
// plugins.push(new webpack.optimize.CommonsChunkPlugin('manifest'));

// Compress extracted CSS. We are using this plugin so that possible
// duplicated CSS from different components can be deduped.
plugins.push(new OptimizeCSSPlugin({
    cssProcessorOptions: {
        safe: true,
        map: {
            inline: false
        }
    }
}));

// Differ settings based on production flag
if ( isProduction() ) {
    plugins.push(new UglifyJsPlugin({
        sourceMap: true,
        // uglifyOptions: {
        //     ecma:8,
        //     compress: {
        //         warnings: false
        //     }
        // }
    }));
    plugins.push(new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/));
    plugins.push(new webpack.DefinePlugin({
        'process.env.NODE_ENV': JSON.stringify(process.env.NODE_ENV),
    }));
    // plugins.push(new BundleAnalyzerPlugin());

    appName = '[name].min.js';
    mode = 'production';
} else {
    appName = '[name].js';
}

module.exports = {
    entry: entryPoint,
    output: {
        path: exportPath,
        filename: appName,

    },

    resolve: {
        extensions: ['.mjs', '.mts', '.ts', '.tsx', '.js', '.jsx'],
        alias: {
            'vue$': 'vue/dist/vue.esm.js',
            '@': path.resolve('./admin/app/'),
        },
        modules: [
            path.resolve('./node_modules'),
            path.resolve(path.join(__dirname, 'admin/app/')),
        ]
    },
    devtool: isProduction()? false : 'inline-source-map',
    plugins,
    optimization: {
        runtimeChunk: 'single',
        splitChunks: {
          chunks: 'all'
        }
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /(node_modules|bower_components)/,
                loader: 'babel-loader',
                query: {
                    presets: ["es2015", "stage-2"]
                }
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader',
            },
            {
                test: /\.less$/,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                    },
                    "css-loader",
                    "less-loader"
                ]
            },
            {
                test: /\.scss$/,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                    },
                    "css-loader",
                    "sass-loader"
                ]
            },
            {
                test: /\.css$/,
                use: [ 'style-loader', 'css-loader' ]
            }
        ]
    },
    mode: mode,
    node: {
        fs: 'empty'
    }
}
