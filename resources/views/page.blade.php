@extends('layouts.app')
@section('content')
    <div class="main-content_main" style="clear: both;">
    </div>

    <div class="container">

        <div class="gird_about_main_home" >
            <div class="image-section">
                <div class="image-wrapper">
                    <img src="{{ asset('storage/' . $page->image) }}"
                        alt="{{ $page->title }}" class="cake-image">
                </div>
            </div>

            <div class="content">
                <h2>{{ $page->title }}</h2>

                <div class="text-content">
                    {!! $page->description !!}
                </div>

            </div>

        </div>


    </div>
@endsection
