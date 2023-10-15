@csrf
<div class="form-group">
    <label for="question-title">Feedback title</label>
    <input type="text" id="question-title" class="form-control @error('title') is-invalid @enderror" name="title" value="{{isset($question) ? $question->title : old('title')}}">
    @error('title')
    <div class="invalid-feedback">
        <strong>{{$message}}</strong>
    </div>
    @enderror
</div>
<div class="form-group">
    <label for="question-category">Feedback category</label>
    <select id="question-category" class="form-control @error('category') is-invalid @enderror" name="category">
        <option value="Bug Report" {{ (isset($question) && $question->category === 'Bug Report') ? 'selected' : '' }}>Bug Report</option>
        <option value="Feature Request" {{ (isset($question) && $question->category === 'Feature Request') ? 'selected' : '' }}>Feature Request</option>
        <option value="Improvements" {{ (isset($question) && $question->category === 'Improvements') ? 'selected' : '' }}>Improvements</option>
        <option value="Others" {{ (isset($question) && $question->category === 'Others') ? 'selected' : '' }}>Others</option>

    </select>
    @error('category')
    <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
    </div>
    @enderror
</div>
<div class="form-group mt-2">
    <label for="question-body">Please provide your feedback </label>
    <textarea id="question-body" class="form-control @error('body') is-invalid @enderror" name="body" rows="10">{{isset($question) ? $question->body : old('body')}}</textarea>
    @error('body')
    <div class="invalid-feedback">
        <strong>{{$message}}</strong>
    </div>
    @enderror
</div>
<div class="form-group mt-3">
    <button type="submit" class="btn btn-outline-primary btn-lg">{{$buttonText}}</button>
</div>
