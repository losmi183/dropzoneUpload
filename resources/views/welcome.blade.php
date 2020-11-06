<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href="/css/app.css">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    </head>
    <body>
        <div class="container">
            <h1>Multiple Upload</h1>
        </div>
        <div id="app">
            <example-component></example-component>
        </div>
        <hr>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    @foreach ($images as $image)
                        <div class="d-inline-block">
                            <a href="{{$image->original}}"><img src="{{$image->thumbnail}}" class="w100"></a>
                            
                            <form action="/images/{{$image->id}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm mt-1 mb-4">Delete</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        <script src="/js/app.js"></script>
    </body>
</html>
