<div id="headerMain" class="">
    <header id="header"
            class="navbar navbar-expand-lg navbar-fixed navbar-height navbar-flush navbar-container navbar-bordered pr-0">
        <div class="navbar-nav-wrap">

            <div class="navbar-nav-wrap-content-left d-xl-none">
                <!-- Navbar Vertical Toggle -->
                <button type="button" class="js-navbar-vertical-aside-toggle-invoker close mr-3">
                    <i class="tio-first-page navbar-vertical-aside-toggle-short-align" data-toggle="tooltip"
                       data-placement="right" title="Collapse"></i>
                    <i class="tio-last-page navbar-vertical-aside-toggle-full-align"
                       data-template='<div class="tooltip d-none d-sm-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                       data-toggle="tooltip" data-placement="right" title="Expand"></i>
                </button>
                <!-- End Navbar Vertical Toggle -->
            </div>

            <!-- Secondary Content -->
            <div class="navbar-nav-wrap-content-right flex-grow-1 w-0">
                <!-- Navbar -->
                <ul class="navbar-nav align-items-center flex-row flex-grow-1 __navbar-nav">


                    <li class="nav-item max-sm-m-0 w-xxl-200px ml-auto flex-grow-0">
                        <button type="button" id="modalOpener" class="title-color bg--secondary border-0 rounded justify-content-between w-100 align-items-center py-2 px-2 px-md-3 d-flex gap-1" data-toggle="modal" data-target="#staticBackdrop">
                            <div class="align-items-center d-flex flex-grow-1 gap-1 justify-content-between">
                                <span class="align-items-center d-none d-xxl-flex gap-2 text-muted">{{translate('Search_or')}}

                                    <span class="bg-E7E6E8 border ctrlplusk d-md-block d-none font-bold fs-12 fw-bold lh-1 ms-1 px-1 rounded text-muted">Ctrl+K</span>

                                </span>
                                <img width="14" class="h-auto" src="{{asset('/public/assets/admin/img/new-img/search.svg')}}" class="svg" alt="">
                            </div>
                        </button>
                    </li>

                    <li class="nav-item max-sm-m-0  mr-lg-3">
                        <a class="btn btn-icon rounded-circle nav-msg-icon"
                           href="#">
                            <img src="{{asset('/public/assets/admin/img/new-img/message-icon.svg')}}" alt="public/img">
                            @php($message=\App\Models\Conversation::whereUserType('admin')->whereHas('last_message', function($query) {
                                $query->whereColumn('conversations.sender_id', 'messages.sender_id');
                            })->where('unread_message_count', '>', 0)->count())
                            @if($message!=0)
                                <span class="btn-status btn-status-danger">{{ $message }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item max-sm-m-0">
                        <div class="hs-unfold">
                            <div>
                                @php( $local = session()->has('local')?session('local'): null)
                                @php($lang = \App\Models\BusinessSetting::where('key', 'system_language')->first())
                                @if ($lang)
                                    <div
                                        class="topbar-text dropdown disable-autohide text-capitalize d-flex">
                                        <a class="topbar-link dropdown-toggle d-flex align-items-center title-color"
                                           href="#" data-toggle="dropdown">
                                            @foreach(json_decode($lang['value'],true) as $data)
                                                @if($data['code']==$local)
                                                    <i class="tio-globe"></i> {{$data['code']}}

                                                @elseif(!$local &&  $data['default'] == true)
                                                    <i class="tio-globe"></i> {{$data['code']}}
                                                @endif
                                            @endforeach
                                        </a>
                                        <ul class="dropdown-menu lang-menu">
                                            @foreach(json_decode($lang['value'],true) as $key =>$data)
                                                @if($data['status']==1)
                                                    <li>
                                                        <a class="dropdown-item py-1"
                                                           href="#">
                                                            <span class="text-capitalize">{{$data['code']}}</span>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </li>
                    @php($mod = \App\Models\Module::find(Config::get('module.current_module_id')))
                    <div class="nav-item __nav-item">
                        <a href="javascript:void(0)" class="__nav-link module--nav-icon" id="tourb-0">
                            @if ($mod)
                                <img src="{{ $mod->icon_full_url }}"
                                     class="onerror-image"
                                     data-onerror-image="{{asset('/public/assets/admin/img/new-img/module-icon.svg')}}"
                                     width="20px" alt="public/img">
                            @else
                                <img src="{{asset('/public/assets/admin/img/new-img/module-icon.svg')}}"
                                     alt="public/img">
                            @endif
                            <span class="text-white">{{ $mod ? $mod->module_name : translate('modules') }}</span>
                            <img src="{{asset('/public/assets/admin/img/new-img/angle-white.svg')}}"
                                 class="d-none d-lg-block ml-xl-2" alt="public/img">
                        </a>

                        </li>
                </ul>
                <!-- End Navbar -->
            </div>
            <!-- End Secondary Content -->
        </div>
    </header>
</div>
<div id="headerFluid" class="d-none"></div>
<div id="headerDouble" class="d-none"></div>

<div class="modal fade removeSlideDown" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered max-w-520">
        <div class="modal-content modal-content__search border-0">
            <div class="d-flex flex-column gap-3 rounded-20 bg-card py-2 px-3">
                <div class="d-flex gap-2 align-items-center position-relative">
                    <form class="flex-grow-1" id="searchForm" action="{{ route('admin.search.routing') }}">
                        @csrf
                        <div class="d-flex align-items-center global-search-container">
                            <input  autocomplete="off" class="form-control flex-grow-1 rounded-10 search-input" id="searchInput" maxlength="255" name="search" type="search" placeholder="{{ translate('Search_by_keyword') }}" aria-label="Search" autofocus>
                        </div>
                    </form>
                    <div class="position-absolute right-0 pr-2">
                        <button class="border-0 rounded px-2 py-1" type="button" data-dismiss="modal">{{ translate('Esc') }}</button>
                    </div>
                </div>
                <div class="min-h-350">
                    <div class="search-result" id="searchResults">
                        <div class="text-center text-muted py-5">{{translate('It appears that you have not yet searched.')}}.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div class="toggle-tour">
    <a href="https://youtube.com/playlist?list=PLLFMbDpKMZBxgtX3n3rKJvO5tlU8-ae2Y" target="_blank"
       class="d-flex align-items-center gap-10px">
        <img src="{{ asset('public/assets/admin/img/tutorial.svg') }}" alt="">
        <span>
            <span class="text-capitalize">{{ translate('Turotial') }}</span>
        </span>
    </a>
    <div class="d-flex align-items-center gap-10px restart-Tour">
        <img src="{{ asset('public/assets/admin/img/tour.svg') }}" alt="">
        <span>
            <span class="text-capitalize">{{ translate('Tour') }}</span>
        </span>
    </div>
</div> -->

<div class="toggle-tour">
    <button type="button" class="tour-guide_btn w-40px h-40px border-0 bg-white d-flex align-items-center justify-content-center ">
        <span class="w-32 h-32px  min-w-32 d-flex align-items-center justify-content-center  bg-primary rounded-8"><img src="{{ asset('public/assets/admin/img/solar_multiple-forward-right-line-duotone.svg') }}" alt=""></span>
    </button>
    <div class="d-flex flex-column">
        <!-- <div class="tour-guide-items text-capitalize fs-14 text-title">Guideline</div>                 -->
        <div class="tour-guide-items">
            <a href="https://youtube.com/playlist?list=PLLFMbDpKMZBxgtX3n3rKJvO5tlU8-ae2Y" target="_blank"
               class="d-flex align-items-center gap-10px">
                <span class="text-capitalize fs-14 text-title">{{ translate('Turotial') }}</span>
            </a>
        </div>
        <div class="tour-guide-items d-flex cursor-pointer align-items-center gap-10px restart-Tour">
            <span class="text-capitalize fs-14 text-title">{{ translate('Tour') }}</span>
        </div>
        <!-- <div class="tour-guide-items text-capitalize d-flex align-items-center gap-3 fs-14 text-title">
            Toggle RTL
            <label class="toggle-switch toggle-switch-sm" for="rtl_toggle">
                <input type="checkbox" class="toggle-switch-input" id="rtl_toggle">
                <span class="toggle-switch-label">
                    <span class="toggle-switch-indicator"></span>
                </span>
            </label>
        </div> -->
    </div>
</div>

