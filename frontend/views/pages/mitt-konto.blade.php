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
            Mitt konto
        @endtypography

        @typography([])
            Här kan du uppdatera dina kontouppgifter
        @endtypography

        @form([
            'method' => 'POST',
            'action' => '/mitt-konto/?action=update'
        ])
            @field([
                'type' => 'text',
                'value' => $user->personnr,
                'attributeList' => [
                    'type' => 'number',
                    'name' => 'pnr',
                    'disabled' => 'disabled'
                ],
                'label' => "Ditt personnummer"
            ])
            @endfield

            @field([
                'type' => 'text',
                'value' => $user->namn,
                'attributeList' => [
                    'type' => 'text',
                    'name' => 'name',
                ],
                'label' => "För och efternamn"
            ])
            @endfield

            @field([
                'type' => 'text',
                'value' => $user->epost,
                'attributeList' => [
                    'type' => 'text',
                    'name' => 'email',
                ],
                'label' => "Epostadress"
            ])
            @endfield

            <div class="o-grid">
                <div class="o-grid-auto">
                </div>
                <div class="o-grid-fit">
                    @button([
                        'text' => 'Uppdatera',
                        'color' => 'primary',
                        'type' => 'basic'
                    ])
                    @endbutton
                </div>
            </div>
        @endform
    @endpaper
@stop