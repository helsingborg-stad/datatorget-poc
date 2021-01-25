@extends('layout.containers.page')
@section('article')

    @paper([
        'padding'=> 4, 
        'classList' => ['o-grid-12', 'o-grid-6@md', 'u-align-self--center']
    ])
    
        @typography([
            'element' => 'h1',
            'classList' => ['u-color__text--primary', 'u-margin__bottom--2']
        ])
            Logga in
        @endtypography

        @typography([])
            För att logga in, behöver du först registrera ett konto. <br/><a href="/registrera-konto">Skapa ett nytt konto här.</a>
        @endtypography

        @form([
            'method' => 'POST',
            'action' => '/?action=login',
            'classList' => ['u-margin__top--2']
        ])
            @field([
                'type' => 'text',
                'attributeList' => [
                    'type' => 'number',
                    'name' => 'pnr',
                    'maxlength' => '10',
                    'minlength' => '10'
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
@stop