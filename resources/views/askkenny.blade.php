<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Ask Kenny</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css" />
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/main.css') }}"  />
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/big.css') }}"  />
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/nprogress.css') }}"  />
    </head>
    <body>
        <div class="flex-center position-ref full-height">
          <div class="banner skew">
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
                          <a href="{{ url('/feminique-woman')}}">Feminique Woman</a>
                          <a class="on" href="{{ url('/ask-kenny')}}">Ask Kenny</a>
                          <a href="{{ url('/blog')}}">Blog</a>
                      </div>
                    </div>
                  </div>

                </div>


              </div>
              <div class="middle_piece larger no_padding">
                <div>
                  <p class="greeting">Hi there</p>
                  <p class="first">My name is Kenny Nwani, I am the founder of the A Beautiful Life By Kenny initiative as well as the GMD/CEO of Meadow Hall Group and together with my mentoring partners, we'll be on hand to answer any pressing questions you may have. Bless you!</p>
                </div>

                <div>

                </div>
              </div>

              <div class="two--show bio__portrait bio_bounce"></div>
            </div>
          </div>

            <div class="read_block">
              <div class="about">
              <div class="questions_bg">
                <div class="questions">
                  <div class="top_header">
                    <span class="title">Questions</span>
                    <a class="ask button" onclick="showQuestionAskbox()">Ask a question</a>
                  </div>

                  <div class="content question">
                    @if($data['questions']->isEmpty())

                    <div class="empty">
                      No questions have been asked yet. You could be the first. Go ahead, ask a question
                    </div>

                    @else


                    @foreach ($data['questions'] as $indexKey => $question)
                    <!--href="{{ url('/ask-kenny/' . $question->ID . '/' . $question->titleFriendly())}}"-->
                      <a onclick="showQuestion(this)" data-id="{{$question->ID}}" data-path="{{ url('/ask-kenny/' . $question->ID . '/' . $question->titleFriendly())}}" class="question_item" >
                          <div class="question_content">

                            <div class="asker">
                              <img src="{{$question->getAvatar()}}" />
                              <div class="details">
                                <span class="name">{{$question->Who}}</span>
                                <span class="date">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $question->created_at)->format('d M Y h:i a')}}</span>
                              </div>
                            </div>
                            <div class="sparrow">
                              <div class="question_title">{{$question->Question}}</div>
                              <div class="question_status">{{$question->checkAnswer()}}</div>
                              <div class="answer" id="answer">
                                <img src="{{asset('/images/kenny-headshot.png')}}" />
                                <div class="answer_content">
                                  <div class="name">Kenny Nwani</div>
                                  <div class="brex">{{$question->checkAnswerValue()}}</div>
                                </div>
                              </div>
                              <div class="answer" id="answer">
                                <img src="{{asset('/authors/anon.jpg')}}" />
                                <div class="answer_content">
                                  <div class="name">Aderenle Lokulo-Sodipe</div>
                                  <div class="brex">{{$question->ade}}</div>
                                </div>
                              </div>
                              <div class="answer" id="answer">
                                <img src="{{asset('/authors/sade.jpg')}}" />
                                <div class="answer_content">
                                  <div class="name">Sade Bamgboye</div>
                                  <div class="brex">{{$question->sade}}</div>
                                </div>
                              </div>
                            </div>
                          </div>
                      </a>
                    @endforeach


                    @endif
                  </div>


                </div>
              </div>

              <div class="footer">
                <div>All Rights Reserved. A Beautiful Life &copy; 2017</div>
                <div>Designed with <i class="fa fa-heart"></i> in Lagos, Nigeria by <a href="http://ephodng.com" target="_blank">Ephod&trade;</a></div>
                <div class="icons"><a href="https://www.instagram.com/abeautifullifebykenny" target="_blank"><i class="fa fa-instagram"></i></a><a href="https://www.facebook.com/ablbykenny" target="_blank"><i class="fa fa-facebook-square"></i></a><a href="https://twitter.com/ablbykenny" target="_blank"><i class="fa fa-twitter-square"></i></a><a href="https://www.youtube.com/channel/UCgYF0G6EPQAfVIvaRa-oB2A" target="_blank"><i class="fa fa-youtube-square"></i></a></div>
              </div>
            </div>

          </div>
        </div>

        <div class="parentModal ng-scope" style="">

        <div class="close"><i class="fa fa-close fa-fw"></i></div>

        <div class="parentModal_child">

          <div class="asking-questions">
            <div class="section_header">Ask a question</div>

            <form method="post">
              <textarea id="rum" class="more_bottom_margin" placeholder="Keep your question straight to the point, on one topic and under 140 characters" maxlength="140"></textarea>
            </form>

            <div class="buttons social">
              <a class="button facebook" onclick="askQuestion('Facebook')"><i class="fa fa-facebook-official"></i>Ask with Facebook</a>
              <a class="button twitter" onclick="askQuestion('Twitter')"><i class="fa fa-twitter-square"></i>Ask with Twitter</a>
              <a class="button google" onclick="askQuestion('Google')"><i class="fa fa-google-plus-square"></i>Ask with Google</a>
            </div>
          </div>

          @if(isset($data['question']))
            <script>var show_modal = true; </script>
            <div class="viewing-questions" data-path="{{url('')}}">
              <div class="question_content">
                <div class="asker" id="view-asker">
                  <img src="{{$data['question']->avatar}}" />
                  <div class="details" id="view-details">
                    <span class="name">{{$data['question']->Who}}</span>
                    <span class="date">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['question']->created_at)->format('d M Y h:i a')}}</span>
                  </div>
                </div>
                <div class="sparrow" id="view-sparrow">
                  <div class="question_title">{{$data['question']->Question}}</div>
                  <div class="question_status">{{$data['question']->checkAnswer()}}</div>
                  <div class="answer" id="answer">
                    <img src="{{asset('/images/kenny-headshot.png')}}" />
                    <div class="answer_content">
                      <div class="name">Kenny Nwani</div>
                      <div class="brex">{{$data['question']->checkAnswerValue()}}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @else
          <script>var show_modal = false;</script>
            <div class="viewing-questions" data-path="{{url('')}}">
              <div class="question_content">
                <div class="asker" id="view-asker">
                  <img src="" />
                  <div class="details" id="view-details">
                    <span class="name"></span>
                    <span class="date"></span>
                  </div>
                </div>
                <div class="sparrow" id="view-sparrow">
                  <div class="question_title"></div>
                  <div class="question_status"></div>

                </div>
              </div>
            </div>
          @endif

        </div>

        </div>

        <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="{{ asset('/js/ninja.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/nprogress.js') }}"></script>

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

          if(show_modal == true){
            showModal();
            $(".asking-questions").css("display", "none");
            $(".viewing-questions").css("display", "block");

            var the_former_link = $(".viewing-questions").attr('data-path') + "/ask-kenny";

            //set the close button
            $(".close").bind("click", function (){
              closeModal();
              history.pushState(null, null, the_former_link);
              //history.back();
            });
          }

          //alert(show_modal);

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
