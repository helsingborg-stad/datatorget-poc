@extends('layout.containers.page')
@section('article')

    @if($action == "register") 
        @notice([
            'type' => 'success',
            'message' => [
                'text' => 'Ditt konto har registrerats!',
                'size' => 'sm'
            ],
            'icon' => [
                'name' => 'check',
                'size' => 'md',
                'color' => 'white'
            ],
            'classList' => ['u-margin__bottom--4', 'o-grid-12', 'o-grid-6@md', 'u-align-self--center']
        ])
        @endnotice

        @button([
            'href' => '/',
            'text' => 'Härligt! Ta mig till inloggningen',
            'color' => 'primary',
            'type' => 'basic',
            'size' => 'lg',
            'classList' => ['o-grid-12', 'o-grid-6@md', 'u-align-self--center']
        ])
        @endbutton

    @else 

        

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
                        'type' => 'text',
                        'name' => 'pnr',
                    ],
                    'label' => "Ange ditt personnummer"
                ])
                @endfield

                @field([
                    'type' => 'text',
                    'attributeList' => [
                        'type' => 'text',
                        'name' => 'firstname',
                    ],
                    'label' => "Förnamn"
                ])
                @endfield

                @field([
                    'type' => 'text',
                    'attributeList' => [
                        'type' => 'text',
                        'name' => 'lastname',
                    ],
                    'label' => "Efternamn"
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

    @endif

@stop