<nav x-data="{ open: false }" class="bg-gradient-to-r from-indigo-600 to-purple-600 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 text-white">

            <!-- Logo -->
            <div class="flex items-center gap-10">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold tracking-wide">
                    MyShop
                </a>

                <!-- Nav Menu Desktop -->
                <div class="hidden sm:flex gap-6">
                    <a href="{{ route('dashboard') }}" class="hover:text-yellow-300">Dashboard</a>
                    <a href="{{ route('orders.index') }}" class="hover:text-yellow-300">Orders</a>
                    <a href="{{ route('cart.index') }}" class="hover:text-yellow-300">Cart</a>
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 px-4 py-2 rounded-full bg-white text-indigo-600 shadow hover:bg-gray-100 transition">
                            <span class="font-medium">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                        <x-dropdown-link :href="route('orders.index')">Orders</x-dropdown-link>
                        <x-dropdown-link :href="route('cart.index')">Cart</x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Logout
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open">
                    <svg class="h-6 w-6" stroke="white" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'block': !open }" stroke-linecap="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{ 'hidden': !open, 'block': open }" stroke-linecap="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" class="sm:hidden bg-white text-gray-700 px-6 py-4 space-y-3">
        <a href="{{ route('dashboard') }}" class="block">Dashboard</a>
        <a href="{{ route('orders.index') }}" class="block">Orders</a>
        <a href="{{ route('cart.index') }}" class="block">Cart</a>
        <a href="{{ route('profile.edit') }}" class="block">Profile</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-red-500">Logout</button>
        </form>
    </div>
</nav>
