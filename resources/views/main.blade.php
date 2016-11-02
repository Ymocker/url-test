<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>URL Analyser</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/app.css">

        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">

        <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>

    </head>
    <body>
        <h4>Page analysis</h4>
        {!! Form::open(['url' => '/', 'class' => 'form-horizontal']) !!}
            <div class="form-group form-group-lg">
                {!! Form::label('url', 'Enter URL') !!}
                <div class="col-sm-4">
                    {!! Form::input('text', 'url', 'http://', ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
            {!! Form::submit('Analyse',['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
        <div id="result">
            <table id="infotable" class="display" width="100%"></table>
        </div>


        <script>
            $(document).ready(function() {
                var dataSet = {!! $data !!};

                if (dataSet=="no") {
                    alert("Something goes wrong!");
                    return;
                }

                $('#infotable').DataTable( {
                    data: dataSet,
                    searching: false,
                    autoWidth: false,
                    columns: [
                        { title: "Site", "width": "5%" },
                        { title: "URL Link", "width": "40%" },
                        { title: "URL Text", "width": "45%" },
                        { title: "Scan Time", "width": "10%" }
                    ]
                } );

            } );
        </script>
    </body>
</html>
