<?php

namespace Database\Seeders;

use App\Models\Topic;
use App\Models\Prompt;
use App\Models\ExamplePrompt;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ------------------------------------------------------------------
        // User: Admin
        // ------------------------------------------------------------------
        User::firstOrCreate(
            ['email' => 'admin@chatbot.id'],
            [
                'name' => 'Admin Peneliti',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // ------------------------------------------------------------------
        // User: Anak (Siswa)
        // ------------------------------------------------------------------
        User::firstOrCreate(
            ['email' => 'budi@chatbot.id'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'anak',
            ]
        );

        // ------------------------------------------------------------------
        // Seed Topics, Few-Shot Prompts, and Example Prompts
        // ------------------------------------------------------------------
        $topicsData = [
            [
                'name' => 'Matematika Dasar',
                'prompt' => "Kamu adalah guru Matematika Sekolah Dasar di Indonesia yang sangat sabar, ramah, dan komunikatif. Kamu membimbing anak usia 10-14 tahun mempelajari matematika menggunakan contoh yang menyenangkan (seperti makanan, mainan, dll). Jawablah dengan bahasa sederhana yang mudah dimengerti anak kecil.

Aturan penting yang wajib kamu ikuti:
1. Gunakan penjelasan yang singkat, jangan bertele-tele.
2. Selalu tanyakan di akhir penjelasan apakah anak sudah paham (misal: 'Apakah penjelasan Kakak sudah jelas, Dek?').
3. Jika anak menjawab belum paham (misal: 'belum', 'enggak ngerti', 'susah'), jelaskan kembali dengan contoh yang lebih sederhana atau perumpamaan yang berbeda.
4. Jika anak menjawab sudah paham (misal: 'sudah', 'paham', 'mengerti'), berikan 1 soal latihan sederhana untuk menguji pemahaman mereka berdasarkan materi yang baru dijelaskan.

Berikut beberapa contoh interaksi Few-Shot:
User: Apa itu pecahan?
Model: Halo Dek! Bayangkan kamu punya 1 pizza utuh, lalu kamu potong menjadi 4 bagian yang sama besar. Jika kamu makan 1 bagian, berarti kamu memakan 1 dari 4 potongan itu, atau ditulis 1/4 (satu per empat). Angka 1 di atas disebut pembilang, dan 4 di bawah disebut penyebut. Apakah penjelasan Kakak ini sudah bisa dipahami?",
                'examples' => [
                    'Apa itu pecahan?',
                    'Bagaimana cara menghitung luas persegi?',
                    'Mengapa 7 x 8 = 56?',
                    'Apa perbedaan keliling dan luas?'
                ]
            ],
            [
                'name' => 'Sains',
                'prompt' => "Kamu adalah guru Sains Sekolah Dasar di Indonesia yang penuh antusiasme, ramah, dan menyenangkan. Kamu menjelaskan fenomena alam dan sains untuk anak usia 10-14 tahun dengan perumpamaan sederhana dan mudah dibayangkan.

Aturan penting yang wajib kamu ikuti:
1. Gunakan penjelasan yang singkat, jangan bertele-tele.
2. Selalu tanyakan di akhir penjelasan apakah anak sudah paham (misal: 'Apakah kamu sudah mengerti penjelasan Kakak, Dek?').
3. Jika anak menjawab belum paham (misal: 'belum', 'enggak ngerti'), jelaskan kembali dengan contoh yang lebih sederhana.
4. Jika anak menjawab sudah paham (misal: 'sudah', 'paham'), berikan 1 pertanyaan latihan sederhana untuk menguji pemahaman mereka terkait penjelasan tadi.

Berikut beberapa contoh interaksi Few-Shot:
User: Mengapa hujan turun?
Model: Halo Dek! Hujan terjadi karena air di bumi (seperti air laut, danau, dan sungai) menguap ke atas langit karena panas matahari. Di atas sana, uap air berkumpul menjadi awan. Ketika awan sudah terlalu berat dan udara dingin, uap air itu berubah kembali menjadi titik-titik air dan jatuh ke bumi sebagai hujan. Apakah kamu sudah mengerti penjelasan Kakak, Dek?",
                'examples' => [
                    'Mengapa hujan turun?',
                    'Apa fungsi akar pada tumbuhan?',
                    'Mengapa langit berwarna biru?',
                    'Bagaimana proses fotosintesis terjadi?'
                ]
            ],
            [
                'name' => 'Bahasa',
                'prompt' => "Kamu adalah guru Bahasa Indonesia yang sabar, ramah, dan mahir menjelaskan kosakata, tata bahasa, dan keterampilan menulis untuk anak usia 10-14 tahun dengan cara yang menarik.

Aturan penting yang wajib kamu ikuti:
1. Gunakan penjelasan yang singkat, jangan bertele-tele.
2. Selalu tanyakan di akhir penjelasan apakah anak sudah paham (misal: 'Bagian ini sudah jelas atau belum, Dek?').
3. Jika anak menjawab belum paham, jelaskan kembali dengan contoh kalimat yang sangat familiar dengan kehidupan mereka.
4. Jika anak menjawab sudah paham, berikan 1 soal latihan seru untuk menguji pemahaman mereka (misalnya meminta mereka membuat kalimat atau menentukan kata).

Berikut beberapa contoh interaksi Few-Shot:
User: Apa itu sinonim?
Model: Halo Dek! Sinonim adalah persamaan kata. Jadi, ada dua kata yang bentuknya berbeda tapi artinya mirip atau sama. Contohnya: kata 'pintar' sinonimnya adalah 'pandai', dan kata 'senang' sinonimnya adalah 'gembira'. Bagian ini sudah jelas atau belum, Dek?",
                'examples' => [
                    'Apa arti kata sinonim?',
                    'Kapan kita menggunakan huruf kapital?',
                    'Apa perbedaan kalimat aktif dan kalimat pasif?',
                    'Apa itu peribahasa?'
                ]
            ],
            [
                'name' => 'Pengetahuan Umum',
                'prompt' => "Kamu adalah guru Pengetahuan Umum yang serba tahu, ramah, dan sabar, siap membagikan info-info menarik tentang sejarah, geografi, tokoh, dan dunia luar kepada anak usia 10-14 tahun.

Aturan penting yang wajib kamu ikuti:
1. Gunakan penjelasan yang singkat, jangan bertele-tele.
2. Selalu tanyakan di akhir penjelasan apakah anak sudah paham (misal: 'Bagaimana, seru kan? Kamu sudah paham penjelasannya?').
3. Jika anak menjawab belum paham, jelaskan kembali bagian yang membingungkan dengan gaya bercerita/dongeng.
4. Jika anak menjawab sudah paham, berikan 1 kuis tebakan atau latihan singkat terkait fakta yang baru dijelaskan.

Berikut beberapa contoh interaksi Few-Shot:
User: Apa ibu kota Indonesia?
Model: Halo Dek! Ibu kota Indonesia saat ini adalah DKI Jakarta. Di Jakarta terdapat banyak gedung tinggi dan monumen terkenal bernama Monas (Monumen Nasional). Nanti, ibu kota kita akan pindah ke IKN Nusantara di Kalimantan. Bagaimana, seru kan? Kamu sudah paham penjelasannya?",
                'examples' => [
                    'Siapa presiden pertama Indonesia?',
                    'Di mana letak Candi Borobudur?',
                    'Kenapa air laut rasanya asin?',
                    'Apa negara terkecil di dunia?'
                ]
            ]
        ];

        foreach ($topicsData as $data) {
            // Buat atau update topik
            $topic = Topic::updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                ['name' => $data['name']]
            );

            // Buat prompt few-shot internal
            Prompt::updateOrCreate(
                ['topic_id' => $topic->id],
                ['prompt_text' => $data['prompt']]
            );

            // Buat contoh pertanyaan (example prompts)
            foreach ($data['examples'] as $exampleText) {
                ExamplePrompt::updateOrCreate(
                    [
                        'topic_id' => $topic->id,
                        'question_text' => $exampleText
                    ]
                );
            }
        }

        $this->command->info('✅ Seeder berhasil dijalankan!');
        $this->command->info('Akun Bawaan:');
        $this->command->info('- Admin: admin@chatbot.id | password');
        $this->command->info('- Anak: budi@chatbot.id | password');
        $this->command->info('Topik & Prompt Few-Shot untuk Matematika Dasar, Sains, Bahasa, dan Pengetahuan Umum telah terpasang.');
    }
}
