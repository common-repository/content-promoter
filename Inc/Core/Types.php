<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

class Types
{
    /**
     * Returns all available content types
     * 
     * @return  array
     */
    public static function getTypes()
    {
        return [
            'text' => [
                'name' => 'Text',
                'label' => contentpromoter()->_('CP_TEXT')
            ],
            'image' => [
                'name' => 'Image',
                'label' => contentpromoter()->_('CP_IMAGE')
            ],
            
            
            'quote_free' => [
                'name' => 'Quote',
                'label' => contentpromoter()->_('CP_QUOTE'),
                'pro'   => true
            ],
            'post_free' => [
                'name' => 'Post',
                'label' => contentpromoter()->_('CP_POST'),
                'pro'   => true
            ],
            'page_free' => [
                'name' => 'Page',
                'label' => contentpromoter()->_('CP_PAGE'),
                'pro'   => true
            ],
            'menu_free' => [
                'name' => 'Menu',
                'label' => contentpromoter()->_('CP_MENU'),
                'pro'   => true
            ],
            'promotion_free' => [
                'name' => 'Promotion',
                'label' => contentpromoter()->_('CP_PROMOTION'),
                'pro'   => true
            ],
            'cta_free' => [
                'name' => 'Cta',
                'label' => contentpromoter()->_('CP_CTA'),
                'pro'   => true
            ],
            'wpform_free' => [
                'name' => 'WPForm',
                'label' => contentpromoter()->_('CP_WPFORMS'),
                'pro'   => true
            ],
            'gravityform_free' => [
                'name' => 'GravityForm',
                'label' => contentpromoter()->_('CP_GRAVITY_FORMS'),
                'pro'   => true
            ],
            'woocommerce_free' => [
                'name' => 'WooCommerce',
                'label' => contentpromoter()->_('CP_WOOCOMMERCE_PRODUCT'),
                'pro'   => true
            ],
            'comingsoon_free' => [
                'name' => 'ComingSoon',
                'label' => contentpromoter()->_('CP_COMING_SOON'),
                'pro' => true
            ],
            'generalsale_free' => [
                'name' => 'GeneralSale',
                'label' => contentpromoter()->_('CP_SALE'),
                'pro' => true
            ],
            'blackfridaysale_free' => [
                'name' => 'BlackFridaySale',
                'label' => contentpromoter()->_('CP_BF_SALE'),
                'pro' => true
            ],
            'cybermondaysale_free' => [
                'name' => 'CyberMondaySale',
                'label' => contentpromoter()->_('CP_CM_SALE'),
                'pro' => true
            ],
            // Facebook
            'facebookpost_free' => [
                'name' => 'FacebookPost',
                'label' => contentpromoter()->_('CP_FACEBOOK_POST'),
                'pro' => true
            ],
            'facebookpage_free' => [
                'name' => 'FacebookPage',
                'label' => contentpromoter()->_('CP_FACEBOOK_PAGE'),
                'pro' => true
            ],
            'facebookvideo_free' => [
                'name' => 'FacebookVideo',
                'label' => contentpromoter()->_('CP_FACEBOOK_VIDEO'),
                'pro' => true
            ],
            'facebookcomment_free' => [
                'name' => 'FacebookComment',
                'label' => contentpromoter()->_('CP_FACEBOOK_COMMENT'),
                'pro' => true
            ],
            'facebooklike_free' => [
                'name' => 'FacebookLike',
                'label' => contentpromoter()->_('CP_FACEBOOK_LIKE'),
                'pro' => true
            ],
            'facebookshare_free' => [
                'name' => 'FacebookShare',
                'label' => contentpromoter()->_('CP_FACEBOOK_SHARE'),
                'pro' => true
            ],
            // Twitter
            'tweetbutton_free' => [
                'name' => 'TweetButton',
                'label' => contentpromoter()->_('CP_TWEET_BTN'),
                'pro' => true
            ],
            'twitterfollowbutton_free' => [
                'name' => 'TwitterFollowButton',
                'label' => contentpromoter()->_('CP_FOLLOW_BTN'),
                'pro' => true
            ],
            'embedtweets_free' => [
                'name' => 'EmbedTweets',
                'label' => contentpromoter()->_('CP_EMBED_TWEETS'),
                'pro' => true
            ],
            // YouTube Video
            'youtubevideo_free' => [
                'name' => 'YouTubeVideo',
                'label' => contentpromoter()->_('CP_YT_VIDEO'),
                'pro' => true
            ]
            
        ];
    }
}