<?php
namespace ContentPromoter\Core;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

use ContentPromoter\Core\Libs\Registry;
use ContentPromoter\Core\Helpers\PromotingContentsHelper;

class Previewer {
	/**
	 * Promoting Content Item data.
	 *
	 * @var  array
	 */
	public $item_data;

    /**
     * Inits Previewer
     * 
     * @return  void
     */
    public function init()
    {
        if (!$this->is_preview_page())
        {
			return;
		}

		$this->hooks();
    }

	/**
	 * Check if current page request meets requirements for promoting item preview page.
	 *
	 * @return  boolean
	 */
    public function is_preview_page()
    {
		// Only proceed for the promoting item preview page.
        if (empty($_GET['ctpr_item_preview']))
        {
			return false;
		}

		// Check for logged in user with correct capabilities.
        if (!\is_user_logged_in())
        {
			return false;
		}

		$item_id = \absint($_GET['ctpr_item_preview']); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

        if (!\current_user_can('administrator'))
        {
			return false;
		}

        $this->item_data = contentpromoter()->container['Item']->getItemData($item_id);
        
        if (!isset($this->item_data['items']))
        {
            return false;
        }

		return true;
	}

	/**
	 * Hooks.
	 *
     * @return  void
	 */
	public function hooks() {

		\add_action('pre_get_posts', [$this, 'pre_get_posts']);

		\add_filter('the_title', [$this, 'the_title'], 100, 1);

		\add_filter('the_content', [$this, 'the_content'], 999);

		\add_filter('get_the_excerpt', [$this, 'the_content'], 999);

		\add_filter('template_include', [$this, 'template_include']);

		\add_filter('post_thumbnail_html', '__return_empty_string');

		
	}

	

	/**
	 * Modify query, limit to one post.
	 *
	 * @param   \WP_Query  $query The WP_Query instance.
     * 
     * @return  void
	 */
    public function pre_get_posts($query)
    {
        if (!is_admin() && $query->is_main_query())
        {
			$query->set('posts_per_page', 1);
		}
	}

	/**
	 * Customize promoting item preview page title.
	 *
	 * @param   string  $title
	 *
	 * @return  string
	 */
    public function the_title($title)
    {
        if (in_the_loop())
        {
			$title = sprintf(
				/* translators: %s: Name of Promoting Item */
				esc_html__('%s Preview', 'content-promoter'),
				! empty($this->item_data['post']->post_title) ? sanitize_text_field($this->item_data['post']->post_title) : esc_html__('Promoting Item', 'content-promoter')
			);
		}

		return $title;
	}

	/**
	 * Customize promoting item preview page content.
	 *
	 * @return string
	 */
	public function the_content()
	{
		if (!isset($this->item_data['promoting_content_id']))
		{
			return '';
		}

		if (!current_user_can('administrator'))
		{
			return '';
		}
        
        if (!isset($this->item_data['total_items']))
        {
            return '';
		}
		
		$total_items = $this->item_data['total_items'];
		
		$links = [];

		$links[] = [
			'url'  => esc_url(
				add_query_arg(
					[
						'post'	 => absint($this->item_data['promoting_content_id']),
						'action' => 'edit',
					],
					admin_url('post.php')
				)
			),
			'text' => esc_html__('Edit Promoting Item', 'content-promoter'),
		];

		$links[] = [
			'url'  => esc_url(
				add_query_arg(
					[
						'post_type' => 'content-promoter',
					],
					admin_url('edit.php')
				)
			),
			'text' => esc_html__('View Promoting Items', 'content-promoter'),
		];

		$content  = '<div style="padding: 15px; background: #ededed;">';
		$content .= '<p>';
		$content .= esc_html__('This is a preview of how your promoting item will look like in a post/page. This page is not publicly accessible.', 'content-promoter');
        if (!empty($links))
        {
			$content .= '<br>';
            foreach ($links as $key => $link)
            {
				$content .= '<a href="' . $link['url'] . '">' . $link['text'] . '</a>';
				$l        = array_keys($links);
                if (end($l) !== $key)
                {
					$content .= ' <span style="display:inline-block;margin:0 6px;opacity: 0.5">|</span> ';
				}
			}
		}
		$content .= '</p>';
        $content .= '</div>';
        
        $preview_content = $this->getPreviewerContent($total_items);

        $this->item_data['publish_settings']['replacement_element'] = 'div';

        $item_data_parsed = new Registry([
            'meta' => $this->item_data
		]);

        PromotingContentsHelper::prepareInAuto($preview_content, $item_data_parsed);

        $content .= $preview_content;

		return $content;
    }
    
    private function getPreviewerContent($total_items)
    {
        $content = '<div class="ctpr-previewer-wrapper">';
        
        for ($i = 0; $i < $total_items * 3; $i++)
        {
            $content .= $this->getParagraph();
        }

        return $content . '</div>';
    }

    private function getParagraph()
    {
        return '<div class="ctpr-preview-paragraph">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</div>';
    }

	/**
	 * Force page template types.
	 *
	 *
	 * @return  string
	 */
	public function template_include() {

		return locate_template(['page.php', 'single.php', 'index.php']);
	}
}