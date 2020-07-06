@extends('layouts.app')

@section('content')

  @if (Auth::check())
            <div class="center jumbotron">
                <div class="text-center">
                    <h1>Tasklist</h1>
                    {{-- タスク投稿ボタン --}}
                    {!! link_to_route('tasks.create', 'Newpost', [], ['class' => 'btn btn-lg btn-primary']) !!}
                </div>
            </div>
        <div class="row">
            <div class="col-sm-8">
                {{-- 投稿一覧 --}}
                @include('commons.tasks')
            </div>
            
        </div>
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>Welcome to the Tasklist</h1>
                {{-- ユーザ登録ページへのリンク --}}
                {!! link_to_route('signup.get', 'Sign up now!', [], ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
          
        </div>
    @endif
@endsection