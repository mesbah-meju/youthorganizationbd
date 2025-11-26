<div class="aiz-sidebar-wrap">
    <div class="aiz-sidebar left c-scrollbar">
        <div class="aiz-side-nav-logo-wrap">
            <a href="{{ route('admin.dashboard') }}" class="d-block text-center">
                @if(get_setting('system_logo_white') != null)
                <img class="mw-100" src="{{ uploaded_asset(get_setting('system_logo_white')) }}" class="brand-icon" alt="{{ get_setting('site_name') }}">
                @else
                <img class="mw-100" src="{{ static_asset('assets/img/logo.png') }}" class="brand-icon" alt="{{ get_setting('site_name') }}">
                @endif
            </a>
        </div>
        <div class="aiz-side-nav-wrap">
            <div class="px-3 mb-3 position-relative">
                <input class="form-control bg-transparent rounded-2 form-control-sm text-white fs-14" type="text" name="" placeholder="{{ translate('Search in menu') }}" id="menu-search" onkeyup="menuSearch()">
                <span class="absolute-top-right pr-3 mr-3" style="margin-top: 10px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path id="search_FILL0_wght200_GRAD0_opsz20" d="M176.921-769.231l6.255-6.255a5.99,5.99,0,0,0,1.733.949,5.687,5.687,0,0,0,1.885.329,5.317,5.317,0,0,0,3.9-1.608,5.31,5.31,0,0,0,1.609-3.9,5.322,5.322,0,0,0-1.608-3.9,5.306,5.306,0,0,0-3.9-1.611,5.321,5.321,0,0,0-3.9,1.609,5.312,5.312,0,0,0-1.611,3.9,5.554,5.554,0,0,0,.35,1.946,6.043,6.043,0,0,0,.929,1.672l-6.255,6.255Zm9.874-5.82a4.51,4.51,0,0,1-3.317-1.352,4.51,4.51,0,0,1-1.352-3.317,4.51,4.51,0,0,1,1.352-3.317,4.51,4.51,0,0,1,3.317-1.352,4.51,4.51,0,0,1,3.317,1.352,4.51,4.51,0,0,1,1.352,3.317,4.51,4.51,0,0,1-1.352,3.317A4.51,4.51,0,0,1,186.8-775.051Z" transform="translate(-176.307 785.231)" fill="#4e5767" />
                    </svg>
                </span>
            </div>
            <ul class="aiz-side-nav-list" id="search-menu">
            </ul>
            <ul class="aiz-side-nav-list" id="main-menu" data-toggle="aiz-side-menu">
                <!-- Dashboard -->
                @can('admin_dashboard')
                <li class="aiz-side-nav-item">
                    <a href="{{route('admin.dashboard')}}" class="aiz-side-nav-link">
                        <div class="aiz-side-nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                <path id="_3d6902ec768df53cd9e274ca8a57e401" data-name="3d6902ec768df53cd9e274ca8a57e401" d="M18,12.286a1.715,1.715,0,0,0-1.714-1.714h-4a1.715,1.715,0,0,0-1.714,1.714v4A1.715,1.715,0,0,0,12.286,18h4A1.715,1.715,0,0,0,18,16.286Zm-8.571,0a1.715,1.715,0,0,0-1.714-1.714h-4A1.715,1.715,0,0,0,2,12.286v4A1.715,1.715,0,0,0,3.714,18h4a1.715,1.715,0,0,0,1.714-1.714Zm7.429,0v4a.57.57,0,0,1-.571.571h-4a.57.57,0,0,1-.571-.571v-4a.57.57,0,0,1,.571-.571h4a.57.57,0,0,1,.571.571Zm-8.571,0v4a.57.57,0,0,1-.571.571h-4a.57.57,0,0,1-.571-.571v-4a.57.57,0,0,1,.571-.571h4a.57.57,0,0,1,.571.571ZM9.429,3.714A1.715,1.715,0,0,0,7.714,2h-4A1.715,1.715,0,0,0,2,3.714v4A1.715,1.715,0,0,0,3.714,9.429h4A1.715,1.715,0,0,0,9.429,7.714Zm8.571,0A1.715,1.715,0,0,0,16.286,2h-4a1.715,1.715,0,0,0-1.714,1.714v4a1.715,1.715,0,0,0,1.714,1.714h4A1.715,1.715,0,0,0,18,7.714Zm-9.714,0v4a.57.57,0,0,1-.571.571h-4a.57.57,0,0,1-.571-.571v-4a.57.57,0,0,1,.571-.571h4a.57.57,0,0,1,.571.571Zm8.571,0v4a.57.57,0,0,1-.571.571h-4a.57.57,0,0,1-.571-.571v-4a.57.57,0,0,1,.571-.571h4a.57.57,0,0,1,.571.571Z" transform="translate(-2 -2)" fill="#575b6a" fill-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="aiz-side-nav-text">{{translate('Dashboard')}}</span>
                    </a>
                </li>
                @endcan

                <!-- Director -->
                @can(['view_all_director'])
                <li class="aiz-side-nav-item">
                    <a href="{{ route('directors.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['directors.index', 'directors.create', 'directors.edit'])}}">
                        <div class="aiz-side-nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                <path id="ef567a7fa3ca8f4541f8ab7b62352aa6" d="M19,9.625a.638.638,0,0,0-.079-.307l-2.779-5A.614.614,0,0,0,15.606,4H6.394a.614.614,0,0,0-.536.318l-2.779,5A.638.638,0,0,0,3,9.625a2.5,2.5,0,0,0,1.231,2.153V18.75A1.24,1.24,0,0,0,5.462,20H9.08a1.24,1.24,0,0,0,1.231-1.25V16.058a.759.759,0,0,1,.615-.773.684.684,0,0,1,.534.176.706.706,0,0,1,.229.521V18.75A1.24,1.24,0,0,0,12.92,20h3.618a1.24,1.24,0,0,0,1.231-1.25V11.777A2.5,2.5,0,0,0,19,9.625Zm-1.239.149a1.23,1.23,0,0,1-2.453-.149.578.578,0,0,0-.017-.086.548.548,0,0,0-.006-.084L14.114,5.25h1.132ZM9.164,5.25h1.22V9.625a1.23,1.23,0,0,1-2.455.063Zm2.451,0h1.22l1.235,4.437a1.23,1.23,0,0,1-2.455-.062Zm-4.862,0H7.886l-1.169,4.2a.548.548,0,0,0-.006.084.578.578,0,0,0-.018.086,1.23,1.23,0,0,1-2.453.149Zm9.785,13.5H12.92V15.981a1.964,1.964,0,0,0-.635-1.446,1.9,1.9,0,0,0-1.482-.491A2,2,0,0,0,9.08,16.061V18.75H5.462V12.125a2.439,2.439,0,0,0,1.846-.848A2.419,2.419,0,0,0,11,11.261a2.419,2.419,0,0,0,3.692.016,2.439,2.439,0,0,0,1.846.848Z" transform="translate(-3 -4)" fill="#575b6a" />
                            </svg>
                        </div>
                        <span class="aiz-side-nav-text">{{ translate('Activate Users') }}</span>
                    </a>
                </li>
                @endcan

                <!-- Organization -->
                @can(['view_all_organization'])
                <li class="aiz-side-nav-item">
                    <a href="{{ route('organizations.index') }}" class="aiz-side-nav-link">
                        <div class="aiz-side-nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                <path id="ef567a7fa3ca8f4541f8ab7b62352aa6" d="M19,9.625a.638.638,0,0,0-.079-.307l-2.779-5A.614.614,0,0,0,15.606,4H6.394a.614.614,0,0,0-.536.318l-2.779,5A.638.638,0,0,0,3,9.625a2.5,2.5,0,0,0,1.231,2.153V18.75A1.24,1.24,0,0,0,5.462,20H9.08a1.24,1.24,0,0,0,1.231-1.25V16.058a.759.759,0,0,1,.615-.773.684.684,0,0,1,.534.176.706.706,0,0,1,.229.521V18.75A1.24,1.24,0,0,0,12.92,20h3.618a1.24,1.24,0,0,0,1.231-1.25V11.777A2.5,2.5,0,0,0,19,9.625Zm-1.239.149a1.23,1.23,0,0,1-2.453-.149.578.578,0,0,0-.017-.086.548.548,0,0,0-.006-.084L14.114,5.25h1.132ZM9.164,5.25h1.22V9.625a1.23,1.23,0,0,1-2.455.063Zm2.451,0h1.22l1.235,4.437a1.23,1.23,0,0,1-2.455-.062Zm-4.862,0H7.886l-1.169,4.2a.548.548,0,0,0-.006.084.578.578,0,0,0-.018.086,1.23,1.23,0,0,1-2.453.149Zm9.785,13.5H12.92V15.981a1.964,1.964,0,0,0-.635-1.446,1.9,1.9,0,0,0-1.482-.491A2,2,0,0,0,9.08,16.061V18.75H5.462V12.125a2.439,2.439,0,0,0,1.846-.848A2.419,2.419,0,0,0,11,11.261a2.419,2.419,0,0,0,3.692.016,2.439,2.439,0,0,0,1.846.848Z" transform="translate(-3 -4)" fill="#575b6a" />
                            </svg>
                        </div>
                        <span class="aiz-side-nav-text">{{ translate('Organizations') }}</span>
                    </a>
                </li>
                @endcan

                <!-- Submissions -->
                @canany(['view_all_pending_submission', 'view_all_approved_submission','view_all_search_submission'])
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <div class="aiz-side-nav-icon">
                            <svg id="stats_3916778" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                <path id="Path_40739" data-name="Path 40739" d="M16,16H2a2,2,0,0,1-2-2V0H1.333V14A.667.667,0,0,0,2,14.667H16Z" fill="#575b6a" />
                                <rect id="Rectangle_21340" data-name="Rectangle 21340" width="1.333" height="6" transform="translate(9.333 7.333)" fill="#575b6a" />
                                <rect id="Rectangle_21341" data-name="Rectangle 21341" width="1.333" height="6" transform="translate(4 7.333)" fill="#575b6a" />
                                <rect id="Rectangle_21342" data-name="Rectangle 21342" width="1.333" height="9.333" transform="translate(12 4)" fill="#575b6a" />
                                <rect id="Rectangle_21343" data-name="Rectangle 21343" width="1.333" height="9.333" transform="translate(6.667 4)" fill="#575b6a" />
                            </svg>
                        </div>
                        <span class="aiz-side-nav-text">{{ translate('Submissions') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        @can('view_all_pending_submission')
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('organizations.pending') }}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">{{ translate('Pending') }}</span>
                            </a>
                        </li>
                        @endcan
                    
                        @can('view_all_approved_submission')
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('organizations.approved') }}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">{{ translate('Approved') }}</span>
                            </a>
                        </li>
                        @endcan
                        @can('view_all_rejected_submission')
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('organizations.rejected') }}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">{{ translate('Rejected') }}</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                    {{-- <ul class="aiz-side-nav-list level-2">
                        @can('view_all_search_submission')
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('organizations.search') }}" class="aiz-side-nav-link">
                    <span class="aiz-side-nav-text">{{ translate('Search') }}</span>
                    </a>
                </li>
                @endcan
            </ul> --}}
            </li>
            @endcanany

            <!-- Reports -->
            @canany(['deputy_directors_list_report', 'organization_list_report'])
            <li class="aiz-side-nav-item">
                <a href="#" class="aiz-side-nav-link">
                    <div class="aiz-side-nav-icon">
                        <svg id="stats_3916778" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <path id="Path_40739" data-name="Path 40739" d="M16,16H2a2,2,0,0,1-2-2V0H1.333V14A.667.667,0,0,0,2,14.667H16Z" fill="#575b6a" />
                            <rect id="Rectangle_21340" data-name="Rectangle 21340" width="1.333" height="6" transform="translate(9.333 7.333)" fill="#575b6a" />
                            <rect id="Rectangle_21341" data-name="Rectangle 21341" width="1.333" height="6" transform="translate(4 7.333)" fill="#575b6a" />
                            <rect id="Rectangle_21342" data-name="Rectangle 21342" width="1.333" height="9.333" transform="translate(12 4)" fill="#575b6a" />
                            <rect id="Rectangle_21343" data-name="Rectangle 21343" width="1.333" height="9.333" transform="translate(6.667 4)" fill="#575b6a" />
                        </svg>
                    </div>
                    <span class="aiz-side-nav-text">{{ translate('Reports') }}</span>
                    <span class="aiz-side-nav-arrow"></span>
                </a>
                <ul class="aiz-side-nav-list level-2">
                    @can('deputy_directors_list_report')
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('deputy_directors_list_report.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['deputy_directors_list_report.index'])}}">
                            <span class="aiz-side-nav-text">{{ translate('Deputy Directors List') }}</span>
                        </a>
                    </li>
                    @endcan
                    @can('organization_list_report')
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('organization_list_report.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['organization_list_report.index'])}}">
                            <span class="aiz-side-nav-text">{{ translate('Organization List') }}</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany

            <!-- marketing -->
            @canany(['view_all_flash_deals','view_all_dynamic_popups','view_all_custom_alerts','manage_email_templates','send_newsletter','notification_settings','view_all_notification_types','send_custom_notification','view_custom_notification_history','send_bulk_sms','view_all_subscribers','view_all_coupons'])
            <li class="aiz-side-nav-item">
                <a href="#" class="aiz-side-nav-link">
                    <div class="aiz-side-nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <g id="_8dbc7a38f7bdee3f0be2c44d010760a2" data-name="8dbc7a38f7bdee3f0be2c44d010760a2" transform="translate(0 -4.027)">
                                <path id="Path_40740" data-name="Path 40740" d="M38.286,16.393a.555.555,0,0,1-.344-.119L34.032,13.2a.557.557,0,0,1-.213-.438v-5.1a.556.556,0,0,1,.212-.438l3.91-3.074a.557.557,0,0,1,.9.438V15.836a.556.556,0,0,1-.556.557Zm-3.354-3.9,2.8,2.2V5.73l-2.8,2.2Z" transform="translate(-25.364 0)" fill="#575b6a" />
                                <path id="Path_40741" data-name="Path 40741" d="M9.011,22.556H3.093a3.1,3.1,0,0,1,0-6.192H9.011a.557.557,0,0,1,.557.557V22A.557.557,0,0,1,9.011,22.556ZM3.093,17.478a1.982,1.982,0,0,0,0,3.964H8.455V17.478Z" transform="translate(0 -9.25)" fill="#575b6a" />
                                <path id="Path_40742" data-name="Path 40742" d="M10.2,31.9a1.895,1.895,0,0,1-1.847-1.5l-.974-5.455a.557.557,0,1,1,1.089-.229l.975,5.455a.777.777,0,1,0,1.521-.32l-.824-4.74a.557.557,0,1,1,1.089-.229l.824,4.74A1.894,1.894,0,0,1,10.2,31.9Zm8.487-7.6h-.862a.557.557,0,0,1,0-1.114h.862a1.105,1.105,0,0,0,1.1-1.105,1.106,1.106,0,0,0-1.1-1.105h-.862a.557.557,0,0,1,0-1.114h.862a2.22,2.22,0,0,1,1.566,3.79A2.2,2.2,0,0,1,18.683,24.3Z" transform="translate(-4.9 -11.875)" fill="#575b6a" />
                            </g>
                        </svg>
                    </div>
                    <span class="aiz-side-nav-text">{{ translate('Marketing') }}</span>
                    <span class="aiz-side-nav-arrow"></span>
                </a>
                <ul class="aiz-side-nav-list level-2">
                    @can('view_all_dynamic_popups')
                    <li class="aiz-side-nav-item">
                        <a href="{{route('dynamic-popups.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['dynamic-popups.index', 'dynamic-popups.create', 'dynamic-popups.edit'])}}">
                            <span class="aiz-side-nav-text">{{ translate('Dynamic Pop-up') }}</span>
                        </a>
                    </li>
                    @endcan
                    @can('view_all_custom_alerts')
                    <li class="aiz-side-nav-item">
                        <a href="{{route('custom-alerts.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['custom-alerts.index', 'custom-alerts.create', 'custom-alerts.edit'])}}">
                            <span class="aiz-side-nav-text">{{ translate('Custom Alert') }}</span>
                        </a>
                    </li>
                    @endcan
                    @can('manage_email_templates')
                    <li class="aiz-side-nav-item">
                        <a href="javascript:void(0);" class="aiz-side-nav-link">
                            <span class="aiz-side-nav-text">{{translate('Email Templates')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-3">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('email-templates.index', 'admin') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Admin Templates')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('email-templates.index', 'school') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('School Templates')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('email-templates.index', 'doctor') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Doctor Templates')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('email-templates.index', 'all') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Common Templates')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endcan
                    @can('send_newsletter')
                    <li class="aiz-side-nav-item">
                        <a href="{{route('newsletters.index')}}" class="aiz-side-nav-link">
                            <span class="aiz-side-nav-text">{{ translate('Newsletters') }}</span>
                        </a>
                    </li>
                    @endcan
                    @canany(['notification_settings','view_all_notification_types','send_custom_notification', 'view_custom_notification_history'])
                    <li class="aiz-side-nav-item">
                        <a href="javascript:void(0);" class="aiz-side-nav-link">
                            <span class="aiz-side-nav-text">{{translate('Notification')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-3">
                            @can('notification_settings')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('notification.settings') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Settings')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('view_all_notification_types')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('notification-type.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['notification-type.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Notification Types')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('send_custom_notification')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('custom_notification') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Custom Notification')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('view_custom_notification_history')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('custom_notification.history') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Custom Notification History')}}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcanany

                    @if (addon_is_activated('otp_system') && auth()->user()->can('send_bulk_sms'))
                    <li class="aiz-side-nav-item">
                        <a href="{{route('sms.index')}}" class="aiz-side-nav-link">
                            <span class="aiz-side-nav-text">{{ translate('Bulk SMS') }}</span>
                            @if (env("DEMO_MODE") == "On")
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14.001" viewBox="0 0 16 14.001" class="mx-2">
                                <path id="Union_49" data-name="Union 49" d="M-19322,3342.5v-5a2.007,2.007,0,0,0-2-2v1.5a3,3,0,0,1-3,3h-4v-10h4a3,3,0,0,1,3,3v1.5a3,3,0,0,1,3,3v5a.506.506,0,0,1-.5.5A.5.5,0,0,1-19322,3342.5Zm-11-2V3339h-3a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v-7.5a.5.5,0,0,1,.5-.5.5.5,0,0,1,.5.5v11a.5.5,0,0,1-.5.5A.506.506,0,0,1-19333,3340.5Zm-3-7.5a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v2Z" transform="translate(19337 -3329)" fill="#f51350" />
                            </svg>
                            @endif
                        </a>
                    </li>
                    @endif

                    @can('view_all_subscribers')
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('subscribers.index') }}" class="aiz-side-nav-link">
                            <span class="aiz-side-nav-text">{{ translate('Subscribers') }}</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany

            <!-- Support -->
            @canany(['view_all_support_tickets','view_all_product_conversations','view_all_product_queries'])
            <li class="aiz-side-nav-item">
                <a href="#" class="aiz-side-nav-link">
                    <div class="aiz-side-nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <g id="Group_28286" data-name="Group 28286" transform="translate(0)">
                                <path id="Path_40743" data-name="Path 40743" d="M16,9.125a3.122,3.122,0,0,0-1.255-2.5,6.9,6.9,0,0,0-1.94-4.6,6.725,6.725,0,0,0-9.61,0,6.9,6.9,0,0,0-1.94,4.6,3.124,3.124,0,0,0,1.87,5.627h1.25A.625.625,0,0,0,5,11.625v-5A.625.625,0,0,0,4.375,6H3.125a3.129,3.129,0,0,0-.569.052,5.487,5.487,0,0,1,10.887,0A3.129,3.129,0,0,0,12.875,6h-1.25A.625.625,0,0,0,11,6.625v5a.625.625,0,0,0,.625.625h.625v.625a1.877,1.877,0,0,1-1.875,1.875H8A.625.625,0,0,0,8,16h2.375A3.129,3.129,0,0,0,13.5,12.875v-.688A3.13,3.13,0,0,0,16,9.125ZM3.75,7.25V11H3.125a1.875,1.875,0,0,1,0-3.75ZM12.875,11H12.25V7.25h.625a1.875,1.875,0,1,1,0,3.75Z" fill="#575b6a" />
                                <path id="Path_40744" data-name="Path 40744" d="M197.875,113.25a.626.626,0,0,1,.625.625.618.618,0,0,1-.137.391,4.365,4.365,0,0,0-1.113,2.746v.613a.625.625,0,0,0,1.25,0v-.613a3.186,3.186,0,0,1,.838-1.964A1.875,1.875,0,1,0,196,113.875a.625.625,0,0,0,1.25,0A.626.626,0,0,1,197.875,113.25Z" transform="translate(-189.875 -108.5)" fill="#575b6a" />
                                <circle id="Ellipse_891" data-name="Ellipse 891" cx="0.625" cy="0.625" r="0.625" transform="translate(7.375 11)" fill="#575b6a" />
                            </g>
                        </svg>
                    </div>
                    <span class="aiz-side-nav-text">{{translate('Support')}}</span>
                    <span class="aiz-side-nav-arrow"></span>
                </a>
                <ul class="aiz-side-nav-list level-2">
                    @can('view_all_support_tickets')
                    @php
                    $support_ticket = DB::table('tickets')->where('viewed', 0)->select('id')->count();
                    @endphp
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('support_ticket.admin_index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['support_ticket.admin_index', 'support_ticket.admin_show'])}}">
                            <span class="aiz-side-nav-text">{{ translate('Ticket') }}</span>
                            @if($support_ticket > 0)<span class="badge badge-info">{{ $support_ticket }}</span>@endif
                        </a>
                    </li>
                    @endcan

                    @can('view_all_contacts')
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('contacts') }}" class="aiz-side-nav-link {{ areActiveRoutes(['contacts']) }}">
                            <span class="aiz-side-nav-text">{{ translate('Contacts') }}</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany

            <!--OTP addon -->
            @if (addon_is_activated('otp_system'))
            @canany(['otp_configurations','sms_templates','sms_providers_configurations','send_bulk_sms'])
            <li class="aiz-side-nav-item">
                <a href="#" class="aiz-side-nav-link">
                    <div class="aiz-side-nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <path id="pin-code" d="M4.25,12.25a.625.625,0,0,1,.625.625h0a.625.625,0,1,1-1.25,0h0A.625.625,0,0,1,4.25,12.25Zm1.875.625h0a.625.625,0,1,0,1.25,0h0a.625.625,0,1,0-1.25,0Zm2.5,0h0a.625.625,0,1,0,1.25,0h0a.625.625,0,1,0-1.25,0Zm2.5,0h0a.625.625,0,1,0,1.25,0h0a.625.625,0,0,0-1.25,0Zm3-3.046a.625.625,0,0,0-.312,1.211,1.249,1.249,0,0,1,.937,1.211V13.5a1.251,1.251,0,0,1-1.25,1.25H2.5A1.251,1.251,0,0,1,1.25,13.5V12.25a1.257,1.257,0,0,1,.9-1.2.625.625,0,1,0-.354-1.2,2.518,2.518,0,0,0-1.284.888A2.478,2.478,0,0,0,0,12.25V13.5A2.5,2.5,0,0,0,2.5,16h11A2.5,2.5,0,0,0,16,13.5V12.25A2.5,2.5,0,0,0,14.125,9.829Zm-10.562-.7V5.749A1.877,1.877,0,0,1,5.437,3.874h.124V2.387a2.438,2.438,0,0,1,4.875,0V3.874h.126a1.877,1.877,0,0,1,1.875,1.875V9.124A1.877,1.877,0,0,1,10.562,11H5.437A1.877,1.877,0,0,1,3.562,9.124Zm3.249-5.25H9.187V2.387a1.189,1.189,0,0,0-2.375,0V3.874Zm-2,5.25a.626.626,0,0,0,.625.625h5.125a.626.626,0,0,0,.625-.625V5.749a.626.626,0,0,0-.625-.625H5.437a.626.626,0,0,0-.625.625ZM8,8.125A.625.625,0,0,0,8.625,7.5h0a.625.625,0,0,0-1.25,0h0A.625.625,0,0,0,8,8.125Z" transform="translate(0)" fill="#575b6a" />
                        </svg>
                    </div>
                    <span class="aiz-side-nav-text">{{translate('OTP System')}}</span>
                    @if (env("DEMO_MODE") == "On")
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14.001" viewBox="0 0 16 14.001" class="mx-2">
                        <path id="Union_49" data-name="Union 49" d="M-19322,3342.5v-5a2.007,2.007,0,0,0-2-2v1.5a3,3,0,0,1-3,3h-4v-10h4a3,3,0,0,1,3,3v1.5a3,3,0,0,1,3,3v5a.506.506,0,0,1-.5.5A.5.5,0,0,1-19322,3342.5Zm-11-2V3339h-3a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v-7.5a.5.5,0,0,1,.5-.5.5.5,0,0,1,.5.5v11a.5.5,0,0,1-.5.5A.506.506,0,0,1-19333,3340.5Zm-3-7.5a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v2Z" transform="translate(19337 -3329)" fill="#f51350" />
                    </svg>
                    @endif
                    <span class="aiz-side-nav-arrow"></span>
                </a>
                <ul class="aiz-side-nav-list level-2">
                    @can('otp_configurations')
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('otp.configconfiguration') }}" class="aiz-side-nav-link">
                            <span class="aiz-side-nav-text">{{translate('OTP Configurations')}}</span>
                        </a>
                    </li>
                    @endcan
                    @can('sms_providers_configurations')
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('otp_credentials.index') }}" class="aiz-side-nav-link">
                            <span class="aiz-side-nav-text">{{translate('Set OTP Credentials')}}</span>
                        </a>
                    </li>
                    @endcan
                    @can('sms_templates')
                    <li class="aiz-side-nav-item">
                        <a href="{{route('sms-templates.index')}}" class="aiz-side-nav-link">
                            <span class="aiz-side-nav-text">{{translate('SMS Templates')}}</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany
            @endif

            <!-- Website Setup -->
            @canany(['header_setup','footer_setup','view_all_website_pages','website_appearance','authentication_layout_settings'])
            <li class="aiz-side-nav-item">
                <a href="#" class="aiz-side-nav-link {{ areActiveRoutes(['website.footer', 'website.header'])}}">
                    <div class="aiz-side-nav-icon">
                        <svg id="Group_28315" data-name="Group 28315" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <circle id="Ellipse_893" data-name="Ellipse 893" cx="0.625" cy="0.625" r="0.625" transform="translate(7.375 6.125)" fill="#575b6a" />
                            <path id="Path_40777" data-name="Path 40777" d="M13.5,0H2.5A2.5,2.5,0,0,0,0,2.5V11a2.5,2.5,0,0,0,2.5,2.5H7.375v1.25H5.5A.625.625,0,0,0,5.5,16h5a.625.625,0,0,0,0-1.25H8.625V12.875A.625.625,0,0,0,8,12.25H2.5A1.251,1.251,0,0,1,1.25,11V2.5A1.251,1.251,0,0,1,2.5,1.25h11A1.251,1.251,0,0,1,14.75,2.5V11a1.251,1.251,0,0,1-1.25,1.25h-3a.625.625,0,0,0,0,1.25h3A2.5,2.5,0,0,0,16,11V2.5A2.5,2.5,0,0,0,13.5,0Z" fill="#575b6a" />
                            <path id="Path_40778" data-name="Path 40778" d="M120.375,84.75a.625.625,0,0,0,.625-.625v-.688a3.107,3.107,0,0,0,1.1-.456l.487.487a.625.625,0,0,0,.884-.884l-.487-.487a3.108,3.108,0,0,0,.456-1.1h.688a.625.625,0,1,0,0-1.25h-.688a3.108,3.108,0,0,0-.456-1.1l.487-.487a.625.625,0,0,0-.884-.884l-.487.487a3.107,3.107,0,0,0-1.1-.456v-.688a.625.625,0,0,0-1.25,0v.688a3.108,3.108,0,0,0-1.1.456l-.487-.487a.625.625,0,0,0-.884.884l.487.487a3.108,3.108,0,0,0-.456,1.1h-.688a.625.625,0,0,0,0,1.25h.688a3.108,3.108,0,0,0,.456,1.1l-.487.487a.625.625,0,0,0,.884.884l.487-.487a3.107,3.107,0,0,0,1.1.456v.688A.625.625,0,0,0,120.375,84.75ZM118.5,80.375a1.875,1.875,0,1,1,1.875,1.875A1.877,1.877,0,0,1,118.5,80.375Z" transform="translate(-112.375 -73.625)" fill="#575b6a" />
                        </svg>
                    </div>
                    <span class="aiz-side-nav-text">{{translate('Website Setup')}}</span>
                    <span class="aiz-side-nav-arrow"></span>
                </a>
                <ul class="aiz-side-nav-list level-2">
                    @can('website_appearance')
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('website.appearance') }}" class="aiz-side-nav-link">
                            <span class="aiz-side-nav-text">{{translate('Appearance')}}</span>
                        </a>
                    </li>
                    @endcan
                    @can('authentication_layout_settings')
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('website.authentication-layout-settings') }}" class="aiz-side-nav-link">
                            <span class="aiz-side-nav-text">{{translate('Authentication')}}</span>
                        </a>
                    </li>
                    @endcan
                    @can('header_setup')
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('website.header') }}" class="aiz-side-nav-link">
                            <span class="aiz-side-nav-text">{{translate('Header')}}</span>
                        </a>
                    </li>
                    @endcan
                    @can('footer_setup')
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('website.footer', ['lang'=>  App::getLocale()] ) }}" class="aiz-side-nav-link {{ areActiveRoutes(['website.footer'])}}">
                            <span class="aiz-side-nav-text">{{translate('Footer')}}</span>
                        </a>
                    </li>
                    @endcan
                    @can('view_all_website_pages')
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('website.pages') }}" class="aiz-side-nav-link {{ areActiveRoutes(['website.pages', 'custom-pages.create' ,'custom-pages.edit'])}}">
                            <span class="aiz-side-nav-text">{{translate('Pages')}}</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany

            <!-- Setup & Configurations -->
            @canany(['general_settings','features_activation','language_setup','currency_setup','vat_&_tax_setup',
            'pickup_point_setup','smtp_settings','schedule_settings','payment_methods_configurations','order_configuration','file_system_&_cache_configuration',
            'social_media_logins','facebook_chat','facebook_comment','analytics_tools_configuration','google_recaptcha_configuration','google_map_setting',
            'google_firebase_setting','shipping_configuration','shipping_country_setting','manage_shipping_states','manage_shipping_cities','manage_zones','manage_carriers'])
            <li class="aiz-side-nav-item">
                <a href="#" class="aiz-side-nav-link">
                    <div class="aiz-side-nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <path id="Path_40779" data-name="Path 40779" d="M7.688,16h.625a1.877,1.877,0,0,0,1.875-1.875V13.81a.209.209,0,0,1,.133-.191l.011,0a.209.209,0,0,1,.23.041l.223.223a1.875,1.875,0,0,0,2.652,0l.442-.442a1.875,1.875,0,0,0,0-2.652l-.223-.223a.209.209,0,0,1-.041-.23l0-.012a.209.209,0,0,1,.191-.133h.315A1.877,1.877,0,0,0,16,8.313V7.688a1.877,1.877,0,0,0-1.875-1.875H13.81a.209.209,0,0,1-.191-.133l0-.011a.209.209,0,0,1,.041-.23l.223-.223a1.875,1.875,0,0,0,0-2.652l-.442-.442a1.875,1.875,0,0,0-2.652,0l-.223.223a.21.21,0,0,1-.23.041l-.012,0a.209.209,0,0,1-.133-.191V1.875A1.877,1.877,0,0,0,8.312,0H7.687A1.877,1.877,0,0,0,5.812,1.875V2.19a.209.209,0,0,1-.133.191l-.012,0a.209.209,0,0,1-.23-.041l-.223-.223a1.875,1.875,0,0,0-2.652,0l-.442.442a1.875,1.875,0,0,0,0,2.652l.223.223a.209.209,0,0,1,.041.23l0,.011a.209.209,0,0,1-.191.133H1.875A1.877,1.877,0,0,0,0,7.687v.625a1.874,1.874,0,0,0,1.407,1.816.625.625,0,1,0,.312-1.211.624.624,0,0,1-.468-.605V7.688a.626.626,0,0,1,.625-.625H2.19a1.455,1.455,0,0,0,1.347-.906l0-.011a1.455,1.455,0,0,0-.312-1.591l-.223-.223a.625.625,0,0,1,0-.884l.442-.442a.625.625,0,0,1,.884,0l.223.223a1.456,1.456,0,0,0,1.593.311l.009,0A1.455,1.455,0,0,0,7.063,2.19V1.875a.626.626,0,0,1,.625-.625h.625a.626.626,0,0,1,.625.625V2.19a1.455,1.455,0,0,0,.906,1.347l.009,0a1.455,1.455,0,0,0,1.593-.311l.223-.223a.625.625,0,0,1,.884,0l.442.442a.625.625,0,0,1,0,.884l-.223.223a1.455,1.455,0,0,0-.311,1.593l0,.009a1.455,1.455,0,0,0,1.347.906h.315a.626.626,0,0,1,.625.625v.625a.626.626,0,0,1-.625.625H13.81a1.455,1.455,0,0,0-1.347.906l0,.009a1.455,1.455,0,0,0,.311,1.593l.223.223a.625.625,0,0,1,0,.884l-.442.442a.625.625,0,0,1-.884,0l-.223-.223a1.456,1.456,0,0,0-1.593-.311l-.009,0a1.455,1.455,0,0,0-.906,1.347v.315a.626.626,0,0,1-.625.625H7.688a.622.622,0,0,1-.6-.437.625.625,0,1,0-1.193.375A1.867,1.867,0,0,0,7.688,16ZM.536,15.433a1.829,1.829,0,0,1,0-2.586h0L4.589,8.811a3.234,3.234,0,0,1-.308-1.259,2.97,2.97,0,0,1,.9-2.141A4.228,4.228,0,0,1,8.13,4.255h.007a3.322,3.322,0,0,1,1.086.188A.625.625,0,0,1,9.47,5.473L7.964,7.01l.188.811L8.95,8,10.479,6.47a.625.625,0,0,1,1.034.24,3.472,3.472,0,0,1,.2,1.121,4.373,4.373,0,0,1-.8,2.556,3.047,3.047,0,0,1-2.49,1.3H8.417A3.414,3.414,0,0,1,7.159,11.4L3.122,15.433a1.829,1.829,0,0,1-2.586,0Zm6.876-5.311a2.1,2.1,0,0,0,1.007.316,1.818,1.818,0,0,0,1.487-.792,2.988,2.988,0,0,0,.528-1.361l-.843.845A.625.625,0,0,1,9.01,9.3L7.494,8.953a.625.625,0,0,1-.471-.468L6.669,6.959a.625.625,0,0,1,.162-.579l.823-.84A2.844,2.844,0,0,0,6.067,6.3,1.723,1.723,0,0,0,5.531,7.55a2.123,2.123,0,0,0,.342,1,.625.625,0,0,1-.065.809L1.419,13.731a.579.579,0,1,0,.819.818l4.368-4.361a.625.625,0,0,1,.806-.066Z" fill="#575b6a" />
                        </svg>
                    </div>
                    <span class="aiz-side-nav-text">{{translate('Setup & Configurations')}}</span>
                    <span class="aiz-side-nav-arrow"></span>
                </a>
                <ul class="aiz-side-nav-list level-2">
                    @can('features_activation')
                    <li class="aiz-side-nav-item">
                        <a href="{{route('activation.index')}}" class="aiz-side-nav-link">
                            <span class="aiz-side-nav-text">{{translate('Features')}}</span>
                        </a>
                    </li>
                    @endcan
                    @can('language_setup')
                    <li class="aiz-side-nav-item">
                        <a href="{{route('languages.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['languages.index', 'languages.create', 'languages.store', 'languages.show', 'languages.edit'])}}">
                            <span class="aiz-side-nav-text">{{translate('Languages')}}</span>
                        </a>
                    </li>
                    @endcan
                    @can('smtp_settings')
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('smtp_settings.index') }}" class="aiz-side-nav-link">
                            <span class="aiz-side-nav-text">{{translate('Mail Setting')}}</span>
                        </a>
                    </li>
                    @endcan
                    @canany(['facebook_chat','facebook_comment'])
                    <li class="aiz-side-nav-item">
                        <a href="javascript:void(0);" class="aiz-side-nav-link">
                            <span class="aiz-side-nav-text">{{translate('Facebook')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-3">
                            @can('facebook_chat')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('facebook_chat.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Facebook Chat')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('facebook_comment')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('facebook-comment') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Facebook Comment')}}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcanany
                    @canany(['analytics_tools_configuration','google_recaptcha_configuration','google_map_setting','google_firebase_setting'])
                    <li class="aiz-side-nav-item">
                        <a href="javascript:void(0);" class="aiz-side-nav-link">
                            <span class="aiz-side-nav-text">{{translate('Google')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-3">
                            @can('analytics_tools_configuration')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('google_analytics.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Analytics Tools')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('google_recaptcha_configuration')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('google_recaptcha.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Google reCAPTCHA')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('google_map_setting')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('google-map.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Google Map')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('google_firebase_setting')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('google-firebase.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Google Firebase')}}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcanany
                </ul>
            </li>
            @endcanany

            <!-- Users & Permissions -->
            @canany(['view_all_users','view_user_roles', 'add_director'])
            <li class="aiz-side-nav-item">
                <a href="#" class="aiz-side-nav-link">
                    <div class="aiz-side-nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <g id="Group_28314" data-name="Group 28314" transform="translate(-19299 2175)">
                                <path id="Path_40774" data-name="Path 40774" d="M87.867,3.07H84.133V1.72A.716.716,0,0,0,83.422,1H80.578a.716.716,0,0,0-.711.72V3.07H76.133A2.149,2.149,0,0,0,74,5.229V14.84A2.149,2.149,0,0,0,76.133,17H87.867A2.149,2.149,0,0,0,90,14.84V5.229A2.149,2.149,0,0,0,87.867,3.07Zm-6.578-.63h1.422V3.79a.711.711,0,1,1-1.422,0Zm7.289,12.4a.716.716,0,0,1-.711.72H76.133a.716.716,0,0,1-.711-.72V5.229a.716.716,0,0,1,.711-.72h3.856a2.124,2.124,0,0,0,4.022,0h3.856a.716.716,0,0,1,.711.72Z" transform="translate(19225 -2176)" fill="#575b6a" />
                                <g id="Group_28312" data-name="Group 28312" transform="translate(19305.07 -2169.197)">
                                    <path id="Path_40775" data-name="Path 40775" d="M199.864,197.932a1.932,1.932,0,1,0-1.932,1.932A1.934,1.934,0,0,0,199.864,197.932Zm-1.932.644a.644.644,0,1,1,.644-.644A.645.645,0,0,1,197.932,198.576Z" transform="translate(-196 -196)" fill="#575b6a" />
                                </g>
                                <g id="Group_28313" data-name="Group 28313" transform="translate(19303.779 -2165)">
                                    <path id="Path_40776" data-name="Path 40776" d="M160.508,316h-2.576A1.934,1.934,0,0,0,156,317.932v1.288a.644.644,0,1,0,1.288,0v-1.288a.645.645,0,0,1,.644-.644h2.576a.645.645,0,0,1,.644.644v1.288a.644.644,0,1,0,1.288,0v-1.288A1.934,1.934,0,0,0,160.508,316Z" transform="translate(-156 -316)" fill="#575b6a" />
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="aiz-side-nav-text">{{translate('Users & Permissions')}}</span>
                    <span class="aiz-side-nav-arrow"></span>
                </a>
                <ul class="aiz-side-nav-list level-2">
                    @can('add_director')
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('directors.create') }}" class="aiz-side-nav-link {{ areActiveRoutes(['directors.create'])}}">
                            <span class="aiz-side-nav-text">{{translate('Add User')}}</span>
                        </a>
                    </li>
                    @endcan
                    @can('view_all_users')
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('users.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['users.index', 'users.create', 'users.edit'])}}">
                            <span class="aiz-side-nav-text">{{translate('All Users')}}</span>
                        </a>
                    </li>
                    @endcan
                    @can('view_user_roles')
                    <li class="aiz-side-nav-item">
                        <a href="{{route('roles.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['roles.index', 'roles.create', 'roles.edit'])}}">
                            <span class="aiz-side-nav-text">{{translate('Permissions')}}</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany
            </ul>
        </div>
    </div>
    <div class="aiz-sidebar-overlay"></div>
</div>