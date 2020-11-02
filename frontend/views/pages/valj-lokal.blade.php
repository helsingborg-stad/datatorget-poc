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
      Välj lokal
    @endtypography

    @collection(['sharp' => true, 'bordered' => true])

      @if($locations) 
        @foreach($locations as $location)
          @collection__item()
            @slot('prefix')
              <div class="c-collection__icon">
                @icon(['icon' => 'room', 'size' => 'md'])
                @endicon
              </div>
            @endslot

            @typography(['element' => 'h4'])
              {{ $location->namn }}
            @endtypography
            @typography([])
              Antal stolar: {{ $location->egenskaper->capacity }} <span style="padding: 0 16px; display: inline-block; color: #999;"> | </span> Timpris: {{ $location->timpris }}:-
            @endtypography

            @slot('secondary')
              @button(['href' => '/boka?id=' . $location->resursId])
                Välj
              @endbutton
            @endslot
          @endcollection__item
        @endforeach
      @else
        @notice([
          'type' => 'info',
          'message' => [
              'text' => 'Det finns inga bokningsbara lokaler just nu.',
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
@endsection