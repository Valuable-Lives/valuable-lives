# Claude Code Notes

## Git Commits

Commit messages must be a single sentence with NO attribution. No "Co-Authored-By", no multi-line messages. Just one short sentence.

## Project Links

- **GitHub repo:** https://github.com/Valuable-Lives/valuable-lives
- **Project board:** https://github.com/orgs/Valuable-Lives/projects/1
- **SRS:** `../vl-project-docs/Valuable Lives SRS - July 2026.md`
- **Data matcher (internal tool):** https://github.com/Valuable-Lives/vl-data-matcher (sibling project at `../lbs-explorer/`)
- **Forge server:** https://forge.laravel.com/james-alvarez/valuable-lives (server ID 1167795)

## Development Environment

This project uses Laravel Sail (Docker) with MySQL and Mailpit.

```bash
sail up -d
sail artisan migrate
sail artisan db:seed
sail composer install
sail npm install
sail npm run dev
```

## Key Technologies

- Laravel 13 with Blade + Vue components
- MySQL (app database)
- Mailpit (local email testing)
- Meilisearch (planned, for full-text search)
- Leaflet.js (planned, for maps)
- D3.js (planned, for charts and family trees)

## Database

Single MySQL database for all VL data. The LBS database will be read-only via a separate connection (not yet configured).

Core entities: `individuals`, `individual_registers`, `holdings`, `holding_registers`, `enslavers`, `enslaver_holdings`, `life_events`, `relationships`, `relationship_types`, `parishes`, `glossary_terms`, `record_annotations`.

## Fake Data

```bash
sail artisan migrate:fresh --seed
```

Generates ~1,100 individuals, ~50 holdings, ~90 enslavers, relationships, life events, glossary terms, and annotations using historically appropriate Jamaican register-period data.
