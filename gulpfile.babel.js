import { series, src, dest, parallel, watch } from "gulp";
import yargs from "yargs";
import cleanCss from "gulp-clean-css";
import gulpif from "gulp-if";
import browserSync from "browser-sync";
import dartSass from "sass";
import gulpSass from "gulp-sass";
import postcss from "gulp-postcss";
import sourcemaps from "gulp-sourcemaps";
import autoprefixer from "autoprefixer";
import imagemin from "gulp-imagemin";
import del from "del";
import webpack from "webpack-stream";
import named from "vinyl-named";
import concat from "gulp-concat";

const server = browserSync.create();
const PRODUCTION = yargs.argv.prod;
const sass = gulpSass(dartSass);

export const stylesTask = () => {
  return src([
    "node_modules/normalize.css/normalize.css",
    "node_modules/swiper/swiper-bundle.min.css",
    "node_modules/hystmodal/dist/hystmodal.min.css",
    // "node_modules/normalize.css/normalize.css",
    // "node_modules/swiper/swiper-bundle.min.css",
    // "node_modules/swiper/modules/pagination/pagination.min.css",
    // "node_modules/swiper/modules/effect-fade/effect-fade.min.css",
    // "node_modules/swiper/modules/thumbs/thumbs.min.css",
    // "node_modules/swiper/modules/navigation/navigation.min.css",
    "src/styles/bundle.scss",
  ])
    .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
    .pipe(sass().on("error", sass.logError))
    .pipe(gulpif(PRODUCTION, postcss([
      autoprefixer
    ])))
    .pipe(gulpif(PRODUCTION, cleanCss({ compatibility: "ie8" })))
    .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
    .pipe(concat('bundle.css'))
    .pipe(dest("dist/styles"))
    .pipe(server.stream());
};

export const scriptsTask = () => {
  return src("src/scripts/bundle.js")
    .pipe(named())
    .pipe(
      webpack({
        module: {
          rules: [
            {
              test: /\.js$/,
              loader: "babel-loader",
            },
          ],
        },
        mode: PRODUCTION ? "production" : "development",
        devtool: !PRODUCTION ? "inline-source-map" : false,
        output: {
          filename: "[name].js",
        },
      })
    )
    .pipe(dest("dist/scripts"));
};

export const imagesTask = () => {
  return src("src/images/**/*.{jpg,jpeg,png,svg,gif}")
    .pipe(gulpif(PRODUCTION, imagemin()))
    .pipe(dest("dist/images"));
};

export const fontsTask = () => {
  return src("src/fonts/**/*.{ttf,woff,woff2}").pipe(dest("dist/fonts"));
};

export const cleanTask = () => del(["dist"]);

export const watchTask = () => {
  watch("src/styles/**/*.scss", stylesTask);
  watch(
    "src/images/**/*.{jpg,jpeg,png,svg,gif}",
    series(imagesTask, reloadTask)
  );
  watch("src/fonts/**/*.{ttf,woff,woff2}", series(fontsTask, reloadTask));
  watch("src/scripts/**/*.js", series(scriptsTask, reloadTask));
  watch("**/*.php", reloadTask);
};

export const serveTask = (done) => {
  server.init({
    proxy: "127.0.0.1:5000",
    port: 4001,
  });
  done();
};

export const reloadTask = (done) => {
  server.reload();
  done();
};

export const dev = series(
  cleanTask,
  parallel(stylesTask, imagesTask, fontsTask, scriptsTask),
  serveTask,
  watchTask
);

export const build = series(
  cleanTask,
  parallel(stylesTask, imagesTask, fontsTask, scriptsTask)
);

export default dev;
