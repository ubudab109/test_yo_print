<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    </head>
    <body>
        
        <div class="container-fluid">
            <div class="row mt-4">
                <div class="col-12">
                    <form action="{{route('upload.csv')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <div class="custom-file">
                                <input required type="file" name="file" class="custom-file-input" id="customFile" onchange="readFile()">
                                <label class="custom-file-label" for="customFile" id="label-file">Select or Drag and Drop File Here</label>
                            </div>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-outline-secondary" disabled type="button" id="uploadButton">Click Here to Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
        <script>
            function readFile() {
                $("#label-file").text($('#customFile').prop('files')[0].name);
                $("#uploadButton").prop('disabled', false);
            }
        </script>
    </body>
</html>
