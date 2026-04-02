<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Use raw SQL to avoid doctrine/dbal dependency for column type change.
        // Only needed on MySQL (SQLite uses dynamic typing).
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        // Drop FK constraints before modifying column types
        try { DB::statement('ALTER TABLE refund_requests DROP FOREIGN KEY refund_requests_order_id_foreign'); } catch (\Exception $e) {}
        try { DB::statement('ALTER TABLE refund_requests DROP FOREIGN KEY refund_requests_user_id_foreign'); } catch (\Exception $e) {}

        // Change INT to BIGINT to match orders.id / users.id (which use BIGINT UNSIGNED via id())
        DB::statement('ALTER TABLE refund_requests MODIFY order_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE refund_requests MODIFY user_id BIGINT UNSIGNED NOT NULL');

        // Re-add foreign keys
        DB::statement('ALTER TABLE refund_requests ADD CONSTRAINT refund_requests_order_id_foreign FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE');
        DB::statement('ALTER TABLE refund_requests ADD CONSTRAINT refund_requests_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        try { DB::statement('ALTER TABLE refund_requests DROP FOREIGN KEY refund_requests_order_id_foreign'); } catch (\Exception $e) {}
        try { DB::statement('ALTER TABLE refund_requests DROP FOREIGN KEY refund_requests_user_id_foreign'); } catch (\Exception $e) {}

        DB::statement('ALTER TABLE refund_requests MODIFY order_id INT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE refund_requests MODIFY user_id INT UNSIGNED NOT NULL');

        DB::statement('ALTER TABLE refund_requests ADD CONSTRAINT refund_requests_order_id_foreign FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE');
        DB::statement('ALTER TABLE refund_requests ADD CONSTRAINT refund_requests_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
    }
};
