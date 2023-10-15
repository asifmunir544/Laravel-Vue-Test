<div class="d-flex post">
    <div class="flex-shrink-0 d-flex flex-column counters">
        <div class="vote">
            <strong>{{$question->votes_count}}</strong> {{\Illuminate\Support\Str::plural('vote', $question->votes_count)}}
        </div>
        <div class="status {{$question->status}}">
            <strong>{{$question->answers_count}}</strong> {{\Illuminate\Support\Str::plural('answer', $question->answers_count)}}
        </div>
        <div class="view">
            {{$question->views . " " . \Illuminate\Support\Str::plural('view', $question->views)}}
        </div>
    </div>

    <div class="flex-grow-1">
        <div class="d-flex justify-content-between ">
            <h3 class="mt-0"><a href="{{$question->url}}">{{ $question->title}}</a></h3>
            <div class="d-flex q-buttons">
                @can('update', $question)
                    <div>
                        <a href="{{route('questions.edit', $question->id)}}" class="btn btn-outline-info btn-sm me-2">Edit</a>
                    </div>
                @endcan
                @can('delete', $question)
                    <form action="{{route('questions.destroy', $question->id)}}" method="POST" >
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick=" return confirm('Are you sure?')">Delete</button>
                    </form>
                @endcan
            </div>
        </div>

        <h4>
            Category : {{$question->category}}
        </h4>

        <div class="lead">
            Posted by
            <a href="{{$question->user->url}}">{{$question->user->name}}</a>
            <small class="text-muted">{{$question->created_date}}</small>
        </div>

        <div class="excerpt">
            {{$question->excerpt(350)}}
        </div>

    </div>
</div>
