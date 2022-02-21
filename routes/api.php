<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Designs\UploadController;
use App\Http\Controllers\Designs\DesignController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\CommentController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'user']);
Route::post('/logout', [AuthController::class, 'logout']);

// designs
Route::get('designs', [DesignController::class, 'index']);
Route::get('designs/{id}', [DesignController::class, 'findDesign']);
// Route::get('designs/slug/{slug}', 'Designs\DesignController@findBySlug');


//users
Route::get('users', [UserController::class, 'index']);
// Route::get('user/{username}', 'User\UserController@findByUsername');
// Route::get('users/{id}/designs', 'Designs\DesignController@getForUser');

Route::group(['prefix' => 'topics'], function(){
    Route::get('/', [TopicController::class, 'index']);
    Route::post('/', [TopicController::class, 'store'])->middleware('auth:api');
    Route::get('/{topic}', [TopicController::class, 'edit']);
    Route::patch('/{topic}', [TopicController::class, 'update'])->middleware('auth:api');
    Route::delete('/{topic}', [TopicController::class, 'destroy'])->middleware('auth:api');

    // post route groups
	Route::group(['prefix' => '/{topic}/posts'], function () {
		Route::post('/', [PostController::class, 'store'])->middleware('auth:api');
		Route::get('/{post}', [PostController::class, 'edit']);
		Route::patch('/{post}', [PostController::class, 'update'])->middleware('auth:api');
		Route::delete('/{post}', [PostController::class, 'destroy'])->middleware('auth:api');
		// likes
		Route::group(['prefix' => '/{post}/likes'], function () {
            Route::post('/', [PostLikeController::class, 'store'])->middleware('auth:api');
		});
	});
});

Route::group(['middleware' => ['auth:api']], function(){
	Route::put('settings/profile', [SettingsController::class, 'updateProfile']);
	Route::put('settings/password', [SettingsController::class, 'updatePassword']);

	// Upload Designs
    Route::post('designs', [UploadController::class, 'upload']);
    Route::put('designs/{id}', [DesignController::class, 'update']);
    // Route::get('designs/{id}/byUser', 'Designs\DesignController@userOwnsDesign');
    
    Route::delete('designs/{id}', [DesignController::class, 'destroy']);


	// Likes and Unlikes
    Route::post('designs/{id}/like', [DesignController::class, 'like']);
    Route::get('designs/{id}/liked', [DesignController::class, 'checkIfUserHasLiked']);

    // Comments
    Route::post('designs/{id}/comments', [CommentController::class, 'store']);
    Route::put('comments/{id}', [CommentController::class, 'update']);
    Route::delete('comments/{id}', [CommentController::class, 'destroy']);

    // Teams
    // Route::post('teams', 'Teams\TeamsController@store');
    // Route::get('teams/{id}', 'Teams\TeamsController@findById');
    // Route::get('teams', 'Teams\TeamsController@index');
    // Route::get('users/teams', 'Teams\TeamsController@fetchUserTeams');
    // Route::put('teams/{id}', 'Teams\TeamsController@update');
    // Route::delete('teams/{id}', 'Teams\TeamsController@destroy');
    // Route::delete('teams/{team_id}/users/{user_id}', 'Teams\TeamsController@removeFromTeam');
    
    // Invitations
    // Route::post('invitations/{teamId}', 'Teams\InvitationsController@invite');
    // Route::post('invitations/{id}/resend', 'Teams\InvitationsController@resend');
    // Route::post('invitations/{id}/respond', 'Teams\InvitationsController@respond');
    // Route::delete('invitations/{id}', 'Teams\InvitationsController@destroy');

    // Chats
    // Route::post('chats', 'Chats\ChatController@sendMessage');
    // Route::get('chats', 'Chats\ChatController@getUserChats');
    // Route::get('chats/{id}/messages', 'Chats\ChatController@getChatMessages');
    // Route::put('chats/{id}/markAsRead', 'Chats\ChatController@markAsRead');
    // Route::delete('messages/{id}', 'Chats\ChatController@destroyMessage');
});