<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TopicSeeder::class,
        ]);

        $this->command->info('✅ Seeder berhasil dijalankan!');
        $this->command->info('Akun Bawaan:');
        $this->command->info('- Admin: admin@chatbot.id | password');
        $this->command->info('- Anak: budi@chatbot.id | password');
        $this->command->info('Topik & Prompt Few-Shot untuk Matematika, Sains/IPA, Bahasa Indonesia, dan Pengetahuan Umum telah terpasang.');
    }
}
