
# Task Management API (Laravel + Sanctum)

A simple, secure **task management REST API** built using **Laravel 10** and **Sanctum** for authentication.  
Users can register, login, and manage their personal tasks with full CRUD operations, filtering, validation, and pagination.

---

##  Features

### **1. Users**
- Register & login with hashed passwords  
- Authenticated using **Sanctum API tokens**

### **2. Tasks**
Each task includes:
- `title`
- `description`
- `status` (`pending`, `in-progress`, `completed`)
- `user_id` (task owner)

Users can:
- Create tasks  
- List their own tasks  
- Filter by status  
- View a single task  
- Update their tasks  
- Delete their tasks  
- Access **only their own tasks**

### **3. Validation**
- Handled using `StoreTaskRequest` and `UpdateTaskRequest`.

### **4. Filtering & Pagination**
- `GET /api/tasks?status=pending`  
- Pagination: **10 per page**

### **5. Testing**
Feature tests included for:
- Task creation  
- Validation errors  

---

##  Installation

### **1. Clone the Repository**

[GitHub Repository](https://github.com/Peud001/tms-api)

```bash
git clone https://github.com/Peud001/tms-api.git
cd tms-api
````

### **2. Install dependencies**

```bash
composer install
```

### **3. Setup environment file**

```bash
cp .env.example .env
```

Edit `.env`:

```
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### **4. Generate app key**

```bash
php artisan key:generate
```

### **5. Run migrations**

```bash
php artisan migrate
```

### **6. Serve the app**

```bash
php artisan serve
```

API will be available at:

```
http://127.0.0.1:8000
```

---

##  Authentication

### **Register**

**POST** `/api/register`

```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "secret",
  "password_confirmation": "secret"
}
```

### **Login**

**POST** `/api/login`

```json
{
  "email": "john@example.com",
  "password": "secret"
}
```

**Response:**

```json
{
  "token": "generated-token-here"
}
```

Use the token for all authenticated requests:

```
Authorization: Bearer <token>
```

---

##  Task Endpoints (Authenticated Only)

### **List all tasks**

**GET** `/api/tasks`

Filtering:

```
/api/tasks?status=pending
```

### **Create a task**

**POST** `/api/tasks`

```json
{
  "title": "Buy groceries",
  "description": "Milk, eggs, bread",
  "status": "pending"
}
```

### **Get single task**

**GET** `/api/tasks/{id}`

### **Update task**

**PUT** `/api/tasks/{id}`

```json
{
  "title": "Updated title",
  "status": "completed"
}
```

### **Delete task**

**DELETE** `/api/tasks/{id}`

---

##  API Error Responses

All errors follow this structure:

```json
{
  "status": "error",
  "message": "Error description",
  "errors": {
    "field": ["Validation message"]
  }
}
```

| Status  | Meaning                   |
| ------- | ------------------------- |
| **401** | Unauthenticated           |
| **403** | Forbidden (not your task) |
| **404** | Task not found            |
| **422** | Validation failed         |
| **500** | Server error              |

---

##  Project Structure Highlights

* `TaskResource` → clean API response formatting
* `StoreTaskRequest` / `UpdateTaskRequest` → validation logic
* `TaskController` → business logic & ownership checks
* `Handler.php` → centralized exception handling
* `api.php` → routes protected with Sanctum middleware

---

##  Testing

Run all tests:

```bash
php artisan test
```

Includes:

* Task creation
* Validation errors
* Authentication

---

##  Design Approach

* **Sanctum** chosen for lightweight token-based authentication
* **FormRequest validation** keeps controllers clean
* **Task ownership checks** ensure users only manage their own resources
* **Resource classes** give consistent output
* **Centralized error handler** produces unified responses
* **Pagination** ensures scalability

---

##  Notes

* Passwords automatically hashed via `$casts`
* Sensitive fields hidden (`password`, `remember_token`)
* Works seamlessly with Postman, Insomnia, Hoppscotch, etc.


