## Technical Requirements

---
### **The must**

1. The initial data for users, posts and categories should be populated in the database via seeders.
2. The application must be written in [PHP 8.0](https://www.php.net/releases/8.0/en.php)
3. The application must use [Laravel Framework v.8](https://laravel.com/docs/8.x)
4. The application must use the [Bearer Token](https://oauth.net/2/bearer-tokens/) authentication
5. Database seeding must be implemented
6. The code must be pushed into your personal repository which is available to us
- We really want to see your individual commits
- Please avoid big commits by breaking them down into smaller and descriptive commits, ideally containing code specific to a feature.

### **The recommended**

- The application should have database [Migrations](https://laravel.com/docs/8.x/migrations) and [Seeders](https://laravel.com/docs/8.x/seeding) files
- Every table should have an [Eloquent](https://laravel.com/docs/8.x/eloquent) model and relationships (if applicable)
- Every endpoint should have its own [controller](https://laravel.com/docs/8.x/controllers) and the methods of that controller must be linked to a route
- Every route should be protected by a [middleware](https://laravel.com/docs/8.x/middleware)
- The application should have [unit and feature tests](https://laravel.com/docs/8.x/testing)

### **Nice to have (bonus points)**

- It would be nice to have a passing [Larastan](https://github.com/nunomaduro/larastan) LVL 8 rules for static code coverage
- It would be nice to have implemented the [Laravel IDE Helper Generator](https://github.com/barryvdh/laravel-ide-helper)
# Tasks:

Create a rest api for a content management that does the following as shown in the image above:

- **Posts**
    - [ ] Create posts
    - [ ] Delete posts
    - [ ] Edit posts
    - [ ] List posts
- **Categories**
    - [ ] Create a post category
    - [ ] List all post categories
    - [ ] Edit a post category
    - [ ] Delete a post category
- **Users**
    - [ ] Create a user
    - [ ] List all users
    - [ ] Delete a userBearer Token authentication
    - [ ] Edit a single user’s profile information

| User Story                  | Definition                                                                                                                                                                                                                                                                                                                                                          |
|-----------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| API prefix                  | The API routing prefix must follow the following convention: /api/v1/{route_name} For example: https://{{base_url}}/api/v1/user/login https://{{base_url}}/api/v1/posts                                                                                                                                                                                             |
| Bearer Token authentication | A valid JWT token must be created to enable access to protected routes. This token must contain the user_uuid as a claim The issuer must be the API server domain The implementation must use an asymmetric key. Authentication must be carried out using JWT (Check out lcobucci laravel package for this, any other package of your choosing works too)           |
| Middleware protection       | All API routes must be protected by a middleware to avoid injections attacks, Laravel provides a default middleware that needs to be implemented. In addition there must be another middleware to protect secure routes. This middleware need to validate the authenticity of the user token and allow user tokens on the User side.                                |
| User endpoint (CRUD)        | This endpoint will handle the CRUD methods for the user, as well it will enable the following features: Login/logout forgot/reset password listing all user posts Keep in mind that this endpoint must affect only the current logged in user. User A cannot see or edit anything from User B                                                                       |
| Forgot/reset password       | This endpoint will handle the forgot and restet password feature, this feature will do the following: The user will request a token to reset its password, if the email is valid a token will be generated. This token must be unique and there must be only one available token per user at the time. After a successful password update the token must be deleted |
| Categories endpoint (CRUD)  | This endpoint will handle the CRUD methods for the categories. The initial data for these endpoints most be added into the DB via seeders.                                                                                                                                                                                                                          |
| Posts endpoint (CRUD)       | This endpoint will handle the CRUD methods for the brands. The initial data for these endpoints most be added into the DB via seeders.                                                                                                                                                                                                                              |                                                                                                                                                                                                                                                                                                                                                                     |
|                             |                                                                                                                                                                                                                                                                                                                                                                     |

# Submitting Your Code

When you are finished with your testing code, please send a mail with the link to your submission to ‘**clapmiapp@gmail.com**’.

**You will be asked for your git repository and any comments/feedback**