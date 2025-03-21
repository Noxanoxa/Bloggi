<!-- Header -->
<header id="wn__header" class="oth-page header__area header__absolute sticky__header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-7 col-lg-2">
                <div class="logo">
                    <a href="{{ route('frontend.index') }}">
                        <img src="{{ asset('frontend/images/logo/logo.png') }}" alt="logo images">
                    </a>
                </div>
            </div>
            <div class="col-lg-8 d-none d-lg-block">
                <nav class="mainmenu__nav">
                    <ul class="meninmenu d-flex justify-content-start">
                        <li class="drop with--one--item"><a href="{{ route('frontend.index') }}">{{__('frontend/general.home')}}</a></li>
                        <li class="drop with--one--item"><a href="{{ route('frontend.posts.show', 'about-us') }}">{{__('frontend/general.about_us')}}</a></li>
                        <li class="drop with--one--item"><a href="{{ route('frontend.posts.show', 'our-vision') }}">{{__('frontend/general.our_vision')}}</a></li>
                        <li class="drop"><a href="javascript:void(0);">{{__('frontend/general.blog')}}</a>
                            <div class="megamenu dropdown">
                                <ul class="item item01">
                                    @foreach($global_categories as $global_category)
                                        <li><a href="{{ route('frontend.category.posts', $global_category->slug) }}">{{ \Illuminate\Support\Str::upper($global_category->name()) }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        <li><a href="{{ route('frontend.contact') }}">{{__('frontend/general.contact_us')}}</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-md-8 col-sm-8 col-5 col-lg-2">
                <ul class="header__sidebar__right d-flex justify-content-end align-items-center">

                    @if(session()->get('locale') == 'ar')
                        <li class="lang_link">
                            <a class="nav-link" href="{{ route('change_locale', 'en')}}">
                                English
                            </a>
                        </li>
                    @else
                        <li class="lang_link">
                            <a class="nav-link" href="{{ route('change_locale', 'ar')}}">
                                عربي
                            </a>
                        </li>
                    @endif

                    <li class="shop_search"><a class="search__active" href="#"></a></li>
                    <user-notification></user-notification>
                    <li class="setting__bar__icon"><a class="setting__active" href="#"></a>
                        <div class="searchbar__content setting__block">
                            <div class="content-inner">
                                <div class="switcher-currency">
                                    <strong class="label switcher-label">
                                        <span>{{__('frontend/general.my_account')}}</span>
                                    </strong>
                                    <div class="switcher-options">
                                        <div class="switcher-currency-trigger">
                                            <div class="setting__menu">
                                                @guest
                                                    <span><a href="{{ route('frontend.show_login_form') }}">{{__('frontend/general.login')}}</a></span>
                                                    <span><a href="{{ route('frontend.show_register_form') }}">{{__('frontend/general.register')}}</a></span>
                                                @else
                                                    <span><a href="{{ route('users.dashboard') }}">{{__('frontend/general.dashboard')}}</a></span>
                                                    <span><a  href="{{ route('frontend.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{__('frontend/general.logout')}}</a></span>
                                                    <form id="logout-form" action="{{ route('frontend.logout') }}" method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                @endguest
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Start Mobile Menu -->
        <div class="row d-none">
            <div class="col-lg-12 d-none">
                <nav class="mobilemenu__nav">
                    <ul class="meninmenu">
                        <li><a href="{{ route('frontend.index') }}">Home</a></li>
                        <li><a href="{{ route('frontend.posts.show', 'about-us') }}">About Us</a></li>
                        <li><a href="{{ route('frontend.posts.show', 'our-vision') }}">Our Vision </a></li>

                        <li><a href="javascript:void(0);">Blog</a>
                            <ul>
                                <li><a href="#">Un-Categorized</a></li>
                                <li><a href="#">Natural</a></li>
                                <li><a href="#">Flowers</a></li>
                            </ul>
                        </li>
                        <li><a href="{{route('frontend.contact')}}">Contact</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- End Mobile Menu -->
        <div class="mobile-menu d-block d-lg-none">
        </div>
        <!-- Mobile Menu -->
    </div>
</header>
<!-- //Header -->
<!-- Start Search Popup -->
<div class="box-search-content search_active block-bg close__top">

    <form id="search_mini_form" class="minisearch" action="{{ route('frontend.search') }}" method="get">
    <div class="field__search">
        <input type="text" name="keyword" value="{{ old('keyword', request('keyword')) }}" placeholder="Search here...">
        <div class="action">
            <a href="javascript:void(0);" onclick="event.preventDefault();document.getElementById('search_mini_form').submit();"><i class="zmdi zmdi-search"></i></a>
        </div>
    </div>
    </form>

    <div class="close__wrap">
        <span>{{__('frontend/general.close')}}</span>
    </div>
</div>
<!-- End Search Popup -->
<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area bg-image--4">

</div>
