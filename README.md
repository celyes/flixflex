# FlixFlex

This repository contains the backend API source code for the FlixFlex movie app.

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


> [!warning]  
> All the requirements outlined in the user stories are covered in the examples of Postman.
>
> For example, to get the top 5 movies, you can use the list movies endpoint (<code>GET /movies</code>).
>
>
> Also, to get the movies in batches of 10, You can use the same endpoint but with different query parameters.


All endpoints need API tokens to work. To get an API token, make a request to `/auth/register` or `/auth/login` endpoints (if you already have an account)

Once the API token is obtained, you can use it as A bearer token to make subsequent requests.
### Questions and technical decisions

- **Question:** When using the trailers endpoint (`/movies/`), Why can't I watch the trailer directly?
- **Answer:** Front-ends usually make requests using AJAX. This means that it's better to return the response as JSON first. You can find the link to the trailer on YouTube but in real-world scenarios, we can respond with the link from our platform servers (not necessarily the API but it can be our streaming for example)  and let the front-end handle it accordingly (if this is the requirement).


----------------------


- **Question:** Why not implement email verification?
- **Answer:** Two reasons why it's not implemented:
  1. It's outside the scope of this test.
  2. It's not required by the user stories in the given PDF.


----------------------


- **Question:** What data source did you use?
- **Answer:** For the sake of illustration, I picked up a sample of 20 movies from OMDB (Open Movie Database). 20 movies are enough to give examples of the application's pagination functionality as well as other functions. I also studied using TMDB but they require you to submit a request and wait which meant wasted time. Wasting time is the last thing one wants to do in this case. 


----------------------


- **Question:** Why not implement different endpoints for getting the top movies and all movies?
- **Answer:** This will result in more unnecessary code. Besides, we can offer both functionalities and way more using the same endpoint by making use of query parameters as you can see in the Postman examples of `list movies` endpoint. 


----------------------


- **Question:** Why not use JWT tokens?
- **Answer:** JWT tokens are valid to be used in this case, but since the time is limited and the focus is on making the requirements available and for the sake of simplicity, I decided to use simple API keys instead. 
