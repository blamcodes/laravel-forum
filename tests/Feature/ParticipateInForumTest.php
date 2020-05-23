<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForum extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_authenticated_user_may_participate_in_forum_threads()
    {
        // Given we have an authenticated user
        $this->be($user = factory(User::class)->create());

        // And an existing thread
        $thread = factory(Thread::class)->create();

        // When the user adds a reply to the thread
        $reply = factory(Reply::class)->create();
        $this->post('/threads/' . $thread->id . '/replies', $reply->toArray());

        //Then their reply should be visible on the page.
        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
