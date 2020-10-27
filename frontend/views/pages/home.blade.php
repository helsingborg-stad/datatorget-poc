@extends('layout.containers.page')
@section('article')

<div class="">

    @notice([
        'type' => 'info',
        'message' => [
            'text' => 'För att logga in, behöver du först registrera ett konto. <a href="#">Skapa ett nytt konto här.</a>',
            'size' => 'sm'
        ],
        'icon' => [
            'name' => 'report',
            'size' => 'md',
            'color' => 'white'
        ],
        'classList' => ['u-margin__bottom--4', 'o-grid-12', 'o-grid-6@md']
    ])
    @endnotice

    @paper([
        'padding'=> 4, 
        'classList' => ['o-grid-12', 'o-grid-6@md']
    ])
    
        @typography([
            'element' => 'h1',
            'classList' => ['u-color__text--primary']
        ])
            Logga in
        @endtypography

        @form([
            'method' => 'POST',
            'action' => '/logga-in/',
            'classList' => ['u-margin__top--2']
        ])
            @field([
                'type' => 'text',
                'attributeList' => [
                    'type' => 'text',
                    'name' => 'pnr',
                ],
                'label' => "Ange ditt personnummer"
            ])
            @endfield

            <div class="o-grid">
                <div class="o-grid-auto">
                    @typography([
                        'element' => 'span',
                        'variant' => 'meta'
                    ])
                        När du använder den här tjänsten accepterar du <a href="https://helsingborg.se/toppmeny/om-webbplatsen/sa-har-behandlar-vi-dina-personuppgifter/" target="_blank">Helsingborg Stads datapolicy</a>. 
                    @endtypography
                </div>
                <div class="o-grid-fit">
                    @button([
                        'text' => 'Logga in',
                        'color' => 'primary',
                        'type' => 'basic'
                    ])
                    @endbutton
                </div>
            </div>
        @endform
    @endpaper

</div>
@stop