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
      Boka: HbgWorks - StreetFighter
    @endtypography

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
            Måndag 15/5
          @endtypography
          @typography([])
            {{ $time->startTid}} - {{ $time->slutTid}}
          @endtypography

          @slot('secondary')

            @if($time->tillganglig)
              @button(['href' => '/boka?id=&time=' . time()])
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

  @endpaper
@endsection