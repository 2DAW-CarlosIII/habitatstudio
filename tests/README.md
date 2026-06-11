# Tests de evaluación — HabitatStudio

## Ejecución

```bash
# Todos los tests + resumen de puntuación al final
php artisan test

# Solo un bloque
php artisan test --testsuite="RA5 - Bloque A"
php artisan test --testsuite="RA6 - Bloque B"
php artisan test --testsuite="RA7 - Bloque C"

# Solo tests unitarios (sin BD, rápidos)
php artisan test --testsuite="Unit"

# Con detalle de cada test
php artisan test --verbose
```

## Salida esperada al finalizar

```
╔══════════════════════════════════════════════════════════════╗
║  PUNTUACIÓN POR RESULTADO DE APRENDIZAJE                     ║
╠══════════════════════════════════════════════════════════════╣
║  RA5:  6/10 ptos.  →  Nota: 6/10                            ║
║      [✓] A1: 1/1 ptos.                                      ║
║      [✓] A2: 1/1 ptos.                                      ║
║      [✓] A3: 1/1 ptos.                                      ║
║      [✓] A4: 1/1 ptos.                                      ║
║      [~] A5: 1.5/2 ptos.                                    ║
║      [✗] A6: 0/2 ptos.                                      ║
║      [✗] A7: 0/2 ptos.                                      ║
╠══════════════════════════════════════════════════════════════╣
║  RA6:  8/10 ptos.  →  Nota: 8/10                            ║
║      [✓] B1: 1/1 ptos.                                      ║
║      ...                                                    ║
╚══════════════════════════════════════════════════════════════╝
```

Leyenda: `✓` todos los tests del ejercicio pasan · `~` parcialmente · `✗` ninguno pasa.

## Notas

- La BD se reinicia automáticamente antes de cada clase (`RefreshDatabase`).
- **C5** (OpenAPI/Swagger) no tiene tests automáticos; se evalúa manualmente.
