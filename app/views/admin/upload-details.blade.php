<!--app/views/form.blade.php-->
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        Laravel
    </title>
</head>
<body>
{{ Form::open(array('url'=>'/admin/processUploads/','files'=>true)) }}
<p>
{{ Form::select('partner_id', array('STACK' => 'StackSocial', 'AHA' => 'American Heart', 'MOVO' => "Movo"), 'STACK', array( 'style' => 'background-color: yellow;')) }}
</p>
{{ Form::label('file','File',array('id'=>'','class'=>'')) }}
{{ Form::file('file','',array('id'=>'','class'=>'')) }}

@if (isset($status) && strlen($status) > 0)
    <br/><br/>
    <p class="results">{{ $status }}</p>
@else
    <p>Make sure the csv file is in proper format and load the file from your hard-drive.<br/>Note: a copy of the uploaded file will be maintained on the site for backup.</p><br/><br/>
@endif





    <!-- submit buttons -->
{{ Form::submit('Process') }}

<!-- reset buttons -->
{{ Form::reset('Reset') }}

{{ Form::close() }}
</body>
</html>