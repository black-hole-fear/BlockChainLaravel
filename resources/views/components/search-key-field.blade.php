@props(['placeholder' => 'Search...', 'btn' => 'btn--primary'])
<div class="input-group flex-fill w-auto">
    <input class="form-control bg--white" name="search" type="search" value="{{ request()->search }}" placeholder="{{ __($placeholder) }}">
    <button class="btn {{ $btn }}" type="submit"><i class="la la-search"></i></button>
</div>
