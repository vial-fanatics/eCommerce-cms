<?php

app()->booted(function () {
    theme_option()
        ->setField([
            'id'         => 'copyright',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Copyright'),
            'attributes' => [
                'name'    => 'copyright',
                'value'   => '© 2021 Botble Technologies. All right reserved.',
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => __('Change copyright'),
                    'data-counter' => 250,
                ],
            ],
            'helper'     => __('Copyright on footer of site'),
        ])
        ->setField([
            'id'         => 'hotline',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Hotline'),
            'attributes' => [
                'name'    => 'hotline',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => __('Hotline'),
                    'data-counter' => 30,
                ],
            ],
        ])
        ->setField([
            'id'         => 'email',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'email',
            'label'      => __('Email'),
            'attributes' => [
                'name'    => 'email',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => __('Email'),
                    'data-counter' => 120,
                ],
            ],
        ])
        ->setField([
            'id'         => 'address',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Address'),
            'attributes' => [
                'name'    => 'address',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => __('Address'),
                    'data-counter' => 120,
                ],
            ],
        ])
        ->setSection([
            'title'      => __('Header'),
            'desc'       => __('Options for header'),
            'id'         => 'opt-text-subsection-header',
            'subsection' => true,
            'icon'       => 'fas fa-magic',
        ])
        ->setField([
            'id'         => 'enabled_sticky_header',
            'section_id' => 'opt-text-subsection-header',
            'type'       => 'customSelect',
            'label'      => 'Enable sticky header?',
            'attributes' => [
                'name'    => 'enabled_sticky_header',
                'list'    => [
                    'yes' => trans('core/base::base.yes'),
                    'no'  => trans('core/base::base.no'),
                ],
                'value'   => 'no',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setSection([
            'title'      => __('Social'),
            'desc'       => __('Social links'),
            'id'         => 'opt-text-subsection-social',
            'subsection' => true,
            'icon'       => 'fa fa-share-alt',
        ])
        ->setField([
            'id'         => 'facebook',
            'section_id' => 'opt-text-subsection-social',
            'type'       => 'text',
            'label'      => 'Facebook',
            'attributes' => [
                'name'    => 'facebook',
                'value'   => null,
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'twitter',
            'section_id' => 'opt-text-subsection-social',
            'type'       => 'text',
            'label'      => 'Twitter',
            'attributes' => [
                'name'    => 'twitter',
                'value'   => null,
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'linkedin',
            'section_id' => 'opt-text-subsection-social',
            'type'       => 'text',
            'label'      => 'Linkedin',
            'attributes' => [
                'name'    => 'linkedin',
                'value'   => null,
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'youtube',
            'section_id' => 'opt-text-subsection-social',
            'type'       => 'text',
            'label'      => 'Youtube',
            'attributes' => [
                'name'    => 'youtube',
                'value'   => null,
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'instagram',
            'section_id' => 'opt-text-subsection-social',
            'type'       => 'text',
            'label'      => 'Instagram',
            'attributes' => [
                'name'    => 'instagram',
                'value'   => null,
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'pinterest',
            'section_id' => 'opt-text-subsection-social',
            'type'       => 'text',
            'label'      => 'Pinterest',
            'attributes' => [
                'name'    => 'pinterest',
                'value'   => null,
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'product_page_banner_title',
            'section_id' => 'opt-text-subsection-ecommerce',
            'type'       => 'text',
            'label'      => __('The description for products page'),
            'attributes' => [
                'name'    => 'product_page_banner_title',
                'value'   => null,
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'product_page_banner_image',
            'section_id' => 'opt-text-subsection-ecommerce',
            'type'       => 'mediaImage',
            'label'      => __('Banner image for products page'),
            'attributes' => [
                'name'  => 'product_page_banner_image',
                'value' => null,
            ],
        ])
        ->setField([
            'id'         => 'primary_font',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'googleFonts',
            'label'      => __('Primary font'),
            'attributes' => [
                'name'  => 'primary_font',
                'value' => 'Poppins',
            ],
        ])
        ->setField([
            'id'         => 'primary_color',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'customColor',
            'label'      => __('Primary color'),
            'attributes' => [
                'name'  => 'primary_color',
                'value' => '#026e94',
            ],
        ])
        ->setField([
            'id'         => 'secondary_color',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'customColor',
            'label'      => __('Secondary color'),
            'attributes' => [
                'name'  => 'secondary_color',
                'value' => '#2c1dff',
            ],
        ]);

// Facebook integration
    theme_option()
        ->setSection([
            'title'      => __('Facebook Integration'),
            'desc'       => __('Facebook Integration'),
            'id'         => 'opt-text-subsection-facebook-integration',
            'subsection' => true,
            'icon'       => 'fab fa-facebook',
        ])
        ->setField([
            'id'         => 'facebook_chat_enabled',
            'section_id' => 'opt-text-subsection-facebook-integration',
            'type'       => 'select',
            'label'      => __('Enable Facebook chat?'),
            'attributes' => [
                'name'    => 'facebook_chat_enabled',
                'list'    => [
                    'no'  => trans('core/base::base.no'),
                    'yes' => trans('core/base::base.yes'),
                ],
                'value'   => 'no',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
            'helper'     => __('To show chat box on that website, please go to :link and add :domain to whitelist domains!',
                [
                    'domain' => Html::link(url('')),
                    'link'   => Html::link('https://www.facebook.com/' . theme_option('facebook_page_id') . '/settings/?tab=messenger_platform'),
                ]),
        ])
        ->setField([
            'id'         => 'facebook_page_id',
            'section_id' => 'opt-text-subsection-facebook-integration',
            'type'       => 'text',
            'label'      => __('Facebook page ID'),
            'attributes' => [
                'name'    => 'facebook_page_id',
                'value'   => null,
                'options' => [
                    'class' => 'form-control',
                ],
            ],
            'helper'     => __('You can get fan page ID using this site :link',
                ['link' => Html::link('https://findmyfbid.com')]),
        ])
        ->setField([
            'id'         => 'facebook_comment_enabled_in_post',
            'section_id' => 'opt-text-subsection-facebook-integration',
            'type'       => 'select',
            'label'      => __('Enable Facebook comment in post detail page?'),
            'attributes' => [
                'name'    => 'facebook_comment_enabled_in_post',
                'list'    => [
                    'yes' => trans('core/base::base.yes'),
                    'no'  => trans('core/base::base.no'),
                ],
                'value'   => 'no',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'facebook_comment_enabled_in_product',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'select',
            'label'      => __('Enable Facebook comment in product detail page?'),
            'attributes' => [
                'name'    => 'facebook_comment_enabled_in_product',
                'list'    => [
                    'no'  => trans('core/base::base.no'),
                    'yes' => trans('core/base::base.yes'),
                ],
                'value'   => 'no',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'facebook_comment_enabled_in_gallery',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'select',
            'label'      => __('Enable Facebook comment in the gallery detail?'),
            'attributes' => [
                'name'    => 'facebook_comment_enabled_in_gallery',
                'list'    => [
                    'no'  => trans('core/base::base.no'),
                    'yes' => trans('core/base::base.yes'),
                ],
                'value'   => 'no',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'facebook_app_id',
            'section_id' => 'opt-text-subsection-facebook-integration',
            'type'       => 'text',
            'label'      => __('Facebook App ID'),
            'attributes' => [
                'name'        => 'facebook_app_id',
                'value'       => null,
                'options'     => [
                    'class' => 'form-control',
                ],
                'placeholder' => 'Ex: 2061237023872679',
            ],
            'helper'     => __('You can create your app in :link',
                ['link' => Html::link('https://developers.facebook.com/apps')]),
        ])
        ->setField([
            'id'         => 'facebook_admins',
            'section_id' => 'opt-text-subsection-facebook-integration',
            'type'       => 'repeater',
            'label'      => __('Facebook Admins'),
            'attributes' => [
                'name'   => 'facebook_admins',
                'value'  => null,
                'fields' => [
                    [
                        'type'       => 'text',
                        'label'      => __('Facebook Admin ID'),
                        'attributes' => [
                            'name'    => 'text',
                            'value'   => null,
                            'options' => [
                                'class'        => 'form-control',
                                'data-counter' => 40,
                            ],
                        ],
                    ],
                ],
            ],
            'helper'     => __('Facebook admins to manage comments :link',
                ['link' => Html::link('https://developers.facebook.com/docs/plugins/comments')]),
        ]);

    add_filter(THEME_FRONT_HEADER, function ($html) {
        if (theme_option('facebook_app_id')) {
            $html .= Html::meta(null, theme_option('facebook_app_id'), ['property' => 'fb:app_id'])->toHtml();
        }

        if (theme_option('facebook_admins')) {
            foreach (json_decode(theme_option('facebook_admins'), true) as $facebookAdminId) {
                if (Arr::get($facebookAdminId, '0.value')) {
                    $html .= Html::meta(null, Arr::get($facebookAdminId, '0.value'), ['property' => 'fb:admins'])
                        ->toHtml();
                }
            }
        }

        return $html;
    }, 1180);

    add_filter(THEME_FRONT_FOOTER, function ($html) {
        return $html . Theme::partial('facebook-integration');
    }, 1180);
});
