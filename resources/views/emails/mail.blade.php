@extends('beautymail::templates.minty')

@section('content')

    @include('beautymail::templates.minty.contentStart')
    <tr>
        <td class="title">
            {{ $title }}
        </td>
    </tr>
    <tr>
        <td width="100%" height="10"></td>
    </tr>
    <tr>
        <td class="paragraph">
            <h3><strong>{{ \App\Http\Controllers\SystemController::pass_greetings_to_user() }}</strong> !!</h3>
            <p>{!! $body !!}</p>
        </td>
    </tr>
    <tr>
        <td width="100%" height="25"></td>
    </tr>
    @if(isset($url))
        <tr>
            <td>
                @include('beautymail::templates.minty.button', ['text' => $action, 'link' => $url])
            </td>
        </tr>
    @endif
    @if(isset($url2))
        <tr>
            <td>
                @include('beautymail::templates.minty.button', ['text' => $action2, 'link' => $url2])
            </td>
        </tr>
    @endif
    <tr>
        <td width="100%" height="25"></td>
    </tr>
    @include('beautymail::templates.minty.contentEnd')

@stop
