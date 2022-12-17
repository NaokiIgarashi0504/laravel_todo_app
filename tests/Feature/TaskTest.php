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
    public function 一覧を取得できる()
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

    /**
     * @test
     */
    public function タスクを登録することができる()
    {
        // データの作成
        $data = [
            'title' => 'テスト投稿'
        ];

        // postのレスポンスを代入
        $response = $this->postJson('api/tasks', $data);

        $response
            // 正常に作成されているかのチェック（201のチェック）
            ->assertCreated()

            // titleが作成されているかのチェック
            ->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function タスクを更新することができる()
    {
        // データを作成
        $task = Task::factory()->create();

        // タイトルを更新
        $task->title = "書き換え";

        // レスポンスを代入
        $response = $this->patchJson("api/tasks/{$task->id}", $task->toArray());

        $response
            // 正常に作成されているかのチェック（200のチェック）
            ->assertOk()

            // titleが更新されているかのチェック
            ->assertJsonFragment($task->toArray());
    }

    /**
     * @test
     */
    public function タスクを削除することができる()
    {
        // データを作成
        $tasks = Task::factory()->count(10)->create();

        // タイトルを更新
        $tasks->title = "書き換え";

        // レスポンスを代入
        $response = $this->deleteJson("api/tasks/1");
        $response->assertOk();

        // タスク一覧を取得
        $response = $this->getJson("api/tasks");

        // マイナス1になっているかのチェック
        $response->assertJsonCount($tasks->count() - 1);
    }
}
