<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <title>News Bangla</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('frontend/assets/css/styles.css') }}" rel="stylesheet">
</head>

<body>

    <!-- Header news -->
    @include('frontend.section.heder')
    <!-- End Header news -->


    <!-- Tranding news  carousel-->
    @include('frontend.section.tranding-carousel')
    <!-- End Tranding news carousel -->

    <!-- Popular news -->
    @include('frontend.section.popular-news')
    <!-- End Popular news -->

    <div class="large_add_banner">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="large_add_banner_img">
                        <img src="images/placeholder_large.jpg" alt="adds">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular news category -->
    @include('frontend.section.popular-news-category')
    <!-- End Popular news category -->

    @include('frontend.section.footer')

    <a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>

    <script type="text/javascript" src="{{ asset('frontend/assets/js/index.bundle.js') }}"></script>
</body>

</html>
