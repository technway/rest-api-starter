<h1>API Tests for REST API Starter</h1>

This directory contains API test files for the **REST API Starter** theme. These tests are organized into three files:

1. **`authenticate.http`** - Handles authentication to obtain a JWT token.
2. **`get-requests.http`** - Contains all GET requests for retrieving WordPress data.
3. **`post-requests.http`** - Contains all POST requests for creating or updating data (requires authentication).

---

- [Prerequisites](#prerequisites)
  - [Install REST Client Extension](#install-rest-client-extension)
  - [Configure Variables](#configure-variables)
- [File Descriptions](#file-descriptions)
  - [**`authenticate.http`**](#authenticatehttp)
  - [**`get-requests.http`**](#get-requestshttp)
  - [**`post-requests.http`**](#post-requestshttp)
  - [**How to Run These Tests**](#how-to-run-these-tests)
  - [**Security Notes**](#security-notes)

---

## Prerequisites

### Install REST Client Extension
To run these tests, you need the **[REST Client](https://marketplace.visualstudio.com/items?itemName=humao.rest-client)** extension for VS Code:
1. Open VS Code.
2. Go to the Extensions Marketplace (Ctrl+Shift+X).
3. Search for **REST Client** and install it.

### Configure Variables
The `.http` files make use of environment variables that should be defined in your `.env` file:

- `BASE_URL`: The base URL of your WordPress installation (e.g., `http://localhost/wordpress/wp-json`)
- `WP_USERNAME`: Your WordPress username
- `WP_PASSWORD`: Your WordPress password
- `JWT_TOKEN`: The JWT token used for authentication

To set up:
1. Create a `.env` file in the root directory (copy from `.env.example`)
2. Add the following variables:
   ```env
   BASE_URL=http://localhost/your-wordpress/wp-json
   WP_USERNAME=your-wordpress-username
   WP_PASSWORD=your-wordpress-password
   JWT_TOKEN=your-jwt-token
   ```

The token can be obtained by running the authentication request in `authenticate.http`. Copy the token from the response and update your `.env` file accordingly.

Note: The `.env` file should not be committed to version control as it contains sensitive information.

---

## File Descriptions

### **`authenticate.http`**
```http
@baseURL = {{$dotenv BASE_URL}}

### Authenticate and get JWT token
POST {{baseURL}}/jwt-auth/v1/token
Content-Type: application/json

{
  "username": "{{$dotenv WP_USERNAME}}",
  "password": "{{$dotenv WP_PASSWORD}}"
}
```

- **Purpose**: Use this file to generate a JWT token.
- Replace `WP_USERNAME` and `WP_PASSWORD` in your `.env` file with valid WordPress credentials.
- Copy the token from the response and update `JWT_TOKEN` in your `.env` file.

---

### **`get-requests.http`**
```http
@baseURL = {{$dotenv BASE_URL}}

### Retrieve all posts
GET {{baseURL}}/wp/v2/posts

### Search posts by keyword
GET {{baseURL}}/wp/v2/posts?search=hello

### Retrieve media items
GET {{baseURL}}/wp/v2/media
```

- **Purpose**: Contains all GET requests for retrieving posts, searching for content, and fetching media.

---

### **`post-requests.http`**
```http
@baseURL = {{$dotenv BASE_URL}}
@jwtToken = {{$dotenv JWT_TOKEN}}

### Create a new post
POST {{baseURL}}/wp/v2/posts
Authorization: Bearer {{jwtToken}}
Content-Type: application/json

{
  "title": "My 2nd post",
  "content": "some content",
  "status": "publish"
}
```

- **Purpose**: Contains POST requests for creating or updating content.
- Ensure the `JWT_TOKEN` variable in your `.env` file is updated with a valid token from `authenticate.http`.

---

### **How to Run These Tests**
1. **Set Up Environment Variables**:
   - Check [Configure Variables](#configure-variables)

2. **Run the Authentication Test**:
   - Open `authenticate.http`.
   - Click **Send Request** for the authentication endpoint.
   - Copy the `token` value from the response and update `JWT_TOKEN` in the `.env` file.

    ![How to Send Request](https://i.ibb.co/sJsNvjK/how-to-send-request.png)

3. **Run GET Requests**:
   - Open `get-requests.http`.
   - Click **Send Request** for the desired GET endpoint.

4. **Run POST Requests**:
   - Open `post-requests.http`.
   - Click **Send Request** for the desired POST endpoint.

---

### **Security Notes**
- **JWT Token Expiry**: Update the `JWT_TOKEN` in your `.env` file if the token expires.
- **Environment Variables**: Keep `.env` out of version control to protect sensitive credentials.

Enjoy testing your **REST API Starter** theme with this organized setup! 🚀