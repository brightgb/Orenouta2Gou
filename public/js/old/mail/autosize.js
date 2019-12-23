!function(e,t){if("function"==typeof define&&define.amd)define(["exports","module"],t);else if("undefined"!=typeof exports&&"undefined"!=typeof module)t(exports,module);else{var n={exports:{}};t(n.exports,n),e.autosize=n.exports}}(this,function(e,t){"use strict";function n(e){function t(){var t=window.getComputedStyle(e,null);"vertical"===t.resize?e.style.resize="none":"both"===t.resize&&(e.style.resize="horizontal"),s="content-box"===t.boxSizing?-(parseFloat(t.paddingTop)+parseFloat(t.paddingBottom)):parseFloat(t.borderTopWidth)+parseFloat(t.borderBottomWidth),isNaN(s)&&(s=0),a()}function n(t){var n=e.style.width;e.style.width="0px",e.offsetWidth,e.style.width=n,e.style.overflowY=t}function o(e){for(var t=[];e&&e.parentNode&&e.parentNode instanceof Element;)e.parentNode.scrollTop&&t.push({node:e.parentNode,scrollTop:e.parentNode.scrollTop}),e=e.parentNode;return t}function r(){var t=e.style.height,n=o(e),r=document.documentElement&&document.documentElement.scrollTop;e.style.height="";var d=e.scrollHeight+s;return 0===e.scrollHeight?void(e.style.height=t):(e.style.height=d+"px",u=e.clientWidth,i()<11&&n.forEach(function(e){e.node.scrollTop=e.scrollTop}),void(r&&(document.documentElement.scrollTop=r)))}function a(){r();var t=Math.round(parseFloat(e.style.height)),o=window.getComputedStyle(e,null),i="content-box"===o.boxSizing?Math.round(parseFloat(o.height)):e.offsetHeight;if(i!==t?"hidden"===o.overflowY&&(n("scroll"),r(),i="content-box"===o.boxSizing?Math.round(parseFloat(window.getComputedStyle(e,null).height)):e.offsetHeight):"hidden"!==o.overflowY&&(n("hidden"),r(),i="content-box"===o.boxSizing?Math.round(parseFloat(window.getComputedStyle(e,null).height)):e.offsetHeight),c!==i){c=i;var d=l("autosize:resized");try{e.dispatchEvent(d)}catch(a){}}}if(e&&e.nodeName&&"TEXTAREA"===e.nodeName&&!d.has(e)){var s=null,u=e.clientWidth,c=null,p=function(){e.clientWidth!==u&&a()},f=function(t){window.removeEventListener("resize",p,!1),e.removeEventListener("input",a,!1),e.removeEventListener("keyup",a,!1),e.removeEventListener("autosize:destroy",f,!1),e.removeEventListener("autosize:update",a,!1),Object.keys(t).forEach(function(n){e.style[n]=t[n]}),d["delete"](e)}.bind(e,{height:e.style.height,resize:e.style.resize,overflowY:e.style.overflowY,overflowX:e.style.overflowX,wordWrap:e.style.wordWrap});e.addEventListener("autosize:destroy",f,!1),"onpropertychange"in e&&"oninput"in e&&e.addEventListener("keyup",a,!1),window.addEventListener("resize",p,!1),e.addEventListener("input",a,!1),e.addEventListener("autosize:update",a,!1),e.style.overflowX="hidden",e.style.wordWrap="break-word",d.set(e,{destroy:f,update:a}),t()}}function o(e){var t=d.get(e);t&&t.destroy()}function r(e){var t=d.get(e);t&&t.update()}function i(){var e=navigator.userAgent.toLowerCase();if(null!==e.match(/iphone/i)||null!==e.match(/ipod/i)||null!==e.match(/ipad/i)){var t=e.match(/os (\d+)_(\d+)_?(\d+)?/),n=parseInt(t[1],10);return n}return 0}var d="function"==typeof Map?new Map:function(){var e=[],t=[];return{has:function(t){return e.indexOf(t)>-1},get:function(n){return t[e.indexOf(n)]},set:function(n,o){-1===e.indexOf(n)&&(e.push(n),t.push(o))},"delete":function(n){var o=e.indexOf(n);o>-1&&(e.splice(o,1),t.splice(o,1))}}}(),l=function(e){return new Event(e,{bubbles:!0})};try{new Event("test")}catch(a){l=function(e){var t=document.createEvent("Event");return t.initEvent(e,!0,!1),t}}var s=null;"undefined"==typeof window||"function"!=typeof window.getComputedStyle?(s=function(e){return e},s.destroy=function(e){return e},s.update=function(e){return e}):(s=function(e,t){return e&&Array.prototype.forEach.call(e.length?e:[e],function(e){return n(e,t)}),e},s.destroy=function(e){return e&&Array.prototype.forEach.call(e.length?e:[e],o),e},s.update=function(e){return e&&Array.prototype.forEach.call(e.length?e:[e],r),e}),t.exports=s});

$(function(){
    var $textbox = $('.autosize');
    autosize($textbox);
});