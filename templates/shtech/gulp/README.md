# Базовый шаблон для Joomla созданный с Gulp

## Начало работы

 1. Установить [Node.js](https://nodejs.org/en/) последнюю LTS версию '
 2. Обновить npm (
 	`npm install -g npm`
 )
 3.  Установить [gulpjs](http://gulpjs.com/)
 	3.1. Как обновить Gulp? (
 	`npm install gulp@next`
 	или локально
 	`npm install gulp@next --s-d`
 	)
	3.2 Проверка версии Gulp (
		`gulp -v`
		CLI version 1.2.1
	)
	3.3 Установка Gulp = 3.1
	3.3.1 Утсановить Gulp глобально (
	`npm install -g gulp`
	`npm i -g gulp-cli`
	PATH
	C:\Users\orlov\AppData\Roaming\npm
	NODE_PATH
	%AppData%\npm
	)
	3.3.2 Для установки Gulp 4(
		# Uninstall previous Gulp installation and related packages, if any
	   `$ npm rm gulp -g
		$ npm rm gulp-cli -g
		$ cd [your-project-dir/]
		$ npm rm gulp --save-dev
		$ npm rm gulp --save
		$ npm rm gulp --save-optional
		$ npm cache clean`
			# Install the latest Gulp CLI tools globally
			`$ npm install gulpjs/gulp-cli -g`
		# Install Gulp 4 
		`$ npm install gulp@next`
	)
 4. В консоли перейти в директорию с проектом с помощью команды `cd путь/до/шаблона`
 5. Запустить команду `npm install --save-dev`
 6. После этого можно запустить дефолтную задачу командой `gulp` (в директории с шаблоном)




### Проблемы

Если зависимости не устанавливаются попробуйте обновить `npm install npm -g` (из под администратора) 

## Licence

The Joomla Gulp is opensource software released under the [GPL](LICENSE).
