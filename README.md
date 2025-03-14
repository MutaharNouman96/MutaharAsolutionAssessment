# Asolutions Assessment Task

## Overview
This project is a Laravel-based RESTful API that provides user authentication, project management, dynamic attributes using the Entity-Attribute-Value (EAV) model, and advanced filtering capabilities. The API allows users to manage projects and log work hours efficiently.

## Features
### Part 1: Core Models & Relations
- **User**: Contains `first_name`, `last_name`, `email`, and `password` fields.
- **Project**: Includes `name` and `status` fields.
- **Timesheet**: Tracks `task_name`, `date`, and `hours` worked.
- **Relationships**:
  - A user can be assigned to multiple projects.
  - A project can have multiple users.
  - A user can log timesheets for multiple projects.
  - Each timesheet entry is linked to a single user and a single project.

### Part 2: EAV (Entity-Attribute-Value) Implementation
- **Attribute Model**: Stores `name` and `type` (text, date, number, select).
- **AttributeValue Model**: Stores `attribute_id`, `entity_id`, and `value`.
- **Dynamic Attributes for Projects**:
  - Example fields: `department`, `start_date`, `end_date`.
  - API endpoints to:
    - Create/Update attributes.
    - Assign attributes to projects.
    - Fetch projects with dynamic attributes.
    - Filter projects using dynamic attributes.

### Part 3: API Endpoints
- **Authentication**:
  - `POST /api/register` - Register a new user.
  - `POST /api/login` - Authenticate user.
  - `POST /api/logout` - Logout user.
- **CRUD Operations**:
  - `GET /api/{model}` - Fetch all records.
  - `GET /api/{model}/{id}` - Fetch a single record.
  - `POST /api/{model}` - Create a new record.
  - `PUT /api/{model}/{id}` - Update a record.
  - `DELETE /api/{model}/{id}` - Delete a record.

### Part 4: Filtering
- Flexible filtering on standard and dynamic attributes.
- Example:
  ```sh
  GET /api/projects?filters[name]=ProjectA&filters[department]=IT
  ```
- Supported operators: `=`, `>`, `<`, `LIKE`.

## Setup Instructions
1. Clone the repository:
   ```sh
   git clone https://github.com/your-repo.git
   cd your-repo
   ```
2. Install dependencies:
   ```sh
   composer install
   ```
3. Configure environment:
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```

## Database Setup
You have two options for setting up the database:

### Option 1: Using Migrations and Seeders
1. Configure your database settings in `.env`:
   ```sh
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```
2. Run database migrations and seeders:
   ```sh
   php artisan migrate --seed
   ```

### Option 2: Using SQL Dump File
1. Download the SQL dump file from Dropbox:
   in folder Database SQL Dump
2. Import the SQL dump into your database using MySQL:
   ```sh
   mysql -u your_username -p your_database_name < path/to/dump.sql
   ```

## API Documentation
- Full API documentation can be found on **Postman**: [Postman API Collection](https://www.postman.com/bold-moon-385171/workspace/a-solution-project-api/request/17206824-7a21b970-d789-48b0-910c-6698cdda3cd7?action=share&creator=17206824&ctx=documentation&active-environment=17206824-fe66bc67-d2ec-49f4-b94e-2f2fd3d60b59)

## Authentication
- The API uses **Bearer Token** authentication.
- To authenticate:
  1. Register or login to receive an authentication token.
  2. Include the token in the `Authorization` header for all authenticated requests.
  ```sh
  Authorization: Bearer YOUR_ACCESS_TOKEN
  ```
- The API supports environments for both **local** and **live URLs**. Set the correct environment in your Postman or `.env` file accordingly.

## Example Requests & Responses
### Example Request:
```sh
GET {{url}}/project?filters[department]=Media
```
### Example Response:
```json
[
    {
        "id": 1,
        "name": "Project Conroy-Schoen",
        "status": "1",
        "deleted_at": null,
        "created_at": "2025-03-14T08:13:32.000000Z",
        "updated_at": "2025-03-14T08:13:32.000000Z",
        "attributes": [
            {
                "id": 1,
                "name": "start_date",
                "type": "date",
                "pivot": {
                    "project_id": 1,
                    "attribute_id": 1,
                    "value": "2025-03-14"
                }
            },
            {
                "id": 2,
                "name": "end_date",
                "type": "date",
                "pivot": {
                    "project_id": 1,
                    "attribute_id": 2,
                    "value": "2025-07-23"
                }
            },
            {
                "id": 3,
                "name": "department",
                "type": "text",
                "pivot": {
                    "project_id": 1,
                    "attribute_id": 3,
                    "value": "Media"
                }
            },
            {
                "id": 4,
                "name": "members",
                "type": "number",
                "pivot": {
                    "project_id": 1,
                    "attribute_id": 4,
                    "value": "15"
                }
            }
        ]
    }
]
```

## Test Credentials
Use the following test credentials to authenticate:
- **Email**: `testuser.1@example.net`
- **Password**: `password123`

## License
This project is licensed under the MIT License.

