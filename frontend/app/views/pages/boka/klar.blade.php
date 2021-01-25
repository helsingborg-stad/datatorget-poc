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
      Tack för din bokning
    @endtypography

    @include('partials.progress',[
      'percent' => 100
    ])

    @typography([])
      Din bokning är genomförd. Du kommer inom kort få en bekräftelse på din bokning skickad via e-post. Via <a href="/mitt-konto">"Mitt konto"</a> har du möjlighet till att hantera dina bokningar.
    @endtypography

    <div class="o-grid">
      <div class="o-grid-auto  u-margin__bottom--0">
      </div>
      <div class="o-grid-fit  u-margin__bottom--0">
        @button(['href' => '/mitt-konto/#bookings'])
          Logga ut
        @endbutton
        @button(['href' => '/mitt-konto/#bookings', 'classList' => ['u-margin__left--2'], 'color' => 'primary'])
          Hantera mina bokningar
        @endbutton
      </div>
    </div>

  @endpaper
@endsection