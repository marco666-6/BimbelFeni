<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

class GenerateFlowDocumentation extends Command
{
    protected $signature = 'app:generate-docs';
    protected $description = 'Generate comprehensive application flow documentation';

    public function handle()
    {
        $this->info('Generating application flow documentation...');

        $documentation = $this->generateFullDocumentation();

        $filePath = storage_path('docs/application_flow.txt');
        File::ensureDirectoryExists(storage_path('docs'));
        File::put($filePath, $documentation);

        $this->info('Documentation generated at: ' . $filePath);
    }

    private function generateFullDocumentation()
    {
        $doc = "================================================================================\n";
        $doc .= "           DOKUMENTASI ALUR APLIKASI BIMBINGAN BELAJAR\n";
        $doc .= "           Generated: " . now()->format('Y-m-d H:i:s') . "\n";
        $doc .= "================================================================================\n\n";

        $doc .= $this->generateStructureDocumentation();
        $doc .= $this->generateRoutesDocumentation();
        $doc .= $this->generateControllersDocumentation();
        $doc .= $this->generateModelsDocumentation();
        $doc .= $this->generateMiddlewareDocumentation();
        $doc .= $this->generateDatabaseDocumentation();

        return $doc;
    }

    private function generateStructureDocumentation()
    {
        $doc = "\n" . str_repeat('=', 80) . "\n";
        $doc .= "1. STRUKTUR FOLDER PROYEK\n";
        $doc .= str_repeat('=', 80) . "\n\n";

        $doc .= "app/\n";
        $doc .= "├── Http/\n";
        $doc .= "│   ├── Controllers/       # Berisi semua controller (logic pemrosesan request)\n";
        $doc .= "│   │   ├── HomeController.php       # Halaman publik (landing page)\n";
        $doc .= "│   │   ├── AuthController.php       # Login, logout, autentikasi\n";
        $doc .= "│   │   ├── AdminController.php      # Semua fungsi admin\n";
        $doc .= "│   │   ├── OrangTuaController.php   # Semua fungsi orang tua\n";
        $doc .= "│   │   └── SiswaController.php      # Semua fungsi siswa\n";
        $doc .= "│   └── Middleware/       # Filter request sebelum masuk controller\n";
        $doc .= "│       ├── AdminMiddleware.php       # Validasi akses admin\n";
        $doc .= "│       ├── OrangTuaMiddleware.php    # Validasi akses orang tua\n";
        $doc .= "│       ├── SiswaMiddleware.php       # Validasi akses siswa\n";
        $doc .= "│       ├── CheckActiveSubscription.php # Cek langganan aktif\n";
        $doc .= "│       └── RequestLogger.php         # Logging semua request\n";
        $doc .= "├── Models/               # Representasi tabel database & relasi\n";
        $doc .= "│   ├── User.php          # Model user (login)\n";
        $doc .= "│   ├── OrangTua.php      # Model data orang tua\n";
        $doc .= "│   ├── Siswa.php         # Model data siswa\n";
        $doc .= "│   ├── PaketBelajar.php  # Model paket belajar\n";
        $doc .= "│   ├── Transaksi.php     # Model pembayaran\n";
        $doc .= "│   ├── Jadwal.php        # Model jadwal pelajaran\n";
        $doc .= "│   ├── Kehadiran.php     # Model absensi\n";
        $doc .= "│   ├── MateriTugas.php   # Model materi & tugas\n";
        $doc .= "│   ├── PengumpulanTugas.php # Model pengumpulan tugas\n";
        $doc .= "│   ├── Feedback.php      # Model feedback orang tua\n";
        $doc .= "│   ├── Pengumuman.php    # Model pengumuman\n";
        $doc .= "│   ├── Notifikasi.php    # Model notifikasi\n";
        $doc .= "│   ├── LogActivity.php   # Model log aktivitas siswa\n";
        $doc .= "│   └── Settings.php      # Model pengaturan website\n";
        $doc .= "└── Helpers/\n";
        $doc .= "    └── FileUploadHelper.php # Helper upload file\n\n";

        $doc .= "routes/\n";
        $doc .= "└── web.php               # Definisi semua route (URL mapping)\n\n";

        $doc .= "resources/\n";
        $doc .= "└── views/                # File tampilan (blade template)\n";
        $doc .= "    ├── home/             # View halaman publik\n";
        $doc .= "    ├── auth/             # View login\n";
        $doc .= "    ├── admin/            # View dashboard admin\n";
        $doc .= "    ├── orangtua/         # View dashboard orang tua\n";
        $doc .= "    └── siswa/            # View dashboard siswa\n\n";

        $doc .= "database/\n";
        $doc .= "└── Database MySQL berisi " . count($this->getTableList()) . " tabel\n\n";

        return $doc;
    }

