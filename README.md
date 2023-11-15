# FlixFlex

This repository contains the backend API source code for FlixFlex movie app.

### requirements
- PHP >= 8.1
- Composer package manager >=2
- PostgreSQL >= 14.9
### Usage
Before running the project, make sure you meet all the requirements mentioned above.

1. Rename the `.env.example` to `.env`
2. Create a database named flixflex in Postgres. You can change the name of the database in the `.env` file.
3. Run the migrations and data seeders in the shell using this command:
```shell
php artisan migrate:fresh --seed
```
Note that this step will erase all data in the `flixflex` database so be careful!

4. Run the server using this command: 
```shell
php artisan serve
```

### Available Endpoints

You can check all the endpoints using this Postman collection:

[<img src="https://run.pstmn.io/button.svg" alt="Run In Postman" style="width: 128px; height: 32px;">](https://www.postman.com/flixflex/workspace/flixflex/collection/31183614-15645d0a-aa88-41dc-bb53-14ba64253796?action=share&creator=29300535)

<p style="color:#f63;font-weight: bold">Important notice!<br><br>
All the requirements outlined in the user stories are covered in the examples of Postman.
For example, to get the top 5 movies, you can use the list movies endpoint (<code>GET /movies</code>).
Also, to get the movies in batches of 10 but with different parameters, you can use the same endpoint.<br><br> All the use cases are covered in the examples of each request!
</p>


All endpoints need API tokens to work. To get an API token, make a request to `/auth/register` or `/auth/login` endpoints (if you already have an account)

Once the API token is obtained, you can use it as A bearer token to make subsequent requests.
### Questions and technical decisions
- **Question:** When using the trailers endpoint (`/movies/`), Why can't I watch the trailer directly?
- **Answer:** Front-ends usually make requests using AJAX. This means that it's better to return the response as JSON firstly. You can find the link of the trailer to YouTube but in real-world scenarios, we should return the link from our platform and let the frontend handle it accordingly.


- **Question:** Why not implement email verification?
- **Answer:** Two reasons why it's not implemented:
  1. It's outside the scope of this test.
  2. It's nopt required by the user stories in the given PDF.


- **Question:** Why not implement different endpoints for getting the top movies and all movies?
- **Answer:** This will result into more unnecessary code. Besides, we can offer both functionalities and way more using the same endpoint by making use of query parameters as you can see in the Postman examples of `list movies` endpoint. 


- **Question:** Why not use JWT tokens?
- **Answer:** JWT tokens are valid to be used in this case, but since the time is limited and the focus is on making the requirements available and for the sake of simplicity, I decided to use simple API keys instead. 
