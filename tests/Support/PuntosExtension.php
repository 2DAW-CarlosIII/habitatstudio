<?php

namespace Tests\Support;

use PHPUnit\Runner\Extension\Extension;
use PHPUnit\Runner\Extension\Facade;
use PHPUnit\Runner\Extension\ParameterCollection;
use PHPUnit\TextUI\Configuration\Configuration;
use PHPUnit\Event\Test\Passed;
use PHPUnit\Event\Test\Failed;
use PHPUnit\Event\Test\Errored;
use PHPUnit\Event\Test\MarkedIncomplete;
use PHPUnit\Event\Test\Skipped;
use PHPUnit\Event\TestSuite\Finished;

/**
 * Extensión PHPUnit 10/11 que sustituye al antiguo <listeners>.
 *
 * Registro en phpunit.xml:
 *   <extensions>
 *     <bootstrap class="Tests\Support\PuntosExtension"/>
 *   </extensions>
 *
 * Suscribe subscribers al sistema de eventos de PHPUnit 10+ para:
 *   - Detectar qué tests pasaron / fallaron.
 *   - Imprimir el resumen de puntuación al finalizar la suite raíz.
 */
class PuntosExtension implements Extension
{
    public function bootstrap(
        Configuration       $configuration,
        Facade              $facade,
        ParameterCollection $parameters,
    ): void {
        $facade->registerSubscribers(
            new PuntosPassedSubscriber(),
            new PuntosFailedSubscriber(),
            new PuntosErroredSubscriber(),
            new PuntosIncompleteSubscriber(),
            new PuntosSkippedSubscriber(),
            new PuntosSuiteFinishedSubscriber(),
        );
    }
}

// ── Subscribers ───────────────────────────────────────────────────────────────

class PuntosPassedSubscriber implements \PHPUnit\Event\Test\PassedSubscriber
{
    public function notify(Passed $event): void
    {
        [$class, $method] = PuntosCollector::parseTestId($event->test()->id());
        PuntosCollector::getInstance()->registrar($class, $method, true);
    }
}

class PuntosFailedSubscriber implements \PHPUnit\Event\Test\FailedSubscriber
{
    public function notify(Failed $event): void
    {
        [$class, $method] = PuntosCollector::parseTestId($event->test()->id());
        PuntosCollector::getInstance()->registrar($class, $method, false);
    }
}

class PuntosErroredSubscriber implements \PHPUnit\Event\Test\ErroredSubscriber
{
    public function notify(Errored $event): void
    {
        [$class, $method] = PuntosCollector::parseTestId($event->test()->id());
        PuntosCollector::getInstance()->registrar($class, $method, false);
    }
}

class PuntosIncompleteSubscriber implements \PHPUnit\Event\Test\MarkedIncompleteSubscriber
{
    public function notify(MarkedIncomplete $event): void
    {
        [$class, $method] = PuntosCollector::parseTestId($event->test()->id());
        PuntosCollector::getInstance()->registrar($class, $method, false);
    }
}

class PuntosSkippedSubscriber implements \PHPUnit\Event\Test\SkippedSubscriber
{
    public function notify(Skipped $event): void
    {
        [$class, $method] = PuntosCollector::parseTestId($event->test()->id());
        PuntosCollector::getInstance()->registrar($class, $method, false);
    }
}

class PuntosSuiteFinishedSubscriber implements \PHPUnit\Event\TestSuite\FinishedSubscriber
{
    public function notify(Finished $event): void
    {
        // Solo imprimimos al cerrar la suite raíz (la que contiene todas las demás)
        if ($event->testSuite()->isForTestClass()) {
            return;
        }
        PuntosCollector::getInstance()->imprimir();
    }
}
