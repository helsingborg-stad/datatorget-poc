@extends('layout.master')

@section('content')
    @segment([
        'layout' => 'col-right',
        'height' => 'md',
        'color' => 'black'
    ])
        @typography([
            'element' => 'h1',
            'classList' => ['u-color__text--primary']
        ])
            Error 404
        @endtypography

        @typography([
            'element' => 'p',
            'variant' => 'subtitle'
        ])
            Vi kan inte hitta det där, har du kikat i kylskåpet? 
        @endtypography

        @code(['language' => 'php', 'content' => ''])
            {!! $errorMessage !!}
        @endcode

        @slot('bottom')
            @button([
                'text' => 'Go Home',
                'href' => '/',
                'color' => 'primary',
                'type' => 'filled'
            
            ])
            @endbutton
        @endslot
    @endsegment
@endsection