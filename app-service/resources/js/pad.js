import $ from 'jquery';
window.$ = window.jQuery = $;

require('./bootstrap');
import 'jquery-ui/ui/widgets/draggable.js';

import Firepad from 'firepad';
window.Firepad = Firepad;

var phpMode = 'application/x-httpd-php';

$(document).ready(function () {
    // Firebase Setup
    var firebaseConfig = {
        apiKey: process.env.MIX_FIREBASE_API_KEY,
        authDomain: process.env.MIX_FIREBASE_AUTH_DOMAIN,
        databaseURL: process.env.MIX_FIREBASE_DB_URL,
        projectId: process.env.MIX_FIREBASE_PROJECT_ID,
        storageBucket: process.env.MIX_FIREBASE_STORAGE_BUCKET,
        messagingSenderId: process.env.MIX_FIREBASE_MESSAGING_SENDER_ID,
        appId: process.env.MIX_FIREBASE_APP_ID,
        measurementId: process.env.MIX_FIREBASE_MEASUREMENT_ID
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    // Get database ref for firebase
    // Helper to get hash from end of URL or generate a random one.
    function getRef(firebase) {
        var ref = firebase.database().ref();
        var pad_id = $('meta[name="pad_id"]').attr('content');
        var hash = `${process.env.MIX_FIREBASE_PREFIX}-${pad_id}`;
        if (hash) {
            ref = ref.child(hash);
        } else {
            ref = ref.push(); // generate unique location.
            window.location = window.location + '#' + ref.key; // add it as a hash to the URL.
        }
        if (typeof console !== 'undefined') {
            console.log('Firebase data: ', ref.toString());
        }
        return ref;
    }

    var firepadRef = getRef(firebase);

    if ($(document.body).hasClass('page-pad')) {
        let pad_id = $('meta[name="pad_id"]').attr('content'),
            sid = $('meta[name="sid"]').attr('content');
        // Xterm
        var term = new Terminal({
            convertEol: true
        });
        let output = $('.d-none.op').text();
        var fitAddon = new FitAddon();
        term.loadAddon(fitAddon);
        term.open(document.getElementById('console'));
        term.writeln('Enviroment ready. Hit run to try out some code!\n');
        term.writeln(output);
        fitAddon.fit();

        // Pad content
        var pad_content = document.querySelector('.page-pad #pad-content');
        var pad = CodeMirror.fromTextArea(pad_content, {
            lineNumbers: true,
            lineWrapping: true,
            mode: $('.page-pad .action-bar #select_lg option:selected').data('mode'),
            theme: 'monokai',
            styleActiveLine: { nonEmpty: false },
            matchBrackets: true,
            autoRefresh: false,
            autoCloseTags: true,
            autoCloseBrackets: true,
            indentUnit: 2,
            tabSize: 2,
            extraKeys: {
                'Ctrl-/': 'toggleComment',
                'Cmd-/': 'toggleComment',
            }
        });

        function autoComplete (lg_mode) {
            pad.on("inputRead", function(command) {
                CodeMirror.showHint(command, CodeMirror.hint[lg_mode], {completeSingle:false, closeOnUnfocus:true})
            })
        }
        autoComplete(pad.options.mode)

        // If PHP, change indentUnit to 4
        if ($('.page-pad .action #select_lg option:selected').data('mode') === phpMode) {
            pad.setOption('indentUnit', 4);
            pad.setOption('tabSize', 4);
        }

        // Create Firepad.
        var firepad = Firepad.fromCodeMirror(firepadRef, pad, {});

        firepad.on('ready', function() {
            // Firepad is ready.
            if (firepad.isHistoryEmpty()) {
                $.ajax({
                    type: "POST",
                    url: `/pad/${pad_id}/get-content`,
                    dataType: "text",
                    success: function (response) {
                        firepad.setText(response);
                    }
                });
            }
        });

        // Send invitation email
        $('form.emailInvite input.btn-send').click((e) => {
            e.preventDefault();

            function validateEmail(email) {
                let re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }

            if ($('form.emailInvite .email-invite').val() == '' || !validateEmail($('form.emailInvite .email-invite').val())) {
                alert('Please enter valid email');
            } else {
                $.ajax({
                    type: "POST",
                    url: '/send-email',
                    data: {
                        email: $('form.emailInvite .email-invite').val(),
                        link: window.location.href
                    },
                    beforeSend: function () {
                        $('form.emailInvite .email-invite').val('');
                        $('.inviteDropdown .email .sending').show();
                        $('form.emailInvite input.btn-send').prop('disabled', true);
                    },
                    success: function () {
                        $('form.emailInvite input.btn-send').prop('disabled', false);
                        $('.inviteDropdown .email .sending').hide();
                        $('.inviteDropdown .email .sent').show();
                        setTimeout(() => {
                            $('.inviteDropdown .email .sent').hide();
                        }, 3000);
                    },
                    error: function () {
                        $('form.emailInvite input.btn-send').prop('disabled', false);
                        $('.inviteDropdown .email .sending').hide();
                        $('.inviteDropdown .email .fail').show();
                        setTimeout(() => {
                            $('.inviteDropdown .email .fail').hide();
                        }, 3000);
                    }
                });
            }
        })

        // Drag to resize
        function resizeDiv(beforeWidth) {
            var minw = 400,     //Min width
                fullw = $('.page-pad').innerWidth();

            // When window resize
            if (beforeWidth !== fullw) {
                $('.RightPanel').innerWidth(fullw - $('.CodePanel').innerWidth());
                $('.resizer').css('left', $('.CodePanel').innerWidth() + 'px');
            }

            $('.RightPanel').innerWidth();

            var splitter = function (event, ui) {
                var lw = parseInt(ui.position.left),
                    rw = fullw - lw;
                $('.CodePanel').innerWidth(lw);
                $('.RightPanel').innerWidth(rw);
                if ($('.RightPanel .console').css('display') !== 'none') {
                    fitAddon.fit();
                }
            };

            $('.page-pad .workspace .resizer').draggable({
                axis: 'x',
                containment: [minw, 0, fullw - minw, $('.page-pad .workspace').height()], //Left, top, right, bottom
                drag: splitter
            });
        }

        var beforeWidth = $('.page-pad').innerWidth();

        resizeDiv(beforeWidth);

        $(window).resize(function () {
            resizeDiv(beforeWidth);
            beforeWidth = $('.page-pad').innerWidth();
        })

        $('.footer-left .dropdown-menu').on("click.bs.dropdown", function (e) {
            return $('.footer-left .dropup').one('hide.bs.dropdown', function () {
                return false;
            });
        });

        // Change Language
        $('#select_lg').on('change', function () {
            pad.setOption('mode', $(this).find('option:selected').data('mode'));
            // If PHP, change indentUnit to 4
            if ($('.page-pad .action #select_lg option:selected').data('mode') === phpMode) {
                pad.setOption('indentUnit', 4);
                pad.setOption('tabSize', 4);
            } else {
                pad.setOption('indentUnit', 2);
                pad.setOption('tabSize', 2);
            }
            $.ajax({
                type: "PUT",
                url: `/pad/${pad_id}/edit`,
                data: {
                    value: {
                        language_id: $('#select_lg option:selected').val()
                    }
                }
            });
        });

        // Change content
        firepad.on('synced', function(isSynced) {
            // isSynced will be false immediately after the user edits the pad,
            // and true when their edit has been saved to Firebase.
            $.ajax({
                type: "PUT",
                url: `/pad/${pad_id}/edit`,
                data: {
                    value: {
                        content: firepad.getText()
                    }
                }
            });
        });

        setTimeout(() => {
            pad.getDoc().on('cursorActivity', function (doc) {
                let start = doc.sel.ranges[0].anchor,
                    end = doc.sel.ranges[0].head,
                    sid = $('meta[name="sid"]').attr('content'),
                    name = $('.full-screen-overlay .enter-content #candidate_name').val(),
                    color = $(`.user[data-sid=${sid}][data-name='${name}']`).find('.colorIndicator').css('background-color');
                if ((start.line != 0) || (start.ch != 0) || (end.line != 0) || (end.ch != 0)) {
                    const rgb2hexcss = (rgb) => {
                        if (rgb.search("rgb") === -1) return rgb;
                        rgb = rgb.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+))?\)$/);
                        const hex = (x) => ("0" + parseInt(x).toString(16)).slice(-2);
                        return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
                    };
                    firepad.setUserColor(rgb2hexcss(color));
                }
            });
        }, 5000);

        window.addEventListener('beforeunload', (e) => {
            let name = $('.full-screen-overlay .enter-content #candidate_name').val();

            // Delete user from list
            if (name != "") {
                $.ajax({
                    type: "POST",
                    url: `/pad/${pad_id}/delete_member`,
                    data: {
                        value: {
                            pad_id: pad_id,
                            session_id: sid,
                            name: name
                        }
                    }
                });
            }
        });

        // Run code
        $('.CodePanel .action .run').click(function (e) {
            e.preventDefault();
            $(this).prop('disabled', true);
            let name = $('.full-screen-overlay .enter-content #candidate_name').val(),
                language = $('.action #select_lg option:selected').text(),
                first = `${name} ran ${pad.getDoc().size} lines of ${language}`,
                bf_time = new Date().getTime();
            $.ajax({
                type: "POST",
                url: `/faas/${language}`,
                data: {
                    data: pad.getValue(),
                    id: pad_id
                },
                beforeSend: function () {
                    term.write(first);
                },
                success: function (response) {
                    var at_time = new Date().getTime(),
                        time = at_time - bf_time;
                    if (time >= 1000) {
                        time = (time / 1000).toFixed(2) + 's';
                    } else {
                        time = time + 'ms';
                    }
                    term.writeln(` (finished in ${time}):\n${response}`, function () {
                        $.ajax({
                            type: "POST",
                            url: `/pad/${pad_id}/output`,
                            data: {
                                content: `${first} (finished in ${time}):\n${response}`
                            },
                        });
                        $('.CodePanel .action .run').prop('disabled', false);
                    });
                },
            });
        });

        // Reset output
        $('.RightPanel .topbar .btn.reset').click(function (e) {
            e.preventDefault();
            term.clear();
            $.ajax({
                type: "POST",
                url: `/pad/${pad_id}/clear-output`
            });
        });

        // Array to save users info
        var marker = new Array();
        $('.user-list .user').each(function (index, element) {
            let obj = {
                sid: $(element).data('sid'),
                name: $(element).data('name'),
                cursor_mark: "",
                select_mark: ""
            }
            marker.push(obj);
        });

        var pusher = new Pusher('1dcf4e7608b407bd1a07', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe(`pad-${pad_id}-participants`);

        channel.bind('PadJoinerUpdate', (data) => {
            let element;
            switch (data.type) {
                case 'add':
                    element = JSON.parse(data.members);
                    let user = document.createDocumentFragment(),
                        li = document.createElement('li'),
                        span1 = document.createElement('span'),
                        span2 = document.createElement('span');
                    li.className = 'user';
                    li.dataset.sid = element.session_id;
                    li.dataset.name = element.name;
                    span1.className = 'colorIndicator';
                    span2.className = 'username';
                    span2.textContent = element.name;
                    li.appendChild(span1);
                    li.appendChild(span2);
                    user.appendChild(li);
                    setTimeout(() => {
                        document.querySelector('.footer .user-list').appendChild(user);
                    }, 50);
                    let found = false;
                    for (let i = 0; i < marker.length; i++) {
                        let m = marker[i];
                        if (m.sid == element.session_id && m.name == element.name) {
                            found = true;
                            break;
                        }
                    }
                    if (!found) {
                        let obj = {
                            sid: element.session_id,
                            name: element.name,
                            cursor_mark: "",
                            select_mark: ""
                        };
                        marker.push(obj);
                    }
                    break;
                case 'delete':
                    element = JSON.parse(data.members);
                    if ($(`.user-list .user[data-sid=${element.session_id}][data-name='${element.name}']`).length) {
                        $(`.user-list .user[data-sid=${element.session_id}][data-name='${element.name}']`).remove();
                    }

                    marker.forEach((m, index) => {
                        if (m.sid == element.session_id && m.name == element.name) {
                            // clear bookmark
                            if (m.cursor_mark != "") {
                                m.cursor_mark.clear();
                            }
                            if (m.select_mark != "") {
                                m.select_mark.clear();
                            }
                            marker.splice(index, 1);
                        }
                    });
                    break;
                default:
                    let user_list = '';
                    data.members.forEach(e => {
                        element = JSON.parse(e);
                        user_list += `
                            <li class="user" data-sid="${element.session_id}" data-name="${element.name}">
                                <span class="colorIndicator"></span>
                                <span class="username">${element.name}</span>
                            </li>
                        `;
                    });
                    $('.footer .user-list').html(user_list);
                    $('.user-list .user').each(function (index, element) {
                        let obj = {
                            sid: $(element).data('sid'),
                            name: $(element).data('name'),
                            cursor_mark: "",
                            select_mark: ""
                        }
                        marker.push(obj);
                    });
                    break;
            }
        })

        channel.bind('EndPad', function () {
            location.reload();
        });

        var channelOutput = pusher.subscribe(`pad-${pad_id}-output`);

        channelOutput.bind('DisableRunButton', () => {
            $('.CodePanel .action .run').prop('disabled', true);
        })
        channelOutput.bind('PadOutputUpdate', (data) => {
            term.writeln(data.content);
            $('.CodePanel .action .run').prop('disabled', false);
        })
        channelOutput.bind('PadOutputClear', function () {
            term.clear();
        })

        var channelContent = pusher.subscribe(`pad-${pad_id}-content`);

        channelContent.bind('PadLanguageUpdate', (e) => {
            $('#select_lg').val(e.lg_id);
            console.log(e.lg_id)
            pad.setOption('mode', $('#select_lg').find('option:selected').data('mode'));
            // If PHP, change indentUnit to 4
            if ($('.page-pad .action #select_lg option:selected').data('mode') === phpMode) {
                pad.setOption('indentUnit', 4);
                pad.setOption('tabSize', 4);
            } else {
                pad.setOption('indentUnit', 2);
                pad.setOption('tabSize', 2);
            }
        })
    }
});

