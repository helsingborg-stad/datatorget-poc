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
      Välj tid: {{ $roomName }}
    @endtypography

    @include('partials.progress',[
      'percent' => 50
    ])

    @if($currentTimes)

      @collection(['sharp' => true, 'bordered' => true])
        @foreach($currentTimes as $time) 
          @collection__item()
            @slot('prefix')
              <div class="c-collection__icon">
                @icon(['icon' => 'query_builder', 'size' => 'md'])
                @endicon
              </div>
            @endslot

            @typography(['element' => 'h4'])
              {{ $time->day }}
            @endtypography
            @typography([])
              {{ $time->startTime}} - {{ $time->endTime }}
            @endtypography

            @slot('secondary')

              @if($time->isAvailable)
                @button(['href' => '/boka/tid?id=' . $_GET['id'] . "&data=" . $time->passTrough . "&action=make-booking"])
                  Boka
                @endbutton
              @endif
            @endslot
          @endcollection__item

        @endforeach

      @endcollection

      @pagination([
        'list' => $pages,
        'current' => $pagination,
        'classList' => ['u-margin__top--4', 'u-display--flex', 'u-justify-content--center']
      ])
      @endpagination

    @else

      @notice([
        'type' => 'info',
        'message' => [
            'text' => 'Det finns inga bokningsbara tider för den här lokalen just nu.',
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

  @endpaper
@endsection