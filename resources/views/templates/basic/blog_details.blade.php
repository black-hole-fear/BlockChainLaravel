@extends($activeTemplate.'layouts.frontend')

@section('content')
<section class="blog-section pt-120 pb-120">
    <div class="container">
        <div class="row gy-5">
            <div class="col-lg-8">
                <div class="blog-details-wrapper">
                    <div class="blog-details-thumb">
                        <img src="{{ getImage('assets/images/frontend/blog/' . @$blog->data_values->image, '840x480') }}" alt="blog">
                    </div>
                    <div class="blog-details-content">
                        <div class="blog-details-header">
                            <h3 class="title mb-4">{{ __(@$blog->data_values->title) }}</h3>
                        </div>
                        <p>
							@php echo $blog->data_values->description; @endphp
						</p>
                    </div>
                </div>
                <div class="fb-comments" data-href="{{ route('blog.details',[$blog->id,slug($blog->data_values->title)]) }}" data-numposts="5"></div>
				<ul class="post-share d-flex align-items-center justify-content-center mt-5 flex-wrap gap-3">
					<li class="caption">@lang('Share') : </li>
					<li data-bs-toggle="tooltip" data-bs-placement="top" title="Facebook">
						<a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"><i class="lab la-facebook-f"></i></a>
					</li>
					<li data-bs-toggle="tooltip" data-bs-placement="top" title="Linkedin">
						<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode(url()->current()) }}&amp;title={{ __(@$blog->data_values->title) }}&amp;summary={{ __(@$blog->data_values->description) }}"><i class="lab la-linkedin-in"></i></a>
					</li>
					<li data-bs-toggle="tooltip" data-bs-placement="top" title="Twitter">
						<a href="https://twitter.com/intent/tweet?text={{ __(@$blog->data_values->title) }}%0A{{ url()->current() }}"><i class="lab la-twitter"></i></a>
					</li>
					<li data-bs-toggle="tooltip" data-bs-placement="top" title="pinterest">
						<a href="http://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&description={{ __(@$blog->data_values->title) }}&media={{ getImage('assets/images/frontend/blog/' . $blog->data_values->image, '840x480') }}"><i class="lab la-pinterest"></i></a>
					</li>
				</ul>
            </div>
            <div class="col-lg-4">
                <div class="blog-sidebar">
                    <div class="sidebar-item">
                        <div class="recent-post-wrapper">
                            <h5 class="title mb-4 w-100">@lang('Recent Post')</h5>
							@foreach ($latestBlogs as $latestBlog)
                            <div class="blog__item recent-blog">
                                <div class="blog__thumb">
                                    <img src="{{ getImage('assets/images/frontend/blog/thumb_' . @$latestBlog->data_values->image, '420x240') }}" alt="blog">
                                </div>
                                <div class="blog__content">
                                    <h6 class="title"><a href="{{ route('blog.details', [slug(@$latestBlog->data_values->title), $latestBlog->id]) }}">{{ __(@$latestBlog->data_values->title) }}</a></h6>
                                    <span class="date"><i class="flaticon-calendar"></i> {{ $latestBlog->created_at->format('d M, Y') }}</span>
                                </div>
                            </div>
							@endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('fbComment')
	@php echo loadExtension('fb-comment') @endphp
@endpush
