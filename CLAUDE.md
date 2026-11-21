# CodeQuest

Gamified web platform for learning basic programming. Users pick a language, work through
levels of short lessons and practice questions, earn XP, and track their progress.

Core flow: Register/Login → Choose language → Level → Lesson → Questions → Earn XP → Progress → Next level

## Who it's for
- University and school students learning basic programming. Skill levels vary widely, from complete beginners to fairly confident learners.
- Their biggest problems: material that is too theoretical (50%), getting bored or inconsistent (43%), and no clear learning path (29%). Every feature should help with at least one of these: more practice, more variety, or a clearer path.
- Full survey results (14 respondents, Oct 2026): `docs/research/data-gathering.md`. Read it before changing features or learning content.

## Tech stack
- Backend: Laravel 12.0 on PHP 8.3.36
- Frontend: Blade, built with Vite
- Database: MySQL with XAMPP 3.3.0
- Tests: PHPUnit

## Commands
- First-time setup: composer setup (installs dependencies, creates .env, generates the app key, runs migrations, builds assets)
- Run locally: composer dev (server, queue, logs, and Vite together). It keeps running until stopped, so the developer usually keeps it open in their own terminal.
- Run all tests: composer test
- Run one test: php artisan test --filter=XpServiceTest
- Format code: ./vendor/bin/pint --dirty (only files you changed)
- Apply new migrations: php artisan migrate
- Build frontend assets: npm run build

