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



    @paper([
    'padding'=> 4, 
    'classList' => ['o-grid-12', 'o-grid-6@md', 'u-align-self--center']
  ])

    @typography([
      'element' => 'h1',
      'classList' => [
        'u-color__text--primary', 
        'u-margin__bottom--2'
      ]
    ])
      Mina bokningar
    @endtypography


    @collection(['sharp' => true, 'bordered' => true])
      @if($bookings) 
        @foreach($bookings as $booking)
          @collection__item()
            @slot('prefix')
              <div class="c-collection__icon">
                @icon(['icon' => 'room', 'size' => 'md'])
                @endicon
              </div>
            @endslot

            @typography(['element' => 'h4'])
              {{ $booking->bokningsnr }}
            @endtypography
            @typography([])
              
            @endtypography

            @slot('secondary')
              @button(['href' => '/boka/tid?id='])
                Avboka
              @endbutton
              @button(['href' => '/boka/tid?id=', 'classList' => ['u-margin__left--2']])
                Betala
              @endbutton
            @endslot
          @endcollection__item
        @endforeach
      @else
        @notice([
          'type' => 'info',
          'message' => [
              'text' => 'Du har inte gjort några bokningar ännu.',
              'size' => 'sm'
          ],
          'icon' => [
              'name' => 'report',
              'size' => 'md',
              'color' => 'white'
          ]
        ])
        @endnotice
      @endif

    @endcollection

  @endpaper





    <?php var_dump($bookings); ?>
@stop