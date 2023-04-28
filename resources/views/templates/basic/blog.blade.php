@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="blog-section pt-120 pb-120 overflow-hidden">
        <div class="container">
            <div class="row justify-content-center gy-4">
                @foreach ($blogs as $blog)
                    <div class="col-lg-4 col-md-6 col-sm-10">
                        <div class="post-item">
                            <div class="post-item__thumb">
                                <img src="{{ getImage('assets/images/frontend/blog/thumb_' . @$blog->data_values->image, '420x240') }}" alt="blog">
                            </div>
                            <div class="post-item__content">
                                <h5 class="title"><a href="{{ route('blog.details', [slug(@$blog->data_values->title), $blog->id]) }}">{{ __(@$blog->data_values->title) }}</a>
                                </h5>
                                <p>@php echo strLimit(strip_tags(@$blog->data_values->description), 90) @endphp</p>
                                <a class="read-more text--base" href="{{ route('blog.details', [slug(@$blog->data_values->title), $blog->id]) }}">@lang('Read More')</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{ $blogs->links() }}
            </div>
        </div>
    </section>

    @if ($sections != null)
        @foreach (json_decode($sections) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
