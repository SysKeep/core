# Using /user.php
This endpoint handles the users in the `database/` directory.<br>
All the request methods marked with :closed_lock_with_key: require authentication using the Authorization header.
```http
Authorization: Basic username:password
```
`username:password` must be encoded in base64


## POST
Crate a new user.

### Request Body Parameters
| Parameter | Type   | Required | Description                                           |
|-----------|--------|----------|-------------------------------------------------------|
| username  | string | yes      | The username used to access the database              |
| password  | string | yes      | The password used to encrypt the data in the database |
| name      | string | yes      | The user's name                                       |
| surname   | string | yes      | The user's surname                                    |

### Request Example
```http
POST /item.php HTTP/1.1
Content-Type: application/x-www-form-urlencoded

username=john&password=password123&name=John&surname=Doe
```

### Responses
* **204  No Content**:
    * The user has been created.
    * Body:
        ```
        null
        ```
* **400 Bad Request**:
    * Not all the required fields are specified.
    * Body:
        ```json
        {
            "error": "Must specify all the required fields (username, password, name, surname)"
        }
        ```
* **409 Conflict**:
    * The user already exists
    * Body:
        ```json
        {
            "error": "The user already exists"
        }
        ```


## GET (:closed_lock_with_key:)
Retrieve information about the user.

### Request Body Parameters
No parameters are required.

### Request Example
```http
GET /user.php HTTP/1.1
```

### Responses
* **200 OK**:
    * The user's object is returned in the response body
    * Example Body:
        ```json
        {
            "name":"John",
            "surname":"Doe"
        }
        ```
* **400 Bad Request**:
    * Authorization header is not valid.
    * Body:
        ```json
        {
            "error": "Invalid Authorization header format"
        }
        ```
* **401 Unauthorized**:
    * Username or password are not correct
    * Body:
        ```json
        {
            "error": "Invalid Authorization credentials"
        }
        ```


## DELETE (:closed_lock_with_key:)
Delete the user.

### Request Body Parameters
No parameters are required.

### Request Example
```http
DELETE /user.php HTTP/1.1
```

### Responses
* **204 No Content**:
    * The user has been deleted.
    * Body:
        ```
        null
        ```
* **400 Bad Request**:
    * Authorization header is not valid.
    * Body:
        ```json
        {
            "error": "Invalid Authorization header format"
        }
        ```
* **401 Unauthorized**:
    * Username or password are not correct
    * Body:
        ```json
        {
            "error": "Invalid Authorization credentials"
        }
        ```
