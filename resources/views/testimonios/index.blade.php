
        <ul>
            @foreach ($testimonios as $testimonio)

                    <strong>{{ $proyecto->nombre }}</strong>
                   <li> Testimonio :  ({{ $testimonio->testimonio }})</li>
                   <li> Testimonio valoracion:  ({{ $testimonio->valoracion }})</li>
                   <li> Testimonio : fecha_aprobacion ({{ if $(testimonio->fecha_aprobacion !== null){
                    'Estado:  Aprobado';
                   } else {
                    'Estado: Pendiente';
                   }   }})</li>

                    <ul>
                        <li><a href="{{ route('proyectos.show', $proyecto) }}">Ver</a></li>
                        <li><a href="{{ route('proyectos.edit', $proyecto) }}">Editar</a></li>
                        <li>
                            <form action="{{ route('proyectos.destroy', $proyecto) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Borrar</button>
                            </form>
                        </li>
                    </ul>

            @endforeach
        </ul>

{{--             $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('casa_id')->nullable()->constrained('casas')->cascadeOnDelete();
            $table->text('testimonio');
            $table->decimal('valoracion',3,1);
            $table->date('fecha_aprobacion')->nullable()->default(null);
            $table->timestamps();
        }); --}}

{{-- ncluir en cada tarjeta el estado:  Aprobado  o
Pendiente . --}}
