<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Главная')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/dracula.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/ambiance.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/material-darker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/base16-dark.min.css">
    <link rel="stylesheet" href="{{ asset('libs/awesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <main>
        <div class="admin_panel">
            <div class="admin_panel_cnt">
                <div class="admin_sidebar">
                    <div class="sidebar_header">
                        <div class="logo">
                            <i class="fas fa-cube"></i>
                            <div class="logo_text">
                                <h2>LUMIX</h2>
                                <p>Control Panel</p>
                            </div>
                        </div>
                        <button class="sidebar_toggle">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                    <div class="sidebar_nav_scroll">
                        <nav class="sidebar_nav">
                            <div class="nav_group">
                                <div class="nav_group_header">
                                    <i class="fas fa-home"></i>
                                    <span>Ресурсы</span>
                                    <i class="fas fa-chevron-down arrow"></i>
                                </div>
                                <div class="nav_group_content">
                                    <x-menu-bar-item 
                                    name="Документы" 
                                    icon="fa-solid fa-file" 
                                    route="{{ route('documents.index') }}"
                                    count="7"
                                    />
                                    <x-menu-bar-item 
                                    name="Шаблоны" 
                                    icon="fa-solid fa-layer-group" 
                                    route="{{ route('templates.index') }}"
                                    />
                                    <x-menu-bar-item 
                                    name="Чанки" 
                                    icon="fas fa-cubes" 
                                    route="{{ route('welcome') }}"
                                    />
                                    <x-menu-bar-item 
                                    name="Доп поля" 
                                    icon="fas fa-plus-circle" 
                                    route="{{ route('tv_forms.index') }}"
                                    />
                                    
                                </div>
                            </div>
                            
                            <!-- Content Group -->
                            <div class="nav_group">
                                <div class="nav_group_header">
                                    <i class="fas fa-file-alt"></i>
                                    <span>Пользователи</span>
                                    <i class="fas fa-chevron-down arrow"></i>
                                </div>
                                <div class="nav_group_content">
                                    <x-menu-bar-item 
                                    name="Все пользователи" 
                                    icon="fa-solid fa-users" 
                                    route="{{ route('welcome') }}"
                                    count="2"
                                    />
                                </div>
                            </div>
                            
                            <div class="nav_group">
                                <div class="nav_group_header">
                                    <i class="fas fa-users"></i>
                                    <span>Медиа</span>
                                    <i class="fas fa-chevron-down arrow"></i>
                                </div>
                                <div class="nav_group_content">
                                    <x-menu-bar-item 
                                    name="Фаилы" 
                                    icon="fa-solid fa-file" 
                                    route="{{ route('media.index') }}"
                                    />
                                    <a href="#" class="nav_item">
                                        <div class="nav_item_group">
                                            <i class="fas fa-user-plus"></i>
                                            <span>Add New User</span>
                                        </div>
                                    </a>
                                    <a href="#" class="nav_item">
                                        <div class="nav_item_group">
                                            <i class="fas fa-user-shield"></i>
                                            <span>Roles & Permissions</span>
                                        </div>
                                    </a>
                                    <a href="#" class="nav_item">
                                        <div class="nav_item_group">
                                            <i class="fas fa-user-lock"></i>
                                            <span>Banned Users</span>
                                        </div>
                                        <span class="badge danger">2</span>
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Settings Group -->
                            <div class="nav_group">
                                <div class="nav_group_header">
                                    <i class="fas fa-cog"></i>
                                    <span>Настройки</span>
                                    <i class="fas fa-chevron-down arrow"></i>
                                </div>
                                <div class="nav_group_content">
                                    <a href="#" class="nav_item">
                                        <div class="nav_item_group">
                                            <i class="fas fa-sliders-h"></i>
                                            <span>General Settings</span>
                                        </div>
                                    </a>
                                    <a href="#" class="nav_item">
                                        <div class="nav_item_group">
                                            <i class="fas fa-paint-brush"></i>
                                            <span>Appearance</span>
                                        </div>
                                    </a>
                                    <a href="#" class="nav_item">
                                        <div class="nav_item_group">
                                            <i class="fas fa-plug"></i>
                                            <span>Plugins</span>
                                        </div>
                                        <span class="badge">12</span>
                                    </a>
                                    <a href="#" class="nav_item">
                                        <div class="nav_item_group">
                                            <i class="fas fa-server"></i>
                                            <span>System Info</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            
                            <!-- More Groups for Scroll -->
                            <div class="nav_group">
                                <div class="nav_group_header">
                                    <i class="fas fa-chart-bar"></i>
                                    <span>Statistics</span>
                                    <i class="fas fa-chevron-down arrow"></i>
                                </div>
                                <div class="nav_group_content">
                                    <a href="#" class="nav_item">
                                        <div class="nav_item_group">
                                            <i class="fas fa-chart-area"></i>
                                            <span>Site Traffic</span>
                                        </div>
                                    </a>
                                    <a href="#" class="nav_item">
                                        <div class="nav_item_group">
                                            <i class="fas fa-chart-line"></i>
                                            <span>User Growth</span>
                                        </div>
                                    </a>
                                    <a href="#" class="nav_item">
                                        <div class="nav_item_group">
                                            <i class="fas fa-chart-pie"></i>
                                            <span>Revenue</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Another Group -->
                            <div class="nav_group">
                                <div class="nav_group_header">
                                    <i class="fas fa-bell"></i>
                                    <span>Notifications</span>
                                    <i class="fas fa-chevron-down arrow"></i>
                                </div>
                                <div class="nav_group_content">
                                    <a href="#" class="nav_item">
                                        <div class="nav_item_group">
                                            <i class="fas fa-envelope"></i>
                                            <span>Email Notifications</span>
                                        </div>
                                    </a>
                                    <a href="#" class="nav_item">
                                        <div class="nav_item_group">
                                            <i class="fas fa-bell"></i>
                                            <span>Push Notifications</span>
                                        </div>
                                    </a>
                                    <a href="#" class="nav_item">
                                        <div class="nav_item_group">
                                            <i class="fas fa-history"></i>
                                            <span>Notification Log</span>
                                        </div>
                                        <span class="badge">156</span>
                                    </a>
                                </div>
                            </div>
                        </nav>
                    </div>
                    
                    <!-- Footer (примерно 100px) -->
                    <div class="sidebar_footer">
                        <form action="{{ route('logout') }}" method="POST" class="logout-form">
                            @csrf
                            <x-btn type="submit" id="btn-out-admin" text="Выйти" icon="fas fa-sign-out-alt" />
                        </form>
                        <div class="version">v2.5.1</div>
                    </div>
                </div>
                <div class="admin_content">
                    <div class="content_header">
                        <div class="header_left">
                            <h1>@yield('title', 'Главная')</h1>
                            <div class="breadcrumb">
                                <a href="#">Home</a> / <span>Dashboard</span>
                            </div>
                        </div>
                        <div class="header_content_menu">
                            @yield('content_menu')
                            <div class="profile_item">
                                <div class="profile_img">
                                    <a href="#"></a>
                                    <img src="/{{ auth()->user()->avatar }}" alt="">
                                </div>
                                <span class="profile_name">{{ auth()->user()->name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="content_body">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <script>
        window.BASE_ICONS = "{{ asset('images/format') }}/";
        document.querySelectorAll('.nav_group_header').forEach(header => {
            header.addEventListener('click', function() {
                const group = this.parentElement;
                const content = this.nextElementSibling;
                const arrow = this.querySelector('.arrow');
                if (group.classList.contains('open')) {
                    group.classList.remove('open');
                    content.style.maxHeight = '0';
                    arrow.style.transform = 'rotate(0deg)';
                } else {
                    // Close other groups
                    document.querySelectorAll('.nav_group.open').forEach(openGroup => {
                        if (openGroup !== group) {
                            openGroup.classList.remove('open');
                            openGroup.querySelector('.nav_group_content').style.maxHeight = '0';
                            openGroup.querySelector('.arrow').style.transform = 'rotate(0deg)';
                        }
                    });
                    
                    // Open current group
                    group.classList.add('open');
                    content.style.maxHeight = content.scrollHeight + 'px';
                    arrow.style.transform = 'rotate(180deg)';
                }
            });
        });
        
        // Set active menu item
        document.querySelectorAll('.nav_item').forEach(item => {
            item.addEventListener('click', function(e) {
                
                document.querySelectorAll('.nav_item').forEach(i => {
                    i.classList.remove('active');
                });
                this.classList.add('active');
            });
        });
        
        // Open first accordion by default
        document.addEventListener('DOMContentLoaded', function() {
            const firstGroup = document.querySelector('.nav_group');
            if (firstGroup) {
                firstGroup.classList.add('open');
                const content = firstGroup.querySelector('.nav_group_content');
                content.style.maxHeight = content.scrollHeight + 'px';
                firstGroup.querySelector('.arrow').style.transform = 'rotate(180deg)';
            }
        });
        
        // Mobile sidebar toggle
        document.querySelector('.sidebar_toggle').addEventListener('click', function() {
            document.querySelector('.admin_sidebar').classList.toggle('collapsed');
        });
    </script>
    <script src="{{ asset('libs/jquery/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('libs/slick/slick.min.js') }}"></script>
    <script src="{{ asset('libs/animate/gsap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/css/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/htmlmixed/htmlmixed.min.js"></script>
    <script src="{{ asset('libs/Sortable-master/Sortable.min.js') }}"></script>
    <script type="module" src="{{ asset('js/admin.js') }}"></script>
</body>
</html>