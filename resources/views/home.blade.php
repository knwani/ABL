<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>A Beautiful Life By Kenny</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css" />
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/main.css') }}"  />
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/big.css') }}"  />
        <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
        <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/nprogress.css') }}"  />
    </head>

    <body>
        <div class="flex-center position-ref full-height">
          <div class="banner">
            <div class="overlay"></div>
            <div class="content">
              <div class="header">
                <div class="shell">

                  <div class="shell_inner">
                    <div class="extreme">
                      <div class="mobile_menu">
                        <i class="fa fa-2x fa-bars"></i>
                      </div>
                      <div class="shell_logo">
                        <img src="{{ asset('/images/small_logo.png') }}"/>
                      </div>
                    </div>
                    <div class="morty">
                      <div class="tenets">
                        <div class="tenets_front_man"><i class="fa fa-align-left" ></i>&nbsp;&nbsp;Purposes</div>
                        <ul class="menu">
                          <li><a href="{{ url('/tenets/gods-daughter')}}">God's Daughter</a></li>
                          <li><a href="{{ url('/tenets/wife')}}">Wife</a></li>
                          <li><a href="{{ url('/tenets/mother')}}">Mother</a></li>
                          <li><a href="{{ url('/tenets/career-woman')}}">Career Woman</a></li>
                          <li><a href="{{ url('/tenets/nation-builder')}}">Nation Builder</a></li>
                        </ul>
                      </div>
                      <div class="links">
                          <a href="{{ url('/about-us')}}">About Us</a>
                          <a href="{{ url('/feminique-woman')}}">Feminique Woman</a>
                          <a href="{{ url('/unique-man')}}">Unique Man</a>
                          <a href="{{ url('/ask-kenny')}}">Ask Kenny</a>
                          <a href="{{ url('/gallery')}}">Gallery</a>
                          <a href="{{ url('/blog')}}">Blog</a>
                      </div>
                    </div>
                  </div>

                </div>


              </div>
              <div class="middle_piece home">
                <img src="{{ asset('/images/header_twp.png') }}"/>
              </div>
              <div class='icon-scroll'></div>
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
        <div class="alert">
          <a href="{{ url('/welcome-address') }}">Read Founder's welcome address</a>
        </div>
        <div class="scroller">
          <ul class="events">
          @foreach ($data['events'] as $event)

            <li >
              <div class="overlay" style="background-image:url('/events/{{$event->header}}')"></div>
              <div class="content">
                <span class="title">{{$event->event_name}}</span>
                <span class="desc">{{$event->description}}</span>
                <span class="date">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $event->created_at)->format('d M Y')}}</span>
                <a class="button" href="{{ url('/event/' . $event->id . '/' . $event->urlFriendly())}}">View Event</a>
              </div>
            </li>
          @endforeach
          </ul>
        </div>

        <div class="call_to_action">
          <span>Sign up to be a part of the ABL family!</span>

          <input type="text" placeholder="Name" id="name"/>
          <input type="text" placeholder="Phone Number" id="number"/>
          <input type="text" placeholder="E-mail" id="e-mail"/>

          <a href="javascript:void(0)" onclick="signUpNewsletter()" class="button" id="call_to_action_send">Sign Up</a>

          <div class="spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
          </div>
        </div>

        <div class="tenets_new_block_parent">
          <div class="overlay_x"></div>
          <div class="tenets_new_block">

            @foreach ($data['tenets'] as $indexKey => $tenet)

              @if ($indexKey == 1)

              <div class="big_block">

              <a href="{{ url('/tenets/' . $tenet->id . '/' . $tenet->tenetFriendly() . '/' . $tenet->urlFriendly())}}" class="bg small" style="background-image:url('/tenets/{{$tenet->cover}}')">
                <div class="overlay"></div>
                <div class="content">
                  <div class="category_parent">
                    <span class="category">{{$tenet->category}}</span>
                  </div>
                  <span class="title">{{$tenet->article_name}}</span>
                </div>
              </a>

              @elseif ($indexKey == 2)

              <a href="{{ url('/tenets/' . $tenet->id . '/' . $tenet->tenetFriendly() . '/' . $tenet->urlFriendly())}}" class="bg small" style="background-image:url('/tenets/{{$tenet->cover}}')">
                <div class="overlay"></div>
                <div class="content">
                  <div class="category_parent">
                    <span class="category">{{$tenet->category}}</span>
                  </div>
                  <span class="title">{{$tenet->article_name}}</span>
                </div>
              </a>

              </div>

              @elseif ($indexKey == 3)

              <div class="big_block">

              <a href="{{ url('/tenets/' . $tenet->id . '/' . $tenet->tenetFriendly() . '/' . $tenet->urlFriendly())}}" class="bg small" style="background-image:url('/tenets/{{$tenet->cover}}')">
                <div class="overlay"></div>
                <div class="content">
                  <div class="category_parent">
                    <span class="category">{{$tenet->category}}</span>
                  </div>
                  <span class="title">{{$tenet->article_name}}</span>
                </div>
              </a>

              @elseif ($indexKey == 4)

              <a href="{{ url('/tenets/' . $tenet->id . '/' . $tenet->tenetFriendly() . '/' . $tenet->urlFriendly())}}" class="bg small" style="background-image:url('/tenets/{{$tenet->cover}}')">
                <div class="overlay"></div>
                <div class="content">
                  <div class="category_parent">
                    <span class="category">{{$tenet->category}}</span>
                  </div>
                  <span class="title">{{$tenet->article_name}}</span>
                </div>
              </a>

              </div>

              @else

              <a href="{{ url('/tenets/' . $tenet->id . '/' . $tenet->tenetFriendly() . '/' . $tenet->urlFriendly())}}" class="big_block">

              <div class="bg" style="background-image:url('/tenets/{{$tenet->cover}}')">
                <div class="overlay"></div>
                <div class="content">
                  <div class="category_parent">
                    <span class="category">{{$tenet->category}}</span>
                  </div>
                  <span class="title">{{$tenet->article_name}}</span>
                </div>
              </div>

            </a>

              @endif

            @endforeach

          </div>

          <div class="footer">
            <div>All Rights Reserved. A Beautiful Life &copy; 2017</div>
            <div>Designed with <i class="fa fa-heart"></i> in Lagos, Nigeria by <a href="http://ephodng.com" target="_blank">Ephod&trade;</a></div>
            <div class="icons"><a href="https://www.instagram.com/abeautifullifebykenny" target="_blank"><i class="fa fa-instagram"></i></a><a href="https://www.facebook.com/ablbykenny" target="_blank"><i class="fa fa-facebook-square"></i></a><a href="https://twitter.com/ablbykenny" target="_blank"><i class="fa fa-twitter-square"></i></a><a href="https://www.youtube.com/channel/UCgYF0G6EPQAfVIvaRa-oB2A" target="_blank"><i class="fa fa-youtube-square"></i></a></div>
          </div>
        </div>

        <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="slick/slick.min.js"></script>
        <script type="text/javascript" src="{{ asset('/js/ninja.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/nprogress.js') }}"></script>

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

          $(".tenets").click(function(){
            if($(".menu").css("display") == "none"){
              $(".menu").css("display", "block");
            } else {
              $(".menu").css("display", "none");
            }
            event.stopPropagation();
          });

          $("body").click(function(){
            $(".menu").css("display", "none");
          });

          var s = $(".header");
          var pos = s.position();
          //alert(pos.top);

          $(window).scroll(function () {
              var windowpos = $(window).scrollTop();
              //s.html("Distance from top: " + pos.top + "<br/>Scroll position: " + windowpos);
              if (windowpos > pos.top) {
                  s.addClass("header_bg");
                  //s.addClass("stick");
              } else if (windowpos <= pos.top) {
                  //s.removeClass("stick");
                  s.removeClass("header_bg");
              }

          });
        });
        </script>

    </body>
</html>
