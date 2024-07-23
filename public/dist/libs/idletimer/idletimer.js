/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory();
	else if(typeof define === 'function' && define.amd)
		define([], factory);
	else {
		var a = factory();
		for(var i in a) (typeof exports === 'object' ? exports : root)[i] = a[i];
	}
})(self, function() {
return /******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./libs/idletimer/idletimer.js":
/*!*************************************!*\
  !*** ./libs/idletimer/idletimer.js ***!
  \*************************************/
/***/ (function() {

eval("function _typeof(o) { \"@babel/helpers - typeof\"; return _typeof = \"function\" == typeof Symbol && \"symbol\" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && \"function\" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? \"symbol\" : typeof o; }, _typeof(o); }\n/*! Idle Timer - v1.1.1 - 2020-06-25\n * https://github.com/thorst/jquery-idletimer\n * Copyright (c) 2020 Paul Irish; Licensed MIT */\n/*\n\tmousewheel (deprecated) -> IE6.0, Chrome, Opera, Safari\n\tDOMMouseScroll (deprecated) -> Firefox 1.0\n\twheel (standard) -> Chrome 31, Firefox 17, IE9, Firefox Mobile 17.0\n\n\t//No need to use, use DOMMouseScroll\n\tMozMousePixelScroll -> Firefox 3.5, Firefox Mobile 1.0\n\n\t//Events\n\tWheelEvent -> see wheel\n\tMouseWheelEvent -> see mousewheel\n\tMouseScrollEvent -> Firefox 3.5, Firefox Mobile 1.0\n*/\n(function ($) {\n  $.idleTimer = function (firstParam, elem) {\n    var opts;\n    if (_typeof(firstParam) === 'object') {\n      opts = firstParam;\n      firstParam = null;\n    } else if (typeof firstParam === 'number') {\n      opts = {\n        timeout: firstParam\n      };\n      firstParam = null;\n    }\n\n    // element to watch\n    elem = elem || document;\n\n    // defaults that are to be stored as instance props on the elem\n    opts = $.extend({\n      idle: false,\n      // indicates if the user is idle\n      timeout: 30000,\n      // the amount of time (ms) before the user is considered idle\n      events: 'mousemove keydown wheel DOMMouseScroll mousewheel mousedown touchstart touchmove MSPointerDown MSPointerMove' // define active events\n    }, opts);\n    var jqElem = $(elem),\n      obj = jqElem.data('idleTimerObj') || {},\n      /* (intentionally not documented)\n       * Toggles the idle state and fires an appropriate event.\n       * @return {void}\n       */\n      toggleIdleState = function toggleIdleState(e) {\n        var obj = $.data(elem, 'idleTimerObj') || {};\n\n        // toggle the state\n        obj.idle = !obj.idle;\n\n        // store toggle state date time\n        obj.olddate = +new Date();\n\n        // create a custom event, with state and name space\n        var event = $.Event((obj.idle ? 'idle' : 'active') + '.idleTimer');\n\n        // trigger event on object with elem and copy of obj\n        $(elem).trigger(event, [elem, $.extend({}, obj), e]);\n      },\n      /**\n       * Handle event triggers\n       * @return {void}\n       * @method event\n       * @static\n       */\n      handleEvent = function handleEvent(e) {\n        var obj = $.data(elem, 'idleTimerObj') || {};\n\n        // ignore writting to storage unless related to idleTimer\n        if (e.type === 'storage' && e.originalEvent.key !== obj.timerSyncId) {\n          return;\n        }\n\n        // this is already paused, ignore events for now\n        if (obj.remaining != null) {\n          return;\n        }\n\n        /*\n              mousemove is kinda buggy, it can be triggered when it should be idle.\n              Typically is happening between 115 - 150 milliseconds after idle triggered.\n              @psyafter & @kaellis report \"always triggered if using modal (jQuery ui, with overlay)\"\n              @thorst has similar issues on ios7 \"after $.scrollTop() on text area\"\n              */\n        if (e.type === 'mousemove') {\n          // if coord are same, it didn't move\n          if (e.pageX === obj.pageX && e.pageY === obj.pageY) {\n            return;\n          }\n          // if coord don't exist how could it move\n          if (typeof e.pageX === 'undefined' && typeof e.pageY === 'undefined') {\n            return;\n          }\n          // under 200 ms is hard to do, and you would have to stop, as continuous activity will bypass this\n          var elapsed = +new Date() - obj.olddate;\n          if (elapsed < 200) {\n            return;\n          }\n        }\n\n        // clear any existing timeout\n        clearTimeout(obj.tId);\n\n        // if the idle timer is enabled, flip\n        if (obj.idle) {\n          toggleIdleState(e);\n        }\n\n        // store when user was last active\n        obj.lastActive = +new Date();\n\n        // update mouse coord\n        obj.pageX = e.pageX;\n        obj.pageY = e.pageY;\n\n        // sync lastActive\n        if (e.type !== 'storage' && obj.timerSyncId) {\n          if (typeof localStorage !== 'undefined') {\n            localStorage.setItem(obj.timerSyncId, obj.lastActive);\n          }\n        }\n\n        // set a new timeout\n        obj.tId = setTimeout(toggleIdleState, obj.timeout);\n      },\n      /**\n       * Restore initial settings and restart timer\n       * @return {void}\n       * @method reset\n       * @static\n       */\n      reset = function reset() {\n        var obj = $.data(elem, 'idleTimerObj') || {};\n\n        // reset settings\n        obj.idle = obj.idleBackup;\n        obj.olddate = +new Date();\n        obj.lastActive = obj.olddate;\n        obj.remaining = null;\n\n        // reset Timers\n        clearTimeout(obj.tId);\n        if (!obj.idle) {\n          obj.tId = setTimeout(toggleIdleState, obj.timeout);\n        }\n      },\n      /**\n       * Store remaining time, stop timer\n       * You can pause from an idle OR active state\n       * @return {void}\n       * @method pause\n       * @static\n       */\n      pause = function pause() {\n        var obj = $.data(elem, 'idleTimerObj') || {};\n\n        // this is already paused\n        if (obj.remaining != null) {\n          return;\n        }\n\n        // define how much is left on the timer\n        obj.remaining = obj.timeout - (+new Date() - obj.olddate);\n\n        // clear any existing timeout\n        clearTimeout(obj.tId);\n      },\n      /**\n       * Start timer with remaining value\n       * @return {void}\n       * @method resume\n       * @static\n       */\n      resume = function resume() {\n        var obj = $.data(elem, 'idleTimerObj') || {};\n\n        // this isn't paused yet\n        if (obj.remaining == null) {\n          return;\n        }\n\n        // start timer\n        if (!obj.idle) {\n          obj.tId = setTimeout(toggleIdleState, obj.remaining);\n        }\n\n        // clear remaining\n        obj.remaining = null;\n      },\n      /**\n       * Stops the idle timer. This removes appropriate event handlers\n       * and cancels any pending timeouts.\n       * @return {void}\n       * @method destroy\n       * @static\n       */\n      destroy = function destroy() {\n        var obj = $.data(elem, 'idleTimerObj') || {};\n\n        //clear any pending timeouts\n        clearTimeout(obj.tId);\n\n        //Remove data\n        jqElem.removeData('idleTimerObj');\n\n        //detach the event handlers\n        jqElem.off('._idleTimer');\n      },\n      /**\n       * Returns the time until becoming idle\n       * @return {number}\n       * @method remainingtime\n       * @static\n       */\n      remainingtime = function remainingtime() {\n        var obj = $.data(elem, 'idleTimerObj') || {};\n\n        //If idle there is no time remaining\n        if (obj.idle) {\n          return 0;\n        }\n\n        //If its paused just return that\n        if (obj.remaining != null) {\n          return obj.remaining;\n        }\n\n        //Determine remaining, if negative idle didn't finish flipping, just return 0\n        var remaining = obj.timeout - (+new Date() - obj.lastActive);\n        if (remaining < 0) {\n          remaining = 0;\n        }\n\n        //If this is paused return that number, else return current remaining\n        return remaining;\n      };\n\n    // determine which function to call\n    if (firstParam === null && typeof obj.idle !== 'undefined') {\n      // they think they want to init, but it already is, just reset\n      reset();\n      return jqElem;\n    } else if (firstParam === null) {\n      // they want to init\n    } else if (firstParam !== null && typeof obj.idle === 'undefined') {\n      // they want to do something, but it isnt init\n      // not sure the best way to handle this\n      return false;\n    } else if (firstParam === 'destroy') {\n      destroy();\n      return jqElem;\n    } else if (firstParam === 'pause') {\n      pause();\n      return jqElem;\n    } else if (firstParam === 'resume') {\n      resume();\n      return jqElem;\n    } else if (firstParam === 'reset') {\n      reset();\n      return jqElem;\n    } else if (firstParam === 'getRemainingTime') {\n      return remainingtime();\n    } else if (firstParam === 'getElapsedTime') {\n      return +new Date() - obj.olddate;\n    } else if (firstParam === 'getLastActiveTime') {\n      return obj.lastActive;\n    } else if (firstParam === 'isIdle') {\n      return obj.idle;\n    }\n\n    // Test via a getter in the options object to see if the passive property is accessed\n    // This isnt working in jquery, though is planned for 4.0\n    // https://github.com/jquery/jquery/issues/2871\n    /*var supportsPassive = false;\n      try {\n          var Popts = Object.defineProperty({}, \"passive\", {\n              get: function() {\n                  supportsPassive = true;\n              }\n          });\n          window.addEventListener(\"test\", null, Popts);\n      } catch (e) {}\n    */\n\n    /* (intentionally not documented)\n     * Handles a user event indicating that the user isn't idle. namespaced with internal idleTimer\n     * @param {Event} event A DOM2-normalized event object.\n     * @return {void}\n     */\n    jqElem.on((opts.events + ' ').split(' ').join('._idleTimer ').trim(), function (e) {\n      handleEvent(e);\n    });\n    //}, supportsPassive ? { passive: true } : false);\n\n    if (opts.timerSyncId) {\n      $(window).on('storage', handleEvent);\n    }\n\n    // Internal Object Properties, This isn't all necessary, but we\n    // explicitly define all keys here so we know what we are working with\n    obj = $.extend({}, {\n      olddate: +new Date(),\n      // the last time state changed\n      lastActive: +new Date(),\n      // the last time timer was active\n      idle: opts.idle,\n      // current state\n      idleBackup: opts.idle,\n      // backup of idle parameter since it gets modified\n      timeout: opts.timeout,\n      // the interval to change state\n      remaining: null,\n      // how long until state changes\n      timerSyncId: opts.timerSyncId,\n      // localStorage key to use for syncing this timer\n      tId: null,\n      // the idle timer setTimeout\n      pageX: null,\n      // used to store the mouse coord\n      pageY: null\n    });\n\n    // set a timeout to toggle state. May wish to omit this in some situations\n    if (!obj.idle) {\n      obj.tId = setTimeout(toggleIdleState, obj.timeout);\n    }\n\n    // store our instance on the object\n    $.data(elem, 'idleTimerObj', obj);\n    return jqElem;\n  };\n\n  // This allows binding to element\n  $.fn.idleTimer = function (firstParam) {\n    if (this[0]) {\n      return $.idleTimer(firstParam, this[0]);\n    }\n    return this;\n  };\n})(jQuery);\n\n//# sourceURL=webpack://Materio/./libs/idletimer/idletimer.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./libs/idletimer/idletimer.js"]();
/******/ 	
/******/ 	return __webpack_exports__;
/******/ })()
;
});