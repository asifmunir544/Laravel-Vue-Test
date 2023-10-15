<div class="container">
    <div class="row">
        <!-- Column 1: User Email -->
        <div class="col-md-3">
            <div class="flex-shrink-0">
                <strong>Email:</strong> {{$user->email}}
                <br>
            </div>
        </div>

        <!-- Column 2: isAdmin -->
        <div class="col-md-3">
            <div class="flex-shrink-0">
                <strong>isAdmin:</strong>
                <span style="color: {{$user->is_admin == 1 ? 'green' : 'red'}}; font-weight: {{$user->is_admin == 1 ? 'bold' : 'normal'}};">
            {{$user->is_admin == 1 ? 'true' : 'false'}}
        </span>
            </div>
        </div>


        <!-- Column 3: Authorize Comments with Radio Buttons -->
        <div class="col-md-4">
            <form id="commentStatusForm" action="{{ route('users.update', ['id' => $user->id]) }}" method="POST">
                @csrf
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="comment_allowed" id="allowComment" value="1" {{$user->comment_allowed == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="allowComment">Allow</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="comment_allowed" id="disallowComment" value="0" {{$user->comment_allowed == null ? 'checked' : ''}}>
                    <label class="form-check-label" for="disallowComment">Disallow</label>
                </div>
                <input type="hidden" name="id" value="{{$user->id}}">
                <button class="btn btn-outline-info btn-sm" type="submit">Update Comment</button> <!-- Change <a> to <button> -->
            </form>
        </div>


        <!-- Column 4: Delete User -->
        <div class="col-md-2">
            <div>
                <form action="{{route('users.destroy', ['id' => $user->id])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm" name="id" value="{{$user->id}}" onclick="return confirm('Are you sure?')">Delete User</button>
                </form>
            </div>
        </div>
    </div>
</div>
