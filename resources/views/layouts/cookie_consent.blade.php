<link rel='stylesheet' href='{{asset('css/cookieconsent.css')}}' media="screen" />
<script src="{{ asset('js/cookieconsent.js') }}"></script>
@php
    $setting = Utility::cookie_settings();
    $a = (json_encode($setting));
    @endphp

<script>
    
    let myVar = {!! json_encode($a) !!};
        let data = JSON.parse(myVar);

    let language_code = data.default_language;
    let languages = {};
    languages[language_code] = {
        consent_modal: {
            title: 'hello',
            description: 'description',
            primary_btn: {
                text: 'primary_btn text',
                role: 'accept_all'
            },
            secondary_btn: {
                        text: 'secondary_btn text',
                        role: 'accept_necessary'
                    }
                },
                settings_modal: {
                    title: 'settings_modal',
                    save_settings_btn: 'save_settings_btn',
                    accept_all_btn: 'accept_all_btn',
                    reject_all_btn: 'reject_all_btn',
                    close_btn_label: 'close_btn_label',
                    blocks: [{
                            title: 'block title',
                            description: 'block description'
                        },

                        {
                            title: 'title',
                            description: 'description',
                            toggle: {
                                value: 'necessary',
                                enabled: true,
                                readonly: false
                            }
                        },
                    ]
                }
            };
            </script>
        <script>
            function setCookie(cname, cvalue, exdays) {
                const d = new Date();
                d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                let expires = "expires=" + d.toUTCString();
                document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            }
            
            function getCookie(cname) {
                let name = cname + "=";
                let decodedCookie = decodeURIComponent(document.cookie);
                let ca = decodedCookie.split(';');
                for (let i = 0; i < ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) == ' ') {
                        c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                        return c.substring(name.length, c.length);
                    }
                }
                return "";
            }
            
            
            // obtain plugin
            var cc = initCookieConsent();
            // run plugin with your configuration
            cc.run({
                current_lang: 'en',
                autoclear_cookies: true, // default: false
                page_scripts: true,
                // ...
                gui_options: {
                    consent_modal: {
                        layout: 'cloud', // box/cloud/bar
                        position: 'bottom center', // bottom/middle/top + left/right/center
                        transition: 'slide', // zoom/slide
                        swap_buttons: false // enable to invert buttons
                    },
                    settings_modal: {
                        layout: 'box', // box/bar
                        // position: 'left',           // left/right
                        transition: 'slide' // zoom/slide
                    }
                },
               
                onChange: function(cookie, changed_preferences) {},
                onAccept: function(cookie) {
                    if (!getCookie('cookie_consent_logged')) {
                        var cookie = cookie.level;
                        $.ajax({
                            url: '{{ route('cookie-consent') }}',
                            datType: 'json',
                            data: {
                                cookie: cookie,
                            },
                        })
                        setCookie('cookie_consent_logged', '1', 182, '/');
                    }
                },
                languages: {
                    'en': {
                        consent_modal: {
                            title: data.cookie_title,
                            description: data.cookie_description+' '+'<button type="button" data-cc="c-settings" class="cc-link">Let me choose</button>',
                            primary_btn: {
                                text: "{{__('Accept all')}}",
                                role: 'accept_all' // 'accept_selected' or 'accept_all'
                            },
                            secondary_btn: {
                                text: "{{__('Reject all')}}",
                                role: 'accept_necessary' // 'settings' or 'accept_necessary'
                            },
                        },
                        
                        settings_modal: {
                            title: "{{__('Cookie preferences')}}",
                            save_settings_btn: "{{__('Save settings')}}",
                            accept_all_btn: "{{__('Accept all')}}",
                            reject_all_btn: "{{__('Reject all')}}",
                            close_btn_label: "{{__('Close')}}",
                            cookie_table_headers: [{
                                col1: 'Name'
                            },
                            {
                                col2: 'Domain'
                                },
                                {
                                    col3: 'Expiration'
                                },
                                {
                                    col4: 'Description'
                                }
                            ],
                            blocks: [{
                                title: data.cookie_title +' '+ '📢',
                                description: data.cookie_description,
                            }, {
                                title: data.strictly_cookie_title,
                                description: data.strictly_cookie_description,
                                toggle: {
                                    value: 'necessary',
                                    enabled: true,
                                    readonly: true // cookie categories with readonly=true are all treated as "necessary cookies"
                                }
                            }, {
                                title: "{{__('More information')}}",
                                description: data.more_information_description+' '+'<a class="cc-link" href="'+data.contactus_url+'">Contact Us</a>.',
                            }]
                        }
                    }
                }
                
            });
        </script>