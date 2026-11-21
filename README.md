# CodeQuest

CodeQuest is a gamified web platform for learning basic programming. Learners pick a
language, then work through a path of levels: short, practical lessons followed by
practice questions with immediate feedback. The interface is in Indonesian and styled
like a retro terminal.

It is built for university and school students, from complete beginners to fairly
confident learners, and aims at the problems they reported most: material that is too
theoretical, losing motivation, and not knowing what to learn next.

## Features

- **Accounts:** register, sign in, and sign out.
- **Languages:** Python, Java, and C, each with its own learning path.
- **Learning path:** one node per level. Each level opens a page with its lessons and
  practice, also drawn as a path.
- **Lessons:** start with a code example and its output, then explain.
- **Practice:** four question types (predict the output, fill in the code, multiple
  choice, and case studies). Answers are checked on the server, and every answer gets
  an explanation, right or wrong.
- **Unlocking in order:** each lesson, then the level's practice, then the next level.
  The practice passes with at least the level's minimum score (70% for now), and
  finished steps stay open for review.
- **Saved progress:** every completed lesson and every answer is saved straight away.

Not built yet: XP totals, the progress page, the leaderboard, and the forum. Their
pages show "segera hadir".

## Tech stack

- Laravel 12 on PHP 8.3
- Blade views with Bootstrap 5.3, built with Vite
- MySQL (via XAMPP) for development
- PHPUnit for tests, on an in-memory SQLite database

## Getting started

You need PHP 8.3, Composer, Node.js, and MySQL (XAMPP works).

1. Clone the repository and create the environment file:

   ```bash
   git clone https://github.com/RizStillLearning/CodeQuest.git
   cd CodeQuest
   cp .env.example .env
   ```

2. Create a MySQL database named `codequest` (for example in phpMyAdmin), then point
   `.env` at it:

   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=codequest
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. Install everything, generate the app key, run the migrations, and build the assets:

   ```bash
   composer setup
   ```

4. Start the app and open http://localhost:8000:

   ```bash
   composer dev
   ```

   This runs the web server, queue worker, log viewer, and Vite together. On Windows
   the log viewer (Laravel Pail) stops straight away because PHP on Windows has no
   `pcntl` extension; the rest keeps running. You can also run `php artisan serve` and
   `npm run dev` in two terminals instead.

## Commands

| Command | What it does |
|---|---|
| `composer setup` | First-time setup: dependencies, `.env`, app key, migrations, assets |
| `composer dev` | Run the app locally |
| `composer test` | Run all tests |
| `php artisan test --filter=ProgressTest` | Run one test class |
| `php artisan migrate` | Apply new migrations |
| `npm run build` | Build the frontend assets |
| `./vendor/bin/pint --dirty` | Format the PHP files you changed |

## Writing lessons and questions

All learning content lives in [`content/`](content/) as plain files, so it can be
changed without touching code:

```text
content/
  python/
    level-01-basic-programming/
      level.yaml        title, description, and the score needed to pass
      lessons/          one Markdown file per lesson
      questions.yaml    the level's practice questions
```

The file formats and writing rules are in [`content/README.md`](content/README.md).
The site reads the files on every request, so a saved change shows up on the next page
refresh. Run `composer test` after editing: the tests check every file against those
rules, open every lesson and question page, and confirm that each question's own
answer is accepted.

## Project structure

| Path | Contents |
|---|---|
| `app/Content/` | Reads `content/` into languages, levels, lessons, and questions |
| `app/Progress/` | The unlock rule: what a learner has done and what they may open |
| `app/Http/Controllers/` | One controller per page |
| `app/ViewModels/` | Display logic for the learning paths |
| `app/Models/` | Users, completed steps, and saved answers |
| `resources/views/` | Blade pages, layouts, and partials |
| `resources/css/app.css` | The retro terminal theme |
| `content/` | Lessons and questions |
| `docs/` | User research and design references |
| `tests/` | Feature and unit tests |
