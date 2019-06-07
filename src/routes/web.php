<?php

Route::group([
    'middleware' => ['web'],
    'prefix' => 'blog',
    'as' => 'blog.'
    ], function () {
    /*
     *  blog/api/
     */
    Route::group(['prefix' => 'api'], function () {
        Route::get('featured', 'MetaGameTechnologies\Blog\Http\controllers\PostsController@getFeaturedPosts');
        Route::get('latest/{post_num?}', 'MetaGameTechnologies\Blog\Http\controllers\PostsController@getLatestPosts')->where('postNum', '[0-9]+');
        Route::get('categories', 'MetaGameTechnologies\Blog\Http\controllers\PostsController@getAllCategories');
        Route::get('categories/{id}', 'MetaGameTechnologies\Blog\Http\controllers\PostsController@getPostsByCategories');
        Route::get('post/{slug}', 'MetaGameTechnologies\Blog\Http\controllers\PostsController@getPost');
    });
    /*
     *   blog/panel/
     */
    Route::resource('panel', 'MetaGameTechnologies\Blog\Http\controllers\AdminPanelController', [
        'parameters' => [
            'panel' => 'post'
        ]
    ]);
    Route::post('panel/image-upload', 'MetaGameTechnologies\Blog\Http\controllers\AdminPanelController@upload');
    /*
     *  blog/
     */
    Route::get('/', 'MetaGameTechnologies\Blog\Http\controllers\BlogController@index');
    Route::get('{slug}', 'MetaGameTechnologies\Blog\Http\controllers\BlogController@show');
});