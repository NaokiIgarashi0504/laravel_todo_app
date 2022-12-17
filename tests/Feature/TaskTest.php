<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function 一覧を取得()
    {
        // データ作成
        $tasks = Task::factory()->count(10)->create();

        // タスク一覧ページを開く
        $response = $this->getJson('api/tasks');

        $response
            ->assertOk()

            // $tasksと同じ数かどうかチェック
            ->assertJsonCount($tasks->count());
    }
}
