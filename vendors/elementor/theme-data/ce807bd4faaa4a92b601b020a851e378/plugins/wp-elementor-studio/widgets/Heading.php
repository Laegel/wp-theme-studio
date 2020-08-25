<?php
namespace WP_Elementor_Studio;

use \Elementor\Core\Schemes;

/**
 * Elementor heading widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class Heading extends \Elementor\Widget_Base
{

    /**
     * Get widget name.
     *
     * Retrieve heading widget name.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'dynamic-heading';
    }

    /**
     * Get widget title.
     *
     * Retrieve heading widget title.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('Heading', 'elementor');
    }

    /**
     * Get widget icon.
     *
     * Retrieve heading widget icon.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-t-letter';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the heading widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since  2.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return [ 'templating' ];
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since  2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
        return [ 'heading', 'title', 'text' ];
    }

    /**
     * Register heading widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_title',
            [
            'label' => __('Title', 'elementor'),
            ]
        );

        $this->add_control(
            'link',
            [
            'label' => __('Link', 'elementor'),
            'type' => \Elementor\Controls_Manager::URL,
            'dynamic' => [
            'active' => true,
            ],
            'default' => [
                    'url' => '',
            ],
            'separator' => 'before',
            ]
        );

        $this->add_control(
            'size',
            [
            'label' => __('Size', 'elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
            'default' => __('Default', 'elementor'),
            'small' => __('Small', 'elementor'),
            'medium' => __('Medium', 'elementor'),
            'large' => __('Large', 'elementor'),
            'xl' => __('XL', 'elementor'),
            'xxl' => __('XXL', 'elementor'),
            ],
            ]
        );

        $this->add_control(
            'header_size',
            [
            'label' => __('HTML Tag', 'elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
            'h1' => 'H1',
            'h2' => 'H2',
            'h3' => 'H3',
            'h4' => 'H4',
            'h5' => 'H5',
            'h6' => 'H6',
            'div' => 'div',
            'span' => 'span',
            'p' => 'p',
            ],
            'default' => 'h2',
            ]
        );

        $this->add_responsive_control(
            'align',
            [
            'label' => __('Alignment', 'elementor'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
            'left' => [
            'title' => __('Left', 'elementor'),
            'icon' => 'eicon-text-align-left',
            ],
            'center' => [
            'title' => __('Center', 'elementor'),
            'icon' => 'eicon-text-align-center',
            ],
            'right' => [
            'title' => __('Right', 'elementor'),
            'icon' => 'eicon-text-align-right',
            ],
            'justify' => [
            'title' => __('Justified', 'elementor'),
            'icon' => 'eicon-text-align-justify',
            ],
            ],
            'default' => '',
            'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
            ],
            ]
        );

        $this->add_control(
            'view',
            [
            'label' => __('View', 'elementor'),
            'type' => \Elementor\Controls_Manager::HIDDEN,
            'default' => 'traditional',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
            'label' => __('Title', 'elementor'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
            'label' => __('Text Color', 'elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'scheme' => [
            'type' => Schemes\Color::get_type(),
            'value' => Schemes\Color::COLOR_1,
            ],
            'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title' => 'color: {{VALUE}};',
            ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
            'name' => 'typography',
            'scheme' => Schemes\Typography::TYPOGRAPHY_1,
            'selector' => '{{WRAPPER}} .elementor-heading-title',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
            'name' => 'text_shadow',
            'selector' => '{{WRAPPER}} .elementor-heading-title',
            ]
        );

        $this->add_control(
            'blend_mode',
            [
            'label' => __('Blend Mode', 'elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
            '' => __('Normal', 'elementor'),
            'multiply' => 'Multiply',
            'screen' => 'Screen',
            'overlay' => 'Overlay',
            'darken' => 'Darken',
            'lighten' => 'Lighten',
            'color-dodge' => 'Color Dodge',
            'saturation' => 'Saturation',
            'color' => 'Color',
            'difference' => 'Difference',
            'exclusion' => 'Exclusion',
            'hue' => 'Hue',
            'luminosity' => 'Luminosity',
            ],
            'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title' => 'mix-blend-mode: {{VALUE}}',
            ],
            'separator' => 'none',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render heading widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render()
    {
		$this->print_out($this->render_template());
    }

    static $template = '<[[heading]] [[attributes]]>[[content]]</[[heading]]>';

    public function render_template()
    {
        $settings = $this->get_settings_for_display();

        $title = '<?php the_title();?>';

        $this->add_render_attribute('title', 'class', 'elementor-heading-title');

        if (!empty($settings['size']) ) {
            $this->add_render_attribute('title', 'class', 'elementor-size-' . $settings['size']);
        }

        if (!empty($settings['link']['url']) ) {
			$this->add_link_attributes('url', $settings['link']);
            $title = "<a {$this->get_render_attribute_string('url')}>$title</a>";
        }

        return $this->evaluate_template([
			'heading' => $settings['header_size'],
			'attributes' => $this->get_render_attribute_string('title'),
			'content' => $title
		]);
    }
}
