<?php

namespace App\Content;

/**
 * The question types allowed in content/<language>/<level>/questions.yaml.
 */
enum QuestionType: string
{
    case PredictOutput = 'predict_output';
    case FillIn = 'fill_in';
    case MultipleChoice = 'multiple_choice';
    case CaseStudy = 'case_study';

    /**
     * Name shown to learners.
     */
    public function label(): string
    {
        return match ($this) {
            self::PredictOutput => 'Tebak Output',
            self::FillIn => 'Lengkapi Kode',
            self::MultipleChoice => 'Pilihan Ganda',
            self::CaseStudy => 'Studi Kasus',
        };
    }

    /**
     * Bootstrap Icons name (without the "bi-" prefix).
     */
    public function icon(): string
    {
        return match ($this) {
            self::PredictOutput => 'terminal-fill',
            self::FillIn => 'input-cursor-text',
            self::MultipleChoice => 'ui-radios',
            self::CaseStudy => 'briefcase-fill',
        };
    }

    /**
     * Whether learners pick from `options` instead of typing an answer.
     */
    public function hasOptions(): bool
    {
        return $this === self::MultipleChoice || $this === self::CaseStudy;
    }
}
