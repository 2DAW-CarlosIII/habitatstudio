@extends('layouts.habitatstudio')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                <div class="lg:sticky lg:top-24 h-fit">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Nuevo testimonio</h2>




                    <div class="bg-white rounded-3xl shadow-lg overflow-hidden border border-gray-100">
                        @if (isset($casa))
                            <img src="{{ $casa->imagen_url }}" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $casa->nombre_casa }}</h3>
                                <p class="text-gray-500 mb-4"><i
                                        class="fas fa-map-marker-alt text-red-500 mr-2"></i>{{ $casa->ubicacion }}</p>
                                <div class="border-t border-dashed border-gray-200 my-4"></div>
                                <p class="text-gray-600 text-sm">Deja tu opinión y valoración sobre esta casa. Los
                                    testimonios serán revisados antes de publicarse.</p>
                            </div>
                        @else
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Comparte tu experiencia</h3>
                                <p class="text-gray-600 text-sm">Selecciona la casa a la que corresponde tu testimonio en el
                                    formulario.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div>
                    <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100 relative">
                        <form action="" method="POST">

                            @csrf


                            @foreach ($casas as $casa)
                                @if (isset($casa))
                                    <input type="hidden" name="casa_id" value="{{ $casa->id }}">
                                @else
                                    <div class="mb-5">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Casa</label>
                                        <select name="casa_id" required
                                            class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50">
                                            <option value="">Selecciona una casa</option>
                                            <option value="">Comentario general sobre la plataforma</option>
                                            @foreach ($casas ?? [] as $c)
                                                <option value="{{ $c->id }}"
                                                    {{ old('casa_id') == $c->id ? 'selected' : '' }}>{{ $c->nombre_casa }} —
                                                    {{ $c->ubicacion }}</option>
                                            @endforeach
                                        </select>
                                        @error('casa_id')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endif
                            @endforeach


                            <div class="mb-6">
                                <h3 class="text-xl font-bold text-gray-900">Tu testimonio</h3>
                                <p class="text-sm text-gray-400">Sé honesto y concreto. El testimonio se revisará antes de
                                    publicarse.</p>
                            </div>

                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Contenido</label>
                                    <textarea name="contenido" required rows="6"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-gray-50">{{ old('contenido') }}</textarea>
                                    @error('contenido')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Valoración (1-5)</label>
                                    <input type="number" name="valoracion" required min="1" max="5"
                                        value="{{ old('valoracion', 5) }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-gray-50">
                                    @error('valoracion')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-8 pt-6 border-t border-gray-100">
                                <div class="flex gap-4">

                                    <a href="{{ url()->previous() }}"
                                        class="flex-1 h-12 rounded-xl border-2 border-red-100 text-red-500 bg-white font-bold text-sm hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition shadow-sm transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-xmark"></i> Cancelar
                                    </a>

                                    <button type="submit"
                                        class="flex-1 h-12 rounded-xl bg-slate-900 text-white font-bold text-sm border-2 border-transparent hover:bg-blue-700 hover:shadow-blue-500/30 transition shadow-lg transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                        Publicar testimonio <i class="fa-solid fa-arrow-right"></i>
                                    </button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
