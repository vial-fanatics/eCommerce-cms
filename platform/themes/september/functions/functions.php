<?php

use Botble\Ecommerce\Models\FlashSale;
use Botble\SimpleSlider\Models\SimpleSliderItem;
use Illuminate\Routing\Events\RouteMatched;

register_page_template([
    'homepage'   => __('Homepage'),
    'full-width' => __('Full width'),
]);

register_sidebar([
    'id'          => 'footer_sidebar',
    'name'        => __('Footer sidebar'),
    'description' => __('Footer sidebar'),
]);

app()->booted(function () {
    remove_sidebar('primary_sidebar');
});

Menu::removeMenuLocation('header-menu')
    ->removeMenuLocation('footer-menu');

RvMedia::setUploadPathAndURLToPublic();

RvMedia::addSize('medium', 570, 570)
    ->addSize('small', 570, 268);

Form::component('themeIcon', Theme::getThemeNamespace() . '::partials.icons-field', [
    'name',
    'value'      => null,
    'attributes' => [],
]);

if (is_plugin_active('simple-slider')) {
    add_filter(BASE_FILTER_BEFORE_RENDER_FORM, function ($form, $data) {
        if (get_class($data) == SimpleSliderItem::class) {

            $value = MetaBox::getMetaData($data, 'button_text', true);

            $form
                ->addAfter('link', 'button_text', 'text', [
                    'label'      => __('Button text'),
                    'label_attr' => ['class' => 'control-label'],
                    'value'      => $value,
                    'attr'       => [
                        'placeholder' => __('Ex: Shop now'),
                    ],
                ]);
        }

        return $form;
    }, 124, 3);

    add_action(BASE_ACTION_AFTER_CREATE_CONTENT, 'save_addition_slider_fields', 120, 3);
    add_action(BASE_ACTION_AFTER_UPDATE_CONTENT, 'save_addition_slider_fields', 120, 3);

    /**
     * @param string $screen
     * @param Request $request
     * @param \Botble\Base\Models\BaseModel $data
     */
    function save_addition_slider_fields($screen, $request, $data)
    {
        if (get_class($data) == SimpleSliderItem::class) {
            MetaBox::saveMetaBoxData($data, 'button_text', $request->input('button_text'));
        }
    }
}

add_filter(BASE_FILTER_BEFORE_RENDER_FORM, function ($form, $data) {
    switch (get_class($data)) {
        case FlashSale::class:
            $image = MetaBox::getMetaData($data, 'image', true);

            $form
                ->addAfter('end_date', 'image', 'mediaImage', [
                    'label'      => __('Image'),
                    'label_attr' => ['class' => 'control-label'],
                    'value'      => $image,
                ]);
            break;
    }

    return $form;
}, 124, 3);
