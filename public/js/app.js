/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/css/app.css":
/*!*******************************!*\
  !*** ./resources/css/app.css ***!
  \*******************************/
/***/ (() => {

throw new Error("Module build failed (from ./node_modules/mini-css-extract-plugin/dist/loader.js):\nModuleBuildError: Module build failed (from ./node_modules/postcss-loader/dist/cjs.js):\nError: It looks like you're trying to use `tailwindcss` directly as a PostCSS plugin. The PostCSS plugin has moved to a separate package, so to continue using Tailwind CSS with PostCSS you'll need to install `@tailwindcss/postcss` and update your PostCSS configuration.\n    at Re (/home/flow/skin-commerce-app/skin-commerce-app/node_modules/tailwindcss/dist/lib.js:33:1723)\n    at LazyResult.runOnRoot (/home/flow/skin-commerce-app/skin-commerce-app/node_modules/postcss/lib/lazy-result.js:361:16)\n    at LazyResult.runAsync (/home/flow/skin-commerce-app/skin-commerce-app/node_modules/postcss/lib/lazy-result.js:290:26)\n    at LazyResult.async (/home/flow/skin-commerce-app/skin-commerce-app/node_modules/postcss/lib/lazy-result.js:192:30)\n    at LazyResult.then (/home/flow/skin-commerce-app/skin-commerce-app/node_modules/postcss/lib/lazy-result.js:436:17)\n    at processResult (/home/flow/skin-commerce-app/skin-commerce-app/node_modules/webpack/lib/NormalModule.js:891:19)\n    at /home/flow/skin-commerce-app/skin-commerce-app/node_modules/webpack/lib/NormalModule.js:1037:5\n    at /home/flow/skin-commerce-app/skin-commerce-app/node_modules/loader-runner/lib/LoaderRunner.js:400:11\n    at /home/flow/skin-commerce-app/skin-commerce-app/node_modules/loader-runner/lib/LoaderRunner.js:252:18\n    at context.callback (/home/flow/skin-commerce-app/skin-commerce-app/node_modules/loader-runner/lib/LoaderRunner.js:124:13)\n    at Object.loader (/home/flow/skin-commerce-app/skin-commerce-app/node_modules/postcss-loader/dist/index.js:142:7)");

/***/ }),

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
Object(function webpackMissingModule() { var e = new Error("Cannot find module './bootstrap'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	__webpack_modules__["./resources/js/app.js"](0, {}, __webpack_require__);
/******/ 	// This entry module doesn't tell about it's top-level declarations so it can't be inlined
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/css/app.css"](0, __webpack_exports__, __webpack_require__);
/******/ 	
/******/ })()
;