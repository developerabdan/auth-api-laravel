<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://packagist.org/packages/laravel/sanctum"><img src="https://img.shields.io/packagist/v/laravel/sanctum" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/sanctum"><img src="https://img.shields.io/packagist/l/laravel/sanctum" alt="License"></a>
</p>

# Laravel Authentication API with Sanctum

A robust, secure, and well-tested Laravel API authentication system using Laravel Sanctum for token-based authentication. This project implements SOLID principles for clean, maintainable code architecture.

## Overview

This project provides a complete authentication API solution built with Laravel, featuring:

- **Token-based Authentication** using Laravel Sanctum
- **SOLID Principle Implementation** for maintainable architecture
- **Comprehensive Test Coverage** for all endpoints
- **Clean, RESTful API Design**

## Architecture

The project follows SOLID principles for clean code and maintainability:

- **Single Responsibility Principle**: Each class has one responsibility (e.g., `SanctumServices` handles only authentication logic)
- **Open/Closed Principle**: Architecture allows extending functionality without modifying existing code
- **Liskov Substitution Principle**: Service implementations can be substituted without affecting behavior
- **Interface Segregation Principle**: Focused interfaces like `AuthServiceInterface` define clear contracts
- **Dependency Inversion Principle**: High-level modules depend on abstractions (e.g., controllers depend on interfaces)

## API Endpoints

### Authentication

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|--------------|
| POST | `/api/register` | Register a new user | No |
| POST | `/api/login` | Login and get access token | No |
| GET | `/api/user` | Get authenticated user details | Yes |

### Request Examples

#### Register a New User

```http
POST /api/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123"
}
```

#### Login

```http
POST /api/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "password123"
}
```

#### Get User Profile

```http
GET /api/user
Authorization: Bearer {your_access_token}
```

## Testing

The application includes comprehensive test coverage for all API endpoints:

- Registration success and failure scenarios
- Authentication validation
- Access control enforcement
- Input validation

Run the tests with:

```bash
php artisan test
```

### Postman Collection

A Postman collection is available to easily test all API endpoints:

[Auth API Laravel Postman Collection](https://www.postman.com/teambull/workspace/auth-api-laravel)

Import this collection to quickly test the authentication flow.

## Installation

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   ```
3. Configure environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Run migrations:
   ```bash
   php artisan migrate
   ```
5. Start the server:
   ```bash
   php artisan serve
   ```

## Technology Stack

- **Laravel**: PHP framework for web development
- **Sanctum**: Laravel's lightweight authentication system
- **PHPUnit**: Testing framework default by Laravel

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Author

@abdansyakuro.id
