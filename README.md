# Laravel Blog API

## Project Overview
This project is a RESTful API built with Laravel 11.x for a simple blog application. It includes features for creating, reading, updating, and deleting blog posts, utilizing Laravel Passport for authentication.

## Table of Contents
- [Technologies Used](#technologies-used)
- [Setup Instructions](#setup-instructions)
- [API Endpoints](#api-endpoints)
- [Authentication](#authentication)
- [Unit Testing](#Unit-Testing)
- [Live Demo](#Live-Demo)
- [Continuous Integration/Deployment](#continuous-integrationdeployment)
- [License](#license)

## Technologies Used
- **PHP 8.3**
- **Laravel 11.x**
- **MySQL 8.0**
- **Docker**
- **GitHub Actions for CI/CD**
- **Postman for API testing**

## Setup Instructions

### Prerequisites
- Docker and Docker Compose installed on your machine.
- Access to a command line interface.

### Cloning the Repository
```
git clone <repository-url>
cd <repository-directory>
```

### Docker Setup
- **Build and run the Docker containers:**
```
docker-compose up --build -d
```
- **Running Migrations:**
```
docker-compose exec app php artisan migrate
```
- **Generating Client Credentials:**
```
docker-compose exec app php artisan passport:client --personal
```
**Take note of the client_id and client_secret.**

### The API is accessible at:
- API Base URL: http://localhost:8080/api/posts

## API Endpoints
- POST ```/oauth/token``` - Generate access tokens.
- GET ```/api/posts``` - List all posts.
- POST ```/api/posts``` - Create a new post.
- GET ```/api/posts/{id}``` - Retrieve a specific post.
- PUT ```/api/posts/{id}``` - Update a post.
- DELETE ```/api/posts/{id}``` - Delete a post.

## Authentication 
- Use Postman to authenticate:
  - Create a new request and set the method to POST.
  - Enter the URL: http://localhost:8080/oauth/token.
  - In the Body, select form-data and include the following:
    ```
    grant_type: password
    client_id: xxxx
    client_secret: xxxx
    username: xx@xxx.xx
    password: xxxxx
    ```
- After successful authentication, save the ```access_token``` and ```refresh_token``` for further requests.

## Post Creation Payload (Using generated access_token as Bearer Token for authorization)
```
{
    "title": "QA Automation",
    "content": "QA Automation Science",
    "author": "QA Tester",
    "status": "draft" // Optional, defaults to "draft"
}
```

## Unit Testing
```
docker-compose exec app php artisan test
```

## Live Demo
A live demo has been made available for testing purposes.
* Get client_id and client_secret from here: [Get Testing Client](https://github.com/Godwill-Kemmoe-Development/LaravelBlogApi/issues/1)
* Use https://blogapi.godwillkemmoe.com/oauth/token to generate ```access_token``` and ```refresh_token```:
  ```
  grant_type: password
  client_id: xxxx
  client_secret: xxx
  username: qa@tester.com
  password: testerpassword
  ```
* Play with the endpoints

## Continuous Integration/Deployment
*This project uses GitHub Actions for CI/CD. On each push or merge to the master branch, the application will automatically deploy to the production environment.*

## License
All rights reserved. Made with love by [Godwill Kemmoe](https://www.godwillkemmoe.com).