## Project structure
- `app/Content/`: reads `content/` into `Language`, `Level`, `Lesson`, and `Question` objects through `ContentRepository`. Read-only: it never touches progress or XP.
- `app/Http/Controllers/`: one controller per page. `HomeController` is the guest-only landing page; `LearnController` (`/belajar`) is the signed-in home where learners pick a language, each card showing the level they're on; `PathController` (`/belajar/{language}`) shows that language's learning path as one node per level, with finished levels marked and the levels after the current one locked; `LevelController` (`/belajar/{language}/{level}`) opens from a level node and shows that level's lessons and practice as a path, ending with the next level; `LessonController` (`/belajar/{language}/{level}/pelajaran/{n}`) renders a lesson's Markdown and marks it done; `PracticeController` (`/belajar/{language}/{level}/latihan/{n}`) shows one question per page, checks answers on the server, saves each answer, and completes the level's practice once every question is answered with a passing score. The level, lesson, and practice controllers send a learner who opens a locked step back to the path (`Controller::ensureUnlocked`); `ProgressController`, `LeaderboardController`, and `ForumController` show a "segera hadir" page until those features are built; `Auth/` holds register, login, and logout
- `app/Http/Requests/`: form validation, e.g. `Auth/RegisterRequest` and `Auth/LoginRequest` (login rate limiting lives here)
- `app/Models/`: `User`, plus progress: `Completion` (a finished lesson or practice set, by content id) and `Answer` (the learner's answer to each question in the current run; restarting a practice deletes them but keeps the completion)
- `app/Progress/LearnerProgress.php`: the unlock rule. From a learner's completions in one language it says which lessons, practice sets, and levels are done and which are open; the path and level pages and the study controllers all use it.
- `app/ViewModels/`: display data that needs real logic, built by controllers and passed to views, e.g. `LearningPath` (path nodes and the SVG line; `forLanguage()` has a node per level for the path page, `forLevel()` has one level's lessons and practice for the level page, `preview()` is level 1 for the homepage)
- `app/Providers/AppServiceProvider.php`: binds `{language}` (key) and `{level}` (order number) in URLs to the content's `Language` and `Level`; unknown ones are a 404
- `bootstrap/app.php`: middleware and exception setup, e.g. an expired form (419) goes back to the form with a message
- `config/codequest.php`: enabled languages (display order, name, tagline, example file name) and the homepage demo question
- `content/`: lessons and questions as data files, organized by language and level
- `docs/`: research, design notes, and decisions
- `lang/id/`: Indonesian validation and auth messages. Rules not listed there fall back to English, so add a line when a form uses a new rule.
- `resources/views/`: Blade pages. `layouts/` holds `app` (main), `auth` (login/register, extends `app`), and `minimal` (error pages; must not touch the database, session, or auth); `partials/` holds included pieces (navbar, footer, logo, CRT scanlines and status bars, form input, code block, content notice, language and level summaries, level progress, path panel, learning path, level header; `language-tracks` and `home/` are the homepage's); `paths/`, `levels/`, `lessons/`, and `practice/` hold the study pages; `errors/` holds the friendly error pages, which extend `errors/layout`.
- `resources/css/app.css`: the retro terminal theme from `docs/design/style-prompt.md` on top of Bootstrap 5.3: tokens (`--cq-*`), 0px corners, hard double shadows, and CodeQuest component styles. Icons are pixelarticons (`pixelart-icons-font-<name>`); there is no Tailwind. Fonts (Press Start 2P for headings and labels, VT323 for everything else) are bundled from npm via Fontsource; don't load fonts from a CDN.
- `resources/js/`: Bootstrap JS and small page scripts, e.g. `home/try-question.js` and `forms.js`
- `tests/`: PHPUnit tests, run on in-memory SQLite (never the dev database). `tests/Feature/Content/ContentFilesTest.php` checks the real `content/` files against the rules in `content/README.md`, and `ContentPagesTest.php` opens every lesson and question page; `tests/Feature/RoutesTest.php` checks that every route uses a controller.

## Product rules

### Learning content
- Keep lessons short and practical: start with an interactive code example, then explain. Prefer visuals over long blocks of text.
- Question types: predict the output, fill in the code, multiple choice, and simple case studies. Mix types within each level so levels don't feel repetitive.
- Every answer gets immediate feedback explaining why it is right or wrong.
- Level 1 assumes zero knowledge. Never use a concept before the lesson that introduces it.
- Lessons and questions live in `content/` as data, never hardcoded in components, so content can be updated without code changes.

### Gamification
- XP is the strongest motivator (4.64/5). Award XP for completed lessons and question sets, and keep the user's XP visible.
- Steps unlock in order: each lesson, then the level's practice, then the next level. A level's practice is done once every question is answered with at least the level's `unlock.min_score` % correct; below that the learner retries it and the next level stays locked. Finished steps stay open for review.
- Calculate XP and level unlocks on the server. Never trust values sent by the client.

### Stability comes first
- Bugs, errors, and lag are the top reason users would quit. A smaller feature that works beats a bigger one that is flaky.
- Never lose progress: save after each completed question.
- On errors, show a friendly message with a way to retry. Never show a blank screen.
- Add or update tests whenever XP, level-unlock, or progress logic changes.

## Feature priorities
MVP, build in this order:
1. Register & login
2. Language selection: Python and Java first (57% each), then C (36%)
3. Levels, lessons, and practice questions
4. XP system
5. Progress tracking (79% want it)

Later, only when asked:
- Discussion/Q&A forum (71%)
- Leaderboard (64%; lowest-rated idea at 4.21/5, so treat it as optional)
- Badges/certificates (43%)
- Daily study reminders (21%)

## Conventions
- Code, comments, and commit messages in English.
- UI text in Indonesian.
- Every route points to a controller in `app/Http/Controllers` (no closures, no `Route::view`). Controllers prepare all the data a page needs, including the current user; page views only render it, with no `@php` blocks and no `auth()` calls. Display data that needs real logic goes in a class in `app/ViewModels` (e.g. `LearningPath`) that the controller builds. The shared navbar may use `@auth`.
- Views use classic Blade: pages `@extends` a layout and fill `@section`s; reusable pieces are `@include`d partials with their data passed as an array (`@include('partials.form-input', ['name' => 'email', ...])`). No Blade components (`<x-...>`, `@props`, `$slot`). Each partial lists the variables it expects in a comment at the top. `tests/Unit/ViewConventionsTest.php` checks this.
- Branch naming and commit format: GitHub Conventional Commit

## Code style: don't write AI-looking code

### Comments
- Comment the *why*, not the *what*. Don't comment code that explains itself.
- No numbered step comments ("# Step 1: ...").
- No comments that describe the edit ("# Fixed: ...", "# Updated to ...").
- Docstrings only for public or non-obvious functions. Skip Args/Returns boilerplate that just repeats the signature.
- No emojis in code, comments, logs, or output.

### Error handling
- No broad `try/except Exception`. Catch specific exceptions only where you can actually handle them; otherwise let it fail.
- Don't check for conditions that can't happen.
- No silent fallbacks (`.get(k, {})` chains, "Unknown" defaults) that hide bad data.

### Naming and structure
- Use short, specific names from the domain, not generic ones like `processed_data`, `final_result`, `handle_data`.
- Never create `_v2`, `_new`, `_improved`, `_enhanced` versions. Edit the original.
- Keep the solution in proportion to the problem. No classes, managers, or config objects for small scripts, and no helpers that are only called once.
- No boilerplate (`if __name__ == "__main__"`, logging setup) unless the file needs it.

### Fit the codebase
- Read the surrounding code first. Follow its conventions and reuse its existing utilities.
- Remove unused imports. Only use APIs that exist in the installed version.

### No placeholders
- No TODO stubs, "in a real implementation..." comments, fake data, or placeholder keys. If something can't be done, say so.
- Tests must check real behavior. Never weaken or rewrite a test just to make it pass.

### Diffs and commits
- Keep diffs minimal. Don't reformat or touch unrelated code.
- Commit messages: one short summary line, with a body only when the change needs explaining. Keep PR descriptions in proportion to the change.

## IMPORTANT NOTES!
- Dont change anything in `docs/` and `content/` unless I ask.