@extends('layout.containers.page')
@section('article')

    @notice([
        'type' => 'warning',
        'message' => [
            'text' => '<strong>Använd inte riktiga personuppgifter!</strong><p>Det här är en proof-of-concept applikation som inte uppfyller de säkerhetskrav som normalt ställs på applikationer som hanterar personuppgifter. Använd därför inga riktiga personuppgifter vid registrering.</p>',
            'size' => 'sm'
        ],
        'icon' => [
            'name' => 'report',
            'size' => 'md',
            'color' => 'white'
        ],
        'classList' => ['u-margin__bottom--4', 'o-grid-12', 'o-grid-6@md', 'u-align-self--center']
    ])
    @endnotice

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