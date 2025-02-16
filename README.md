# BACKEND TEST PROJECT

## Requirements
### Techs:
- Docker
- Docker Compose

## Setup
### 1. Run Project with Docker Compose
```bash
docker compose up --build
```

### 2. Create `.env` File
```bash
copy .env.example .env  # Windows
# OR
cp .env.example .env  # macOS/Linux
```

### 3. Access PHP Container
```bash
docker compose exec app sh
```

### 4. Install Dependencies
```bash
composer install
```

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Run Database Migrations
```bash
php artisan migrate
```

### 7. Seed Database (Optional, for testing)
```bash
php artisan db:seed
```

## View project: 
- Web: http://localhost:8080
- Phpmyadmin: http://localhost:8081
- Default account: admin@gmail.com / assword
