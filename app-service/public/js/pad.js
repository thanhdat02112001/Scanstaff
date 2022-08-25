/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************!*\
  !*** ./resources/js/pad.js ***!
  \*****************************/
var pad_content = $("#pad-content").val();
var pad = monaco.editor.create(document.getElementById('pad-content'), {
  value: pad_content,
  language: $(".page-pad .action #select_lg option:selected").data("mode"),
  theme: 'vs',
  lineNumbers: on,
  vertical: 'auto',
  horizontal: 'auto',
  extraKeys: {
    "Ctrl-/": "toggleComment",
    "Cmd-/": "toggleComment"
  },
  matchBrackets: true,
  styleActiveLine: {
    nonEmpty: false
  }
});
/******/ })()
;