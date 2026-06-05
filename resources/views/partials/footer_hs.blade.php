    <footer class="bg-slate-900 text-white pt-16 pb-8 border-t border-slate-800 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-8 mb-12">
            <div class="lg:col-span-4">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold">HS</div><span class="font-bold text-xl">HabitatStudio</span>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed mb-6 pr-4">Compañero fiel del estudiante. Buscar alojamiento cómodo, seguro y asequible tan fácil como navegar.</p>
                <div class="flex space-x-3">
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 transition text-white border border-slate-700 hover:border-blue-600"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-500 transition text-white border border-slate-700 hover:border-blue-500"><i class="fa-brands fa-twitter"></i></a>
                    <a href="https://github.com/AdhityaDaffaR/SobatKos-CariKosNyaman-Website" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-700 transition text-white border border-slate-700 hover:border-blue-700"><i class="fa-brands fa-github"></i></a>
                </div>
            </div>
            <div class="lg:col-span-2">
                <h4 class="text-lg font-bold mb-4 text-white">Navegación</h4>
                <ul class="space-y-2 text-slate-400 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-blue-400 transition">Inicio</a></li>
                    <li><a href="{{ route('casas.index') }}" class="hover:text-blue-400 transition">Buscar alojamientos</a></li>
                    <li><a href="{{ route('home') }}#ventajas" class="hover:text-blue-400 transition">Ventajas</a></li>
                    <li><a href="{{ route('home') }}#testimonios" class="hover:text-blue-400 transition">Testimonios</a></li>
                </ul>
            </div>
            <div class="lg:col-span-3">
                <h4 class="text-lg font-bold mb-4 text-white">Contáctanos</h4>
                <ul class="space-y-3 text-slate-400 text-sm">
                    <li class="flex items-center gap-3"><i class="fa-brands fa-whatsapp w-5 text-green-500"></i> +34 123456789</li>
                    <li class="flex items-center gap-3"><i class="fa-regular fa-envelope w-5 text-blue-400"></i> help@habitatstudio.test</li>
                    <li class="flex items-center gap-3"><i class="fa-solid fa-location-dot w-5 text-red-500"></i> Cartagena, Murcia</li>
                </ul>
            </div>
            <div class="lg:col-span-3">
                <h4 class="text-lg font-bold mb-4 text-white">Novedades de alojamientos</h4>
                <p class="text-slate-400 text-sm mb-4">¿Quieres recibir ofertas y descuentos de alojamiento? Déjananos tu correo.</p>
                <form action="#" class="space-y-2">
                    <input type="email" placeholder="Tu correo..." class="w-full bg-slate-800 border border-slate-700 text-white px-4 py-3 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm placeholder-slate-500">
                    <button type="button" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-900/20 text-sm">Suscribirse</button>
                </form>
            </div>
        </div>
        <div class="border-t border-slate-800 pt-8 text-center text-slate-500 text-xs">© {{ date('Y') }} SobatKos. Todos los derechos reservados.</div>
    </div>
</footer>
