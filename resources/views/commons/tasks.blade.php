@if (count($tasks) > 0)
    <table class="table">
        <thead>
            <tr>
                <th>id</th>
                <th>ステータス</th>
                <th>タスク</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
            <tr>
                <td>{!! link_to_route('tasks.show', $task->id,['task' => $task->id]) !!}</td>
                {{-- 投稿内容 --}}
                <td>{!! nl2br(e($task->status)) !!}</td>
                <td>{!! nl2br(e($task->content)) !!}</td>
            </tr>           
            @endforeach
        </tbody>    
    </table>
    {{-- ページネーションのリンク --}}
    {{ $tasks->links() }}
@endif