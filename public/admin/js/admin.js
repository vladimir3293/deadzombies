/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/admin.js":
/***/ (function(module, exports) {

(function ($, undefined) {
    $(document).ready(function () {
        console.log('start');

        // var client = algoliasearch('TQARMJGO8A', '3690a3214c8934d794287d2d4c28d37f');
        // var index = client.initIndex('prod_GAMEDISTRIBUTION');
        // // https://www.algolia.com/doc/api-reference/api-methods/browse/?language=php#examples
        // var browser = index.browseAll();
        // var hits = [];
        //
        // browser.on('result', function onResult(content) {
        //     hits = hits.concat(content.hits);
        // });
        //
        // browser.on('end', function onEnd() {
        //     console.log('Finished!');
        //     console.log('We got %d hits', hits.length);
        // });
        //
        // browser.on('error', function onError(err) {
        //     throw err;
        // });


        $('#show-game').click(function (event) {
            var game = $('#game-player');
            game.attr('src', game.attr('data-src'));
            // game.css('display', 'block');
            game.toggle();
            // console.log(game);
        });

        // $('.nav-categories-link').click(function (event) {
        //     event.preventDefault();
        //     $('.nav-categories ul').slideToggle("slow");
        // });
    });
})(jQuery);

/***/ }),

/***/ 2:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/admin.js");


/***/ })

/******/ });