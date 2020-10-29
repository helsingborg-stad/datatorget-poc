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
            Bokningsportalen är en del av projektet datatorget. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec sed odio dui. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.
        @endtypography

    @endpaper

@stop