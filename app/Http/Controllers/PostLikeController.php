<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function store(Request $request, Topic $topic, Post $post) {
		// $this->authorize('like', $post);
		// check
		// if ($request->user()->hasLikedPost($post)) {
		// 	return response(null, 409);
		// }
		// create like
		$like = new Like();
		$like->user()->associate($request->user());
		$post->likes()->save($like);
		return response(null, 204);
	}
}