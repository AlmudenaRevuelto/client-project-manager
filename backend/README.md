# Backend

PHP backend for the Client & Project Manager application.

## Structure
- `config/` – Configuration files (database connection, environment)
- `src/` – Application source code
- `public/` – Entry point for HTTP requests (future API)

## Architecture
The backend follows a simple layered architecture:
- Models represent domain entities
- Repositories handle database access
- Services contain business logic
- Controllers manage request handling (to be implemented)

## Entry Point
All HTTP requests are handled through `public/index.php`, acting as a front controller and routing requests to the appropriate controllers.


## Client Endpoints
| Method | Endpoint | Description |
|------|------|------|
| GET | /clients | List all clients |
| GET | /clients/{id} | Get client by id |
| POST | /clients | Create client |
| PUT | /clients/{id} | Update client |
| DELETE | /clients/{id} | Delete client |

## Project Endpoints
| Method | Endpoint | Description |
|------|------|------|
| GET | /projects | List all projects |
| POST | /projects | Create project |
| GET | /clients/{id}/projects | List projects for a client |
