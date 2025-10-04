# Widitrade - Product Listing Platform

This project was generated with [Symfony](https://symfony.com/) and uses MongoDB as the database. 
The application displays a list of top soundbar products with authentication to restrict accessy.

## Tech Stack

- Backend Framework: Symfony 6.4.26 (latest LTS version)
- Database: MongoDB 6.0.26
- Containerization: Docker + Docker Compose
- Frontend: Twig templates
- Authentication: Symfony Security with form login

## Requirements

Before running the application, ensure you have:

- Docker Desktop installed and running
- Git for version control

## Architecture

The application runs in Docker containers:
- PHP 8.2-FPM: Application server with MongoDB extension
- Nginx Alpine: Web server
- MongoDB 6.0: NoSQL database

## Dependencies

- doctrine/mongodb-odm-bundle providing MongoDB ODM integration
- symfony/security-bundle providing authentication and authorization
- symfony/maker-bundle for code generation (dev only)

## Getting Started

- Clone the repository
- Environment variables already set in .env
- Run `docker-compose build` to build Docker images
- Run `docker-compose up -d` to start containers
- Run `docker exec -it widi_php composer install` to install dependencies
- Run `docker exec -it widi_php php bin/console app:create-user` to create demo user
- Run `docker exec -it widi_php php bin/console app:import-products` to import products (obtained from json data file in the project)

## Build

Run `docker-compose up -d` to serve the project. The application will be available at http://localhost:8080

## Using the Application

### Login:
Access http://localhost:8080 and use the demo credentials:
- Email: cliente@widi.com
- Password: password123

You will be redirected to the product listing page.

### Product Listing:
View top 10 soundbar products with ratings, features, and pricing information. Each product displays a rating score, star rating, brand, discount badges, and shipping information.

### Product Details:
Click "Mostrar más" to expand product features and specifications. Click "Mostrar menos" to collapse the details. Products start in collapsed state by default.

### Buy Products:
Click "Comprar ahora" buttons to be redirected to the product's Amazon page in a new tab.

### Logout:
When you're ready to log out, click on the "Cerrar Sesión" button in the header. You will be logged out of your account and redirected to the login page.
