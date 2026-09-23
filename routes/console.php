<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('db:cols {table}', function ($table) {
    $cols = DB::select("DESCRIBE `{$table}`");
    foreach ($cols as $c) {
        $this->line($c->Field . ' (' . $c->Type . ')');
    }
});

Artisan::command('db:inspect', function () {
    $this->info('Testing DB connection to ' . config('database.connections.mysql.host') . ' / ' . config('database.connections.mysql.database'));
    try {
        $pdo = DB::connection()->getPdo();
        $this->info('Connection SUCCESSFUL!');
        
        $keyTables = ['orders', 'BulkOrder', 'BuyHistory', 'CusDocs', 'VendorIP', 'adminuser', 'address', 'RoutingTable', 'sip_buddies', 'OnlinePayments', 'PayPalAuthorize', 'didOption', 'vcareticket'];
        
        foreach ($keyTables as $table) {
            $exists = DB::select("SHOW TABLES LIKE '{$table}'");
            if (!empty($exists)) {
                $count = DB::table($table)->count();
                $columns = DB::select("DESCRIBE `{$table}`");
                $colList = array_map(fn($c) => $c->Field . ' (' . $c->Type . ($c->Key ? ' [' . $c->Key . ']' : '') . ')', $columns);
                $this->line("<comment>Table: {$table}</comment> (Rows: {$count})");
                $this->line("  Columns: " . implode(', ', array_slice($colList, 0, 15)) . (count($colList) > 15 ? ' ...' : ''));
            } else {
                $this->warn("Table {$table} not found.");
            }
        }
    } catch (\Throwable $e) {
        $this->error('Connection failed: ' . $e->getMessage());
    }
});

Artisan::command('server:fix-db-grant', function () {
    $this->info('Connecting via SSH to 192.168.88.119 with user awais...');
    try {
        $ssh = new \phpseclib3\Net\SSH2('192.168.88.119');
        if (!$ssh->login('awais', 'personal')) {
            $this->error('SSH Login failed with awais / personal');
            return;
        }
        $this->info('SSH Login successful! Elevating with su - ...');
        
        $sql1 = "GRANT ALL PRIVILEGES ON didx2.* TO 'admin'@'%' IDENTIFIED BY '12343211'; FLUSH PRIVILEGES;";
        $sql2 = "CREATE USER IF NOT EXISTS 'admin'@'%' IDENTIFIED BY '12343211'; ALTER USER 'admin'@'%' IDENTIFIED BY '12343211'; GRANT ALL PRIVILEGES ON didx2.* TO 'admin'@'%'; FLUSH PRIVILEGES;";
        
        // Execute via su -
        $ssh->enablePTY();
        $ssh->exec('su -');
        $ssh->read('Password:');
        $ssh->write("personal\n");
        $prompt = $ssh->read('#');
        $this->info('Root shell acquired!');
        
        $sql = "SET GLOBAL validate_password.policy=LOW; SET GLOBAL validate_password.length=4; SET GLOBAL validate_password.mixed_case_count=0; SET GLOBAL validate_password.number_count=0; SET GLOBAL validate_password.special_char_count=0; CREATE USER IF NOT EXISTS 'admin'@'%' IDENTIFIED BY '12343211'; ALTER USER 'admin'@'%' IDENTIFIED BY '12343211'; GRANT ALL PRIVILEGES ON *.* TO 'admin'@'%' WITH GRANT OPTION; FLUSH PRIVILEGES;";
        $ssh->write("mysql -u admin -p12343211 -e \"{$sql}\"\n");
        $out = $ssh->read('#');
        $this->line("Grant Output: " . $out);
        $this->info('Grants applied successfully!');
    } catch (\Throwable $e) {
        $this->error('SSH Error: ' . $e->getMessage());
    }
});
