# Chart API

This is an API created for my project submission for my code challenge at Customerix.

## Getting Started

Before getting started, you will need to have [PHP](https://www.php.net/manual/en/install.php) and [Composer](https://getcomposer.org/download/) installed. Once done, follow the steps below:

1. Fork and clone this repository.

2. Navigate into your newly created directory.

3. To run the migrations, run the command `php artisan migrate`.

4. Run `php artisan serve` to start your server on port 8000.


## API Endpoints Available

Here are the various endpoints available.

### 1. Sign Up

This is the endpoint for creating a new account/ signing up.

```http
POST /api/register
```

| Parameter | Type | Description |
| :--- | :--- | :--- |
| `name` | `string` | **Required**. A username |
| `email` | `string` | **Required**, **unique**. An email |
| `password` | `string` | **Required**. A password |
| `confirm_password` | `string` | **Required**. A password |

#### Responses

```javascript
{
    "message": string,
    "token": string,
}
```

#### Status Codes
| Status Code | Description |
| :--- | :--- |
| 201 | `CREATED` |
| 500 | `INTERNAL SERVER ERROR` |

### 2. Login

This is the endpoint for logging in a user based on existing credentials.

```http
POST /api/login
```

| Parameter | Type | Description |
| :--- | :--- | :--- |
| `email` | `string` | **Required**. Your email address |
| `password` | `string` | **Required**. Your password |

#### Responses

```javascript
{
    "token": "string",
    "message": "string",
}
```

#### Status Codes

| Status Code | Description |
| :-- | :-- |
| 200 | `OK` |
| 500 | `INTERNAL SERVER ERROR` |

### 3. Products

This is the endpoint for getting, posting, updating and deleting products.

```http
GET /api/products
```

#### Responses

```javascript
[
    {
        "id": int,
        "name": string,
        "details": string,
        "category_id": int,
        "created_at": datetime,
        "updated_at": datetime,
    },
],
```

#### Status Codes

| Status Code | Description |
| :-- | :-- |
| 200 | `OK` |

### 4. Categories