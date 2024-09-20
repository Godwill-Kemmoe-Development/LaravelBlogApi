<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\BlogPost;

class BlogPostUnitTest extends TestCase
{
    public function test_blog_post_creation()
    {
        $post = new BlogPost([
            'title' => 'Test Title',
            'content' => 'Test Content',
            'author' => 'QA Tester',
            'status' => 'draft'
        ]);

        $this->assertEquals('Test Title', $post->getAttribute('title'));
        $this->assertEquals('Test Content', $post->getAttribute('content'));
        $this->assertEquals('QA Tester', $post->getAttribute('author'));
        $this->assertEquals('draft', $post->getAttribute('status'));
    }

    public function test_blog_post_requires_fields()
    {
        $post = new BlogPost();

        $this->assertNull($post->getAttribute('title'));
        $this->assertNull($post->getAttribute('content'));
        $this->assertNull($post->getAttribute('author'));
    }
}
