@extends('layout.containers.page')

@section('article')
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
      Betalning
    @endtypography

    @include('partials.progress',[
      'percent' => 75
    ])

    <div class="u-margin__bottom--4">

      @button([
        'color' => 'primary',
        'text' => 'Kortbetalning',
        'size' => 'md',
        'type' => 'basic',
        'href' => '/boka/betala?id=' . $_GET['id'],
        'attributeList' => ['disabled' => 'disabled']
      ])
      @endbutton

      @button([
        'color' => 'primary',
        'text' => 'Swish',
        'size' => 'md',
        'type' => 'basic',
        'href' => '/boka/betalaswish?id=' . $_GET['id'],
      ])
      @endbutton

    </div>


    @form([
      'id' => 'card-payment',
      'method' => 'POST',
      'action' => '/boka/klar?action=swishPayment'
    ])

      @field([
        'type' => 'text',
        'value' => $user->namn,
        'attributeList' => [
            'type' => 'text',
            'name' => 'name',
        ],
        'label' => "Namn på kort"
      ])
      @endfield

      @field([
          'type' => 'text',
          'value' => '',
          'attributeList' => [
              'type' => 'number',
              'name' => 'cardnumber',
          ],
          'label' => "Kortnummer"
      ])
      @endfield

      <div class="o-grid u-margin--0">
        <div class="o-grid-auto u-padding--0 u-margin--0">
          @field([
            'type' => 'text',
            'value' => date("m"),
            'attributeList' => [
                'type' => 'number',
                'name' => 'expirymonth',
            ],
            'label' => "Giltigt till (månad)",
            'classList' => ['u-margin__right--1']
          ])
          @endfield
        </div>
        <div class="o-grid-auto u-padding--0 u-margin--0">
          @field([
            'type' => 'text',
            'value' => date("y"),
            'attributeList' => [
                'type' => 'number',
                'name' => 'expiryyear',
            ],
            'label' => "Giltigt till (år)"
          ])
          @endfield
        </div>
      </div>

      @field([
          'type' => 'text',
          'value' => '',
          'attributeList' => [
              'type' => 'number',
              'name' => 'cvc',
          ],
          'label' => "CVC kod"
      ])
      @endfield

      <div class="o-grid">
          <div class="o-grid-auto">
          </div>
          <div class="o-grid-fit">
              @button([
                  'text' => 'Betala',
                  'color' => 'primary',
                  'type' => 'basic'
              ])
              @endbutton
          </div>
      </div>
    @endform

  @endpaper
@endsection