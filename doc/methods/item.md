# Using /item.php
This endpoint handles the items in the vault.<br>
All the request methods require authentication using the Authorization header.
```http
Authorization: Basic username:password
```
Where "`username:password`" must be encoded in base64.<br>
If the Authorization header has an invalid format a **400** HTTP status code with the following body is returned:
```json
{
    "error": "Invalid Authorization header format"
}
```
If the username or password are incorrect a **401** HTTP status code with the following body is returned:
```json
{
    "error": "Invalid Authorization credentials"
}
```



## POST
Adds a new item to the vault.

### Request Body Parameters
All the [ALLOWED_ITEM_KEYS](https://github.com/SysKeep/core/blob/main/doc/env-usage.md) as strings, at least one from the list is required.

### Request Example
```http
POST /item.php HTTP/1.1
Content-Type: application/x-www-form-urlencoded

type=password&website=https://example.com&username=email@example.com&password=StrongPassword123
```

### Responses
* **204 No Content**:
    * The item has been created.
    * Body:
        ```
        null
        ```
* **400 Bad Request**:
    * At least one optional parameter must be specified.
    * Example Body:
        ```json
        {
            "error": "Must specify at least one key (type, website, username, password, description)"
        }
        ```


## GET
Retrieve information about an item or the entire vault.

### Request Body Parameters
| Parameter | Type | Required | Description                                                        |
|-----------|------|----------|--------------------------------------------------------------------|
| id        | int  | no       | The ID of the item to get, if not specified all items are returned |

### Request Example
```http
GET /item.php?id=1 HTTP/1.1
```

### Responses
* **200 OK**:
    * The item's (or an array of items) object is returned in the response body.
    * Example Body:
        ```json
        {
            "type":"password",
            "website":"https://example.com",
            "username":"email@example.com",
            "password":"StrongPassword123"
        }
        ```
* **404 Not Found**:
    * The Item was not found
    * Body:
        ```json
        {
            "error": "Item not found."
        }
        ```


## DELETE
Delete an item.

### Request Body Parameters
| Parameter | Type | Required | Description                    |
| --------- | ---- | -------- | ------------------------------ |
| id        | int  | yes      | The ID of the item to delete   |

### Request Example
```http
DELETE /item.php HTTP/1.1
```

### Responses
* **204 No Content**:
    * The item has been deleted.
    * Body:
        ```
        null
        ```
* **404 Not Found**:
    * The Item was not found
    * Body:
        ```json
        {
            "error": "Item not found."
        }
        ```