'use strict'
var gulp 			= require('gulp'); // Подключаем gulp
var sass 			= require('gulp-sass'); // sass делает css
//var Fiber = require('fibers'); // быстро асинхронной компиляции scss
var autoprefixer 	= require('gulp-autoprefixer'); // модуль для автоматической установки автопрефиксов
var plumber 		= require("gulp-plumber"); // поиск ошибок 
var csso 			= require('gulp-csso'); // минфикатор css
var uglify 			= require('gulp-uglify'); // минфикатор js
var concat 			= require('gulp-concat'); // объеденить фаилы
var del 			= require('del'); // удаление каталогов и фаилов
var notify 			= require('gulp-notify'); // отображение ошибок в cmd
var browserSync 	= require('browser-sync').create(); //локальный сервер (смотрит за стилями)
sass.compiler 		= require('node-sass');
//пути gulp.src
var path = {
	src: {
		customjs: './node_modules/jquery/dist/jquery.min.js',
		appjs: 	[
		'./node_modules/popper.js/dist/umd/popper.min.js',
		'./node_modules/bootstrap/dist/js/bootstrap.min.js',
		'./gulp/js/libs/slick.min.js',
		'./gulp/js/libs/miup.min.js',
		'./gulp/js/libs/control.js'
		],
		js: './gulp/js/themes.js',

		customcss: './gulp/scss/custom.scss',
		css: './gulp/scss/themes.scss',
	},
	dest: {
		js: 	'./js/',
		css: 	'./css/',
		}
}
// browserSync.init({
// 		// Адрес сайта на который нужно кинуть прокси
// 		server          : 'test.loc',
// 		// IP в локальной сети используется для открытия на других устройствах например
// 		// http://192.168.1.101:3000 - сам сайт,
// 		// http://192.168.1.101:9090 - webkit инспектор
// 		// http://localhost:3001 - UI где все настраивается
// 		// Если у вас несколько сетевых карт то имеет смыл указать нужный вам ip ниже, автоматически не всегда верно определятеся
// 		// host : '192.168.1.101',
// 		// Запрещаем открывать браузер автоматически
// 		open           : false,
// 		// Клики, Скрол и Ввод в поля форм отзеркаливаются на всех устройствах подключенных к серверу
// 		ghostMode      : false,
// 		// Перезагружаем сервер при рестарте задачи
// 		reloadOnRestart: true,
// 		'ui'           : {
// 			// Кастомный порт для webkit инспектора, можно использовать любой не занятый
// 			'weinre': {
// 				'port': 9090
// 			}
// 		}
// });

//свои css
function css(){
	return gulp.src(path.src.css)
	.pipe(plumber({ // обработчик потоков pipe отслеживает ошибки с notify
		errorHandler: notify.onError(function (error){
		return {
			title  : "Sass function css!",
			message: "<%= error.message %>"	
		}
		})
	}))
	.pipe(sass.sync({outputStyle: 'compressed'}))

	.pipe(autoprefixer({
		browsers: [
			'last 1 major version',
			'>= 1%',
			'Chrome >= 45',
			'Firefox >= 38',
			'Edge >= 12',
			'Explorer >= 10',
			'iOS >= 9',
			'Safari >= 9',
			'Android >= 4.4',
			'Opera >= 30'
		],
		cascade: false
	}))
	.pipe(concat('themes.css'))
	.pipe(csso({
		restructure: true,
		sourceMap: false,
		debug: true
	}))
	.pipe(gulp.dest(path.dest.css));
}

// копируем фаилы css
function customcss(){
	return gulp.src(path.src.customcss)
	.pipe(plumber())
	.pipe(sass.sync({outputStyle: 'compressed'}).on('error', sass.logError)
		.on('error', notify.onError({
			title  : "Sass function customcss",
			message: "<%= error.message %>"
			}))
		)
		.pipe(autoprefixer({
		browsers: [
			'last 1 major version',
			'>= 1%',
			'Chrome >= 45',
			'Firefox >= 38',
			'Edge >= 12',
			'Explorer >= 10',
			'iOS >= 9',
			'Safari >= 9',
			'Android >= 4.4',
			'Opera >= 30'			
		],
		cascade: false
	}))
	.pipe(concat('custom.css'))
	.pipe(csso({
		restructure: true,
		sourceMap: false,
		debug: true
	}))
	.pipe(gulp.dest(path.dest.css));
}
// копируем фаилы js
function customjs(){
	return gulp.src(path.src.customjs)
	.pipe(concat('jq.js'))
	.pipe(uglify())
	.pipe(plumber())
	.pipe(gulp.dest(path.dest.js));
}
function appjs(){
	return gulp.src(path.src.appjs)
	.pipe(concat('app.js'))
	.pipe(uglify())
	.pipe(plumber())
	.pipe(gulp.dest(path.dest.js));
}
// свои стили js
/*function appjs(){
	return gulp.src(path.src.js)
	.pipe(concat('themes.js'))
	.pipe(uglify())
	.pipe(plumber())
	.pipe(gulp.dest(path.dest.js));
}*/
function js(){
	return gulp.src(path.src.js)
	.pipe(concat('themes.js'))
	//.pipe(uglify())
	.pipe(plumber())
	.pipe(gulp.dest(path.dest.js));
}
function clean(){
	return gulp.src([path.dest.js, path.dest.css])
}

// function watch(){
// 	gulp.watch(path.src.customjs, customjs);
// 	gulp.watch(path.src.js, js);
// 	gulp.watch('./gulp/scss/bootstrap/**/*', customcss);
// 	gulp.watch('./gulp/scss/themes/**/*', css);
// }

//добавление функции к команде
gulp.task('customcss', customcss);
gulp.task('css', css);
gulp.task('customjs', customjs);
gulp.task('appjs', appjs);
gulp.task('js', js);
gulp.task('clean', clean);
gulp.task('watch', watch);
gulp.task('serve', serve);

gulp.task('build', gulp.series('clean', 
	gulp.parallel('customcss','css','customjs','appjs', 'js' ))
);

function watch(){
gulp.watch([
	path.src.customjs, 
	path.src.js,
	'./gulp/scss/bootstrap/**/*', 
	'./gulp/scss/themes/**/*'], 
		gulp.series([
			'customjs',
			'appjs',
			'js',
			'css',
			'customcss'
		])
	).on('unlink', function(filepath){
		remember.forget(['css', 'customcss'], path.resolve(filepath));
	});
}

function serve(){
	browserSync.init({
		proxy: 'joomla/',
			// http://192.168.1.101:3000 - сам сайт,
			// http://192.168.1.101:9090 - webkit инспектор
		//server: 'joomla/',
		open: false,
		reloadOnRestart: true,
				'ui'           : {
			// Кастомный порт для webkit инспектора, можно использовать любой не занятый
			'weinre': {
				'port': 9090
			}
		}
	})
	browserSync.watch([path.dest.css, path.dest.js]).on('change',browserSync.reload);
}
// 'gulp dev' команда по умолчанию - запускает build(чистит папки и запускает таски) 
// -> watch - ослеживание измения в фаилах, serve - сразу отображат изменения на сервере
gulp.task('go', gulp.series('build' , gulp.parallel('watch', 'serve')));