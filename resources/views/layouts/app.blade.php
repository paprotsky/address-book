<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Address Book') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app" v-cloak>
        <el-container>
            <el-header>
                <span class="brand">Address Book</span>
                @guest
                    <span class="nav-link"><a href="{{ route('login') }}">Login</a></span>
                    <span class="nav-link"><a href="{{ route('register') }}">Register</a></span>
                @else
                    <el-dropdown trigger="click">
                        <span class="el-dropdown-link">
                            <svg width="32" height="32" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M896 0q182 0 348 71t286 191 191 286 71 348q0 181-70.5 347t-190.5 286-286 191.5-349 71.5-349-71-285.5-191.5-190.5-286-71-347.5 71-348 191-286 286-191 348-71zm619 1351q149-205 149-455 0-156-61-298t-164-245-245-164-298-61-298 61-245 164-164 245-61 298q0 250 149 455 66-327 306-327 131 128 313 128t313-128q240 0 306 327zm-235-647q0-159-112.5-271.5t-271.5-112.5-271.5 112.5-112.5 271.5 112.5 271.5 271.5 112.5 271.5-112.5 112.5-271.5z" fill="#fff"/></svg>
                            <span class="user-name">{{ Auth::user()->name }}</span>
                        </span>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
            </el-header>

            @yield('content')
        </el-container>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
