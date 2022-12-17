<?php

namespace App\Http\Controllers;

// use App\Http\Requests\StoreTaskRequest;
// use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
// use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Task一覧
     *
     * @return Taskモデルの情報を全て
     */
    public function index()
    {
        // Taskモデルの情報を全てviewに返す（idの降順）
        return Task::orderByDesc('id')->get();
    }

    /**
     * タスクの新規登録
     *
     * @param  TaskRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TaskRequest $request)
    {
        // 作成されたタスクを変数に代入
        $task = Task::create($request->all());

        if ($task) {
            // 成功した場合は送られてきたものとステータスコード201を返す
            return response()->json($task, 201);
        } else {
            // 失敗した場合は、空配列とステータスコード500を返す
            return response()->json([], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    // public function show(Task $task)
    // {
    //     //
    // }

    /**
     * タスク更新
     *
     * @param  TaskRequest  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TaskRequest $request, Task $task)
    {
        // 更新されたタスクのタイトルを代入
        $task->title = $request->title;

        // taskモデルのupdateの処理を実行
        if ($task->update()) {
            // 成功した場合は送られてきたものとステータスコード201を返す
            return response()->json($task);
        } else {
            // 失敗した場合は、空配列とステータスコード500を返す
            return response()->json([], 500);
        }
    }

    /**
     * タスク削除
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task)
    {
        // taskモデルのdeleteの処理を実行
        if ($task->delete()) {
            // 成功した場合は送られてきたものとステータスコード201を返す
            return response()->json($task);
        } else {
            // 失敗した場合は、空配列とステータスコード500を返す
            return response()->json([], 500);
        }
    }
}
