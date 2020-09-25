const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
    mode: "production",
    output: {
        path: __dirname + "/template/static",
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "[name].css",
            chunkFilename: "[id].css",
            ignoreOrder: false,
        }),
    ],
    module: {
        rules: [
            {
                test: /\.s[ac]ss$/i,
                use: [MiniCssExtractPlugin.loader, "css-loader", "sass-loader"],
            },
            {
                test: /\.(ttf|eot|woff|woff2)$/i,
                use: {
                    loader: "file-loader",
                    options: {
                        name: "fonts/[name]-[hash].[ext]",
                    },
                },
            },
            {
                test: /\.svg$/i,
                use: {
                    loader: "file-loader",
                    options: {
                        name: "svg/[name]-[hash].[ext]",
                    },
                },
            },
        ],
    },
};
