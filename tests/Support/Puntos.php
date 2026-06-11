<?php

namespace Tests\Support;

/**
 * Atributo PHP 8.1 para anotar la puntuación y el RA de cada test.
 *
 * Uso:
 *   #[Puntos(2, 'RA6', 'B3')]
 *   public function test_algo(): void { ... }
 */
#[\Attribute(\Attribute::TARGET_METHOD)]
class Puntos
{
    public function __construct(
        public readonly float  $valor,
        public readonly string $ra,
        public readonly string $ejercicio,
    ) {}
}
