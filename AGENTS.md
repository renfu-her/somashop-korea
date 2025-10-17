# Repository Guidelines

Contribute to SOMA SHOP by following these repository-specific practices.

## Project Structure & Module Organization
- Laravel application code lives in `app/`; `app/Http/Controllers/Frontend` and `app/Http/Controllers/Admin` separate storefront and dashboard logic.
- Domain models sit in `app/Models`, shared helpers in `app/Services`, and HTTP entry points in `routes/web.php` and `routes/api.php`.
- Views use `resources/views/frontend` and `resources/views/admin`, while Vite assets reside in `resources/js` and `resources/css`.
- Persist schema changes in `database/migrations` (plus `database/seeders` when needed) and keep related tests under `tests/Feature` or `tests/Unit`.

## Build, Test, and Development Commands
- `composer install` / `npm install`: install PHP and Node dependencies.
- `php artisan serve`: start the local server at `http://127.0.0.1:8000`.
- `php artisan migrate --seed`: apply migrations and load baseline catalog data.
- `npm run dev` or `npm run build`: compile Vite assets for development or production.
- `php artisan test`: execute the PHPUnit suite; add `--filter` to narrow runs.

## Coding Style & Naming Conventions
- Follow PSR-12: 4-space indentation, PascalCase classes, camelCase methods, snake_case database columns.
- Controllers end with `Controller`, models use singular nouns, and Blade templates favor hyphenated, descriptive filenames (e.g., `checkout-summary.blade.php`).
- Keep Vue/JS components in `resources/js/components` and align naming with the Blade view that mounts them.

## Testing Guidelines
- Favor Feature tests for HTTP flows and Unit tests for service classes; mirror production namespaces.
- Use expressive method names (`test_guest_cannot_checkout`) so CI output stays readable.
- Seed only the data required for the scenario by using factories and the `RefreshDatabase` trait.

## Commit & Pull Request Guidelines
- Write imperative, sentence-case commit subjects as seen in history (e.g., `Update social link section.`) and add context in the body if non-obvious.
- Keep each commit focused; do not mix asset builds with PHP logic changes.
- PRs should describe intent, link issues, call out migrations, and include UI screenshots or screencasts for view changes.

## Security & Configuration Tips
- Keep secrets in `.env`; share ECPay and logistics keys through secure channels and never commit them.
- Run `php artisan key:generate` for new environments and rotate keys when access changes.
- Validate third-party callbacks via ngrok or sandbox credentials before promoting to staging.
