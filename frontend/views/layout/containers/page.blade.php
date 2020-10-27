@extends('layout.master')

@section('content')
<div class="page">
    <div class="o-container">
        <section class="u-margin__top--8">
            <article class="article">
                @yield('article')
            </article>
        </section>
        @include('layout.footer')
    </div>
</div>
@stop