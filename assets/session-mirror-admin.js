;(function ($, d, w) {
    var SM = {
        projectSelector: 'select#session-mirror-project-select',
        ajaxAction: 'session_mirror',
        ajaxUrl: session_mirror_ajax.ajax_url,
        videoFilterTableSelector: 'table#session-mirror-video-filter-table',
        loginFormContainerSelector: "div.session-mirror-lf-c",
        videosTbodySelector: '#session-mirror-videos-tbody',
        formLoadingIconSelector: 'i.session-mirror-form-loading-icon',
        videoFilterFormSelector: 'form.session-mirror-video-filter-form-s',

        videoPaginationCurrentPage: 1,
        videoPaginationItemPerPage: 50,
        videoPaginationLastPageNumber: 1,
        videoPaginationNumberSelector: '.session-mirror-video-pagination-number',
        videoPaginationFirstSelector: '.session-mirror-video-pagination-first',
        videoPaginationPrevSelector: '.session-mirror-video-pagination-prev',
        videoPaginationCurrentPageTextSelector: '.session-mirror-video-pagination-current-page',
        videoPaginationNextSelector: '.session-mirror-video-pagination-next',
        videoPaginationLastSelector: '.session-mirror-video-pagination-last',

        videoPlayerContainerSelector: '#session-mirror-video-player-container',
        videoPlayerContentSelector: 'div#session-mirror-video-player-content',
        videoPlayerModalSessionIdInputSelector: 'input#session-mirror-video-player-modal-session-id',
        videoPlayerModalVideoCountSelector: '.session-mirror-video-player-modal-info-video-count',
        videoPlayerModalVideoCountInputSelector: 'input#session-mirror-video-player-modal-page-count',
        videoPlayerModalCurrentPageIndex: 0,

        countries: {
            "AF": "Afghanistan",
            "AL": "Albania",
            "DZ": "Algeria",
            "AS": "American Samoa",
            "AD": "Andorra",
            "AO": "Angola",
            "AI": "Anguilla",
            "AQ": "Antarctica",
            "AG": "Antigua and Barbuda",
            "AR": "Argentina",
            "AM": "Armenia",
            "AW": "Aruba",
            "AU": "Australia",
            "AT": "Austria",
            "AZ": "Azerbaijan",
            "BS": "Bahamas",
            "BH": "Bahrain",
            "BD": "Bangladesh",
            "BB": "Barbados",
            "BY": "Belarus",
            "BE": "Belgium",
            "BZ": "Belize",
            "BJ": "Benin",
            "BM": "Bermuda",
            "BT": "Bhutan",
            "BO": "Bolivia",
            "BA": "Bosnia and Herzegovina",
            "BW": "Botswana",
            "BV": "Bouvet Island",
            "BR": "Brazil",
            "IO": "British Indian Ocean Territory",
            "BN": "Brunei Darussalam",
            "BG": "Bulgaria",
            "BF": "Burkina Faso",
            "BI": "Burundi",
            "KH": "Cambodia",
            "CM": "Cameroon",
            "CA": "Canada",
            "CV": "Cape Verde",
            "KY": "Cayman Islands",
            "CF": "Central African Republic",
            "TD": "Chad",
            "CL": "Chile",
            "CN": "China",
            "CX": "Christmas Island",
            "CC": "Cocos (Keeling) Islands",
            "CO": "Colombia",
            "KM": "Comoros",
            "CG": "Congo",
            "CD": "Congo, the Democratic Republic of the",
            "CK": "Cook Islands",
            "CR": "Costa Rica",
            "CI": "Cote D'Ivoire",
            "HR": "Croatia",
            "CU": "Cuba",
            "CY": "Cyprus",
            "CZ": "Czech Republic",
            "DK": "Denmark",
            "DJ": "Djibouti",
            "DM": "Dominica",
            "DO": "Dominican Republic",
            "EC": "Ecuador",
            "EG": "Egypt",
            "SV": "El Salvador",
            "GQ": "Equatorial Guinea",
            "ER": "Eritrea",
            "EE": "Estonia",
            "ET": "Ethiopia",
            "FK": "Falkland Islands (Malvinas)",
            "FO": "Faroe Islands",
            "FJ": "Fiji",
            "FI": "Finland",
            "FR": "France",
            "GF": "French Guiana",
            "PF": "French Polynesia",
            "TF": "French Southern Territories",
            "GA": "Gabon",
            "GM": "Gambia",
            "GE": "Georgia",
            "DE": "Germany",
            "GH": "Ghana",
            "GI": "Gibraltar",
            "GR": "Greece",
            "GL": "Greenland",
            "GD": "Grenada",
            "GP": "Guadeloupe",
            "GU": "Guam",
            "GT": "Guatemala",
            "GN": "Guinea",
            "GW": "Guinea-Bissau",
            "GY": "Guyana",
            "HT": "Haiti",
            "HM": "Heard Island and McDonald Islands",
            "VA": "Holy See (Vatican City State)",
            "HN": "Honduras",
            "HK": "Hong Kong",
            "HU": "Hungary",
            "IS": "Iceland",
            "IN": "India",
            "ID": "Indonesia",
            "IR": "Iran, Islamic Republic of",
            "IQ": "Iraq",
            "IE": "Ireland",
            "IL": "Israel",
            "IT": "Italy",
            "JM": "Jamaica",
            "JP": "Japan",
            "JO": "Jordan",
            "KZ": "Kazakhstan",
            "KE": "Kenya",
            "KI": "Kiribati",
            "KP": "North Korea",
            "KR": "South Korea",
            "KW": "Kuwait",
            "KG": "Kyrgyzstan",
            "LA": "Lao People's Democratic Republic",
            "LV": "Latvia",
            "LB": "Lebanon",
            "LS": "Lesotho",
            "LR": "Liberia",
            "LY": "Libya",
            "LI": "Liechtenstein",
            "LT": "Lithuania",
            "LU": "Luxembourg",
            "MO": "Macao",
            "MG": "Madagascar",
            "MW": "Malawi",
            "MY": "Malaysia",
            "MV": "Maldives",
            "ML": "Mali",
            "MT": "Malta",
            "MH": "Marshall Islands",
            "MQ": "Martinique",
            "MR": "Mauritania",
            "MU": "Mauritius",
            "YT": "Mayotte",
            "MX": "Mexico",
            "FM": "Micronesia, Federated States of",
            "MD": "Moldova, Republic of",
            "MC": "Monaco",
            "MN": "Mongolia",
            "MS": "Montserrat",
            "MA": "Morocco",
            "MZ": "Mozambique",
            "MM": "Myanmar",
            "NA": "Namibia",
            "NR": "Nauru",
            "NP": "Nepal",
            "NL": "Netherlands",
            "NC": "New Caledonia",
            "NZ": "New Zealand",
            "NI": "Nicaragua",
            "NE": "Niger",
            "NG": "Nigeria",
            "NU": "Niue",
            "NF": "Norfolk Island",
            "MK": "North Macedonia, Republic of",
            "MP": "Northern Mariana Islands",
            "NO": "Norway",
            "OM": "Oman",
            "PK": "Pakistan",
            "PW": "Palau",
            "PS": "Palestinian Territory, Occupied",
            "PA": "Panama",
            "PG": "Papua New Guinea",
            "PY": "Paraguay",
            "PE": "Peru",
            "PH": "Philippines",
            "PN": "Pitcairn",
            "PL": "Poland",
            "PT": "Portugal",
            "PR": "Puerto Rico",
            "QA": "Qatar",
            "RE": "Reunion",
            "RO": "Romania",
            "RU": "Russia",
            "RW": "Rwanda",
            "SH": "Saint Helena",
            "KN": "Saint Kitts and Nevis",
            "LC": "Saint Lucia",
            "PM": "Saint Pierre and Miquelon",
            "VC": "Saint Vincent and the Grenadines",
            "WS": "Samoa",
            "SM": "San Marino",
            "ST": "Sao Tome and Principe",
            "SA": "Saudi Arabia",
            "SN": "Senegal",
            "SC": "Seychelles",
            "SL": "Sierra Leone",
            "SG": "Singapore",
            "SK": "Slovakia",
            "SI": "Slovenia",
            "SB": "Solomon Islands",
            "SO": "Somalia",
            "ZA": "South Africa",
            "GS": "South Georgia and the South Sandwich Islands",
            "ES": "Spain",
            "LK": "Sri Lanka",
            "SD": "Sudan",
            "SR": "Suriname",
            "SJ": "Svalbard and Jan Mayen",
            "SZ": "Eswatini",
            "SE": "Sweden",
            "CH": "Switzerland",
            "SY": "Syrian Arab Republic",
            "TW": "Taiwan",
            "TJ": "Tajikistan",
            "TZ": "Tanzania, United Republic of",
            "TH": "Thailand",
            "TL": "Timor-Leste",
            "TG": "Togo",
            "TK": "Tokelau",
            "TO": "Tonga",
            "TT": "Trinidad and Tobago",
            "TN": "Tunisia",
            "TR": "Turkey",
            "TM": "Turkmenistan",
            "TC": "Turks and Caicos Islands",
            "TV": "Tuvalu",
            "UG": "Uganda",
            "UA": "Ukraine",
            "AE": "United Arab Emirates",
            "GB": "United Kingdom",
            "US": "USA",
            "UM": "United States Minor Outlying Islands",
            "UY": "Uruguay",
            "UZ": "Uzbekistan",
            "VU": "Vanuatu",
            "VE": "Venezuela",
            "VN": "Vietnam",
            "VG": "Virgin Islands, British",
            "VI": "Virgin Islands, U.S.",
            "WF": "Wallis and Futuna",
            "EH": "Western Sahara",
            "YE": "Yemen",
            "ZM": "Zambia",
            "ZW": "Zimbabwe",
            "AX": "Åland Islands",
            "BQ": "Bonaire, Sint Eustatius and Saba",
            "CW": "Curaçao",
            "GG": "Guernsey",
            "IM": "Isle of Man",
            "JE": "Jersey",
            "ME": "Montenegro",
            "BL": "Saint Barthélemy",
            "MF": "Saint Martin (French part)",
            "RS": "Serbia",
            "SX": "Sint Maarten (Dutch part)",
            "SS": "South Sudan",
            "XK": "Kosovo"
        },

        timeAgo: function(time) {
            time = +new Date(time);
            var time_formats = [
                [60, 'seconds', 1], // 60
                [120, '1 minute ago', '1 minute from now'], // 60*2
                [3600, 'minutes', 60], // 60*60, 60
                [7200, '1 hour ago', '1 hour from now'], // 60*60*2
                [86400, 'hours', 3600], // 60*60*24, 60*60
                [172800, 'Yesterday', 'Tomorrow'], // 60*60*24*2
                [604800, 'days', 86400], // 60*60*24*7, 60*60*24
                [1209600, 'Last week', 'Next week'], // 60*60*24*7*4*2
                [2419200, 'weeks', 604800], // 60*60*24*7*4, 60*60*24*7
                [4838400, 'Last month', 'Next month'], // 60*60*24*7*4*2
                [29030400, 'months', 2419200], // 60*60*24*7*4*12, 60*60*24*7*4
                [58060800, 'Last year', 'Next year'], // 60*60*24*7*4*12*2
                [2903040000, 'years', 29030400], // 60*60*24*7*4*12*100, 60*60*24*7*4*12
                [5806080000, 'Last century', 'Next century'],
                [58060800000, 'centuries', 2903040000]
            ];
            var seconds = (+new Date() - time) / 1000,
                token = 'ago',
                list_choice = 1;

            if (seconds === 0) {
                return 'Just now';
            }
            if (seconds < 0) {
                seconds = Math.abs(seconds);
                token = 'from now';
                list_choice = 2;
            }
            var i = 0, format;
            while (format = time_formats[i++])
                if (seconds < format[0]) {
                    if (typeof format[2] == 'string')
                        return format[list_choice];
                    else
                        return Math.floor(seconds / format[2]) + ' ' + format[1] + ' ' + token;
                }
            return time;
        }
    };

    $(d).ready(function () {
        // load videos
        var videoFilterForm = $(SM.videoFilterTableSelector);
        if (videoFilterForm.length) {
            loadVideoFilters();
            loadVideosByProject();
        }

        // login form - check site domain
        var loginForm = $(SM.loginFormContainerSelector);
        if (loginForm.length) {
            var siteDomainInput = loginForm.find('input[name="session_mirror_site"]');
            if (!siteDomainInput.val()) {
                siteDomainInput.val(d.location.protocol + "//" + d.location.host);
            }
        }
    });

    var loadVideosByProject = function (filters) {
        var body = $(SM.videosTbodySelector);
        var loadinIcon = $(SM.formLoadingIconSelector);
        loadinIcon.show();

        var data = {
            'action': SM.ajaxAction,
            'function': 'videos',
            'data': filters || {}
        };
        var html = '';
        $.post(SM.ajaxUrl, data, function (response) {
            var res = JSON.parse(response);
            if (!res.response || !res.response.sessions) {
                return false;
            }
            var sessions = res.response.sessions;

            for (var i = 0; i < sessions.length; i++) {
                var item = sessions[i];
                var records = item.records;
                var links = '';

                for (var j = 0; j < records.length; j++) {
                    links += '<a style="cursor:pointer;" onclick="sessionMirrorVideoPlayerOpenModal(\'' + item.sessionId+ '\', ' +j+')">' + (j+1) + '. ' +  parseDomain(records[j].details.url) +'</a><br/>';
                }

                html += '<tr id="session-' + i + '" class="iedit author-self level-0 status-publish format-standard hentry">' +
                    '<td class="title column-title has-row-actions column-primary page-title">' +
                    '<a style="cursor: pointer;" onclick="sessionMirrorVideoPlayerOpenModal(\'' + item.sessionId + '\')"><i class="fa fa-play-circle" style="font-size:40px"></i></a>' +
                    '</td>' +
                    '<td>' + timeDuration(item.totalDuration) + '</td>' +
                    '<td class="user-agent-icons">' +
                    '<i class="' + browserIcon(item.userAgent.browserCode) + '" title="' + item.userAgent.browserName + ' - ' + item.userAgent.browserVersion + '"></i>' +
                    '<i class="' + deviceIcon(item.userAgent.browserType) + '" title="' + item.userAgent.browserType + '" "></i>' +
                    '<i class="' + osIcon(item.userAgent.osCode) + '" title="' + item.userAgent.os + '"></i>' +
                    '</td>' +
                    '<td>' + (item.country ? (SM.countries[item.country] || item.country) + ' / ' : '') + (item.city || '') + '</td>' +
                    '<td><div class="session-mirror-video-links-td-d">' + links + '</div></td>' +
                    '<td style="display:none;">' + parseTags(item.tags) + '</td>' +
                    '<td class="date column-date" title="' + item.createdAt + '">' + SM.timeAgo(item.createdAt) + '</td>' +
                    '</tr>';
            }

            loadinIcon.hide();

            if (!html) {
                html = '<td colspan="7"><div class="sm-video-not-found-message">Video not found.</div></td>';
            }
            body.html(html);

            preparePaginationHtml(res.response);
        });
    };

    var loadVideoFilters = function () {
        var data = {
            'action': SM.ajaxAction,
            'function': 'video_filters',
            'data': {}
        };
        $.post(SM.ajaxUrl, data, function (response) {
            var table = $(SM.videoFilterTableSelector),
                countrySelect = table.find('select[name="country"]'),
                citySelect = table.find('select[name="city"]'),
                data = JSON.parse(response).response,
                countryHtml = '<option value="">' + countrySelect.find('option:eq(0)').text() + '</option>',
                cityHtml = '<option value="">' + citySelect.find('option:eq(0)').text() + '</option>',
                countryMap = {},
                tagsSelect = table.find('select.tags_list'),
                tagsHtml = '<option value="">' + tagsSelect.find('option:eq(0)').text() + '</option>'
            ;

            // country
            for (var i = 0; i < data.cities.length; i++) {
                var item = data.cities[i];
                var _country = SM.countries[item.country] || item.country;
                if (item.country && !countryMap[item.country]) {
                    countryHtml += '<option value="' + item.country + '">' + _country + '</option>';
                }
                if (item.country) {
                    if (!countryMap[item.country]) {
                        countryMap[item.country] = [];
                    }
                    countryMap[item.country].push(item.city);
                }
            }

            // city
            Object.keys(countryMap).forEach(function (value) {
                var _c = SM.countries[value] || value;
                cityHtml += '<optgroup label="' + _c + '">';
                for (var i = 0; i < countryMap[value].length; i++) {
                    var item = countryMap[value][i];
                    cityHtml += '<option value="' + item + '">' + item + '</option>';
                }
                cityHtml += '</optgroup>';
            });
            countrySelect.html(countryHtml);
            citySelect.html(cityHtml);

            // tags
            for (var j = 0; j < data.tags.length; j++) {
                var tag = data.tags[j];
                tagsHtml += '<option value="' + tag + '">' + tag + '</option>';
            }
            tagsSelect.html(tagsHtml);
        });
    };

    var timeDuration = function (secs) {
        var hours = Math.floor(secs / (60 * 60));
        var divisor_for_minutes = secs % (60 * 60);
        var minutes = Math.floor(divisor_for_minutes / 60);

        var divisor_for_seconds = divisor_for_minutes % 60;
        var seconds = Math.ceil(divisor_for_seconds);

        var hourseStr = hours < 10 ? '0' + hours : hours;
        var minutesStr = minutes < 10 ? '0' + minutes : minutes;
        var secondsStr = seconds < 10 ? '0' + seconds : seconds;

        if (hours === 0) {
            return minutesStr + ':' + secondsStr;
        }
        return hourseStr + ':' + minutesStr + ':' + secondsStr;
    };

    var browserIcon = function(browser) {
        switch (true) {
            case browser.indexOf('CHROME') !== -1:
                return 'icon-chrome';
            case browser.indexOf('SAFARI') !== -1:
                return 'icon-safari';
            case browser.indexOf('FIREFOX') !== -1:
                return 'icon-firefox';
            case browser.indexOf('MOZILLA') !== -1:
                return 'icon-firefox';
            case browser.indexOf('OPERA') !== -1:
                return 'icon-opera';
            case browser.indexOf('IE') !== -1:
                return 'icon-IE';
            case browser.indexOf('EDGE') !== -1:
                return 'icon-IE';
            case browser.indexOf('BOT') !== -1:
                return 'icon-bug2';
            case browser.indexOf('APPLE') !== -1:
                return 'icon-apple2';
            default:
                console.error('unknown browser icon for ', browser);
        }
    };

    var deviceIcon = function(type) {
        switch (true) {
            case type.indexOf('WEB') !== -1:
                return 'icon-display';
            case type.indexOf('MOBILE') !== -1:
                return 'icon-mobile';
            case type.indexOf('ROBOT') !== -1:
                return 'icon-bug2';
            default:
                console.error('unknown browser type icon for ', type);
        }
    };

    var osIcon = function(os) {
        switch (true) {
            case os.startsWith('MAC_OS'):
            case os.indexOf('IOS') > -1:
            case os.indexOf('iOS') > -1:
                return 'icon-apple2';
            case os.startsWith('ANDROID'):
                return 'icon-android';
            case os.startsWith('WINDOWS'):
                return 'icon-windows';
            case os.startsWith('LINUX'):
            case os.startsWith('UBUNTU'):
                return 'icon-tux';
            case os.startsWith('UNKNOWN'):
                return 'icon-bug2';
            case os.indexOf('CHROME') > -1:
                return 'icon-chrome';
            default:
                console.error('unknown os icon for ', os);
        }
    };

    var parseDomain = function (url) {
        if (!url) {
            return null;
        }
        try {
            return new URL(url).pathname;
        } catch (e) {
            return null;
        }
    };

    var parseTags = function(tags) {
        var str = '<div class="d-session-tags">';
        var keys = Object.keys(tags);
        for (var i = 0; i < keys.length; i++) {
            str += '<span class="badge badge-light">'+ keys[i] + ': <strong>' + tags[keys[i]] + '</strong></span><br/>';
        }
        return str + '</div>';
    };

    var preparePaginationHtml = function (response) {
        // session count
        $(SM.videoPaginationNumberSelector).html(
            response.total > 0 ? response.total + ' items' : ''
        );

        // first page
        var fl = $(SM.videoPaginationFirstSelector);
        if (SM.videoPaginationCurrentPage > 1) {
            fl.removeClass("disabled");
        } else {
            fl.addClass("disabled");
        }

        // prev
        var pr = $(SM.videoPaginationPrevSelector);
        if (SM.videoPaginationCurrentPage > 1) {
            pr.removeClass("disabled");
        } else {
            pr.addClass("disabled");
        }

        // info text
        var cpt = $(SM.videoPaginationCurrentPageTextSelector);
        var cptt = response.total / SM.videoPaginationItemPerPage;
        if (isNaN(cptt) || cptt < 1) {
            cptt = 1;
        }
        cptt = Math.ceil(cptt);
        SM.videoPaginationLastPageNumber = cptt;
        cpt.html(SM.videoPaginationCurrentPage + ' / ' + cptt);

        // next
        var nb = $(SM.videoPaginationNextSelector);
        var loadedVideo = SM.videoPaginationCurrentPage * SM.videoPaginationItemPerPage;
        if (response.total < loadedVideo + SM.videoPaginationItemPerPage) {
            nb.addClass("disabled");
        } else {
            nb.removeClass("disabled");
        }

        // last
        var lb = $(SM.videoPaginationLastSelector);
        var pp = response.total / SM.videoPaginationItemPerPage;
        if (pp > SM.videoPaginationCurrentPage) {
            lb.removeClass("disabled");
        } else {
            lb.addClass("disabled");
        }
    };

    w.sessionMirrorVideoPlayerOpenModal = function (sessionId, videoIndex) {
        $(SM.videoPlayerContainerSelector).fadeIn();
        $(SM.videoPlayerModalSessionIdInputSelector).val(sessionId);
        var videoContent = $(SM.videoPlayerContentSelector);
        videoContent.html('Loading ...');

        var data = {
            'action': SM.ajaxAction,
            'function': 'video_records',
            'data': { id: sessionId }
        };
        $.post(SM.ajaxUrl, data, function (response) {
            var res = JSON.parse(response);
            var pages = res.response.records;
            var token = res.token;
            var currentPage = null;

            if (!videoIndex) {
                SM.videoPlayerModalCurrentPageIndex = 0;
                currentPage = pages[0];
            } else {
                SM.videoPlayerModalCurrentPageIndex = videoIndex;
                currentPage = pages[videoIndex] || null;
            }

            $(SM.videoPlayerModalVideoCountInputSelector).val(pages.length);

            if(!currentPage) {
                videoContent.html('Video could not be found');
                return;
            }

            $(SM.videoPlayerModalVideoCountSelector).html(
                'Video: ' + (SM.videoPlayerModalCurrentPageIndex + 1) + '/' + pages.length
            );

            var url = 'https://dashboard.sessionmirror.com/direct/' + sessionId + '/play/' + currentPage.pageId +'?token=' + token;
            videoContent.html(
                '<iframe scrolling="no" class="session-mirror-video-player-iframe" src="' + url + '"></iframe>'
            );

        });
    };

    w.sessionMirrorVideosFilterForm = function (form, page) {
        var filters = {
            page: page || "1",
            tags: {},
            sessionName: ""
        };
        var data = $(form).serializeArray();
        for (var i = 0; i < data.length; i++) {
            filters[data[i].name] = data[i].value || "";
        }
        SM.videoPaginationCurrentPage = parseInt(filters.page);

        // tags
        var table = $(SM.videoFilterFormSelector);
        var selectedTag = table.find('select.tags_list').val();
        var selectedTagValue = table.find('input.tags').val();
        if (selectedTag && selectedTagValue) {
            filters.tags[selectedTag] = selectedTagValue;
        }

        loadVideosByProject(filters);
    };

    w.sessionMirrorVideoPaginationFirst = function(that) {
        if ($(that).hasClass("disabled")) {
            return;
        }
        sessionMirrorVideosFilterForm($(SM.videoFilterFormSelector), 1);
    };

    w.sessionMirrorVideoPaginationPrev = function(that) {
        if ($(that).hasClass("disabled")) {
            return;
        }
        sessionMirrorVideosFilterForm($(SM.videoFilterFormSelector), SM.videoPaginationCurrentPage - 1);
    };

    w.sessionMirrorVideoPaginationNext = function(that) {
        if ($(that).hasClass("disabled")) {
            return;
        }
        sessionMirrorVideosFilterForm($(SM.videoFilterFormSelector), SM.videoPaginationCurrentPage + 1);
    };

    w.sessionMirrorVideoPaginationLast = function(that) {
        if ($(that).hasClass("disabled")) {
            return;
        }

        sessionMirrorVideosFilterForm($(SM.videoFilterFormSelector), SM.videoPaginationLastPageNumber);
    };

    w.sessionMirrorVideoPlayerModalClose = function () {
        $(SM.videoPlayerContainerSelector).fadeOut();
        $(SM.videoPlayerModalSessionIdInputSelector).val("");
        $(SM.videoPlayerModalVideoCountInputSelector).val("");
        $(SM.videoPlayerContentSelector).html("");
    };

    w.sessionMirrorVideoPlayerModalNextVideo = function () {
        var sessionId = $(SM.videoPlayerModalSessionIdInputSelector).val();
        var nextPageIndex = SM.videoPlayerModalCurrentPageIndex + 1;
        var totalPage = parseInt($(SM.videoPlayerModalVideoCountInputSelector).val());
        if (nextPageIndex < totalPage) {
            sessionMirrorVideoPlayerOpenModal(sessionId, nextPageIndex);
        }
    };

    w.sessionMirrorVideoPlayerModalPrevVideo = function () {
        var sessionId = $(SM.videoPlayerModalSessionIdInputSelector).val();
        if (SM.videoPlayerModalCurrentPageIndex > 0) {
            sessionMirrorVideoPlayerOpenModal(sessionId, SM.videoPlayerModalCurrentPageIndex - 1);
        }
    };

})(jQuery, document, window);
