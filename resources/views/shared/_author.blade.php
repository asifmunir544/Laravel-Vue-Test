<span class="text-muted">{{$label .' '.$model->created_date}}</span>
<div class="d-flex mt-2">
    <div class="flex-shrink-0">
        <a href="{{$model->user->url}}">
            <img src="{{$model->user->avatar}}" alt="...">
        </a>
    </div>
    <div class="flex-grow-1 ms-2">
        <a class="text-decoration-none" href="{{$model->user->url}}">{{$model->user->name}}</a>
    </div>
</div>
