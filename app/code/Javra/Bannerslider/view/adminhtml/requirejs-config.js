var config = {
    map: {
        '*': {
            'magestore/note': 'Javra_Bannerslider/js/jquery/slider/jquery-ads-note',
        },
    },
    paths: {
        'magestore/flexslider': 'Javra_Bannerslider/js/jquery/slider/jquery-flexslider-min',
        'magestore/evolutionslider': 'Javra_Bannerslider/js/jquery/slider/jquery-slider-min',
        'magestore/zebra-tooltips': 'Javra_Bannerslider/js/jquery/ui/zebra-tooltips',
    },
    shim: {
        'magestore/flexslider': {
            deps: ['jquery']
        },
        'magestore/evolutionslider': {
            deps: ['jquery']
        },
        'magestore/zebra-tooltips': {
            deps: ['jquery']
        },
    }
};
