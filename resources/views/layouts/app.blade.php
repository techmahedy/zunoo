<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Zuno')</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    </head>

    <body>

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <!-- Left Side - Zuno Logo -->
                <a class="navbar-brand" href="{{ route('home') }}">Zuno</a>

                <!-- Right Side -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @if (!isAuthenticated())
                            <li class="nav-item">
                                <a class="nav-link text-white me-3" href="{{ route('login') }}">Sign In</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('register') }}">Register</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link text-white me-3" href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <!-- Profile Dropdown (Assuming User is Logged In) -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Mahedi
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item"
                                            href="{{ route('profile', \Zuno\Auth\Security\Auth::user()->username) }}">Profile</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page Content - Centered 8-Column Layout -->
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="text-center mt-4">
            <p>&copy; {{ date('Y') }} All rights reserved.</p>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>

</html>
