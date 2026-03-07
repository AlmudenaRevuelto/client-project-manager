# Client & Project Manager

Full-stack web application to manage clients and their projects.

## Tech Stack
- PHP
- MySQL
- JavaScript
- HTML & CSS

## Features
- CRUD for clients
- CRUD for projects
- Client-project relationship

## Project Structure
Backend and frontend are separated for better maintainability.

## Backend Status
The backend currently exposes basic client management endpoints using a custom PHP router and a layered architecture (Controller, Service, Repository).

### API Features
- Full CRUD for Clients
- REST API architecture
- Dockerized environment
- MySQL persistence
- Postman collection included

## Database
The project uses a MySQL database initialized automatically via Docker.

Tables:
### clients
- id
- name
- email
- created_at

### projects
- id
- client_id
- name
- description
- status
- created_at