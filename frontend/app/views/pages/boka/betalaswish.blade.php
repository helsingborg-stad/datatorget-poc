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

      <div class="s-group">
        @button([
          'text' => 'Kortbetalning',
          'size' => 'md',
          'type' => 'basic',
          'href' => '/boka/betala?id=' . $_GET['id'] . "&response=" . $_GET['response'],
        ])
        @endbutton

        @button([
          'color' => 'primary',
          'text' => 'Swish',
          'size' => 'md',
          'type' => 'basic',
          'attributeList' => [
            'disabled' => 'disabled',
          ]
        ])
        @endbutton
      </div>

    </div>

    @form([
      'id' => 'swish-payment',
      'method' => 'POST',
      'action' => '/boka/betala?action=swishPayment&id=' . $_GET['id'] . "&response=" . $_GET['response']
    ])
      @field([
          'type' => 'text',
          'value' => '',
          'attributeList' => [
              'type' => 'number',
              'name' => 'phone',
          ],
          'label' => "Telefonnummer"
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