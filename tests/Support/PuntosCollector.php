<?php

namespace Tests\Support;

/**
 * Singleton que acumula puntos durante la ejecución de los tests.
 * Lo usan PuntosExtension (hook AfterLastTestHook) y el trait HasPuntos.
 */
class PuntosCollector
{
    private static ?self $instance = null;

    /** @var array<string, array{obtenidos:float, total:float, ejercicios:array<string,array{obtenidos:float,total:float}>}> */
    private array $ra = [];

    /** @var array<string, bool>  clave única por test+RA+ejercicio para evitar doble conteo */
    private array $contado = [];

    private function __construct() {}

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Registra el resultado de un test.
     *
     * @param string  $testClass  Nombre de la clase del test
     * @param string  $testMethod Nombre del método
     * @param bool    $paso       true = pasó, false = falló
     */
    public function registrar(string $testClass, string $testMethod, bool $paso): void
    {
        try {
            $ref   = new \ReflectionMethod($testClass, $testMethod);
            $attrs = $ref->getAttributes(Puntos::class);
        } catch (\ReflectionException) {
            return;
        }

        foreach ($attrs as $attr) {
            /** @var Puntos $p */
            $p  = $attr->newInstance();
            $ra = $p->ra;
            $ej = $p->ejercicio;
            $v  = $p->valor;

            if (!isset($this->ra[$ra])) {
                $this->ra[$ra] = ['obtenidos' => 0.0, 'total' => 0.0, 'ejercicios' => []];
            }
            if (!isset($this->ra[$ra]['ejercicios'][$ej])) {
                $this->ra[$ra]['ejercicios'][$ej] = ['obtenidos' => 0.0, 'total' => 0.0];
            }

            // Acumular total solo una vez por test
            $totalKey = "{$testClass}::{$testMethod}::{$ra}::{$ej}::total";
            if (!isset($this->contado[$totalKey])) {
                $this->contado[$totalKey] = true;
                $this->ra[$ra]['total'] += $v;
                $this->ra[$ra]['ejercicios'][$ej]['total'] += $v;
            }

            // Acumular puntos obtenidos solo si pasó y solo una vez
            if ($paso) {
                $ptsKey = "{$testClass}::{$testMethod}::{$ra}::{$ej}::pts";
                if (!isset($this->contado[$ptsKey])) {
                    $this->contado[$ptsKey] = true;
                    $this->ra[$ra]['obtenidos'] += $v;
                    $this->ra[$ra]['ejercicios'][$ej]['obtenidos'] += $v;
                }
            }
        }
    }

    public function getRa(): array
    {
        return $this->ra;
    }

    public function imprimir(): void
    {
        $datos = $this->ra;
        if (empty($datos)) {
            return;
        }

        ksort($datos);

        $lineas = [];
        $ancho  = 62;

        $lineas[] = "╔" . str_repeat("═", $ancho) . "╗";
        $lineas[] = $this->fila("  PUNTUACIÓN POR RESULTADO DE APRENDIZAJE", $ancho);
        $lineas[] = "╠" . str_repeat("═", $ancho) . "╣";

        foreach ($datos as $ra => $d) {
            $obt   = round($d['obtenidos'], 2);
            $total = round($d['total'], 2);
            $nota  = $total > 0 ? round(($obt / $total) * 10, 2) : 0;
            $lineas[] = $this->fila("  {$ra}:  {$obt}/{$total} ptos.  →  Nota: {$nota}/10", $ancho);

            ksort($d['ejercicios']);
            foreach ($d['ejercicios'] as $ej => $e) {
                $o = round($e['obtenidos'], 2);
                $t = round($e['total'], 2);
                if ($t == 0) continue;
                $icon = ($o >= $t) ? '✓' : ($o > 0 ? '~' : '✗');
                $lineas[] = $this->fila("      [{$icon}] {$ej}: {$o}/{$t} ptos.", $ancho);
            }

            $lineas[] = "╠" . str_repeat("═", $ancho) . "╣";
        }

        // Reemplazar último ╠═╣ por ╚═╝
        array_pop($lineas);
        $lineas[] = "╚" . str_repeat("═", $ancho) . "╝";

        echo PHP_EOL . PHP_EOL;
        foreach ($lineas as $l) {
            echo $l . PHP_EOL;
        }
        echo PHP_EOL;
    }

    private function fila(string $contenido, int $ancho): string
    {
        $len   = mb_strlen($contenido);
        $pad   = max(0, $ancho - $len);
        return "║" . $contenido . str_repeat(" ", $pad) . "║";
    }

    public static function parseTestId(string $id): array
    {
        // El id tiene formato "Clase::método" o "Clase::método with data set #N"
        $parts  = explode('::', $id);
        $method = explode(' ', $parts[1] ?? '')[0];
        return [$parts[0], $method];
    }
}
