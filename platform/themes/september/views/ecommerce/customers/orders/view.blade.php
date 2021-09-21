@extends(Theme::getThemeNamespace() . '::views.ecommerce.customers.master')
@section('content')
    <h2 class="customer-page-title">{{ __('Order information') }}</h2>
    <div class="clearfix"></div>
    <br>
    <div class="customer-order-detail">
        <div class="row">
            <div class="col-md-6">
                <div class="order-slogan">
                    @php
                        $logo = theme_option('logo_in_the_checkout_page') ?: theme_option('logo');
                    @endphp
                    <img width="100" src="{{ RvMedia::getImageUrl($logo) }}"
                         alt="{{ theme_option('site_title') }}">
                    <br/>
                    {{ setting('contact_address') }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="order-meta">
                    <span>{{ __('Order number') }}:</span> <span
                            class="order-detail-value">{{ get_order_code($order->id) }}</span>
                    <span>{{ __('Time') }}:</span> <span
                        class="order-detail-value">{{ $order->created_at->translatedFormat('h:m d/m/Y') }}</span>
                </div>
            </div>
        </div>
        <br>

        <div class="row">

            <div class="col-12">
                <h5>{{ __('Order information') }}</h5>
                <div>
                    <span>{{ __('Order status') }}:</span> <span
                        class="order-detail-value">{{ $order->status->label() }}</span>&nbsp;

                    <span>{{ __('Payment method') }}:</span> <span
                        class="order-detail-value"> {{ $order->payment->payment_channel->label() }} </span>&nbsp;

                    <span>{{ __('Payment status') }}:</span> <span
                        class="order-detail-value">{{ $order->payment->status->label() }}</span>&nbsp;

                    <span>{{ __('Amount') }}:</span>
                    <span class="order-detail-value"> {{ format_price($order->amount) }} </span>&nbsp;

                    @if (EcommerceHelper::isTaxEnabled())
                        <span>{{ __('Tax') }}:</span>
                        <span class="order-detail-value"> {{ format_price($order->tax_amount) }} </span>&nbsp;
                    @endif

                    <span>{{ __('Discount') }}:</span>
                    <span class="order-detail-value"> {{ format_price($order->discount_amount) }}
                        @if ($order->discount_amount)
                            @if ($order->coupon_code)
                                ({!! __('Coupon code: ":code"', ['code' => Html::tag('strong', $order->coupon_code)->toHtml()]) !!})
                            @elseif ($order->discount_description)
                                ({{ $order->discount_description }})
                            @endif
                        @endif
                    </span>&nbsp;

                    <span>{{ __('Shipping fee') }}:</span> <span
                        class="order-detail-value">{{ format_price($order->shipping_amount) }} </span>&nbsp;

                    @if ($order->description)
                        <span>{{ __('Note') }}:</span> <span class="order-detail-value text-warning">{{ $order->description }} </span>&nbsp;
                    @endif
                </div>

                <br>
                <h5>{{ __('Customer') }}</h5>
                <div>
                    <span>{{ __('Full Name') }}:</span> <span class="order-detail-value">{{ $order->address->name }} </span>&nbsp;
                    <span>{{ __('Phone') }}:</span> <span class="order-detail-value">{{ $order->address->phone }} </span>&nbsp;
                    <div class="row">
                        <div class="col-12">
                            <span>{{ __('Address') }}:</span> <span
                                class="order-detail-value"> {{ $order->address->address }} </span>&nbsp;
                        </div>
                    </div>
                    <span>{{ __('City') }}:</span> <span
                        class="order-detail-value">{{ $order->address->city }} </span>&nbsp;
                    <span>{{ __('State') }}:</span> <span
                        class="order-detail-value"> {{ $order->address->state }} </span>&nbsp;
                </div>

                <br>
                <h5>{{ __('Products') }}</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('Product') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th style="width: 100px">{{ __('Quantity') }}</th>
                            <th class="price text-right">{{ __('Total') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->products as $key => $orderProduct)
                            @php
                                $product = get_products([
                                    'condition' => [
                                        'ec_products.status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED,
                                        'ec_products.id'     => $orderProduct->product_id,
                                    ],
                                    'take'   => 1,
                                    'select' => [
                                        'ec_products.id',
                                        'ec_products.images',
                                        'ec_products.name',
                                        'ec_products.price',
                                        'ec_products.sale_price',
                                        'ec_products.sale_type',
                                        'ec_products.start_date',
                                        'ec_products.end_date',
                                        'ec_products.sku',
                                        'ec_products.is_variation',
                                    ],
                                ]);

                            @endphp
                            <tr>
                                <td style="vertical-align: middle">{{ $key + 1 }}</td>
                                <td style="vertical-align: middle">
                                    <img src="{{ RvMedia::getImageUrl($product ? $product->image : null, 'thumb', false, RvMedia::getDefaultImage()) }}" width="50" alt="{{ $orderProduct->product_name }}">
                                </td>
                                <td style="vertical-align: middle">
                                    {{ $orderProduct->product_name }} @if ($product && $product->sku) ({{ $product->sku }}) @endif
                                    @if ($product && $product->is_variation)
                                        <p>
                                            <small>
                                                <small>{{ $product->variation_attributes }}</small>
                                            </small>
                                        </p>
                                    @endif

                                    @if (!empty($orderProduct->options) && is_array($orderProduct->options))
                                        @foreach($orderProduct->options as $option)
                                            @if (!empty($option['key']) && !empty($option['value']))
                                                <p class="mb-0"><small>{{ $option['key'] }}: <strong> {{ $option['value'] }}</strong></small></p>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td style="vertical-align: middle">{{ format_price($orderProduct->price) }}</td>
                                <td style="vertical-align: middle">{{ $orderProduct->qty }}</td>
                                <td class="money text-right" style="vertical-align: middle">
                                    <strong>
                                        {{ format_price($orderProduct->price * $orderProduct->qty) }}
                                    </strong>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <br>
                <a href="{{ route('customer.print-order', $order->id) }}" class="btn--custom btn--rounded btn--outline btn--sm"><i class="feather icon-download"></i> {{ __('Download invoice') }}</a>
                @if ($order->canBeCanceled())
                    &nbsp;<a href="{{ route('customer.orders.cancel', $order->id) }}" onclick="return confirm('{{ __('Are you sure?') }}')" class="btn--custom btn--rounded btn--outline btn--sm btn-outline-danger">{{ __('Cancel order') }}</a>
                @endif
            </div>
        </div>
@endsection
