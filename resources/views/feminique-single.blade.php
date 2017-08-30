<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Feminique Woman</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,400,600" rel="stylesheet" type="text/css" />
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/main.css') }}"  />
    </head>
    <body>
        <div class="flex-center position-ref four-quarter-height">
          <div class="banner xfashion" style="background-image:url('/fem/{{$data['fashion']->cover}}')">
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
                        <div class="tenets_front_man read"><i class="fa fa-align-left" ></i>&nbsp;&nbsp;Purposes</div>
                        <ul class="menu">
                          <li><a href="{{ url('/tenets/gods-daughter')}}">God's Daughter</a></li>
                          <li><a href="{{ url('/tenets/wife')}}">Wife</a></li>
                          <li><a href="{{ url('/tenets/mother')}}">Mother</a></li>
                          <li><a href="{{ url('/tenets/career-woman')}}">Career Woman</a></li>
                          <li><a href="{{ url('/tenets/nation-builder')}}">Nation Builder</a></li>
                        </ul>
                      </div>
                      <div class="links">
                          <a href="/">Home</a>
                          <a href="{{ url('/about-us')}}">About Us</a>
                          <span class="link on">
                            <a href="{{ url('/feminique-woman')}}">Feminique Woman</a>
                            <div class="categories">
                              <span class="shower">{{$data['fashion']->category}}&nbsp;&nbsp;<i class="fa fa-angle-down"></i></span>
                              <ul class="categories_list">
                                <li><a href="{{ url('/feminique-woman/dresses')}}">Dresses</a></li>
                                <li><a href="{{ url('/feminique-woman/kids')}}">Kids</a></li>
                                <li><a href="{{ url('/feminique-woman/events')}}">Events</a></li>
                                <li><a href="{{ url('/feminique-woman/jewellery')}}">Jewellery</a></li>
                                <li><a href="{{ url('/feminique-woman')}}">All Categories</a></li>
                              </ul>
                            </div>
                          </span>
                          <a href="{{ url('/ask-kenny')}}">Ask Kenny</a>
                          <a href="{{ url('/blog')}}">Blog</a>
                      </div>
                    </div>
                  </div>

                </div>


              </div>
            </div>
          </div>

            <div class="read_block">
              <div class="fashion-read">

                <div class="title-section">
                  <div class="titlex">{{$data['fashion']->title}}</div>
                  <div class="category"><span>{{$data['fashion']->category}}</span></div>
                  <div class="author"></div>
                </div>

                <section class="content">
                  <div class="body">
                    {{$data['fashion']->body}}
                  </div>
                  <div class="more">

                    @foreach ($data['recommended'] as $fashion)

                    <a href="{{ url('/feminique-woman/' . $fashion->categoryFriendly() . '/'  . $fashion->ID . '/' . $fashion->urlFriendly())}}" class="bg small" style="background-image:url('/fem/{{$fashion->cover}}')">
                      <div class="overlay"></div>
                      <div class="ryuk">
                        <div class="category">{{$fashion->category}}</div>
                        <div class="ruler">
                          <div class="first"></div>
                          <div class="second"></div>
                        </div>
                        {{$fashion->title}}
                      </div>
                    </a>

                    @endforeach

                  </div>
                </section>

                <div class="footerholder">
                  <div class="footer x-footer-fashion">
                    <div>All Rights Reserved. A Beautiful Life &copy; 2017</div>
                    <div>Designed with <i class="fa fa-heart"></i> in Lagos, Nigeria by <a href="http://ephodng.com" target="_blank">Ephod&trade;</a></div>
                    <div class="icons"><i class="fa fa-instagram"></i><i class="fa fa-facebook-square"></i><i class="fa fa-twitter-square"></i></div>
                  </div>
                </div>
              </div>



            </div>

        </div>

        <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="{{ asset('/js/ninja.js') }}"></script>

        <script>
        $(document).ready(function(){
          //if the events are enough, create this fucking slider

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
        });
        </script>

    </body>
</html>
