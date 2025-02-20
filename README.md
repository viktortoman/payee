# SETUP - INSTALLATION

    1. Clone the repository
    2. cd payee
    3. cp .env.example .env
    4. Set the environment variables in the .env file
    3. docker-compose up --build -d

# CHECK CONTAINERS
    1. docker ps

# CHECK LOGS
    1. docker logs -f payee_backend
    2. docker logs -f payee_frontend

# URL
    1. Backend: http://localhost:8000
    2. Frontend: http://localhost:4200
    3. MySQL: http://localhost:3306
    4. Swagger API Documentation: http://localhost:8000/api/documentation

# USAGE
    1. Store alapkamat.xlsx file in the storage folder if you want to change the content
    2. Run php artisan app:parse-interest-rates-xlsx-command to parse the XLSX file
    3. Regenerate the Swagger API Documentation: php artisan l5-swagger:generate
