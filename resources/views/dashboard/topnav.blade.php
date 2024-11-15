<nav class="topnav">
    <div class="topnav-left">
        <a href="{{ route('home') }}">KESA WEBSITE</a>
    </div>
    <div class="topnav-right">
        @guest
        <a href="{{ route('register') }}">Register</a>
        <a href="{{ route('login') }}">Login</a>
        @endguest
        @auth
        <!-- Logout Form -->
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        @endauth
    </div>
</nav>
<style>
/* Basic Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Sidebar Styles */
.sidebar {
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    background-color: #333;
    color: #fff;
    padding-top: 20px;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar li {
    margin: 10px 0;
}

.sidebar a {
    color: #fff;
    text-decoration: none;
    padding: 10px;
    display: block;
}

.sidebar a:hover {
    background-color: #444;
}

/* Top Nav Styles */
.topnav {
    background-color: #333;
    color: #fff;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.topnav-left a,
.topnav-right a {
    color: #fff;
    text-decoration: none;
    font-size: 16px;
    padding: 10px;
}

.topnav-left a:hover,
.topnav-right a:hover {
    background-color: #444;
}

/* Content Area */
.content {
    margin-left: 250px;
    padding: 20px;
}

/* Media Queries for responsiveness */
@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
    }

    .content {
        margin-left: 0;
    }
}
</style>