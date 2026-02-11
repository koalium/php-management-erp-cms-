# PHP ERP Backend API

Frontend applications should communicate only with `apim.php`.

## Setup

1. Create database and user in MySQL.
2. Configure connection env vars: `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`.
3. Import schema:

```bash
mysql -u root -p "$DB_NAME" < src/www/schema.sql
```

## Endpoint

Use HTTP GET/POST to `apim.php` with `action`.

### Public actions
- `action=health`
- `action=register` with JSON body: `email`, `password`, `full_name`
- `action=oauth/token` with JSON body: `client_id`, `client_secret`, `email`, `password`

### Protected actions (Bearer token)
- `action=company/create`
- `action=budget/create`
- `action=transaction/create`
- `action=company/dashboard&company_id=...`

## Notes
- API includes auth, OAuth password grant style token issuing, company/user administration base, and financial budgeting/transaction modules.
- `schema.sql` uses `CREATE TABLE IF NOT EXISTS` and `INSERT IGNORE` for defaults.
