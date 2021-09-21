<section class="section section--shopping-cart">
    <div class="section__header">
        <h3>{{ __('Wishlist') }}</h3>
    </div>
    <div class="section__content">
        <div class="customer-list-order">
            <table class="table table--orders table--wishlist">
                <thead>
                    <tr>
                        <th>{{ __('Image') }}</th>
                        <th>{{ __('Product') }}</th>
                        <th>{{ __('Price') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @if (auth('customer')->check())
                    @if (count($wishlist) > 0 && $wishlist->count() > 0)
                        @foreach($wishlist as $item)
                            @php $item = $item->product; @endphp
                            <tr>
                                <td>
                                    <img alt="{{ $item->name }}" width="50" height="70" class="img-fluid"
                                         style="max-height: 75px"
                                         src="{{ RvMedia::getImageUrl($item->image, 'thumb', false, RvMedia::getDefaultImage()) }}">
                                </td>
                                <td><a href="{{ $item->original_product->url }}">{{ $item->name }}</a></td>
                                <td>
                                    <div class="product__price @if ($item->front_sale_price != $item->price) sale @endif">
                                        <span>{{ format_price($item->front_sale_price_with_taxes) }}</span>
                                        @if ($item->front_sale_price != $item->price)
                                            <small><del>{{ format_price($item->price_with_taxes) }}</del></small>
                                        @endif
                                    </div>
                                </td>

                                <td style="width: 300px">
                                    <a class="btn--custom btn--rounded btn--outline btn--sm js-remove-from-wishlist-button" href="#" data-url="{{ route('public.wishlist.remove', $item->id) }}">{{ __('Remove') }}</a>
                                    <a class="btn--custom btn--rounded btn--outline btn--sm add-to-cart-button" data-id="{{ $item->id }}" href="#" data-url="{{ route('public.cart.add-to-cart') }}">{{ __('Add to cart') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center">{{ __('No product in wishlist!') }}</td>
                        </tr>
                    @endif
                @else
                    @if (Cart::instance('wishlist')->count())
                        @foreach(Cart::instance('wishlist')->content() as $cartItem)
                            @php
                                $item = app(\Botble\Ecommerce\Repositories\Interfaces\ProductInterface::class)->findById($cartItem->id);
                            @endphp
                            <tr>
                                <td>
                                    <img alt="{{ $item->name }}" width="50" height="70" class="img-fluid"
                                         style="max-height: 75px"
                                         src="{{ RvMedia::getImageUrl($item->image, 'thumb', false, RvMedia::getDefaultImage()) }}">
                                </td>
                                <td><a href="{{ $item->original_product->url }}">{{ $item->name }}</a></td>

                                <td>
                                    <div class="product__price @if ($item->front_sale_price != $item->price) sale @endif">
                                        <span>{{ format_price($item->front_sale_price_with_taxes) }}</span>
                                        @if ($item->front_sale_price != $item->price)
                                            <small><del>{{ format_price($item->price_with_taxes) }}</del></small>
                                        @endif
                                    </div>
                                </td>

                                <td style="width: 300px">
                                    <a class="btn--custom btn--rounded btn--outline btn--sm js-remove-from-wishlist-button" href="#" data-url="{{ route('public.wishlist.remove', $item->id) }}">{{ __('Remove') }}</a>
                                    <a class="btn--custom btn--rounded btn--outline btn--sm add-to-cart-button" data-id="{{ $item->id }}" href="#" data-url="{{ route('public.cart.add-to-cart') }}">{{ __('Add to cart') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="text-center">{{ __('No product in wishlist!') }}</td>
                        </tr>
                    @endif
                @endif
                </tbody>
            </table>
        </div>

        @if (auth('customer')->check())
            {!! $wishlist->links() !!}
        @endif
    </div>
</section>
