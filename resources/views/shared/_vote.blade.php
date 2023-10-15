@if($model instanceof App\Models\Question)
    @php
        $name = 'question';
        $firstURISegment = 'questions';
    @endphp
@elseif($model instanceof App\Models\Answer)
    @php
        $name = 'answer';
        $firstURISegment = 'answers';
    @endphp
@endif

<div class="flex-shrink-0 flex-column vote-controls">
    <a title="This {{$name}} is useful"
       class="vote-up {{\Illuminate\Support\Facades\Auth::guest() ? 'off' : ''}}"
       onclick="event.preventDefault(); document.getElementById('up-vote-{{$name}}-{{$model->id}}').submit();">
        <i class="fa fa-caret-up fa-3x"></i>
    </a>
    <form id="up-vote-{{$name}}-{{$model->id}}" action="/{{$firstURISegment}}/{{$model->id}}/vote" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="vote" value="1">
    </form>

    <span class="votes-count">{{$model->votes_count}}</span>

    <a title="This {{$name}} is not useful"
       class="vote-down {{\Illuminate\Support\Facades\Auth::guest() ? 'off' : ''}}"
       onclick="event.preventDefault(); document.getElementById('down-vote-{{$name}}-{{$model->id}}').submit();">
        <i class="fa fa-caret-down fa-3x"></i>
    </a>
    <form id="down-vote-{{$name}}-{{$model->id}}" action="/{{$firstURISegment}}/{{$model->id}}/vote" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="vote" value="-1">
    </form>

    @if($model instanceof App\Models\Question)
        <favorite :question="{{$model}}"></favorite>
    @elseif($model instanceof App\Models\Answer)
        <accept :answer="{{$model}}"></accept>
    @endif
</div>
