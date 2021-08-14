<?php namespace Terne\Vuejs;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'terne.vuejs::lang.plugin.name',
            'description' => 'terne.vuejs::lang.plugin.description',
            'author'      => 'Eugene Ternavsky',
            'icon'        => 'icon-code',
            'homepage'    => 'https://github.com/ternavsky/oc-vuejs-plugin'
        ];
    }

    public function registerSettings()
    {
    }

    public function registerComponents()
    {
        return [
           '\Terne\VueJs\Components\Layout'     => 'vueLayout',
        ];
    }

    public function registerMarkupTags()
    {
        return [
            'filters' => [
                'json' => 'json_encode',
            ]
        ];
    }

    public function boot()
    {
        \Event::listen('cms.page.display', function($controller, $url, $page) {
            //dd($controller);
            //check if page requested by ajax and no handler
            if (
                \Request::ajax() &&
                $controller->getAjaxHandler() === null
            ) {
                //dd($controller);
                $assets = $controller->getAssetPaths();
                $content = $controller->renderPage() ?: '<!-- No content -->';
                $vueComponents = [];
                foreach ($page->components as $component) {
                    if (
                        property_exists($component, 'vueComponents') &&
                        is_array($component->vueComponents)
                    ) {

                        //dd($component->getPath());
                        $vueComponents_chunk = $component->vueComponents;
                        foreach ($vueComponents_chunk as $tag => $vcName) {
                            // full vue components options
                            if (is_integer($tag)) {
                                $tag = str_slug($vcName, "-");
                            }
                        }

                        $vueComponents = array_merge($vueComponents, [
                            $tag => $vcName
                        ]);
                    }
                }

                return [
                    'template' => $content,
                    'assets'  => $assets,
                    'components' => $vueComponents,
                ];
            }
        });
    }

}
