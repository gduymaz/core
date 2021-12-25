@php
    $forms = \Dawnstar\Models\Form::withCount('unreadMessages')->having('unread_messages_count', '>', 0)->active()->get();
@endphp

<div class="navbar-custom topnav-navbar topnav-navbar-dark">
    <div class="container-fluid">
        <!-- LOGO -->
        <a href="index.html" class="topnav-logo">
            <span class="topnav-logo-lg">
                <img src="assets/images/logo-light.png" alt="" height="16">
            </span>
            <span class="topnav-logo-sm">
                <img src="assets/images/logo_sm.png" alt="" height="16">
            </span>
        </a>

        <ul class="list-unstyled topbar-menu float-end mb-0">
            @if(session('dawnstar.website'))
            <li class="dropdown notification-list topbar-dropdown d-none d-lg-block">
                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" id="topbar-languagedrop" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ languageFlag(session('dawnstar.language.code')) }}" alt="{{ session('dawnstar.language.code') }}" class="me-1" height="12">
                    <span class="align-middle">{{ strtoupper(session('dawnstar.language.code')) }}</span>
                    <i class="mdi mdi-chevron-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu" aria-labelledby="topbar-languagedrop">
                    @foreach(session('dawnstar.languages') as $language)
                        @continue($language->id === session('dawnstar.language.id'))
                        <a href="{{ route('dawnstar.panel.changeLanguage', $language) }}" class="dropdown-item notify-item">
                            <img src="{{ languageFlag($language->code) }}" alt="{{ $language->code }}" class="me-1" height="12">
                            <span class="align-middle">{{ strtoupper($language->code) }}</span>
                        </a>
                    @endforeach
                </div>
            </li>
            @endif

            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" id="topbar-notifydrop" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="dripicons-bell noti-icon"></i>
                    @if($forms->isNotEmpty())
                    <span class="noti-icon-badge"></span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg" aria-labelledby="topbar-notifydrop">

                    <div class="dropdown-item noti-title">
                        <h5 class="m-0">@lang('Dawnstar::general.notification')</h5>
                    </div>

                    <div style="max-height: 230px;" data-simplebar>
                        @foreach($forms as $form)
                            <a href="{{ route('dawnstar.forms.messages.index', $form) }}" class="dropdown-item notify-item">
                                <div class="notify-icon bg-body">
                                    <i class="mdi mdi-message"></i>
                                </div>
                                <p class="notify-details">
                                    {!! $form->name !!}
                                    <small class="text-muted">{!! $form->unread_messages_count !!} @lang('Dawnstar::form_message.unread_count')</small>
                                </p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </li>

            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" id="topbar-userdrop" href="#" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    <span class="account-user-avatar">
                        <img src="{{ auth('admin')->user()->mf_avatar ?: defaultImage() }}" alt="{{ auth('admin')->user()->full_name }}" class="rounded-circle">
                    </span>
                    <span>
                        <span class="account-user-name mt-1">{{ auth('admin')->user()->full_name }}</span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown" aria-labelledby="topbar-userdrop">
                    <!-- item-->
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Hoşgeldiniz !</h6>
                    </div>

                    <a href="{{ route('dawnstar.profile.index') }}" class="dropdown-item notify-item">
                        <i class="mdi mdi-account-circle me-1"></i>
                        <span>@lang('Dawnstar::admin.profile')</span>
                    </a>

                    <a href="{{ route('dawnstar.developer.index') }}" class="dropdown-item notify-item">
                        <i class="mdi mdi-tools me-1"></i>
                        <span>@lang('Developer::general.title')</span>
                    </a>

                    <form action="{{ route('dawnstar.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item notify-item">
                            <i class="mdi mdi-logout me-1"></i>
                            <span>@lang('Dawnstar::auth.logout')</span>
                        </button>
                    </form>

                </div>
            </li>
        </ul>
        <a class="button-menu-mobile disable-btn">
            <div class="lines">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </a>
    </div>
</div>
