
# Blog

Blog system for business site.

## Installation

```
php artisan blog:install
```
This command will create:

 - Laravel Auth scaffolding, 
 - Dummy Admin Credentials 
 - Publish all config, views and assets,  
 - Migrate database
 
## Dummy Data

To generate dummy data just execute this command 
```
php artisan blog:dummy
```
It will generate a dummy admin user, categories from `config/blog.php` file and three posts.

To add new categories just edit `config/blog.php` and seed using categories seeder:
```
php artisan db:seed --class='MetaGameTechnologies\\Blog\\Database\\Seeds\\CategoriesSeeder'
```

## Admin Panel
Login as admin and then go to `/blog/panel`

- **Create route**: /blog/panel/create
- **Edit route**: /blog/panel/{slug}/edit

**Dummy Admin Credentials**:
- Email: admin@example.com
- Password: secret

## Api Endpoints

|  Method | URL  | Action  |
|---|---|---|
|  GET | `blog/featured`  |  Return `published` and `featured` posts. |
|  GET | `blog/latest/{post_num?}`  |  Return `published` post ordered by `published_at`. Optional parameter: `post_num` is used to set how many posts you want. Default: 10.  |
|  GET |  `blog/categories` | Return all categories  |
|  GET |  `blog/categories/{id}` | Get posts by category id. It will select from `category_post` table the posts that match passed category `id`.  |
|  GET |  `post/{slug}` |  Return post by its `slug` |




