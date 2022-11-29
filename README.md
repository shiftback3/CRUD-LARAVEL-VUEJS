# crud-app

This simple application is to demostration CRUD activities in a fullstack env.
On the Backend a restfulcontroller tecnique was deployed to help build crud apps faster by writting a single controller to take care of multiple crud actions.
On the frontend a simple design patter was used in the dataservice to help minize the number calls you can write to fetch data from the backend.

i hope this is useful.

## Recommended IDE Setup

[VSCode](https://code.visualstudio.com/) 

## Configuration and Setup

clone, fork or download the zip folder
locate the "crud-backend folder" and open the terminal on your code editor, run the follow command:
```
composer update

```
```
php artisan migrate
```

```
php artisan db:seed
```

```
php artisan serve
```

next, locate the "crud-frontend" folder and run:
```
npm i
```
```
npm run dev
```
## view Output
open your browser with the port eg "localhost:8080"
