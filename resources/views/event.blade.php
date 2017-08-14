<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css" />
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/main.css') }}"  />
        <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
        <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
          <div class="banner">
            <div class="overlay"></div>
            <div class="content">
              <div class="header">
                <div class="shell">

                  <div class="shell_inner">

                    <div class="shell_logo">
                      <img src="{{ asset('/images/small_logo.png') }}"/>
                    </div>
                    <div class="morty">
                      <div class="tenets">
                        <i class="fa fa-align-left" ></i>&nbsp;&nbsp;Tenets
                      </div>
                      <div class="links">
                          <a href="https://laravel.com/docs">Home</a>
                          <a href="https://laracasts.com">About Us</a>
                          <a href="https://laravel-news.com">Feminique Woman</a>
                          <a href="https://forge.laravel.com">Ask Kenny</a>
                          <a href="https://github.com/laravel/laravel">Blog</a>
                      </div>
                    </div>
                  </div>

                </div>


              </div>
              <div class="middle_piece">
                <img src="{{ asset('/images/logo.png') }}"/>
              </div>
            </div>
          </div>

            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">

            </div>
        </div>
        <div class="scroller">
          <ul class="events">
          @foreach ($data as $event)

            <li style="background-image:url('/events/{{$event->header}}')">
              <div class="overlay"></div>
              <div class="content">
                <span class="title">{{$event->event_name}}</span>
                <span class="desc">{{$event->description}}</span>
                <span class="date">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $event->created_at)->format('d M Y')}}</span>
                <a class="button" href="{{ url('/event/$event->id') }}">View Event</a>
              </div>
            </li>
          @endforeach
          </ul>
        </div>

        <div class="tenets_new_block">
          
        </div>

        <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="slick/slick.min.js"></script>

        <script>
        $(document).ready(function(){
          //if the events are enough, create this fucking slider
          if($('.events').length > 4){
            $('.events').slick({
                 infinite: true,
                 slidesToShow: 3,
                 slidesToScroll: 3
              });
          }
        });
        </script>

    </body>
</html>
