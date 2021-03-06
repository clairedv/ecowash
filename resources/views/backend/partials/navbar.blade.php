<nav class="top-0 fixed bg-yellow-bright shadow-small admin-font-family flex flex-wrap items-center md:flex-row md:justify-start flex-no-wrap py-2 px-4 w-full z-10">

        @auth
            @if ($withAdminSidebar ?? true)
                <button v-on:click="$emit('openSidebar')">
                    <span class="outline-none">
                        @hamburger
                    </span>
                </button>
            @endif
        @endauth
    <div class="container flex flex-col md:flex-row justify-between no-wrap">
        <a class="text-grey-900 inline-block text-lg" href="{{ url('/admin') }}">
            {{ config('app.name', 'Ecowash') . ' admin' }}
        </a>
        <div class="md:flex collapse mt-2fl" id="navBarToggleable">
            <!-- Right Side Of Navbar -->
            <ul class="md:flex text-grey-400 navbar-nav ml-auto text-base mb-0">
                <!-- Authentication Links -->
                @auth
                    @authenticationLinks
                @endauth
            </ul>
        </div>
    </div>
</nav>
<sidebar-admin>
</sidebar-admin>
