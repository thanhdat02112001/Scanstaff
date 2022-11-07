/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./resources/js/admin.js ***!
  \*******************************/
var ctx = document.getElementById('myChart');
ctx.height = 150;
ctx.width = 400;
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
    datasets: [{
      label: '# of Votes',
      data: [12, 19, 3, 5, 2, 3],
      backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)'],
      borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'],
      borderWidth: 1
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    },
    plugins: {
      title: {
        display: true,
        position: 'bottom',
        margin: 0,
        text: 'Custom Chart Title'
      }
    }
  }
});
// Handle notification count
var noti_list = $('.dropdown-noti .noti-list'),
  current_noti = parseInt(noti_list.data('cur')),
  all_noti = parseInt(noti_list.data('all'));
var pusher = new Pusher('1dcf4e7608b407bd1a07', {
  cluster: 'ap1'
});
var channel = pusher.subscribe('user-register');
channel.bind('new-user', function (e) {
  console.log(e);
  alertify.set('notifier', 'position', 'bottom-right');
  alertify.success('new user registered');
  var notify = JSON.parse(e.noti);
  var noti_string = "User ".concat(notify.name, " with email ").concat(notify.email, " want to register.");

  // if in interviewer page
  if ($('#page-wrapper .main-page-content').hasClass('page-interviewer')) {
    // Add a new row to "List of unapproved users" table
    var max = parseInt($('.unapproved-list .unapproved tbody tr').last().find('th').text()) || 0;
    var tpl1 = document.querySelector('#new-user-row');
    var clone = tpl1.content.cloneNode(true);
    var td = clone.querySelectorAll('td');
    td[0].textContent = notify.name;
    td[1].textContent = notify.email;
    var th = clone.querySelector('th');
    th.textContent = max + 1;
    var acpt = clone.querySelector('.acpt a');
    acpt.href = '/users/' + notify.id + '/approve';
    var decl = clone.querySelector('.decl a');
    decl.href = '/users/' + notify.id + '/decline';
    var tbody = document.querySelector('.unapproved-list .unapproved tbody');
    tbody.appendChild(clone);
    $('.unapproved-list .table-responsive.d-none').removeClass('d-none');
    $('.unapproved-list p.is-empty').addClass('d-none');
  }
  // push notification for admin
  // Notification popup
  var tpl2 = document.querySelector('#push-notify');
  var clone2 = tpl2.content.cloneNode(true);
  var link = clone2.querySelector('.toast-body a');
  link.textContent = noti_string;
  link.href = "/noti/".concat(notify.noti_id, "/seen");
  var container = document.querySelector('.toast-container');
  container.appendChild(clone2);
  $('.main-page-content .toast-container .toast').each(function (i, el) {
    if ($(el).find('a').text() == noti_string) {
      $(el).toast('show');
    }
  });
  // Notification dropdown
  noti_list.attr('data-cur', current_noti++);
  noti_list.attr('data-all', all_noti++);
  $('.topbar .dropdown-toggle .label-primary').text(parseInt($('.topbar .dropdown-toggle .label-primary').text()) + 1);
  var div = document.createElement('div'),
    a = document.createElement('a');
  div.className = 'unseen';
  a.href = "/noti/".concat(notify.noti_id, "/seen");
  a.textContent = noti_string;
  div.appendChild(a);
  var list = document.querySelector('.dropdown-noti .noti-list');
  list.insertBefore(div, list.childNodes[0]);
});
$('.nav-menu > li > a').each(function (index, element) {
  if ($(element).attr('href') == window.location.href) {
    $(element).parent().addClass('active');
  }
  ;
});

// Dropdown notifications
$('.dropdown-menu.dropdown-noti').on("click.bs.dropdown", function (e) {
  return $('.dropdown').one('hide.bs.dropdown', function () {
    return false;
  });
});
$('.dropdown-noti .see-more').click(function (e) {
  e.preventDefault();
  $.ajax({
    type: "post",
    url: "/admin/get-more-noti",
    data: {
      current: current_noti
    },
    success: function success(response) {
      current_noti = current_noti + response.length;
      noti_list.attr('data-cur', current_noti);
      response.forEach(function (element) {
        var div = document.createElement('div'),
          a = document.createElement('a');
        div.className = element.read == 0 ? 'unseen' : '';
        a.href = "/noti/".concat(element.id, "/seen");
        a.textContent = element.description;
        div.appendChild(a);
        var list = document.querySelector('.dropdown-noti .noti-list');
        list.appendChild(div);
      });
      if (current_noti >= all_noti) {
        $('.dropdown-noti .see-more').hide();
      }
    }
  });
});
$('.dropdown-noti .mark-read a').click(function (e) {
  e.preventDefault();
  $.ajax({
    type: "POST",
    url: "/read-noti",
    success: function success() {
      $('.dropdown-noti .noti-list div.unseen').each(function (i, el) {
        $(el).removeClass('unseen');
      });
      $('.dropdown-toggle.count-info .label-primary').text(0);
    }
  });
});
if ($('.main-page-content').hasClass('page-statistics')) {
  $('.wrapper .count').each(function (index, element) {
    var all = $(element).siblings('.all-time').find('.number').text(),
      width = $(element).find('.number').text() / all;
    $(element).find('.progress-bar').width(width * 100 + '%');
  });
}

// Manage interviewees admin page
if ($('.main-page-content').hasClass('page-interviewees-admin')) {
  var searchInterviewees = function searchInterviewees() {
    var name = document.querySelector('.interviewee-filters .search #search').value,
      time = document.querySelector('.interviewee-filters .filter #filter-date').value;
    $.ajax({
      type: "post",
      url: "/admin/interviewee/search",
      data: {
        name: name,
        time: time
      },
      success: function success(interviewees) {
        var tbody = document.querySelector('.interviewees-container .table tbody');

        // empty tbody
        while (tbody.lastChild) {
          tbody.removeChild(tbody.lastChild);
        }

        // Add new value to tbody
        if (interviewees.length == 0) {
          var _html = "<tr>\n                                    <td colspan=\"5\">No matching records found</td>\n                                </tr>";
          tbody.innerHTML = _html;
        } else {
          interviewees.forEach(function (item) {
            html = "<tr>\n                                    <td rowspan=\"".concat(item.pads.length, "\">").concat(item.name, "</td>");
            item.pads.forEach(function (element, index) {
              if (index === 0) {
                html += "\n                                        <td>".concat(element.title, "</td>\n                                        <td>").concat(element.name, "</td>\n                                        <td>").concat(element.created, "</td>\n                                        <td>\n                                            <a href=\"/pad/").concat(element.id, "\" target=\"_blank\">View</a>\n                                        </td>\n                                    </tr>");
              } else {
                html += "\n                                    <tr>\n                                        <td>".concat(element.title, "</td>\n                                        <td>").concat(element.name, "</td>\n                                        <td>").concat(element.created, "</td>\n                                        <td>\n                                            <a href=\"/pad/").concat(element.id, "\" target=\"_blank\">View</a>\n                                        </td>\n                                    </tr>");
              }
            });
            $(tbody).append(html);
          });
        }
      }
    });
  };
  $('.interviewee-filters .search #search').on('input', function () {
    searchInterviewees();
  });
  $('.interviewee-filters .filter #filter-date').change(function (e) {
    e.preventDefault();
    searchInterviewees();
  });
}
/******/ })()
;