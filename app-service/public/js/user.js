/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/user.js ***!
  \******************************/
$(document).ready(function () {
  $('.nav-menu > li > a').each(function (index, element) {
    if ($(element).attr('href') == window.location.href) {
      $(element).parent().addClass('active');
    }
    ;
  });
  $('.questions-container .question-list > li > a').each(function (index, element) {
    if ($(element).attr('href') == window.location.href) {
      $(element).parent().addClass('active');
    }
    ;
  });
  function codeMirrorForQuestion() {
    var quesContent = document.querySelector('.codemirror-new-ques #content');
    var language = $('#new-ques .form-group #select-lg option:selected').data('mode');
    var question = CodeMirror.fromTextArea(quesContent, {
      lineNumbers: true,
      lineWrapping: true,
      mode: language,
      matchBrackets: true,
      autoRefresh: false,
      autoCloseTags: true,
      autoCloseBrackets: true,
      styleActiveLine: {
        nonEmpty: false
      },
      indentUnit: 2,
      tabSize: 2,
      extraKeys: {
        'Ctrl-/': 'toggleComment',
        'Cmd-/': 'toggleComment'
      }
    });
    $('#new-ques .form-group #select-lg ').change(function (e) {
      console.log(1);
      e.preventDefault();
      language = $('#new-ques .form-group #select-lg  option:selected').data('mode');
      question.setOption("mode", language);
    });
  }
  function codeMirrorForShowingQuestion() {
    var container = document.querySelector('.question-right .question-detail .question-content #cmr');
    var language = $(container).data('lg');
    var content = $(container).text();
    var question = CodeMirror.fromTextArea(container, {
      lineWrapping: true,
      mode: language,
      readOnly: 'nocursor'
    });

    // Set value for CodeMirror
    question.getDoc().setValue(content);
  }
  function codeMirrorEditQuestion() {
    var quesContent = document.querySelector('#codemirror-edit-ques');
    var language = $('#select-lg-update option:selected').data('mode');
    var content = $(quesContent).text();
    var question = CodeMirror.fromTextArea(quesContent, {
      lineNumbers: true,
      lineWrapping: true,
      mode: language,
      autoRefresh: false,
      tabSize: 2
    });

    // Set value for CodeMirror
    question.getDoc().setValue(content);
    $('.page-edit-question #update-ques #select-lg').change(function (e) {
      e.preventDefault();
      language = $('.page-edit-question #update-ques #select-lg option:selected').data('mode');
      question.setOption("mode", language);
    });
  }
  function ajaxSearchingQuestions() {
    var search = $('.filter .search-question').val();
    var url = $('.filter .search-question').data('url');
    var lg = $('select[name="filter-lg-question"]').val();
    $.ajax({
      type: "POST",
      url: url,
      data: {
        search: search,
        lg_id: lg
      },
      success: function success(response) {
        var result = JSON.parse(response),
          name = $('meta[name=username]').attr("content"),
          html = '';
        result.forEach(function (element) {
          html += '<li class="question">';
          html += '<a href="/interviewer/question/' + element.id + '">';
          html += '<h5>' + element.title + '</h5>';
          html += '<span>' + element.name + ' by ' + name + '</span>';
          html += '</a>';
          html += '</li>';
        });
        $('.list-wrapper').html(html);
      }
    });
  }
  function ajaxSearchingPads() {
    var search = $('#interviewer-search-pad').val(),
      url = $('#interviewer-search-pad').data('url'),
      status = $('#filter-pad-status').val(),
      lg = $('#filter-pad-lg').val();
    $.ajax({
      type: "POST",
      url: url,
      data: {
        search: search,
        status: status,
        lg_id: lg
      },
      success: function success(response) {
        var pads = JSON.parse(response);
        var tbody = $('.interviewee-table .table tbody');
        // empty tbody
        tbody.empty();
        // Add new value to tbody
        if (pads.length == 0) {
          var _html = "<tr>\n                                    <td colspan=\"7\">No matching records found</td>\n                                </tr>";
          tbody.append(_html);
        } else {
          pads.forEach(function (pad) {
            var tpl = document.querySelector('#pad-row');
            var clone = tpl.content.cloneNode(true);
            var td = clone.querySelectorAll('td');
            td[0].innerText = pad.title;
            td[1].innerText = pad.status;
            td[2].innerText = pad.interviewees;
            td[3].innerText = pad.created;
            td[4].innerText = pad.language;
            var _goto = clone.querySelector('a.goto-pad');
            _goto.href = pad.view_route;
            _goto.innerText = pad.view_text;
            var action = clone.querySelector('a.red-btn');
            action.classList.add(pad.action_text);
            action.href = pad.action_route;
            action.innerText = pad.action_text;
            tbody.append(clone);
          });
          $('.End').click(function (e) {
            e.preventDefault();
            $('#modalEnd .modal-footer form').prop('action', $(this).prop('href'));
            $('#modalEnd').modal('show');
          });
          $('.Delete').click(function (e) {
            e.preventDefault();
            $('#modalDelete .modal-footer form').prop('action', $(this).prop('href'));
            $('#modalDelete').modal('show');
          });
        }
      }
    });
  }

  // Page pad
  if ($(document.body).hasClass('page-pad')) {
    var addMember = function addMember() {
      $.ajax({
        type: "POST",
        url: "/pad/".concat(pad_id, "/add_member"),
        data: {
          value: {
            session_id: sid,
            name: name,
            token: firebaseToken
          }
        }
      });
    };
    var pad_id = $('meta[name="pad_id"]').attr('content'),
      sid = $('meta[name="sid"]').attr('content'),
      name = $('.full-screen-overlay .enter-content #candidate_name').val(),
      firebaseToken = '';
    if (firebase.messaging.isSupported()) {
      var messaging = firebase.messaging();
      messaging.requestPermission().then(function () {
        // get the token in the form of promise
        return messaging.getToken();
      }).then(function (token) {
        firebaseToken = token;
        addMember();
      })["catch"](function (err) {
        console.log("Unable to get permission to notify.", err);
        addMember();
      });

      // Handle incoming messages. Called when:
      // - a message is received while the app has focus
      // - the user clicks on an app notification created by a service worker
      //   `messaging.setBackgroundMessageHandler` handler.
      messaging.onMessage(function (payload) {
        alert(payload.data.body);
      });
    } else {
      addMember();
      console.log("This browser doesn't support FCM");
    }
    $('.RightPanel .topbar .tabs li').click(function (e) {
      $(this).addClass('active');
      $(this).siblings().removeClass('active');
      var my_console = $('.right-wrapper .console'),
        notes = $('.right-wrapper .notes');
      if ($(e.target).hasClass('output')) {
        my_console.css('display', 'block');
        notes.hide();
      } else {
        my_console.hide();
        notes.css('display', 'block');
      }
    });
    var id = $('meta[name="pad_id"]').attr('content');

    // Handle event to update pad
    $('.footer-right .title').on('input', function () {
      var title = $('.footer-right .title').val();
      $.ajax({
        type: "PUT",
        url: "/pad/" + id + "/edit",
        data: {
          value: {
            title: title
          }
        }
      });
    });
    $('textarea#note').on('input', function () {
      var note = $('.right-wrapper #note').val();
      $.ajax({
        type: "PUT",
        url: "/pad/" + id + "/edit",
        data: {
          value: {
            note: note
          }
        }
      }).fail(function (data) {
        alert(data);
      });
    });
    var pusher = new Pusher('1dcf4e7608b407bd1a07', {
      cluster: 'ap1'
    });
    var channel = pusher.subscribe("pad-".concat(id, "-user-update"));
    channel.bind('note-update', function (e) {
      setTimeout(function () {
        $('textarea#note').val(e.note);
      }, 50);
    });
    channel.bind('title-update', function (e) {
      setTimeout(function () {
        $('.footer-right .title').val(e.title);
      }, 50);
    });
  }

  // New question page
  if ($('.interviewer-wrapper').hasClass('page-new-question')) {
    codeMirrorForQuestion();
  }

  // Edit question page
  if ($('.interviewer-wrapper').hasClass('page-edit-question')) {
    codeMirrorEditQuestion();
  }

  // Manage questions page
  if ($('.interviewer-wrapper').hasClass('page-questions')) {
    if ($('.question-right .question-detail .question-content').length) {
      codeMirrorForShowingQuestion();
    }
    $('.filter .search-question').on('input', function () {
      ajaxSearchingQuestions();
    });
    $('.filter .filter-lg-question').change(function (e) {
      e.preventDefault();
      ajaxSearchingQuestions();
    });
  }

  // Manage pads page
  if ($('.interviewer-wrapper').hasClass('page-pads')) {
    $('#interviewer-search-pad').on('input', function () {
      ajaxSearchingPads();
    });
    $('#filter-pad-status').change(function (e) {
      e.preventDefault();
      ajaxSearchingPads();
    });
    $('#filter-pad-lg').change(function (e) {
      e.preventDefault();
      ajaxSearchingPads();
    });
    $('.End').click(function (e) {
      e.preventDefault();
      $('#modalEnd .modal-footer form').prop('action', $(this).prop('href'));
      $('#modalEnd').modal('show');
    });
    $('.Delete').click(function (e) {
      e.preventDefault();
      $('#modalDelete .modal-footer form').prop('action', $(this).prop('href'));
      $('#modalDelete').modal('show');
    });
  }

  // Manage interviewees page
  if ($('.interviewer-wrapper').hasClass('page-interviewees')) {
    var searchInterviewees = function searchInterviewees() {
      var name = $("#search-name").val(),
        url = $("#search-name").data('url'),
        time = $('#filter-date').val();
      console.log(time);
      $.ajax({
        type: "post",
        url: url,
        data: {
          name: name,
          time: time
        },
        success: function success(interviewees) {
          var tbody = $('#tbody');
          console.log(interviewees.length);
          // empty tbody
          tbody.empty();
          // Add new value to tbody
          if (interviewees.length == 0) {
            var _html2 = "<tr>\n                                        <td colspan=\"5\">No matching records found</td>\n                                    </tr>";
            $(tbody).append(_html2);
          } else {
            interviewees.forEach(function (item) {
              html = "<tr>\n                                        <td rowspan=\"".concat(item.pads.length, "\" style=\"vertical-align: middle\">").concat(item.name, "</td>");
              item.pads.forEach(function (element, index) {
                if (index === 0) {
                  html += "\n                                            <td>".concat(element.title, "</td>\n                                            <td>").concat(element.name, "</td>\n                                            <td>").concat(element.created, "</td>\n                                            <td>\n                                                <a href=\"/pad/").concat(element.id, "\" target=\"_blank\"><i class=\"fa fa-eye text-success fs-4 ms-4\"></i></a>\n                                            </td>\n                                        </tr>");
                } else {
                  html += "\n                                        <tr>\n                                            <td>".concat(element.title, "</td>\n                                            <td>").concat(element.name, "</td>\n                                            <td>").concat(element.created, "</td>\n                                            <td>\n                                                <a href=\"/pad/").concat(element.id, "\" target=\"_blank\"><i class=\"fa fa-eye text-success fs-4 ms-4\"></i></a>\n                                            </td>\n                                        </tr>");
                }
              });
              $(tbody).append(html);
            });
          }
        }
      });
    };
    $("#search-name").on('input', function () {
      searchInterviewees();
    });
    $('#filter-date').change(function (e) {
      e.preventDefault();
      searchInterviewees();
    });
  }
});
/******/ })()
;