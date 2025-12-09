<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('libs/awesome/css/all.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">

  

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Admin</title>
</head>
<body>
    <main>
        <div class="admin_panel">
            <div class="admin_panel_cnt">
                <div class="admin_sidebar">
                    <div class="sidebar_header">
                        <div class="cms-logo">
                           <div class="logo-icon">
                               <i class="fas fa-cube"></i>
                           </div>
                         LUMIX
                        </div>
                    </div>
                    <div class="sidebar_group">
                        <div class="sidebar_menu">
                            <x-lists class="sidebar-menu active" class="active" name="{{ __('resource') }}">
                                <li>
                                    <x-link 
                                    href="{{ route('documents.index') }}" 
                                    active="{{ request()->is('admin/documents*') }}"
                                    class="text-blue-600">
                                        {{ __('bar_menu_doc') }}
                                        <i class="fa-solid fa-file-lines"></i>
                                    </x-link>
                                </li>
                                @if(auth()->user()->hasPermission('template', 'read'))
                                <li>
                                    <x-link 
                                    href="{{ route('templates.index') }}" 
                                    active="{{ request()->is('admin/templates*') }}"
                                    class="text-blue-600">
                                        {{ __('bar_menu_template') }}
                                        <i class="fa-solid fa-layer-group"></i>
                                    </x-link>
                                </li>
                               @endif
                                @if(auth()->user()->hasPermission('chunk', 'read'))
                                <li>
                                    <x-link 
                                    href="{{ route('chunks.index') }}" 
                                    active="{{ request()->is('admin/chunks*') }}"
                                    class="text-blue-600">
                                        {{ __('bar_menu_chunk') }}
                                        <i class="fa-solid fa-code"></i>
                                    </x-link>
                                </li>
                               @endif
                                @if(auth()->user()->hasPermission('tvs', 'read'))
                                <li>
                                    <x-link 
                                    href="{{ route('tvs.index') }}" 
                                    active="{{ request()->is('admin/tvs*') }}"
                                    class="text-blue-600">
                                        {{__('TV_fields')}}
                                        <i class="fa-solid fa-tv"></i>
                                    </x-link>
                                </li>
                               @endif
                                <li>
                                    <x-link 
                                    href="/register" 
                                    active="{{ request()->is('admin/register*') }}"
                                    class="text-blue-600">
                                        {{ __('bar_menu_snipet') }}
                                        <i class="fa-solid fa-file-code"></i>
                                    </x-link>
                                </li>
                                <li>
                                    <x-link 
                                    href="{{ route('media.index') }}" 
                                    active="{{ request()->is('admin/media*') }}"
                                    class="text-blue-600">
                                        {{ __('bar_menu_file') }}
                                        <i class="fa-solid fa-file"></i>
                                    </x-link>
                                </li>
                            </x-lists>
                            <x-lists class="sidebar-menu" name="{{ __('users') }}">
                                <li>
                                    <x-link 
                                    href="{{ route('users.index') }}" 
                                    active="{{ request()->is('admin/users*') }}"
                                    class="text-blue-600">
                                        {{ __('all_users') }}
                                        <i class="fa-solid fa-users-medical"></i>
                                    </x-link>
                                </li>
                                <li>
                                    <x-link 
                                    href="{{ route('roles.index') }}" 
                                    active="{{ request()->is('admin/roles*') }}"
                                    class="text-blue-600">
                                        Управление ролями
                                        <i class="fa-solid fa-lock"></i>
                                    </x-link>
                                </li>
                               
                            </x-lists>
                            <x-lists class="sidebar-menu" name="{{ __('system') }}">
                                <li>
                                    <x-link 
                                    href="{{ route('setings') }}" 
                                    active="{{ request()->is('admin/setings*') }}"
                                    class="text-blue-600">
                                        {{ __('setings') }}
                                        <i class="fa-solid fa-user-gear"></i>
                                    </x-link>
                                </li>
                            </x-lists>
                        </div>  
                        <div class="profile">
                            <div class="profile_cnt">
                                <div class="profile_cnt_group">
                                    <span class="user_avatar">
                                        <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar">
                                    </span>
                                    <div class="profile_cnt_txt">
                                        <span class="user_title">{{ __('user') }}</span>
                                        <span class="user_name">
                                            {{ Auth::user()->name }}
                                        </span>
                                    </div>
                                </div>
                                <a href="#">
                                    Посмотреть профиль
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="admin_content">
                    <x-header :title-header="$pageTitle" class="text-blue-600" :buttons="$buttons" />
                    @yield('content') 
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('libs/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/lang/summernote-ru-RU.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.15.0/ace.js"></script>


    <script type="module" src="{{ asset('js/main.js') }}"></script>
</body>
</html>