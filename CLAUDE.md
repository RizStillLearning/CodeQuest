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
- `app/Http/Controllers/`: one controller per page. `HomeController` is the guest-only landing page; `LearnController` (`/belajar`) is the signed-in home; `ProgressController`, `LeaderboardController`, and `ForumController` show a "segera hadir" page until those features are built; `Auth/` holds register, login, and logout
- `app/Http/Requests/`: form validation, e.g. `Auth/RegisterRequest` and `Auth/LoginRequest` (login rate limiting lives here)
- `app/ViewModels/`: display data that needs real logic, built by controllers and passed to views, e.g. `LearningPath` (path steps and the SVG line)
- `bootstrap/app.php`: middleware and exception setup, e.g. an expired form (419) goes back to the form with a message
- `config/codequest.php`: enabled languages (display order, name, tagline, example file name) and the homepage demo question
- `content/`: lessons and questions as data files, organized by language and level
- `docs/`: research, design notes, and decisions
- `lang/id/`: Indonesian validation and auth messages. Rules not listed there fall back to English, so add a line when a form uses a new rule.
- `resources/views/`: Blade pages. `layouts/` holds `app` (main), `auth` (login/register, extends `app`), and `minimal` (error pages; must not touch the database, session, or auth); `partials/` holds included pieces (navbar, footer, logo, form input, code block, language tracks, learning path, `home/`); `errors/` holds the friendly error pages, which extend `errors/layout`.
- `resources/css/app.css`: Bootstrap 5.3 theme tokens (`--cq-*`) and CodeQuest component styles. Icons are Bootstrap Icons; there is no Tailwind.
- `resources/js/`: Bootstrap JS and small page scripts, e.g. `home/try-question.js` and `forms.js`
- `tests/`: PHPUnit tests, run on in-memory SQLite (never the dev database). `tests/Feature/Content/ContentFilesTest.php` checks the real `content/` files against the rules in `content/README.md`; `tests/Feature/RoutesTest.php` checks that every route uses a controller.

## Product rules

### Learning content
- Keep lessons short and practical: start with an interactive code example, then explain. Prefer visuals over long blocks of text.
- Question types: predict the output, fill in the code, multiple choice, and simple case studies. Mix types within each level so levels don't feel repetitive.
- Every answer gets immediate feedback explaining why it is right or wrong.
- Level 1 assumes zero knowledge. Never use a concept before the lesson that introduces it.
- Lessons and questions live in `content/` as data, never hardcoded in components, so content can be updated without code changes.

### Gamification
- XP is the strongest motivator (4.64/5). Award XP for completed lessons and question sets, and keep the user's XP visible.
- The next level unlocks when [TODO: requirement, e.g. all questions done or a minimum score].
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