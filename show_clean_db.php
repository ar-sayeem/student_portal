<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== STUDENT PORTAL - CLEAN DATABASE STRUCTURE ===\n\n";

try {
    $tables = DB::select('SHOW TABLES');
    $databaseName = config('database.connections.mysql.database');
    
    echo "Database: {$databaseName}\n";
    echo "Total Tables: " . count($tables) . "\n\n";
    
    foreach ($tables as $table) {
        $tableName = array_values((array)$table)[0];
        
        // Get table row count
        try {
            $count = DB::table($tableName)->count();
            echo "✅ {$tableName} (Rows: {$count})\n";
            
            // Show table structure
            $columns = DB::select("DESCRIBE {$tableName}");
            foreach ($columns as $column) {
                echo "   - {$column->Field} ({$column->Type})" . 
                     ($column->Key === 'PRI' ? ' [PRIMARY]' : '') . 
                     ($column->Null === 'NO' ? ' [NOT NULL]' : '') . "\n";
            }
            echo "\n";
            
        } catch (Exception $e) {
            echo "❌ {$tableName} (Error getting count)\n\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== ESSENTIAL TABLES ONLY - CACHE & JOBS REMOVED ===\n";