    private function generateRoutesDocumentation()
    {
        $doc = "\n" . str_repeat('=', 80) . "\n";
        $doc .= "2. DAFTAR ROUTE (URL MAPPING)\n";
        $doc .= str_repeat('=', 80) . "\n\n";

        $routes = Route::getRoutes();
        $grouped = $this->groupRoutes($routes);

        foreach ($grouped as $group => $items) {
            $doc .= "\n--- {$group} ---\n\n";

            foreach ($items as $item) {
                $doc .= sprintf(
                    "%-8s %-50s -> %s\n",
                    $item['method'],
                    $item['uri'],
                    $item['action']
                );

                if (!empty($item['middleware'])) {
                    $doc .= "         Middleware: " . implode(', ', $item['middleware']) . "\n";
                }

                $doc .= "\n";
            }
        }

        return $doc;
    }

    private function groupRoutes($routes)
    {
        $grouped = [
            'PUBLIC' => [],
            'AUTH' => [],
            'ADMIN' => [],
            'ORANG TUA' => [],
            'SISWA' => [],
        ];

        foreach ($routes as $route) {
            $uri = $route->uri();
            $name = $route->getName();
            $action = $route->getActionName();
            $methods = $route->methods();
            $middleware = $route->middleware();

            // Skip routes yang tidak relevan
            if (strpos($uri, '_ignition') !== false || strpos($uri, 'sanctum') !== false) {
                continue;
            }

            $item = [
                'method' => implode('|', array_filter($methods, fn($m) => $m !== 'HEAD')),
                'uri' => $uri,
                'name' => $name,
                'action' => $action,
                'middleware' => $middleware,
            ];

            if (strpos($uri, 'admin/') === 0) {
                $grouped['ADMIN'][] = $item;
            } elseif (strpos($uri, 'orangtua/') === 0) {
                $grouped['ORANG TUA'][] = $item;
            } elseif (strpos($uri, 'siswa/') === 0) {
                $grouped['SISWA'][] = $item;
            } elseif (strpos($uri, 'login') !== false || strpos($uri, 'logout') !== false) {
                $grouped['AUTH'][] = $item;
            } else {
                $grouped['PUBLIC'][] = $item;
            }
        }

        return $grouped;
    }

    private function generateControllersDocumentation()
    {
        $doc = "\n" . str_repeat('=', 80) . "\n";
        $doc .= "3. CONTROLLERS & METHODS\n";
        $doc .= str_repeat('=', 80) . "\n\n";

        $controllers = [
            'HomeController' => 'Halaman publik',
            'AuthController' => 'Autentikasi (login/logout)',
            'AdminController' => 'Semua fungsi administrator',
            'OrangTuaController' => 'Semua fungsi orang tua',
            'SiswaController' => 'Semua fungsi siswa',
        ];

        foreach ($controllers as $controller => $description) {
            $doc .= "\n{$controller} - {$description}\n";
            $doc .= str_repeat('-', 80) . "\n";

            $className = "App\\Http\\Controllers\\{$controller}";
            if (class_exists($className)) {
                $reflection = new \ReflectionClass($className);
                $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);

                foreach ($methods as $method) {
                    if ($method->class === $className && !$method->isConstructor()) {
                        $doc .= "  • {$method->name}()\n";

                        // Coba ambil doc comment
                        $docComment = $method->getDocComment();
                        if ($docComment) {
                            $lines = explode("\n", $docComment);
                            foreach ($lines as $line) {
                                $line = trim($line, "/* \t\n\r\0\x0B");
                                if (!empty($line) && $line !== '/**' && $line !== '*/') {
                                    $doc .= "    {$line}\n";
                                }
                            }
                        }

                        $doc .= "\n";
                    }
                }
            }
        }

