@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-slate-900">Historial de reservas</h1>
            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full">
                {{ count($bookings) }} Transacciones
            </span>
        </div>

        @if(session('success'))
        <div id="alert-success" class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm animate-fade-in-down">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-check-circle text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="document.getElementById('alert-success').style.display='none'" class="text-green-800 hover:text-green-900 font-bold">&times;</button>
        </div>
        @endif

        <div class="space-y-5">
            @forelse($bookings as $booking)
            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-lg transition duration-300 flex flex-col md:flex-row items-center gap-6 md:gap-8">

                <div class="w-full md:w-36 h-28 flex-shrink-0">
                    <img src="{{ $booking->imagen_url }}" class="w-full h-full object-cover rounded-xl border border-slate-100 shadow-sm">
                </div>

                <div class="flex-1 w-full text-center md:text-left">
                    <h3 class="text-xl font-bold text-slate-900 line-clamp-1 mb-1">{{ $booking->nombre_casa }}</h3>
                    <p class="text-slate-500 text-sm mb-3 font-mono bg-slate-50 inline-block px-2 py-1 rounded">
                        #INV-{{ $booking->id }} • {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}
                    </p>
                    <div class="flex items-center justify-center md:justify-start gap-4 text-base">
                        <span class="text-blue-600 font-bold text-lg">€ {{ number_format($booking->precio_total, 0, ',', '.') }}</span>
                        <span class="text-slate-300">|</span>
                        <span class="text-slate-600">{{ $booking->duracion }} Meses</span>
                    </div>
                </div>

                <div class="w-full md:w-auto flex flex-col md:flex-row items-center gap-4 border-t md:border-t-0 border-slate-100 pt-5 md:pt-0">

                    <div class="flex-shrink-0 w-full md:w-36">
                        @if($booking->estado == 'Pagado')
                            <span class="h-12 w-full flex items-center justify-center rounded-xl text-sm font-bold bg-green-100 text-green-700 border-2 border-green-200 box-border">
                                <i class="fa-solid fa-check mr-2"></i> Pagado
                            </span>
                        @else
                            <span class="h-12 w-full flex items-center justify-center rounded-xl text-sm font-bold bg-yellow-100 text-yellow-700 border-2 border-yellow-200 box-border">
                                <i class="fa-solid fa-clock mr-2"></i> En espera
                            </span>
                        @endif
                    </div>

                    <div class="hidden md:block w-px h-12 bg-slate-200 mx-1"></div>

                    <div class="flex items-center gap-3 w-full md:w-auto">

                        @if($booking->estado == 'Pendiente')
                            <a href="{{ route('bookings.payment', $booking->id) }}"
                               class="h-12 w-full md:w-48 flex items-center justify-center bg-slate-900 text-white rounded-xl text-sm font-bold border-2 border-transparent hover:bg-blue-700 hover:shadow-blue-500/30 transition shadow-lg whitespace-nowrap tracking-wide transform hover:-translate-y-0.5 box-border gap-2">
                                Pagar ahora
                            </a>
                        @else
                            <button class="h-12 w-full md:w-48 flex items-center justify-center border-2 border-slate-100 bg-slate-50 text-slate-400 rounded-xl text-sm font-bold cursor-default whitespace-nowrap box-border">
                                Ver factura
                            </button>
                        @endif

                        <button type="button" onclick="openDeleteModal('{{ $booking->id }}', '{{ $booking->nombre_casa }}')"
                                class="h-12 w-14 flex-shrink-0 flex items-center justify-center border-2 border-red-100 text-red-500 bg-white rounded-xl hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition shadow-sm transform hover:-translate-y-0.5 box-border"
                                title="Eliminar historial">
                            <i class="fa-solid fa-trash-can text-lg"></i>
                        </button>
                    </div>

                </div>

            </div>
            @empty
            <div class="text-center py-20 bg-white rounded-3xl border border-slate-100 shadow-sm">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-receipt text-3xl text-slate-300"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Sin historial</h3>
                <p class="text-slate-500 mb-8">¡Busca alojamientos ahora!</p>
                <a href="{{ route('home') }}" class="inline-block h-12 flex items-center justify-center bg-blue-600 text-white font-bold px-8 rounded-xl hover:bg-blue-700 transition shadow-lg transform hover:-translate-y-0.5">
                    Buscar alojamientos
                </a>
            </div>
            @endforelse
        </div>
    </div>
</div>

<div id="deleteModal" class="fixed inset-0 z-[999] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity opacity-0" id="modalBackdrop"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md scale-95 opacity-0" id="modalPanel">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fa-solid fa-triangle-exclamation text-red-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-lg font-bold leading-6 text-slate-900">¿Eliminar historial de reserva?</h3>
                            <div class="mt-2">
                                <p class="text-sm text-slate-500">
                                    Vas a eliminar el historial de reserva para <span id="modalKostName" class="font-bold text-slate-800">Nombre del alojamiento</span>.
                                    Los datos eliminados no se pueden recuperar.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                    <form id="deleteForm" action="" method="POST" class="w-full sm:w-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-red-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-red-500 sm:w-auto transition transform hover:-translate-y-0.5">
                            Sí, eliminar
                        </button>
                    </form>
                    <button type="button" onclick="closeDeleteModal()" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto transition">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('deleteModal');
    const backdrop = document.getElementById('modalBackdrop');
    const panel = document.getElementById('modalPanel');
    const deleteForm = document.getElementById('deleteForm');
    const kostNameSpan = document.getElementById('modalKostName');
    const baseUrl = "{{ url('/booking/delete') }}/";

    function openDeleteModal(id, kostName) {
        deleteForm.action = baseUrl + id;
        kostNameSpan.textContent = kostName;
        modal.classList.remove('hidden');
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            panel.classList.remove('scale-95', 'opacity-0');
            panel.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeDeleteModal() {
        backdrop.classList.add('opacity-0');
        panel.classList.remove('scale-100', 'opacity-100');
        panel.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
@endsection
