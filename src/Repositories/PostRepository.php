<?php

namespace emmy\Press\Repositories;

use emmy\Press\Post;
use Illuminate\Support\Str;

class PostRepository
{
    public function save($post)
    {
        Post::updateOrCreate([
          'identifier' => $post['identifier'],
        ],
            [
                'slug' => Str::slug($post['title']),
                'title' => $post['title'],
                'body' => $post['body'],
                'extra' => $post['extra'] ?? json_encode([])
            ]);

    }
}