        return $doc;
    }

    private function generateModelsDocumentation()
    {
        $doc = "\n" . str_repeat('=', 80) . "\n";
        $doc .= "4. MODELS & RELASI DATABASE\n";
        $doc .= str_repeat('=', 80) . "\n\n";

        $models = [
            'User' => 'users',
            'OrangTua' => 'orang_tua',
            'Siswa' => 'siswa',
            'PaketBelajar' => 'paket_belajar',
            'Transaksi' => 'transaksi',
            'Jadwal' => 'jadwal',
            'Kehadiran' => 'kehadiran',
            'MateriTugas' => 'materi_tugas',
            'PengumpulanTugas' => 'pengumpulan_tugas',
            'Feedback' => 'feedback',
            'Pengumuman' => 'pengumuman',
            'Notifikasi' => 'notifikasi',
            'LogActivity' => 'log_activity',
            'Settings' => 'settings',
        ];

        foreach ($models as $model => $table) {
            $doc .= "\n{$model} (Tabel: {$table})\n";
            $doc .= str_repeat('-', 80) . "\n";

            $className = "App\\Models\\{$model}";
            if (class_exists($className)) {
                $instance = new $className;

                // Fillable fields
                if (property_exists($instance, 'fillable')) {
                    $reflection = new \ReflectionClass($className);
                    $fillable = $reflection->getProperty('fillable')->getValue($instance);
                    $doc .= "  Fillable: " . implode(', ', $fillable) . "\n\n";
                }

                // Relations
                $reflection = new \ReflectionClass($className);
                $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
                $relations = [];

                foreach ($methods as $method) {
                    if ($method->class === $className) {
                        $source = file_get_contents($method->getFileName());
                        $methodSource = '';

                        if (preg_match('/function\s+' . $method->name . '\s*\([^)]*\)\s*\{([^}]*)\}/s', $source, $matches)) {
                            $methodSource = $matches[1];

                            if (preg_match('/(hasOne|hasMany|belongsTo|belongsToMany|morphTo|morphMany)\s*\(/', $methodSource)) {
                                $relations[] = $method->name . '()';
                            }
                        }
                    }
                }

                if (!empty($relations)) {
                    $doc .= "  Relasi: " . implode(', ', $relations) . "\n";
                }
            }

            $doc .= "\n";
        }

        return $doc;
    }

    private function generateMiddlewareDocumentation()
    {
        $doc = "\n" . str_repeat('=', 80) . "\n";
        $doc .= "5. MIDDLEWARE (REQUEST FILTERS)\n";
        $doc .= str_repeat('=', 80) . "\n\n";

        $doc .= "AdminMiddleware\n";
        $doc .= "  • Cek apakah user login\n";
        $doc .= "  • Cek apakah role = 'admin'\n";
        $doc .= "  • Cek apakah status = 'aktif'\n";
        $doc .= "  • Jika tidak memenuhi -> redirect dengan error\n\n";

        $doc .= "OrangTuaMiddleware\n";
        $doc .= "  • Cek apakah user login\n";
        $doc .= "  • Cek apakah role = 'orangtua'\n";
        $doc .= "  • Cek apakah status = 'aktif'\n";
        $doc .= "  • Jika tidak memenuhi -> redirect dengan error\n\n";

        $doc .= "SiswaMiddleware\n";
        $doc .= "  • Cek apakah user login\n";
        $doc .= "  • Cek apakah role = 'siswa'\n";
        $doc .= "  • Cek apakah status = 'aktif'\n";
        $doc .= "  • Jika tidak memenuhi -> redirect dengan error\n\n";

        $doc .= "CheckActiveSubscription\n";
        $doc .= "  • Cek transaksi terakhir yang verified\n";
        $doc .= "  • Hitung tanggal berakhir berdasarkan durasi paket\n";
        $doc .= "  • Jika sudah expired -> redirect dengan warning\n\n";

        $doc .= "RequestLogger\n";
        $doc .= "  • Log semua request ke file txt\n";
        $doc .= "  • Catat: user, method, URL, data, response, waktu eksekusi\n";
        $doc .= "  • Lokasi: storage/logs/request_tracking/\n\n";

        return $doc;
    }

    private function generateDatabaseDocumentation()
    {
        $doc = "\n" . str_repeat('=', 80) . "\n";
        $doc .= "6. DATABASE TABLES & RELATIONSHIPS\n";
        $doc .= str_repeat('=', 80) . "\n\n";

        $tables = $this->getTableList();

        foreach ($tables as $table => $description) {
            $doc .= "{$table}\n";
            $doc .= "  {$description}\n\n";
        }

        $doc .= "\nRELASI UTAMA:\n";
        $doc .= "  users -> orang_tua (one-to-one)\n";
        $doc .= "  users -> siswa (one-to-one)\n";
        $doc .= "  orang_tua -> siswa (one-to-many)\n";
        $doc .= "  siswa -> jadwal (one-to-many)\n";
        $doc .= "  siswa -> kehadiran (one-to-many)\n";
        $doc .= "  siswa -> pengumpulan_tugas (one-to-many)\n";
        $doc .= "  siswa -> transaksi (one-to-many)\n";
        $doc .= "  jadwal -> kehadiran (one-to-many)\n";
        $doc .= "  materi_tugas -> pengumpulan_tugas (one-to-many)\n";
        $doc .= "  paket_belajar -> transaksi (one-to-many)\n\n";

        return $doc;
    }

    private function getTableList()
    {
        return [
            'users' => 'Data login semua pengguna (admin, orangtua, siswa)',
            'orang_tua' => 'Data detail orang tua',
            'siswa' => 'Data detail siswa',
            'paket_belajar' => 'Paket bimbingan belajar yang tersedia',
            'transaksi' => 'Riwayat pembayaran & bukti transfer',
            'jadwal' => 'Jadwal pelajaran siswa',
            'kehadiran' => 'Absensi siswa per pertemuan',
            'materi_tugas' => 'Materi pembelajaran & tugas',
            'pengumpulan_tugas' => 'File tugas yang dikumpulkan siswa',
            'feedback' => 'Feedback orang tua ke admin',
            'pengumuman' => 'Pengumuman dari admin',
            'notifikasi' => 'Notifikasi untuk user',
            'log_activity' => 'Log aktivitas siswa',
            'settings' => 'Pengaturan website',
        ];
    }
}