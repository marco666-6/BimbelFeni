<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RequestLogger
{
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);

        // Data request
        $logData = [
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'user' => auth()->check() ? [
                'id' => auth()->id(),
                'username' => auth()->user()->username,
                'role' => auth()->user()->role,
            ] : 'Guest',
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'route_name' => $request->route() ? $request->route()->getName() : 'N/A',
            'route_action' => $request->route() ? $request->route()->getActionName() : 'N/A',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'request_data' => [
                'query_params' => $request->query(),
                'post_data' => $this->filterSensitiveData($request->all()),
                'files' => $request->allFiles() ? array_keys($request->allFiles()) : [],
            ],
        ];

        // Process request
        $response = $next($request);

        // Data response
        $executionTime = microtime(true) - $startTime;
        $logData['response'] = [
            'status_code' => $response->getStatusCode(),
            'execution_time' => round($executionTime * 1000, 2) . 'ms',
        ];

        // Log ke file
        $this->logToFile($logData);

        return $response;
    }

    private function filterSensitiveData($data)
    {
        $filtered = $data;
        $sensitiveKeys = ['password', 'password_confirmation', 'remember_token'];

        foreach ($sensitiveKeys as $key) {
            if (isset($filtered[$key])) {
                $filtered[$key] = '***HIDDEN***';
            }
        }

        return $filtered;
    }

    private function logToFile($data)
    {
        $logPath = storage_path('logs/request_tracking');

        if (!file_exists($logPath)) {
            mkdir($logPath, 0777, true);
        }

        $filename = $logPath . '/tracking_' . date('Y-m-d') . '.txt';

        $logEntry = "\n" . str_repeat('=', 100) . "\n";
        $logEntry .= "TIMESTAMP: " . $data['timestamp'] . "\n";
        $logEntry .= "USER: " . (is_array($data['user']) ? json_encode($data['user']) : $data['user']) . "\n";
        $logEntry .= "METHOD: " . $data['method'] . "\n";
        $logEntry .= "URL: " . $data['url'] . "\n";
        $logEntry .= "ROUTE NAME: " . $data['route_name'] . "\n";
        $logEntry .= "CONTROLLER: " . $data['route_action'] . "\n";
        $logEntry .= "IP ADDRESS: " . $data['ip_address'] . "\n";
        $logEntry .= "\n--- REQUEST DATA ---\n";
        $logEntry .= "Query Params: " . json_encode($data['request_data']['query_params'], JSON_PRETTY_PRINT) . "\n";
        $logEntry .= "POST Data: " . json_encode($data['request_data']['post_data'], JSON_PRETTY_PRINT) . "\n";
        $logEntry .= "Files: " . json_encode($data['request_data']['files']) . "\n";
        $logEntry .= "\n--- RESPONSE ---\n";
        $logEntry .= "Status Code: " . $data['response']['status_code'] . "\n";
        $logEntry .= "Execution Time: " . $data['response']['execution_time'] . "\n";
        $logEntry .= str_repeat('=', 100) . "\n";

        file_put_contents($filename, $logEntry, FILE_APPEND);
    }
}