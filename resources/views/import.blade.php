<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ URL::to('css/app.css') }}">
 
    <title>Laravel Excel Import csv and XLS file in Database</title>
 
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
<link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css">
 
    <!-- Styles -->
    <!--<style>
    html, body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Raleway', sans-serif;
        font-weight: 100;
        height: 100vh;
        margin: 0;
        padding: 5%
    }
</style> -->
</head>
<body class="text-center">
    <div class="container cover-container">
      
        <main class="inner cover">
            <h2 class="text-center">
                Laravel Excel/CSV Import
            </h2>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif 

            @include('flash::message')
            <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                Choose your xls/csv File : <input type="file" name="file" class="form-control ">
            
                <input type="submit" class="btn btn-primary btn-lg" style="margin-top: 3%">
            </form>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
    <script>
        $('div.alert').not('.alert-important').delay(5000).fadeOut(350);
    </script>
</body>
</html>
