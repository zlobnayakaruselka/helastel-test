# helastel-test

## Installation
   Requirements:
   * PHP 7.3.*
   * mysql для применения схемы и фикстур (brew install mysql)
   * docker

## Install docker percona image and load fixtures
```
$ docker-compose up -d
$ cd ./tools/ && sh fixtures_loader.sh
```

## Start server
Run server

```
$ cd ../public/
$ php -S localhost:8090
``` 

Go to http://localhost:8090 (get 404)

## Routes
#### Get all authors
```
GET http://localhost:8090/authors
```

#### Get all books
```
GET http://localhost:8090/books
```

#### Get books by author id (author_id is integer)
```
GET http://localhost:8090/authors/{author_id}/books
```
example
```
GET http://localhost:8090/authors/3/books
```

#### Get authors by book id (book_id is integer)
```
GET http://localhost:8090/books/{book_id}/authors
```
example
```
GET http://localhost:8090/books/1/authors
```

#### Get books with {N} authors (N is integer)
```
GET http://localhost:8090/books/authors?count={N}
```
example
```
GET http://localhost:8090/books/authors?count=3
```
