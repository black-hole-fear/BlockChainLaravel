@php
$breadcrumb = getContent('breadcrumb.content',true);
@endphp
<section class="inner-banner bg_img" style="background: url('{{ getImage('assets/images/frontend/breadcrumb/' . @$breadcrumb->data_values->image, '1920x280') }}') center;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7 col-xl-6 text-center">
        <h3 class="title text--base">{{ __($pageTitle) }}</h3>
      </div>
    </div>
  </div>
</section>
