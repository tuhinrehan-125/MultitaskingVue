<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TopicCreateRequest;
use App\Http\Requests\UpdateTopicRequest;

use App\Models\Post;
use App\Models\Topic;

use App\Http\Resources\TopicResource;

class TopicController extends Controller
{
    public function index(){
        $topics = Topic::latestFirst()->paginate(5);
        return TopicResource::collection($topics);
    }

    public function store(TopicCreateRequest $request){
        $topic = new Topic();
        $topic->title = $request->title;
        $topic->user()->associate($request->user());

        $post = new Post();
        $post->body = $request->body;
        $post->user()->associate($request->user());

        $topic->save();
        $topic->posts()->save($post);

        return new TopicResource($topic);
    }

    public function edit(Topic $topic) {
        return new TopicResource($topic);
    }

    public function update(UpdateTopicRequest $request, Topic $topic) {
        $this->authorize('update', $topic);
        $topic->title = $request->get('title', $topic->title);
        $topic->save();
        return new TopicResource($topic);
    }

    public function destroy(Topic $topic) {
        $this->authorize('update', $topic);
        $topic->delete();
        return response(null, 204);
    }
}