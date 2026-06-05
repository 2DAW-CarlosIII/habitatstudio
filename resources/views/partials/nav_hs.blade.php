
    <nav class="fixed top-0 w-full z-50 glass-nav h-20 flex items-center transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="flex justify-between items-center h-full">

                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-white font-bold text-xl shadow-lg transition-all duration-300 ease-out group-hover:scale-110 group-hover:rotate-12">
                        <span class="transition-transform duration-300 group-hover:-rotate-12">HS</span>
                    </div>
                    <span class="font-bold text-2xl tracking-tight text-slate-800">Habitat<span class="text-blue-600">Studio</span></span>
                </a>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}#inicio" class="text-gray-600 hover:text-blue-600 font-medium transition text-sm">Inicio</a>
                    <a href="{{ route('home') }}#recomendaciones" class="text-gray-600 hover:text-blue-600 font-medium transition text-sm">Recomendaciones</a>
                    <a href="{{ route('home') }}#ventajas" class="text-gray-600 hover:text-blue-600 font-medium transition text-sm">Ventajas</a>
                    <a href="{{ route('home') }}#testimonios" class="text-gray-600 hover:text-blue-600 font-medium transition text-sm">Testimonios</a>
                </div>

                <div class="hidden md:flex items-center gap-4">
                    <a href="{{ route('bookings.history') }}" class="text-gray-600 hover:text-blue-600 font-medium text-sm"><i class="fa-solid fa-clock-rotate-left mr-1"></i> Historial</a>
                    @include('partials.auth')
                </div>

                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-slate-800 focus:outline-none p-2 transition-transform duration-300"><i id="menu-icon" class="fa-solid fa-bars text-2xl"></i></button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="absolute top-20 left-0 w-full bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-xl md:hidden overflow-hidden transition-all duration-500 ease-in-out max-h-0 opacity-0">
            <div class="flex flex-col p-6 space-y-6 text-center">
                <a href="{{ route('home') }}#inicio" class="block text-gray-600 hover:text-blue-600 font-medium text-lg mobile-link">Inicio</a>
                <a href="{{ route('home') }}#recomendaciones" class="block text-gray-600 hover:text-blue-600 font-medium text-lg mobile-link">Recomendaciones</a>
                <a href="{{ route('home') }}#ventajas" class="block text-gray-600 hover:text-blue-600 font-medium text-lg mobile-link">Ventajas</a>
                <a href="{{ route('home') }}#testimonios" class="block text-gray-600 hover:text-blue-600 font-medium text-lg mobile-link">Testimonios</a>
                <a href="{{ route('bookings.history') }}" class="block text-gray-600 hover:text-blue-600 font-medium text-lg mobile-link">Historial de reservas</a>
                <a href="#" class="block w-full bg-slate-900 text-white font-bold py-3.5 rounded-xl hover:bg-blue-700 transition shadow-lg mobile-link">Iniciar sesión</a>
            </div>
        </div>
    </nav>
