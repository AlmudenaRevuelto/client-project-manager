# Services

Business logic layer of the application.

## Responsibility
Services coordinate application logic and use repositories to access data.

They:
- Apply business rules
- Orchestrate multiple repositories if needed
- Expose use cases to controllers

They do not contain persistence or presentation logic.
