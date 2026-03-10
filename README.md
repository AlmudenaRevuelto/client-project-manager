# Developer Project Portfolio

Personal developer portfolio built with **PHP, Docker, MySQL and Twig** following an **MVC architecture**.

This project acts as a **central hub for showcasing software projects**, allowing them to be organised, described and linked to their respective repositories or live demos.

The goal of this project is both:

* to serve as a **technical portfolio**
* and to demonstrate **backend architecture, API design and containerised development**

---

# Project Overview

This application provides a system where **projects can be registered, managed and displayed**.

Each project can contain information such as:

* name
* description
* programming language
* framework
* GitHub repository
* live demo link
* status

The frontend renders project information using **Twig templates**, while the backend exposes a **REST API** that manages all data.

---

# Tech Stack

### Backend

* PHP
* REST API
* MVC architecture
* MySQL
* PDO

### Frontend

* Twig
* HTML
* CSS
* Vanilla JavaScript

### Infrastructure

* Docker
* Apache
* MySQL
* phpMyAdmin

### Tools

* Postman (API testing)
* Git / GitHub

---

# Architecture

The project is divided into two main layers:

```
frontend
   ↓
Backend API
   ↓
Database
```

### Backend

```
backend
 ├── public
 ├── src
 │   ├── Controllers
 │   ├── Services
 │   ├── Repositories
 │   └── Models
```

Responsibilities:

* Controllers → handle HTTP requests
* Services → business logic
* Repositories → database access
* Models → domain entities

---

### Frontend

```
frontend
 ├── public
 ├── src
 │   └── Controller
 ├── templates
 └── assets
```

Responsibilities:

* Controllers → fetch data from API
* Twig templates → render views
* CSS / JS → presentation and behaviour

---

# Running the Project

Requirements:

* Docker
* Docker Compose

Start the environment:

```
docker compose up --build
```

Application will be available at:

```
http://localhost:8000
```

---

# API Endpoints

Example endpoints available in the backend API:

```
GET    /api/clients
POST   /api/clients
GET    /api/projects
POST   /api/projects
PUT    /api/projects/{id}
DELETE /api/projects/{id}
```

The API can be tested using **Postman**.

---

# Database

Database schema is located in:

```
database/schema.sql
```

It is automatically loaded when the MySQL container starts.

---

# Development Goals

This project is intentionally built without large frameworks in order to:

* better understand **backend architecture**
* practise **clean MVC structure**
* learn **Docker based development**
* integrate **frontend templating with Twig**

Future improvements will include:

* project tagging / technologies
* GitHub integration
* project screenshots
* improved frontend interface
* search and filtering

---

# Author

Almudena Revuelto
Software Developer
