<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="{{route('dashboard')}}">
            <div class="logo-img">
               <img height="30" src="{{ asset('img/logo_white.svg')}}" class="header-brand-img" title="Terakret"> 
            </div>
        </a>
        <div class="sidebar-action"><i class="ik ik-arrow-left-circle"></i></div>
        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
    </div>

    @php
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
    @endphp
    
    <div class="sidebar-content">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main">
                <div class="nav-item {{ ($segment1 == 'dashboard') ? 'active' : '' }}">
                    <a href="{{route('dashboard')}}"><i class="ik ik-bar-chart-2"></i><span>{{ __('Dashboard')}}</span></a>
                </div>

                <div class="nav-item {{ ($segment1 == 'users' || $segment1 == 'roles'||$segment1 == 'permission' ||$segment1 == 'user') ? 'active open' : '' }} has-sub d-none">
                    <a href="#"><i class="ik ik-user"></i><span>{{ __('Adminstrator')}}</span></a>
                    <div class="submenu-content">
                        <!-- only those have manage_user permission will get access -->
                        @can('manage_user')
                        <a href="{{url('users')}}" class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">{{ __('Users')}}</a>
                        <a href="{{url('user/create')}}" class="menu-item {{ ($segment1 == 'user' && $segment2 == 'create') ? 'active' : '' }}">{{ __('Add User')}}</a>
                         @endcan
                         <!-- only those have manage_role permission will get access -->
                        @can('manage_roles')
                        <a href="{{url('roles')}}" class="menu-item {{ ($segment1 == 'roles') ? 'active' : '' }}">{{ __('Roles')}}</a>
                        @endcan
                        <!-- only those have manage_permission permission will get access -->
                        @can('manage_permission')
                        <a href="{{url('permission')}}" class="menu-item {{ ($segment1 == 'permission') ? 'active' : '' }}">{{ __('Permission')}}</a>
                        @endcan
                    </div>
                </div>

                <!-- Customer Manager -->
                <div class="nav-item {{ ($segment1 == 'customer') ? 'active open' : '' }} has-sub">
                    <a href="{{url('customer')}}"><i class="ik ik-users"></i><span>{{ __('Customers')}}</span></a>
                    <div class="submenu-content">
                        <!-- only those have manage_user permission will get access -->
                        @can('manage_user')
                        <a href="{{url('customer')}}" class="menu-item {{ ($segment1 == 'customer') ? 'active' : '' }}">{{ __('Customer')}}</a>
                        <a href="{{url('customer/create')}}" class="menu-item {{ ($segment1 == 'customer' && $segment2 == 'create') ? 'active' : '' }}">{{ __('Add Customer')}}</a>
                         @endcan
                    </div>
                </div>
                
                  <!-- User Withdrawal Manager -->
                  <div class="nav-item {{ ($segment1 == 'withdrawal') ? 'active open' : '' }}">
                    <a href="{{url('withdrawal')}}"><i class="fas fa-wallet"></i><span>{{ __('Withdrawal')}}</span></a>
                </div>
                
                  <!-- User wallets Manager -->
                  <div class="nav-item {{ ($segment1 == 'wallets') ? 'active open' : '' }}">
                    <a href="{{url('wallets')}}"><i class="fas fa-wallet"></i><span>{{ __('wallets')}}</span></a>
                </div>

                <!-- Coupon Manager -->
                 <div class="nav-item {{ ($segment1 == 'coupon') ? 'active open' : '' }} has-sub">
                    <a href="{{url('coupon')}}"><i class="fas fa-tags"></i><span>{{ __('Coupons')}}</span></a>
                    <div class="submenu-content">
                        <!-- only those have manage_user permission will get access -->
                        @can('manage_user')
                        <a href="{{url('coupon')}}" class="menu-item {{ ($segment1 == 'coupon') ? 'active' : '' }}">{{ __('Coupon')}}</a>
                        <a href="{{url('coupon/create')}}" class="menu-item {{ ($segment1 == 'coupon' && $segment2 == 'create') ? 'active' : '' }}">{{ __('Add Coupon')}}</a>
                         @endcan
                    </div>
                </div>

                <!-- User Coupon -->
                 <div class="nav-item {{ ($segment1 == 'user_coupon') ? 'active open' : '' }} has-sub">
                    <a href="{{url('user_coupon')}}"><i class="fa fa-money-bill-alt"></i><span>{{ __('User Coupons')}}</span></a>
                    <div class="submenu-content">
                        <!-- only those have manage_user permission will get access -->
                        @can('manage_user')
                        <a href="{{url('user_coupon')}}" class="menu-item {{ ($segment1 == 'user_coupon') ? 'active' : '' }}">{{ __('User Coupons')}}</a>
                         @endcan
                    </div>
                </div>
                
                <!-- User Bank -->
                <div class="nav-item {{ ($segment1 == 'user_bank') ? 'active' : '' }}">
                    <!-- only those have manage_user permission will get access -->
                    @can('manage_user')
                    <a href="{{url('user_bank')}}"><i class="ik ik-credit-card"></i><span>{{ __('User Bank')}}</span></a>
                    @endcan
                </div>
                 

                <!-- Banner Manager -->
                 <div class="nav-item {{ ($segment1 == 'banners') ? 'active open' : '' }} has-sub">
                    <a href="{{url('banners')}}"><i class="ik ik-layers"></i><span>{{ __('Banners')}}</span></a>
                    <div class="submenu-content">
                        <!-- only those have manage_user permission will get access -->
                        @can('manage_user')
                        <a href="{{url('banners')}}" class="menu-item {{ ($segment1 == 'banners') ? 'active' : '' }}">{{ __('Banner')}}</a>
                        <a href="{{url('banners/create')}}" class="menu-item {{ ($segment1 == 'banners' && $segment2 == 'create') ? 'active' : '' }}">{{ __('Add Banner')}}</a>
                         @endcan
                    </div>
                </div>

                <!-- Product Manager -->
                 <div class="nav-item {{ ($segment1 == 'product') ? 'active open' : '' }} has-sub">
                    <a href="{{url('product')}}"><i class="ik ik-shopping-bag"></i><span>{{ __('Products')}}</span></a>
                    <div class="submenu-content">
                        <!-- only those have manage_user permission will get access -->
                        @can('manage_user')
                        <a href="{{url('product')}}" class="menu-item {{ ($segment1 == 'product') ? 'active' : '' }}">{{ __('Products')}}</a>
                        <a href="{{url('product/create')}}" class="menu-item {{ ($segment1 == 'product' && $segment2 == 'create') ? 'active' : '' }}">{{ __('Add Product')}}</a>
                         @endcan
                    </div>
                </div>

                <!-- Contact Manager -->
                 <div class="nav-item {{ ($segment1 == 'contact_us') ? 'active open' : '' }}">
                    <a href="{{url('contact_us')}}"><i class="ik ik-mail"></i><span>{{ __('Contact Us')}}</span></a>
                </div>

                 <!-- App Manager -->
                 <div class="nav-item {{ ($segment1 == 'app_settings') ? 'active open' : '' }}">
                    <a href="{{url('app_settings')}}"><i class="fas fa-cog"></i><span>{{ __('App Settings')}}</span></a>
                </div>

            </nav>
        </div>
    </div>
</div>