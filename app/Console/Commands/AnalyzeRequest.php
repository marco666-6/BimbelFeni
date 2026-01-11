<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class AnalyzeRequest extends Command
{
    protected $signature = 'app:analyze {url}';
    protected $description = 'Analyze what happens when accessing a specific URL';

    public function handle()
    {
        $url = $this->argument('url');
        $url = ltrim($url, '/');

        $this->info("Analyzing URL: /{$url}");
        $this->info(str_repeat('=', 80));

        $route = null;
        foreach (Route::getRoutes() as $r) {
            if ($r->uri() === $url) {
                $route = $r;
                break;
            }
        }

        if (!$route) {
            $this->error("Route not found!");
            return;
        }

        $this->info("\n1. ROUTE INFORMATION");
        $this->table(
            ['Property', 'Value'],
            [
                ['Name', $route->getName() ?? 'N/A'],
                ['Methods', implode(', ', $route->methods())],
                ['URI', $route->uri()],
                ['Action', $route->getActionName()],
            ]
        );

        $this->info("\n2. MIDDLEWARE CHAIN");
        $middleware = $route->middleware();
        if (empty($middleware)) {
            $this->warn("No middleware");
        } else {
            foreach ($middleware as $index => $m) {
                $this->line(($index + 1) . ". {$m}");
            }
        }

        $this->info("\n3. CONTROLLER & METHOD");
        $action = $route->getActionName();
        if (strpos($action, '@') !== false) {
            [$controller, $method] = explode('@', $action);
            $this->line("Controller: {$controller}");
            $this->line("Method: {$method}");

            if (class_exists($controller)) {
                $reflection = new \ReflectionClass($controller);
                if ($reflection->hasMethod($method)) {
                    $methodReflection = $reflection->getMethod($method);
                    $parameters = $methodReflection->getParameters();

                    if (!empty($parameters)) {
                        $this->info("\n4. METHOD PARAMETERS");
                        foreach ($parameters as $param) {
                            $type = $param->getType() ? $param->getType()->getName() : 'mixed';
                            $this->line("  \${$param->getName()}: {$type}");
                        }
                    }
                }
            }
        }
    }
}