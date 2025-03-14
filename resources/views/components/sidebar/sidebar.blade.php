<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sidebar-blade.css') }}">
</head>

<body>
    <!-- Sidebar Toggle Icon for small screens -->
    <div id="menu-toggle">
        <i class="fas fa-bars"></i>
    </div>

    <div id="nav-bar">
        <a id="nav-title" href="#">
            <i class="fas fa-cog"></i> Dashboard
        </a>

        <nav id="nav-content">
            @auth
            @php
            $dep_id = Auth::user()->dep_id;
            @endphp

            @if($dep_id == 1)
            <a class="nav-button" href="{{ route('student.dashboard') }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
            @elseif(in_array($dep_id, [3,4, 5, 6, 7, 8, 9, 10, 11, 15, 14, 13, 16 , 17 , 18, 19, 20, 21, 22, 23, 24,
            25,]))
            <a class="nav-button" href="{{ route('Clearance.list', ['departmentId' => auth()->user()->dep_id]) }}">
                <i class="fas fa-cogs"></i> Clearance
            </a>

            <a class="nav-button" href="{{ route('staff.store') }}">
                <i class="fas fa-user-plus"></i> Add Staff
            </a>

            @endif

            <a class="nav-button" href="#"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Log Out
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @endauth
        </nav>
    </div>

    <main id="main-content">
        @yield('content')
    </main>

    <script>
    // JavaScript for button activation and responsive sidebar
    document.addEventListener('DOMContentLoaded', function() {
        // Activate button on click
        document.querySelectorAll('.nav-button').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.nav-button').forEach(btn => btn.classList.remove(
                    'active'));
                this.classList.add('active');
            });
        });

        // Responsive sidebar for smaller screens
        const body = document.body;
        const menuToggle = document.querySelector('#menu-toggle');

        menuToggle.addEventListener('click', () => {
            body.classList.toggle('sidebar-active');
        });
    });
    </script>
</body>

</html>