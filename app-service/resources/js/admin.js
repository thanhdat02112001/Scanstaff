const ctx = document.getElementById('myChart');
ctx.height = 150;
ctx.width = 400;
const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
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
let noti_list = $('.dropdown-noti .noti-list'),
    current_noti = parseInt(noti_list.data('cur')),
    all_noti = parseInt(noti_list.data('all'));

var pusher = new Pusher('1dcf4e7608b407bd1a07', {
    cluster: 'ap1'
});

var channel = pusher.subscribe('user-register');
channel.bind('new-user', function(e) {
    console.log(e)
    alertify.set('notifier','position', 'bottom-right');
    alertify.success('new user registered');
    var notify = JSON.parse(e.noti);
    var noti_string = `User ${notify.name} with email ${notify.email} want to register.`;

    // if in interviewer page
    if ($('#interviewer-wrapper').hasClass('unapproved')) {
        // Add a new row to "List of unapproved users" table
        var max = parseInt($('.unapproved tbody tr').last().find('th').text()) || 0;
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
        var tbody = document.querySelector('.unapproved tbody');
        tbody.appendChild(clone);
        $('.unapproved-list .table-responsive.d-none').removeClass('d-none');
        $('.unapproved-list p.is-empty').addClass('d-none');
    }
    // Notification dropdown
    noti_list.attr('data-cur', current_noti++);
    noti_list.attr('data-all', all_noti++);
    $('.dropdown .noti-icon .badge').text(parseInt($('.dropdown .noti-icon .badge').text()) + 1);
    let div = document.createElement('div'),
        a = document.createElement('a');
    div.className = 'unseen';
    a.href = `/admin/noti/${notify.noti_id}/seen`;
    a.textContent = noti_string;
    div.appendChild(a);
    let list = document.querySelector('.dropdown-noti .noti-list');
    list.insertBefore(div, list.childNodes[0]);
});

$('.nav-menu > li > a').each(function (index, element) {
    if ($(element).attr('href') == window.location.href) {
        $(element).parent().addClass('active');
    };
});

$('.dropdown-noti .see-more').click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    $.ajax({
        type: "post",
        url: "/admin/get-more-noti",
        data: { current: current_noti },
        success: function (response) {
            current_noti = current_noti + response.length;
            noti_list.attr('data-cur', current_noti);
            response.forEach(element => {
                let div = document.createElement('div'),
                    a = document.createElement('a');
                div.className = (element.read == 0) ? 'unseen' : '';
                a.href = `/admin/noti/${element.id}/seen`;
                a.textContent = element.description;
                div.appendChild(a);
                let list = document.querySelector('.dropdown-noti .noti-list');
                list.appendChild(div);
            });
            if (current_noti >= all_noti) {
                $('.dropdown-noti .see-more').hide();
            }
        }
    });
});

$('.dropdown-noti .mark-read a').click((e) => {
    e.preventDefault();
    e.stopPropagation();
    $.ajax({
        type: "POST",
        url: "/admin/read-all-noti",
        success: function () {
            $('.dropdown-noti .noti-list div.unseen').each((i, el) => {
                $(el).removeClass('unseen');
            });
            $('.dropdown .noti-icon .badge').text(0);
        }
    });
});

if ($('.main-page-content').hasClass('page-statistics')) {
    $('.wrapper .count').each(function (index, element) {
        let all = $(element).siblings('.all-time').find('.number').text(),
            width = $(element).find('.number').text() / all;
        $(element).find('.progress-bar').width((width * 100) + '%');
    });
}

// Manage interviewees admin page
if ($('.main-page-content').hasClass('page-interviewees-admin')) {
    function searchInterviewees() {
        let name = document.querySelector('.interviewee-filters .search #search').value,
            time = document.querySelector('.interviewee-filters .filter #filter-date').value;
        $.ajax({
            type: "post",
            url: "/admin/interviewee/search",
            data: { name: name, time: time },
            success: function (interviewees) {
                let tbody = document.querySelector('.interviewees-container .table tbody');

                // empty tbody
                while (tbody.lastChild) {
                    tbody.removeChild(tbody.lastChild);
                }

                // Add new value to tbody
                if (interviewees.length == 0) {
                    let html = `<tr>
                                    <td colspan="5">No matching records found</td>
                                </tr>`;
                    tbody.innerHTML = html;
                } else {
                    interviewees.forEach(item => {
                        html = `<tr>
                                    <td rowspan="${item.pads.length}">${item.name}</td>`;
                        item.pads.forEach((element, index) => {
                            if (index === 0) {
                                html += `
                                        <td>${element.title}</td>
                                        <td>${element.name}</td>
                                        <td>${element.created}</td>
                                        <td>
                                            <a href="/pad/${element.id}" target="_blank">View</a>
                                        </td>
                                    </tr>`;
                            } else {
                                html += `
                                    <tr>
                                        <td>${element.title}</td>
                                        <td>${element.name}</td>
                                        <td>${element.created}</td>
                                        <td>
                                            <a href="/pad/${element.id}" target="_blank">View</a>
                                        </td>
                                    </tr>`;
                            }
                        });
                        $(tbody).append(html);
                    });
                }
            }
        });
    }

    $('.interviewee-filters .search #search').on('input', function () {
        searchInterviewees();
    })

    $('.interviewee-filters .filter #filter-date').change(function (e) {
        e.preventDefault();
        searchInterviewees();
    });
}
