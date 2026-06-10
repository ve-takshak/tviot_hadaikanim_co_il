@props(['items'])

<div {{ $attributes->merge(['class' => 'd-flex justify-content-between flex-wrap font-14']) }} >
    <div>
        {{__('Showing')}} <b>{{ $items->firstItem() }}</b> - <b>{{ $items->lastItem() }}</b> {{ __('of')}} <b>{{ $items->total() }}</b>
    </div>
    <div> {{__('Showing')}} <b>{{ $items->currentPage() }}</b> {{ __('of')}} <b>{{ $items->lastPage() }}</b> {{ __('Pages')}} </div>
</div>