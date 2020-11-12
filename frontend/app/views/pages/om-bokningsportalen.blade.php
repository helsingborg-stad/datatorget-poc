@extends('layout.containers.page')
@section('article')

    @paper([
        'padding'=> 4, 
        'classList' => ['o-grid-12', 'o-grid-8@md', 'u-align-self--center']
    ])

        @typography([
            'element' => 'h1',
            'classList' => ['u-color__text--primary', 'u-margin__bottom--2']
        ])
            Om bokningsportalen
        @endtypography

        @typography()
            Bokningsportalen är en P.O.C (proof of concept) som syftar till att visa hur vi kan koppla ihop system med olika bakomliggande mjukvaror, främst i en eventdriven arkitektur. 
        @endtypography

        @typography()
            Bokningsportalen är en del av projektet datatorget. 
        @endtypography

        @typography(['element' => 'h2'])
            Datakällor
        @endtypography

        @typography()
            Nedan finner du dokumentation till de datakällor som används för att driva portalen.
        @endtypography

        @foreach ($apis as $item) 
            @button($item)
            @endbutton
        @endforeach

    @endpaper

@stop