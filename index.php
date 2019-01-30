<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/favicomatic/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/favicomatic/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/favicomatic/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/favicomatic/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="/favicomatic/apple-touch-icon-60x60.png" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="/favicomatic/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="/favicomatic/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="/favicomatic/apple-touch-icon-152x152.png" />
    <link rel="icon" type="image/png" href="/favicomatic/favicon-196x196.png" sizes="196x196" />
    <link rel="icon" type="image/png" href="/favicomatic/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/png" href="/favicomatic/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="/favicomatic/favicon-16x16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="/favicomatic/favicon-128.png" sizes="128x128" />
    <meta name="application-name" content="GOGOTV"/>
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="msapplication-TileImage" content="/favicomatic/mstile-144x144.png" />
    <meta name="msapplication-square70x70logo" content="/favicomatic/mstile-70x70.png" />
    <meta name="msapplication-square150x150logo" content="/favicomatic/mstile-150x150.png" />
    <meta name="msapplication-wide310x150logo" content="/favicomatic/mstile-310x150.png" />
    <meta name="msapplication-square310x310logo" content="/favicomatic/mstile-310x310.png" />
    <!-- <meta name="apple-mobile-web-app-capable" content="yes" /> -->
    <!-- <meta name="apple-mobile-web-app-status-bar-style" content="black" /> -->

    <title>GogoTV</title>
</head>
<body>

    <div class="container py-5">

        <form class="form" action="/" method="GET">
            <div class="input-group mb-3">
                <input type="text" name="episode" class="form-control" id="anime-episode-go-input" placeholder="https://gogoanime.io">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" id="anime-episode-go-submit">Go</button>
                </div>
            </div>
        </form>

        <div class="list-group d-hide mb-3" id="anime-episodes"></div>

        <div id="anime-player" class="d-hide mb-3">
            <div class="embed-responsive embed-responsive-16by9">
                <iframe id="anime-player-iframe" class="embed-responsive-item" src=""></iframe>
            </div>
        </div>
        <nav class="mb-3 d-hide text-center" id="anime-episode-pagination">
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="" id="anime-episode-pagination-prev" class="btn btn-outline-secondary"></a>
                <a href="" id="anime-episode-pagination-next" class="btn btn-outline-secondary"></a>
            </div>
        </nav>
        <div class="list-group d-hide mb-3" id="anime-episode-server"></div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

    <?php if ( !empty( $_GET['episode'] ) ) : ?>

        <script type="text/javascript">

        var base_url = '/';
        var api_base_url = 'https://gogoanime.io';
        var url = api_base_url + '/<?= $_GET['episode'] ?>';

        function anime_episode_go_input()
        {
            $( '#anime-episode-go-input' ).on('blur, keyup', function() {
                var input = $(this);
                var value = input.val();
                if ( value.includes( api_base_url ) ) {
                    var new_value = value.replace( api_base_url, '' );
                    new_value = new_value.replace( '/', '' );
                    input.val( new_value );
                }
            });
        }
        anime_episode_go_input();

        function anime_episode_server( source )
        {
            var list = [];
            var $source = $( source );
            $source.find( '.anime_muti_link a' ).each(function() {
                var $this = $(this);
                var url = $.trim( $this.attr('data-video') );
                var title = $this.text();
                title = title.replace('Choose this server', '');
                list.push({
                    url: url,
                    title: title
                });
            });
            return list;
        }

        function anime_episode_server_hide()
        {
            $( '#anime-episode-server' ).addClass('d-hide');
        }

        function anime_episode_server_show()
        {
            $( '#anime-episode-server' ).removeClass('d-hide');
        }

        function anime_episode_server_view( list )
        {
            var $view = $( '#anime-episode-server' );
            $view.html( '' );
            $.each(list, function( index, item ) {
                $view.append(`<a href="${item.url}" class="list-group-item list-group-item-action">${item.title}</a>`);
            });
        }

        function anime_get_source( url, successCallback, errorCallback )
        {
            $.ajax({
                url: base_url + 'api.php',
                data: {
                    get_source: url
                },
                success: function( source ) {
                    if (typeof successCallback === 'function') {
                        successCallback( source );
                    }
                },
                error: function() {
                    if (typeof errorCallback === 'function') {
                        errorCallback();
                    }
                }
            });
        }

        function anime_episode_pagination( source )
        {
            var list = {
                prev: {
                    url: null,
                    title: null
                },
                next: {
                    url: null,
                    title: null
                }
            };
            var $source = $( source );
            var l = $source.find( '.anime_video_body_episodes_l a' );
            list['prev']['url'] = l.length ? l.attr('href') : null;
            list['prev']['title'] = l.length ? $.trim( l.text().replace('<<', '') ).replace('/', '') : null;
            var r = $source.find( '.anime_video_body_episodes_r a' );
            list['next']['url'] = r.length ? r.attr('href') : null;
            list['next']['title'] = r.length ? $.trim( r.text().replace('>>', '') ).replace('/', '') : null;
            return list;
        }

        function anime_episode_pagination_view( list )
        {
            if ( list.prev.url ) {
                $( '#anime-episode-pagination-prev' )
                    .attr('href', base_url + '?episode=' + list.prev.url)
                    .html(list.prev.title);
            } else {
                $( '#anime-episode-pagination-prev' ).remove();
            }

            if ( list.next.url ) {
                $( '#anime-episode-pagination-next' )
                    .attr('href', base_url + '?episode=' + list.next.url)
                    .html(list.next.title);
            } else {
                $( '#anime-episode-pagination-next' ).remove();
            }

            $('#anime-episode-pagination').removeClass('d-hide');
        }

        function anime_episode_server_service()
        {
            anime_get_source(url, function( source ) {
                var list = anime_episode_server( source );

                if ( list ) {
                    anime_episode_server_view( list );
                    anime_episode_server_show();
                    anime_episode_player_view( list[0].url );

                    anime_episode_pagination_view( anime_episode_pagination( source ) );
                }
            }, function() {
                alert('Oops... Something went wrong!');
            });
        }

        function anime_episode_player_view( src )
        {
            $('#anime-player-iframe').attr('src', src).removeClass('u-hide');
        }

        function anime_episode_server_binds()
        {
            $(document).on('click', '.anime-episode-server', function( e ) {
                e.preventDefault();
                anime_episode_player_view( $(this).attr('href') );
            });
        }

        // anime_video_body_watch_items
        anime_episode_server_service();
        anime_episode_server_binds();

        </script>
    <?php endif ?>
</body>
</html>
