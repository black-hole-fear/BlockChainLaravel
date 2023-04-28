@php
$blogs = getContent('blog.element',false,3,true);
$blogContent = getContent('blog.content', true);
@endphp
<section class="blog-section pt-120 pb-120 overflow-hidden">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="section-header text-center">
                    <h2 class="section-header__title text--base">{{ __(@$blogContent->data_values->heading) }}</h2>
                    <p>{{ __(@$blogContent->data_values->subheading) }}</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center gy-4">
            @foreach ($blogs as $blog)
            <div class="col-lg-4 col-md-6 col-sm-10">
                <div class="post-item">
                    <div class="post-item__thumb">
                        <img src="{{ getImage('assets/images/frontend/blog/thumb_' . @$blog->data_values->image, '420x240') }}" alt="blog">
                    </div>
                    <div class="post-item__content">
                        <h5 class="title">
                            <a href="{{ route('blog.details', [slug(@$blog->data_values->title), $blog->id]) }}">{{ __(@$blog->data_values->title) }}</a>
                        </h5>
                        <p>@php echo strLimit(strip_tags(@$blog->data_values->description), 90) @endphp</p>
                        <a href="{{ route('blog.details', [slug(@$blog->data_values->title), $blog->id]) }}" class="read-more text--base">@lang('Read More')</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
