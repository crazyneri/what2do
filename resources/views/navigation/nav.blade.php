<nav>
    <div class="nav-container">
    @if(Auth::check() !== true)   
        <ul class="nav-container-list">
            <li><a href="/search">Home</a></li>
            <li><a href="">Register</a></li>
            <li><a href="/login">Login</a>
        </ul>
    @elseif(Auth::user())
    <p>Logged in as {{\Auth::user()->name}}</p>
        <ul class="nav-container-list nav-container-list__logOut">
            <li><a href="/search">Home</a></li>
            <li><a href="/user/{{Auth::id()}}">My profile</a></li>
            <form action="{{ route('logout') }}" method="post">
        @csrf
    
       <li><button class="btn__log-out">Logout</button></li>
    </form>
        </ul>
    @endif
    </div>
</nav>