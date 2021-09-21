<?php

namespace Theme\September\Http\Controllers;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Blog\Repositories\Interfaces\PostInterface;
use Botble\Ecommerce\Repositories\Interfaces\FlashSaleInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductInterface;
use Botble\Ecommerce\Repositories\Interfaces\ReviewInterface;
use Botble\Theme\Http\Controllers\PublicController;
use Cart;
use Illuminate\Http\Request;
use Theme;
use Illuminate\Support\Facades\DB;
use EcommerceHelper;
use Theme\September\Http\Resources\BrandResource;
use Theme\September\Http\Resources\PostResource;
use Theme\September\Http\Resources\ProductCategoryResource;
use Theme\September\Http\Resources\ReviewResource;

class SeptemberController extends PublicController
{
    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function ajaxCart(Request $request, BaseHttpResponse $response)
    {
        if (!$request->ajax()) {
            return $response->setNextUrl(route('public.index'));
        }

        return $response->setData([
            'count' => Cart::instance('cart')->count(),
            'html'  => Theme::partial('cart-panel'),
        ]);
    }

    /**
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function getFeaturedProducts(Request $request, BaseHttpResponse $response)
    {
        if (!$request->ajax() || !$request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $data = [];

        $withCount = [];
        if (EcommerceHelper::isReviewEnabled()) {
            $withCount = [
                'reviews',
                'reviews as reviews_avg' => function ($query) {
                    $query->select(DB::raw('avg(star)'));
                },
            ];
        }

        $products = get_featured_products([
            'take' => (int)$request->input('limit', 8),
            'with' => [
                'slugable',
                'variations',
                'productLabels',
                'variationAttributeSwatchesForProductList',
                'productCollections',
            ],
            'withCount' => $withCount,
        ]);

        foreach ($products as $product) {
            $data[] = Theme::partial('product-item', compact('product'));
        }

        return $response->setData($data);
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param PostInterface $postRepository
     * @return BaseHttpResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Resources\Json\JsonResource
     */
    public function ajaxGetPosts(Request $request, BaseHttpResponse $response, PostInterface $postRepository)
    {
        if (!$request->ajax() || !$request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $posts = $postRepository->getFeatured((int)$request->input('limit', 3), ['slugable']);

        return $response
            ->setData(PostResource::collection($posts))
            ->toApiResponse();
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function getFeaturedProductCategories(Request $request, BaseHttpResponse $response)
    {
        if (!$request->ajax() || !$request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $categories = get_featured_product_categories();

        return $response->setData(ProductCategoryResource::collection($categories));
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function ajaxGetFeaturedBrands(Request $request, BaseHttpResponse $response)
    {
        if (!$request->ajax() || !$request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $brands = get_featured_brands();

        return $response->setData(BrandResource::collection($brands));
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function ajaxGetTrendingProducts(Request $request, BaseHttpResponse $response)
    {
        if (!$request->ajax() || !$request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $data = [];

        $withCount = [];
        if (EcommerceHelper::isReviewEnabled()) {
            $withCount = [
                'reviews',
                'reviews as reviews_avg' => function ($query) {
                    $query->select(DB::raw('avg(star)'));
                },
            ];
        }

        $products = get_trending_products([
            'take' => (int)$request->input('limit', 4),
            'with' => [
                'slugable',
                'variations',
                'productLabels',
                'variationAttributeSwatchesForProductList',
                'productCollections',
            ],
            'withCount' => $withCount,
        ]);

        foreach ($products as $product) {
            $data[] = Theme::partial('product-item', compact('product'));
        }

        return $response->setData($data);
    }

    /**
     * @param int $id
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param ReviewInterface $reviewRepository
     * @param ProductInterface $productRepository
     * @return BaseHttpResponse
     */
    public function ajaxGetProductReviews(
        $id,
        Request $request,
        BaseHttpResponse $response,
        ReviewInterface $reviewRepository,
        ProductInterface $productRepository
    ) {
        if (!$request->ajax() || !$request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $product = $productRepository->getFirstBy([
            'id'           => $id,
            'status'       => BaseStatusEnum::PUBLISHED,
            'is_variation' => 0,
        ]);

        if (!$product) {
            abort(404);
        }

        $condition = [
            'status'     => BaseStatusEnum::PUBLISHED,
            'product_id' => $id,
        ];

        $star = (int)$request->input('star');
        if ($star && $star >= 1 && $star <= 5) {
            $condition['star'] = $star;
        } else {
            $star = 0;
        }

        $reviews = $reviewRepository->advancedGet([
            'condition' => $condition,
            'order_by'  => ['created_at' => 'desc'],
            'paginate'  => [
                'per_page'      => (int)$request->input('per_page', 10),
                'current_paged' => (int)$request->input('page', 1),
            ],
            'with'      => ['user'],
        ]);

        $reviews
            ->onEachSide(1)
            ->appends($request->only(['star']));

        if ($star) {
            $message = __(':total review(s) ":star star" for ":product"', [
                'total'   => $reviews->total(),
                'product' => $product->name,
                'star'    => $star,
            ]);
        } else {
            $message = __(':total review(s) for ":product"', [
                'total'   => $reviews->total(),
                'product' => $product->name,
            ]);
        }

        return $response
            ->setData(ReviewResource::collection($reviews))
            ->setMessage($message)
            ->toApiResponse();
    }

    /**
     * @param int $id
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param ProductInterface $productRepository
     * @return BaseHttpResponse
     */
    public function ajaxGetRelatedProducts($id, Request $request, BaseHttpResponse $response, ProductInterface $productRepository)
    {
        if (!$request->ajax() || !$request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $product = $productRepository->findOrFail($id);

        $products = get_related_products($product, (int)$request->input('limit', 4));

        $data = [];
        foreach ($products as $product) {
            $data[] = Theme::partial('product-item', compact('product'));
        }

        return $response->setData($data);
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param FlashSaleInterface $flashSaleRepository
     * @return BaseHttpResponse
     */
    public function ajaxGetFlashSales(
        Request $request,
        BaseHttpResponse $response,
        FlashSaleInterface $flashSaleRepository
    ) {
        if (!$request->ajax()) {
            return $response->setNextUrl(route('public.index'));
        }

        $flashSales = $flashSaleRepository->getModel()
            ->notExpired()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->with([
                'products' => function ($query) use ($request) {
                    $withCount = [];
                    if (EcommerceHelper::isReviewEnabled()) {
                        $withCount = [
                            'reviews',
                            'reviews as reviews_avg' => function ($query) use ($request) {
                                $query->select(DB::raw('avg(star)'));
                            },
                        ];
                    }

                    return $query
                        ->where('status', BaseStatusEnum::PUBLISHED)
                        ->limit((int) $request->input('limit', 2))
                        ->withCount($withCount);
                },
            ])
            ->get();

        if (!$flashSales->count()) {
            return $response->setData([]);
        }

        $data = [];
        foreach ($flashSales as $flashSale) {
            foreach ($flashSale->products as $product) {
                $data[] = Theme::partial('flash-sale-product', compact('product', 'flashSale'));
            }
        }

        return $response->setData($data);
    }
}
