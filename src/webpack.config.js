/*
 * Copyright (c) Jake Toolson 2018.
 */

const path = require('path');
const WebpackAssetsManifest = require('webpack-assets-manifest');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const assetsDir = __dirname +'/client/';
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');

module.exports = {
    entry: {
        'js/app' : [
            assetsDir + 'main.ts'
        ],
        'js/vendor' : [
            assetsDir + 'vendor.js',
        ],
        'css/vendor' : [
            __dirname + '/node_modules/bootstrap/dist/css/bootstrap.css',
            __dirname + '/node_modules/bootstrap/dist/css/bootstrap-grid.css',
        ]
    },
    output: {
        path: path.join( __dirname, 'public', 'build'),
        filename: "[name]-[hash].js",
        publicPath: 'public/build'
    },
    module: {
        rules: [
            {
                test: /\.(png|jpg|jpeg|gif)$/,
                loader: 'file-loader',
                options: {
                    name: 'img/[name].[ext]',
                    publicPath: '/build/'
                }
            },
            {
                test: /\.css$/,
                use: ExtractTextPlugin.extract({
                    use: ['css-loader'],
                    fallback: 'style-loader'
                })
            },
            {
                test: /\.scss$/,
                exclude: /node_modules/,
                use: ExtractTextPlugin.extract({
                    use: ['css-loader', 'sass-loader'],
                    fallback: "style-loader"
                })
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader',
                options: {
                    loaders: {
                        'scss': 'vue-style-loader!css-loader!sass-loader',
                        'sass': 'vue-style-loader!css-loader!sass-loader?indentedSyntax',
                    }
                }
            },
            {
                test: /\.(ts|tsx)?$/,
                loader: 'awesome-typescript-loader'
            }
        ]
    },
    plugins: [
        new UglifyJSPlugin(), // auto minify
        new WebpackAssetsManifest({
            output: 'rev-manifest.json',
        }),
        new ExtractTextPlugin({
            filename: '[name]-[hash].css',
        }),
        new CleanWebpackPlugin(
            ['js', 'css'],
            {
                root: path.join(__dirname, 'public', 'build'),
                exclude: ['components']
            }
        ),
    ],
    resolve: {
        extensions: ['.ts', '.tsx', '.js', '.vue', '.json'],
        alias: {
            'vue': 'vue/dist/vue.js',
        }
    },
    node: {
        fs: 'empty'
    },
    watchOptions: {
        ignored: [
            '/node_modules/',
        ]
    }
};