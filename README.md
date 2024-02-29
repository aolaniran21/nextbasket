# Nextbasket Task

We've got two microservices

1. Users
2. Notifications

## Installation

1.  **Clone the Repository:**
    `git clone https://github.com/aolaniran21/nextbasket.git`

2.  **CD into project** `cd nextbasket`

3.  **Docker:** Run docker-compose up in terminal

4.  **Run User:** cd into user folder and run php spark serve --port 9000

## Using Postman to Create a New User

1.  **URL:** Open Postman and hit the following URL with a POST request:

        URL: http://localhost:9000/users
        Body: {"email": "test@gmail.com","firstName": "test","lastName": "test"}

## How to run the tests?

1.  Navigate to the users or notification project and run next command:

         phpunit tests
