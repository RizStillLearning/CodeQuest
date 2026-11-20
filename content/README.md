# CodeQuest Content

Lessons and practice questions for CodeQuest, stored as text files.
[TODO: import them into the database with `php artisan content:import` once that command exists.]

## Folder structure

```
content/
└── <language>/                          python, java, c
    └── level-01-basic-programming/
        ├── level.yaml                   level settings
        ├── lessons/                     one Markdown file per lesson, in order
        │   ├── 01-introduction.md
        │   ├── 02-variables.md
        │   └── 03-data-types.md
        └── questions.yaml               practice questions for the level
```

## level.yaml

| Field | Meaning |
|---|---|
| `id` | Permanent ID, e.g. `python-l1` |
| `title` | Level name shown to users |
| `order` | Position in the language's learning path |
| `description` | One sentence shown on the level card |
| `unlock.min_score` | % of questions answered correctly to unlock the next level |

## Lessons

Markdown files with front matter:

| Field | Meaning |
|---|---|
| `id` | Permanent ID, e.g. `python-l1-variables` |
| `title` | Lesson title |
| `order` | Position within the level |
| `xp` | XP awarded for finishing the lesson |

Each lesson covers one idea. Start with a runnable code example and its output,
then explain. Use tables instead of long paragraphs where possible.

## Questions

Every question has `id`, `type`, `prompt`, `answer`, `explanation`, and `xp`.

| `type` | Extra fields | `answer` is |
|---|---|---|
| `predict_output` | `code` | the exact output the code prints |
| `fill_in` | `code` with a `____` blank | the text that goes in the blank (`also_accept` lists other correct answers) |
| `multiple_choice` | `options` | one of the options, written exactly the same |
| `case_study` | `scenario`, `options`, optional `code` | one of the options, written exactly the same |

- In Java and C questions, `code` shows only the lines inside `main()`, unless the
  question is about the program's structure.
- Answers are compared after trimming whitespace at the start and end.
- `explanation` is shown after the user answers, whether they were right or wrong.

## Rules

- **Language:** everything learners read is in Indonesian, addressing the reader as
  "kamu": lesson text, prompts, options, explanations, and text printed by example code.
  Code identifiers (variable names) stay in English, and so do IDs, file names, and field names.
- **Write `explanation` as a `>-` block** (see the existing files). In plain YAML text,
  ` #` starts a comment and `: ` breaks parsing, so a sentence like
  "Baris yang diawali # adalah komentar" would be silently cut off.
- **IDs are permanent.** Never change, reuse, or renumber an `id`: user progress is
  saved against it. To replace a question, delete it and add a new one with a new `id`.
- **Every question needs an `explanation`.** It's the instant feedback users get.
- **Mix question types in every level** so levels don't feel repetitive.
- **Quote answers and options in YAML** (`"10"`, `"true"`) so they stay text.
- **Run every code example before committing it,** and check that the shown output matches.
