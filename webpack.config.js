const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const BrowserSyncPlugin = require("browser-sync-webpack-plugin");
const { CleanWebpackPlugin } = require("clean-webpack-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const CopyWebpackPlugin = require("copy-webpack-plugin");
const ImageMinimizerPlugin = require("image-minimizer-webpack-plugin");

let browserSyncPluginOptions = {
	port: 3000,
	proxy: "http://localhost/fooz/",
};

try {
	const browserSyncCustomConfig = require("./.browsersync.config.json");
	browserSyncPluginOptions.port = browserSyncCustomConfig.port;
	browserSyncPluginOptions.proxy = browserSyncCustomConfig.proxy;
} catch (e) {}

function generateEntryPoints() {
	let entryPoints = {};

	entryPoints["scripts"] = "./assets/index.js";
	return entryPoints;
}

module.exports = {
	mode: "development",

	entry: generateEntryPoints(),
	output: {
		filename: "./[name].js",
		path: path.resolve(__dirname, "dist"),
	},

	plugins: [
		new CleanWebpackPlugin(),
		new MiniCssExtractPlugin({
			filename: "style.css", // Output filename for CSS
		}),
		new BrowserSyncPlugin({
			port: browserSyncPluginOptions.port,
			proxy: browserSyncPluginOptions.proxy,
			files: ["**/*.php"],
			cors: "true",
		}),
		new CopyWebpackPlugin({
			patterns: [
				{
					from: path.resolve(__dirname, "assets/img"), // Source folder
					to: path.resolve(__dirname, "dist/img"), // Destination folder
					globOptions: {
						dot: true, // Include hidden files and directories
						// Only match files that are images (or directories containing them)
						// This ensures that folders like 'icons' are included, even if they are empty
						ignore: ["**/.*"], // Ignore hidden files
					},
					filter: (resourcePath) => {
						// Allow copying image files and directories
						return (
							/\.(jpe?g|png|gif|svg|webp)$/i.test(resourcePath) ||
							resourcePath.endsWith("/")
						);
					},
				},
			],
		}),
		new ImageMinimizerPlugin({
			minimizer: {
				implementation: ImageMinimizerPlugin.imageminGenerate,
				options: {
					plugins: [
						["imagemin-webp", { quality: 75 }], // Conversion to WebP
					],
				},
			},
			generator: [
				{
					implementation: ImageMinimizerPlugin.imageminGenerate, // Generator implementation
					options: {
						plugins: [
							["imagemin-webp", { quality: 75 }], // WebP settings
						],
					},
					filename: "images/[name][ext].webp", // Output file name and location
				},
			],
		}),
	],
	watchOptions: {
		aggregateTimeout: 1500,
		ignored: "**/node_modules",
	},
	module: {
		rules: [
			{
				test: /\.s[ac]ss$/i,
				use: [
					MiniCssExtractPlugin.loader,
					{
						loader: "css-loader",
						options: { sourceMap: true, url: false },
					},
					{
						loader: "sass-loader",
						options: { sourceMap: true },
					},
				],
			},
		],
	},
	optimization: {
		minimizer: [new CssMinimizerPlugin()],
	},
	resolve: {
		extensions: [".tsx", ".ts", ".jsx", ".js", "..."],
	},
};
