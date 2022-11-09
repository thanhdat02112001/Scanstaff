/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./resources/js/guest.js ***!
  \*******************************/
$(document).ready(function () {
  if ($(document.body).hasClass('page-pad')) {
    // Show overlay
    $('.full-screen-overlay').css('display', 'flex');

    // Focus on text input
    $('.full-screen-overlay .enter-content #candidate_name').focus();
    $('.full-screen-overlay .enter-content .btn-go').click(function (e) {
      e.preventDefault();
      var pad_id = $('meta[name="pad_id"]').attr('content'),
        sid = $('meta[name="sid"]').attr('content'),
        name = $('.full-screen-overlay .enter-content #candidate_name').val();

      // Check if value is not empty
      if (name) {
        $.ajax({
          type: "PUT",
          url: "/pad/".concat(pad_id, "/edit/guest"),
          data: {
            id: pad_id,
            name: name
          },
          success: function success(response) {
            if (response === 'founded') {
              $('.enter-content .form-input').hide();
              $('.enter-content .form-confirm').show();
              $('.full-screen-overlay .enter-content .btn-confirm').trigger('focus');
              return false;
            }
            if (response === 'pad not found') {
              alert('Pad id not valid');
              location.reload();
              return false;
            }
            $('.full-screen-overlay').hide();
            $.ajax({
              type: "POST",
              url: "/pad/".concat(pad_id, "/add_member"),
              data: {
                value: {
                  session_id: sid,
                  name: name
                }
              }
            });
          }
        });
      }
    });
    $('.full-screen-overlay .enter-content .btn-confirm').click(function (e) {
      e.preventDefault();
      var pad_id = $('meta[name="pad_id"]').attr('content'),
        sid = $('meta[name="sid"]').attr('content'),
        name = $('.full-screen-overlay .enter-content #candidate_name').val();

      // Check if value is not empty
      if (name) {
        $.ajax({
          type: "PUT",
          url: "/pad/".concat(pad_id, "/edit/guest"),
          data: {
            id: pad_id,
            name: name,
            confirm: true
          },
          success: function success() {
            $('.full-screen-overlay').hide();
            $.ajax({
              type: "POST",
              url: "/pad/".concat(pad_id, "/add_member"),
              data: {
                value: {
                  session_id: sid,
                  name: name
                }
              }
            });
          }
        });
      }
    });
    $('.full-screen-overlay .enter-content .btn-no').click(function (e) {
      e.preventDefault();
      $('.full-screen-overlay .enter-content .form-confirm').hide();
      $('.full-screen-overlay .enter-content .form-input').show();
      // Focus on text input
      $('.full-screen-overlay .enter-content #candidate_name').focus();
    });
    $('.full-screen-overlay .enter-content #candidate_name').on('keyup', function (e) {
      // check if press enter
      if (e.keyCode === 13) {
        $('.full-screen-overlay .enter-content .btn-go').trigger('click');
      }
    });
    $('.messageDropdown').on("click.bs.dropdown", function (e) {
      return $('.message-dropdown').one('hide.bs.dropdown', function () {
        return false;
      });
    });

    // Suggestion
    $('.suggestion p').click(function (e) {
      e.preventDefault();
      $('.push-noti .push-noti-body').val($(this).text());
    });

    // Send push noti
    $('.messageDropdown .btn-send-noti').click(function (e) {
      e.preventDefault();
      var pad_id = $('meta[name="pad_id"]').attr('content'),
        name = $('.full-screen-overlay .enter-content #candidate_name').val();
      if ($('.messageDropdown .push-noti-body').val() == '') {
        alert('Please enter message');
      } else {
        $.ajax({
          type: "POST",
          url: "/pad/".concat(pad_id, "/push_noti"),
          data: {
            id: pad_id,
            name: name,
            message: $('.messageDropdown .push-noti-body').val()
          },
          beforeSend: function beforeSend() {
            $('.messageDropdown .push-noti-body').val('');
            $('.messageDropdown .sending').show();
            $('.messageDropdown input.btn-send-noti').prop('disabled', true);
          },
          success: function success() {
            $('.messageDropdown input.btn-send-noti').prop('disabled', false);
            $('.messageDropdown .sending').hide();
            $('.messageDropdown .sent').show();
            setTimeout(function () {
              $('.messageDropdown .sent').hide();
            }, 3000);
          },
          error: function error() {
            $('.messageDropdown input.btn-send-noti').prop('disabled', false);
            $('.messageDropdown .sending').hide();
            $('.messageDropdown .fail').show();
            setTimeout(function () {
              $('.messageDropdown .fail').hide();
            }, 3000);
          }
        });
      }
    });
  }
});
/******/ })()
;