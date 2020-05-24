<?php

namespace Tests\Unit;

use App\User;
use App\Thread;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp(): void
    {
        parent::setUp();
        $this->thread = factory(Thread::class)->create();
    }

    /** @test */
    public function a_thread_can_make_a_string_path()
    {
        $thread = create(Thread::class);

        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}", $thread->path());
    }

    /** @test */
    function a_thread_has_replies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /** @test */
    function a_thread_has_a_creator()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1,
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function a_thread_belongs_to_a_channel()
    {
        $thread = create(Thread::class);

        $this->assertInstanceOf('App\Channel', $thread->channel);
    }
}
