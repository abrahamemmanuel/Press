<?php

namespace emmy\Press\Console;

use emmy\Press\Facades\Press;
use Illuminate\Console\Command;
use emmy\Press\Post;
use Illuminate\Support\Str;
use emmy\Press\Repositories\PostRepository;

class ProcessCommand extends Command
{
    protected $signature = 'press:process';

    protected $description = 'Update blog posts.';

    public function handle(PostRepository $postRepository)
    {

        if (Press::configNotPublished()) {
            return $this->warn('Please publish the config file by running \'php artisan vendor:publish --tag=press-config\'');
        }

       try {
           $posts = Press::driver()->fetchPosts();

           $this->info('Number of Posts: ' . count($posts));

        foreach ($posts as $post) {
            $postRepository->save($post);

            $this->info('Posts: ' . $post['title']);
        }
       } catch (\Exception $e) {
           $this->error($e->getMessage()); 
       }
    }
}
