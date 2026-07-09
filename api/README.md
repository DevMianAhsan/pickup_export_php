# Catalog API

## Endpoints
- GET /api/catalog/makers
- GET /api/catalog/brands
- GET /api/catalog/types

## Optional filtering
- Add `?active=1` to return only active records.

## Security
- CORS is limited to local React dev origins.
- Access is protected with a Bearer token.
- Send `Authorization: Bearer <token>` or `X-API-Key: <token>`.
- For local testing, the default token is `pickup-export-demo-token` unless you set `PICKUP_EXPORT_API_TOKEN` in your server environment.
