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
      
      @for($i = 1; $i <= 6; $i++)

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
            10:00 - 15:00
          @endtypography

          @slot('secondary')
            @button(['href' => '/boka?id=' . $i . '&time=' . time()])
              Boka
            @endbutton
          @endslot
        @endcollection__item

      @endfor

    @endcollection

    @pagination([
      'list' => [
          ['href' => $pageNow . '?pagination=1', 'label' => 'Page 1'],
          ['href' => $pageNow . '?pagination=2', 'label' => 'Page 2'],
          ['href' => $pageNow . '?pagination=3', 'label' => 'Page 3'],
      ],
      'current' => $pagination,
      'classList' => ['u-margin__top--4', 'u-display--flex', 'u-justify-content--center']
    ])
    @endpagination

  @endpaper
@endsection