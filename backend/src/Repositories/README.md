# Repositories

Data access layer of the application.

## Responsibility
Repositories are responsible for:
- Executing database queries
- Mapping database rows to models
- Isolating persistence logic from business logic

They do not contain business rules.

## Current Repositories
- `ClientRepository` – Handles persistence for Client entities
