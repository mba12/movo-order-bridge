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
{{ Form::select('partner_id', array('STACK' => 'StackSocial', 'MOVO' => "Movo/AHA", 'RETAIL' => "Retail"), 'STACK', array( 'style' => 'background-color: yellow;')) }}
</p>
{{ Form::label('file','File',array('id'=>'','class'=>'')) }}
{{ Form::file('file','',array('id'=>'','class'=>'')) }}

@if (isset($statusList) && count($statusList) > 0)
    <br/><br/>


    <?php $i=1 ?>
    <p class="results">
        <style type="text/css">
            .table   { display: table; border-collapse: collapse; width: 100%; }
            .tablerow  { display: table-row; border: 1px solid #000; padding:5px 5px 5px 5px}
            .tablecell { display: table-cell; padding-bottom: 1em; padding:5px 5px 5px 5px}
        </style>

    @if(is_string($statusList))
        <p>{{{$statusList}}}</p><br/>
    @elseif(is_array($statusList))
    <table class="table">
        <tr><th>Row</th><th>Status</th><th>Message</th><th>Items</th><th>Ship To</th></tr>

        @foreach($statusList as $status)
            <tr class="tablerow">
                <td class="tablecell">
                    {{{ $i }}}
                </td>
                <td class="tablecell">
                    {{$status['status']}}
                </td>
                <td class="tablecell">
                    {{$status['message']}}
                </td>
                <td class="tablecell">
                    @if(isset($status['data']['items']))
                        @foreach($status['data']['items'] as $item)
                            @if(isset($item['quantity']) && strlen($item['quantity']) > 0)
                                {{{$item['quantity']}}} X {{{$item['description']}}}<br/>
                            @endif
                        @endforeach
                    @endif
                </td>
                <td class="tablecell">
                    @if(isset($status['data']))
                        {{{$status['data']['shipping-first-name']}}} {{{$status['data']['shipping-last-name']}}}<br/>
                        {{{$status['data']['shipping-address']}}}<br/>
                        {{{$status['data']['shipping-address2'] or ''}}}
                        @if(isset($status['data']['shipping-address2']) && strlen($status['data']['shipping-address2']) > 0)
                            <br/>
                        @endif
                        {{{$status['data']['shipping-address3'] or ''}}}
                        @if(isset($status['data']['shipping-address3']) && strlen($status['data']['shipping-address3']) > 0)
                            <br/>
                        @endif
                        {{{$status['data']['shipping-city']}}}, {{{$status['data']['shipping-state']}}} {{{$status['data']['shipping-zip']}}}<br/>
                    @endif
                </td>
            </tr>
            <?php $i++ ?>
        @endforeach
    </table>

    </p>

    @endif
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