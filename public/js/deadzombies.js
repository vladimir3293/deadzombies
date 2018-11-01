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
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/deadzombies.js":
/***/ (function(module, exports) {

window.requestFullScreen = function (el) {
    // Supports most browsers and their versions.
    var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullScreen;

    if (requestMethod) {
        // Native full screen.
        requestMethod.call(el);
    } else if (typeof window.ActiveXObject !== "undefined") {
        // Older IE.
        var wscript = new ActiveXObject("WScript.Shell");
        if (wscript !== null) {
            wscript.SendKeys("{F11}");
        }
    }
    return false;
};

window.toggleFull = function () {
    // $(window).trigger("iPanel.fullscreen", true);
    var iframe = document.getElementById('game-player');
    // if (iframe) {
    //     var elem = iframe;
    // } else {
    //     var elem = document.body; // Make the body go full screen.
    // }
    var elem = iframe;
    // var isInFullScreen = (elem.fullScreenElement && elem.fullScreenElement !== null) || (elem.mozFullScreen || elem.webkitIsFullScreen);
    requestFullScreen(elem);

    // if (isInFullScreen) {
    //     iPanel.cancelFullScreen(document);
    // } else {
    //     iPanel.requestFullScreen(elem);
    // }
    return false;
};

(function ($, undefined) {

    $(document).ready(function () {
        // console.debug($('#top-block-button'));
        $('#top-block-button').click(function (event) {
            $('.top-block, .right-content, .index-footer').toggleClass('top-block-clicked');
            $('.top-block svg').toggleClass('top-block-click-svg');
            $('body, html').toggleClass('overflow-hidden');
        });

        $('.game-play-click').click(function () {
            $('.game-box-play, .game-box-img').css('display', 'none');
            $('.game-box-source, .game-box-fullscreen').css('display', 'block');

            var game = $('#game-player');
            game.attr('src', game.attr('data-src'));
        });
    });
})(jQuery);

/***/ }),

/***/ "./resources/assets/sass/scss.scss":
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("./resources/assets/js/deadzombies.js");
module.exports = __webpack_require__("./resources/assets/sass/scss.scss");


/***/ })

/******/ });