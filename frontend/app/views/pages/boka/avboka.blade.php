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
      Avboka tid
    @endtypography

    @typography()
      Är du säker på att du vill avboka den här tiden? 
    @endtypography

    @button([
      'color' => 'primary',
      'text' => 'Avboka',
      'size' => 'md',
      'type' => 'basic',
      'href' => '/boka/avboka?action=unbook&id=' . $_GET['id'],
    ])
    @endbutton

  @endpaper

@endsection