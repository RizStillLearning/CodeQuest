<?php

namespace App\Http\Controllers;

use App\Content\ContentException;
use App\Content\ContentRepository;
use App\Content\QuestionType;
use App\Content\Track;
use App\ViewModels\LearningPath;
use Illuminate\View\View;

/**
 * The public landing page. Guests only: signed-in users go to /belajar.
 */
class HomeController extends Controller
{
    public function __invoke(ContentRepository $content): View
    {
        // A broken content file must not take the homepage down: log it and
        // render the page without the content-driven sections.
        try {
            $languages = $content->languages();
            $demoQuestion = $content->findQuestion((string) config('codequest.home.demo_question'));
        } catch (ContentException $e) {
            report($e);

            $languages = [];
            $demoQuestion = null;
        }

        $tracks = array_map(Track::fromLanguage(...), array_values($languages));

        return view('home', [
            'demoQuestion' => $demoQuestion,
            'demoLanguage' => $demoQuestion ? $languages[$demoQuestion->language] : null,
            'tracks' => $tracks,
            'paths' => LearningPath::forTracks($tracks),
            'reasons' => $this->reasons(),
            'steps' => $this->steps(),
            'questionTypes' => $this->questionTypes(),
        ]);
    }

    /**
     * One card per top learner problem from the survey (docs/research/data-gathering.md).
     *
     * @return list<array{icon: string, tone: string, problem: string, title: string, body: string}>
     */
    private function reasons(): array
    {
        return [
            [
                'icon' => 'code-slash',
                'tone' => 'primary',
                'problem' => 'Materinya terlalu teori, kurang praktik.',
                'title' => 'Praktik dulu, teori belakangan',
                'body' => 'Setiap pelajaran dimulai dari contoh kode dan hasilnya, lalu dijelaskan singkat. Setelah itu langsung latihan soal.',
            ],
            [
                'icon' => 'lightning-charge-fill',
                'tone' => 'xp',
                'problem' => 'Cepat bosan dan susah konsisten.',
                'title' => 'XP dan level di setiap langkah',
                'body' => 'Setiap pelajaran dan soal yang kamu selesaikan memberi XP. Kumpulkan XP dan buka level berikutnya.',
            ],
            [
                'icon' => 'signpost-split-fill',
                'tone' => 'success',
                'problem' => 'Bingung harus mulai dari mana.',
                'title' => 'Jalur belajar yang jelas',
                'body' => 'Materi tersusun level demi level, dimulai dari nol. Kamu selalu tahu apa langkah berikutnya.',
            ],
        ];
    }

    /**
     * The core flow from CLAUDE.md, in learner terms.
     *
     * @return list<array{icon: string, title: string, body: string}>
     */
    private function steps(): array
    {
        return [
            ['icon' => 'person-plus-fill', 'title' => 'Daftar', 'body' => 'Buat akun agar XP dan progresmu tersimpan.'],
            ['icon' => 'code-square', 'title' => 'Pilih bahasa', 'body' => 'Mulai dengan Python, Java, atau C.'],
            ['icon' => 'book-half', 'title' => 'Pelajari materi', 'body' => 'Pelajaran singkat dengan contoh kode.'],
            ['icon' => 'patch-question-fill', 'title' => 'Jawab soal', 'body' => 'Langsung tahu benar atau salah, lengkap dengan penjelasannya.'],
            ['icon' => 'trophy-fill', 'title' => 'Naik level', 'body' => 'Kumpulkan XP dan buka level berikutnya.'],
        ];
    }

    /**
     * @return list<array{type: QuestionType, description: string}>
     */
    private function questionTypes(): array
    {
        $descriptions = [
            QuestionType::PredictOutput->value => 'Baca kodenya, lalu tebak apa yang akan tampil di layar.',
            QuestionType::FillIn->value => 'Isi bagian kode yang kosong agar programnya berjalan benar.',
            QuestionType::MultipleChoice->value => 'Pilih jawaban yang tepat dari beberapa pilihan.',
            QuestionType::CaseStudy->value => 'Pecahkan masalah kecil dari situasi sehari-hari.',
        ];

        return array_map(
            fn (QuestionType $type) => ['type' => $type, 'description' => $descriptions[$type->value]],
            QuestionType::cases(),
        );
    }
}
