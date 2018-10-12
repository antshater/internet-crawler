<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Internet crawler</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Styles -->
</head>
<body>
<div class="container-fluid">
    <div class="col">
        <h1>Internet crawler</h1>
        <form method="POST">
            {{ csrf_field() }}
            <label>File url</label>
            <div class="input-group">
                <input type="text" class="form-control" name="url" placeholder="Example: http://my-site.com/my-file.csv"/>
                <div class="input-group-append">
                    <button class="btn btn-success">Download</button>
                </div>
            </div>
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
        </form>
        @foreach($tasks as $task)
            <div class="alert alert-light">
                <div>Task #{{ $task->id }} - {{ $task->status }}</div>
                <div>Original url: <a href="{{ $task->url }}">{{ $task->url }}</a></div>
                @if($task->result_url)
                    <div>
                        <a id="download-link-{{ $task->id }}" download href="{{ Storage::url($task->result_url) }}">Download</a>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>

</body>
</html>
