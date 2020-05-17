<?php

namespace emmy\Press\Drivers;

use emmy\Press\Exceptions\FileDriverDirectoryNotFound;
use Illuminate\Support\Facades\File;

class FileDriver extends Driver
{
    public function fetchPosts()
    {
        // Fetch all posts
        $files = File::files($this->config['path']);

        // Process each file
        foreach ($files as $file) {
            $this->parse($file->getPathname(), $file->getFilename());
        }

        return $this->posts;

    }

    public function validateSource()
    {
        if (!File::exists($this->config['path'])) {
            throw new FileDriverDirectoryNotFound(
                'Directory: at \'' . $this->config['path'] . '\' does not exist. Check the directory path in the config file. '
            );
        }
    }
}
