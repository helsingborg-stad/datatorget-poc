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
            Registrera konto
        @endtypography

        @typography([])
            För att hantera dina bokningar behöver du skapa ett konto. 
        @endtypography

        @form([
            'method' => 'POST',
            'action' => '/registrera-konto?action=register'
        ])
            @field([
                'type' => 'text',
                'attributeList' => [
                    'type' => 'number',
                    'name' => 'pnr',
                ],
                'label' => "Ange ditt personnummer"
            ])
            @endfield

            @field([
                'type' => 'text',
                'attributeList' => [
                    'type' => 'text',
                    'name' => 'name',
                ],
                'label' => "För och efternamn"
            ])
            @endfield

            @field([
                'type' => 'email',
                'attributeList' => [
                    'type' => 'text',
                    'name' => 'email',
                ],
                'label' => "Epostadress"
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
                        'text' => 'Registrera konto',
                        'color' => 'primary',
                        'type' => 'basic'
                    ])
                    @endbutton
                </div>
            </div>
        @endform
    @endpaper
@stop