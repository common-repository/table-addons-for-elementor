<?php
use \Elementor\Controls_Manager;
use \Elementor\Repeater;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Icons_Manager;


/**
 * Elementor Table Widget.
 *
 * @since 1.0.0
 */
class Table_Addons_For_Elementor_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'Table';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Table', 'plugin-name' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-table';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Get widget promotion data.
	 *
	 * Retrieve the widget promotion data.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return array Widget promotion data.
	 */
	protected function get_upsale_data() {
		return [
			'condition' => !defined( 'TABLE_ADDONS_PRO_FOR_ELEMENTOR_VERSION' ),
			'image' => esc_url( ELEMENTOR_ASSETS_URL . 'images/go-pro.svg' ),
			'image_alt' => esc_attr__( 'Upgrade', 'table-addons-for-elementor' ),
			'title' => esc_html__( 'Upgrade to Table Addons Pro', 'table-addons-for-elementor' ),
			'description' => __( '<div class="upgrade-pro-wrap">Pro version includes those fields support <ul class="left-col"><li>Icon</li><li>Button</li><li>Image</li></ul><ul class="right-col"><li>Icon + Content</li><li>Link</li><li>Rich Text Editor</li></ul></div>', 'table-addons-for-elementor' ),
			'upgrade_url' => esc_url( 'https://fusionplugin.com/plugins/table-addons-for-elementor/?utm_source=activesite&utm_campaign=elementortable&utm_medium=link' ),
			'upgrade_text' => esc_html__( 'Upgrade Now', 'table-addons-for-elementor' ),
		];
	}

	/**
	 * Register widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		//Table Header start
		$this->start_controls_section(
			'content_table_header',
			[
				'label' => __( 'Table Header', 'table-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater_header = new Repeater();

		$repeater_header->add_control(
			'header_content_type', [
				'label' => __( 'Content Type/View', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'default',
				'options' => [
					'default' => [
						'title' => __( 'Default', 'table-addons-for-elementor' ),
						'icon' => 'eicon-text',
					],
					'editor' => [
						'title' => __( 'Editor', 'table-addons-for-elementor' ),
						'icon' => 'eicon-editor-paragraph',
					],
				],
				'render_type' => 'template',
				'classes' => 'elementor-control-start-end',
				'style_transfer' => true,
				'prefix_class' => 'elementor-icon-list--layout-',
				'label_block' => true,
				'separator' => 'before',
			]
		);

		$repeater_header->add_control(
			'text', [
				'label' => __( 'Text', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'placeholder' => __( 'Table header', 'table-addons-for-elementor' ),
				'default' => __( 'Table header', 'table-addons-for-elementor' ),
				'dynamic' => [
		            'active' => true,
		        ],
				'condition' => [
					'header_content_type' => 'default',
				]
			]
		);

		if( !defined( 'TABLE_ADDONS_PRO_FOR_ELEMENTOR_VERSION' ) ):
			if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.19.0', '>' )) :
				$repeater_header->add_control(
					'pro_version_notice_header',
					[
						'type' => \Elementor\Controls_Manager::NOTICE,
						'notice_type' => 'warning',
						'dismissible' => false,
						'heading' => esc_html__( 'Only available in pro version!', 'textdomain' ),
						'content' => sprintf("%1\$s <a href='%2\$s' class='table-addons-notice-button' target='_blank'>%3\$s</a>",
							__( 'This content type is available in pro version only.', 'table-addons-for-elementor' ),
							'https://fusionplugin.com/plugins/table-addons-for-elementor/?utm_source=activesite&utm_campaign=elementortable&utm_medium=link',
							__( 'Get Pro Version', 'table-addons-for-elementor' )
						),
						'condition' => [
							'header_content_type' => [
								'editor',
							],
						],
					]
				);
			else:
				$repeater_header->add_control(
					'pro_version_notice_header_older_version',
					[
						'label'     => __('Get Pro Version to unlock this features', 'table-addons-for-elementor'),
						'type'      => Controls_Manager::HEADING,
						'condition' => [
							'header_content_type' => ['editor'],
						],
					]
				);
			endif;
		endif;
		

		do_action( 'table_addons_pro_header_control', $repeater_header );

		
		$repeater_header->add_control(
			'advance', [
				'label' => __( 'Advance Settings', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'No', 'table-addons-for-elementor' ),
				'label_on' => __( 'Yes', 'table-addons-for-elementor' ),
			]
		);
		$repeater_header->add_control(
			'colspan', [
				'label' => __( 'colSpan', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'advance' => 'yes',
				],
				'label_off' => __( 'No', 'table-addons-for-elementor' ),
				'label_on' => __( 'Yes', 'table-addons-for-elementor' ),
			]
		);
		$repeater_header->add_control(
			'colspannumber', [
				'label' => __( 'colSpan Number', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'condition' => [
					'advance' => 'yes',
					'colspan' => 'yes',
				],
				'placeholder' => __( '1', 'table-addons-for-elementor' ),
				'default' => __( '1', 'table-addons-for-elementor' ),
			]
		);
		$repeater_header->add_control(
			'customwidth', [
				'label' => __( 'Custom Width', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'advance' => 'yes',
				],
				'label_off' => __( 'No', 'table-addons-for-elementor' ),
				'label_on' => __( 'Yes', 'table-addons-for-elementor' ),
			]
		);
		$repeater_header->add_responsive_control(
			'width', [
				'label' => __( 'Width', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'condition' => [
					'advance' => 'yes',
					'customwidth' => 'yes',
				],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'default' => [
					'size' => 30,
					'unit' => '%',
				],
				'size_units' => [ '%', 'px' ],
				'selectors' => [ '{{WRAPPER}} table.tafe-table .tafe-table-header tr {{CURRENT_ITEM}}' => 'width: {{SIZE}}{{UNIT}};',
				]
			]
		);
		$repeater_header->add_control(
			'align', [ 
				'label' => __( 'Alignment', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'condition' => [
					'advance' => 'yes',
				],
				'options' => [
					'left' => [
						'title' => __( 'Left', 'table-addons-for-elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'table-addons-for-elementor' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'table-addons-for-elementor' ),
						'icon' => 'eicon-h-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'table-addons-for-elementor' ),
						'icon' => 'eicon-h-align-stretch',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-header tr {{CURRENT_ITEM}}' => 'text-align: {{VALUE}};',
				]
			]
		);
		$repeater_header->add_control(
			'valign', [
				'label' => __( 'Vertical Alignment', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'condition' => [
					'advance' => 'yes',
				],
				'options' => [
					'top' => [
						'title' => __( 'Top', 'table-addons-for-elementor' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'table-addons-for-elementor' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'table-addons-for-elementor' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-header tr {{CURRENT_ITEM}}' => 'vertical-align: {{VALUE}};',
				],
			]
		);
		$repeater_header->add_control(
			'decoration', [
				'label' => __( 'Decoration', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'condition' => [
					'advance' => 'yes',
				],
				'options' => [
					''  => __( 'Default', 'table-addons-for-elementor' ),
					'underline' => __( 'Underline', 'table-addons-for-elementor' ),
					'overline' => __( 'Overline', 'table-addons-for-elementor' ),
					'line-through' => __( 'Line Through', 'table-addons-for-elementor' ),
					'none' => __( 'None', 'table-addons-for-elementor' ),
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-header tr {{CURRENT_ITEM}}' => 'text-decoration: {{VALUE}};',
				],
			]
		);

		$repeater_header->add_control(
			'header_cell_padding', [
				'label' => __( 'Cell Padding', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-header tr {{CURRENT_ITEM}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'advance' => 'yes',
				],
			]
		);

		$repeater_header->add_control(
			'header_content_color', [
				'label' => __( 'Text Color', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-header tr {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
				],
				'condition' => [
					'advance' => 'yes',
				]
			]
		);

		$repeater_header->add_control(
			'header_content_bg', [
				'label' => __( 'Background Color', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-header tr {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'advance' => 'yes',
				]
			]
		);
		

		$this->add_control(
			'table_header',
			[
				'label' => __( 'Table Header Cell', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater_header->get_controls(),
				'default' => [
					[
						'text' => __( 'Table Header', 'table-addons-for-elementor' ),
					],
					[
						'text' => __( 'Table Header', 'table-addons-for-elementor' ),
					]
				],
				//'title_field' => '{{{ text }}}',
				'title_field' => '{{{ header_content_type == "editor" ? "Advanced Text Editor" : text }}}',
			]
		);

		$this->end_controls_section();

		// Table Body Start
		$this->start_controls_section(
			'content_table_body',
			[
				'label' => __( 'Table Body', 'table-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		//$repeater->start_controls_tabs( 'slides_repeater' );
		//$repeater->start_controls_tab( 'general_table_body', [ 'label' => __( 'General', 'elementor-pro' ) ] );

		$repeater->add_control(
			'row', [
				'label' => __( 'New Row', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'No', 'table-addons-for-elementor' ),
				'label_on' => __( 'Yes', 'table-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'body_content_type',
			[
				'label' => esc_html__( 'Content Type/View', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'default',
				'options' => [
					'default' => [
						'title' => esc_html__( 'Default', 'table-addons-for-elementor' ),
						'icon' => 'eicon-text',
					],
					'icon' => [
						'title' => esc_html__( 'Icon', 'table-addons-for-elementor' ),
						'icon' => 'eicon-check-circle',
					],
					'icon-content' => [
						'title' => esc_html__( 'Icon + Content', 'table-addons-for-elementor' ),
						'icon' => 'eicon-bullet-list',
					],
					'button' => [
						'title' => esc_html__( 'Button', 'table-addons-for-elementor' ),
						'icon' => 'eicon-button',
					],
					'link' => [
						'title' => esc_html__( 'Link', 'table-addons-for-elementor' ),
						'icon' => 'eicon-editor-link',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'table-addons-for-elementor' ),
						'icon' => 'eicon-image',
					],
					'editor' => [
						'title' => esc_html__( 'Editor', 'table-addons-for-elementor' ),
						'icon' => 'eicon-editor-paragraph',
					],

				],
				'render_type' => 'template',
				'classes' => 'elementor-control-start-end',
				'style_transfer' => true,
				'prefix_class' => 'elementor-icon-list--layout-',
				'label_block' => true,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'text', [
				'label' => __( 'Text', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'placeholder' => __( 'Table Data', 'table-addons-for-elementor' ),
				'default' => __( 'Table Data', 'table-addons-for-elementor' ),
				'dynamic' => [
		            'active' => true,
		        ],
				'condition' => [
					'body_content_type' => 'default',
				]
			]
		);

		//$repeater->end_controls_tab();
		//$repeater->start_controls_tab( 'advance_table_body', [ 'label' => __( 'Advance', 'elementor-pro' ) ] );

		
		if( !defined( 'TABLE_ADDONS_PRO_FOR_ELEMENTOR_VERSION' ) ):
			if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.19.0', '>' )) :
				$repeater->add_control(
					'pro_version_notice_1',
					[
						'type' => \Elementor\Controls_Manager::NOTICE,
						'notice_type' => 'warning',
						'dismissible' => false,
						'heading' => esc_html__( 'Only available in pro version!', 'textdomain' ),
						'content' => sprintf("%1\$s <a href='%2\$s' class='table-addons-notice-button' target='_blank'>%3\$s</a>",
							__( 'This content type is available in pro version only.', 'table-addons-for-elementor' ),
							'https://fusionplugin.com/plugins/table-addons-for-elementor/?utm_source=activesite&utm_campaign=elementortable&utm_medium=link',
							__( 'Get Pro Version', 'table-addons-for-elementor' )
						),
						'condition' => [
							'body_content_type' => [
								'icon',
								'icon-content',
								'button',
								'link',
								'image',
								'editor',
							],
						],
					]
				);
			else:
				$repeater->add_control(
					'pro_version_notice_setting_older_version',
					[
						'label'     => __('Get Pro Version to unlock this features', 'table-addons-for-elementor'),
						'type'      => Controls_Manager::HEADING,
						'condition' => [
							'body_content_type' => ['icon','icon-content','button','link','image','editor'],
						],
					]
				);
			endif;
		
		endif;
		

		do_action( 'table_addons_pro_body_control', $repeater );

		$repeater->add_control(
			'advance', [
				'label' => __( 'Advance Settings', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'No', 'table-addons-for-elementor' ),
				'label_on' => __( 'Yes', 'table-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'colspan', [
				'label' => __( 'colSpan', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'advance' => 'yes',
				],
				'label_off' => __( 'No', 'table-addons-for-elementor' ),
				'label_on' => __( 'Yes', 'table-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'colspannumber', [
				'label' => __( 'colSpan Number', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'condition' => [
					'advance' => 'yes',
					'colspan' => 'yes',
				],
				'placeholder' => __( '1', 'table-addons-for-elementor' ),
				'default' => __( '1', 'table-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'rowspan', [
				'label' => __( 'rowSpan', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'advance' => 'yes',
				],
				'label_off' => __( 'No', 'table-addons-for-elementor' ),
				'label_on' => __( 'Yes', 'table-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'rowspannumber', [
				'label' => __( 'rowSpan Number', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'condition' => [
					'advance' => 'yes',
					'rowspan' => 'yes',
				],
				'placeholder' => __( '1', 'table-addons-for-elementor' ),
				'default' => __( '1', 'table-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'align', [
				'label' => __( 'Alignment', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'condition' => [
					'advance' => 'yes',
				],
				'options' => [
					'left' => [
						'title' => __( 'Left', 'table-addons-for-elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'table-addons-for-elementor' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'table-addons-for-elementor' ),
						'icon' => 'eicon-h-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'table-addons-for-elementor' ),
						'icon' => 'eicon-h-align-stretch',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-body tr {{CURRENT_ITEM}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'valign', [
				'label' => __( 'Vertical Alignment', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'condition' => [
					'advance' => 'yes',
				],
				'options' => [
					'top' => [
						'title' => __( 'Top', 'table-addons-for-elementor' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'table-addons-for-elementor' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'table-addons-for-elementor' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-body tr {{CURRENT_ITEM}}' => 'vertical-align: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'body_content_color',
			[
				'label' => __( 'Text Color', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-body tr {{CURRENT_ITEM}}' => 'color: {{VALUE}}!important;fill: {{VALUE}};',
					'{{WRAPPER}} table.tafe-table .tafe-table-body tr {{CURRENT_ITEM}} .table-addons-button' => 'color: {{VALUE}};',
					'{{WRAPPER}} table.tafe-table .tafe-table-body tr {{CURRENT_ITEM}} .table-addons-link' => 'color: {{VALUE}};',
				],
				'condition' => [
					'advance' => 'yes',
				]
			]
		);

		$repeater->add_control(
			'body_content_bg', [
				'label' => __( 'Background Color', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-body tr {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}!important;',
				],
				'condition' => [
					'advance' => 'yes',
				]
			]
		);

		do_action( 'table_addons_pro_single_button_bg_control', $repeater );

		$repeater->add_control(
			'decoration',
			[
				'label' => __( 'Decoration', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'condition' => [
					'advance' => 'yes',
					'body_content_type!' => ['icon','icon-content','button','image'],
				],
				'options' => [
					''  => __( 'Default', 'table-addons-for-elementor' ),
					'underline' => __( 'Underline', 'table-addons-for-elementor' ),
					'overline' => __( 'Overline', 'table-addons-for-elementor' ),
					'line-through' => __( 'Line Through', 'table-addons-for-elementor' ),
					'none' => __( 'None', 'table-addons-for-elementor' ),
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-body tr {{CURRENT_ITEM}}' => 'text-decoration: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'body_cell_padding', [
				'label' => __( 'Cell Padding', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-body tr {{CURRENT_ITEM}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'advance' => 'yes',
				],
			]
		);

		if( !defined( 'TABLE_ADDONS_PRO_FOR_ELEMENTOR_VERSION' ) ):
			$table_body_tab_title = '{{{ body_content_type == "icon" ? "Icon:" : body_content_type == "icon-content" ? "Icon Content:" : body_content_type == "button" ? "Button: " : body_content_type == "link" ? "link: " : body_content_type == "image" ? "Image: " : body_content_type == "editor" ? "Text Editor" : text }}}';
		else:
			$table_body_tab_title = '{{{ body_content_type == "icon" ? elementor.helpers.renderIcon( this, selected_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' : body_content_type == "icon-content" ? (elementor.helpers.renderIcon( this, icon_content_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\') + icon_content_text : body_content_type == "button" ? "Button: " + button_text : body_content_type == "link" ? "Link: " + link_text : body_content_type == "image" ? "Image" : body_content_type == "editor" ? ((new DOMParser().parseFromString(editor, "text/html")).body.textContent.slice(0, 30) + "..." || "Advanced Text Editor") : text }}}';
		endif;

		$this->add_control(
			'table_body',
			[
				'label' => __( 'Table Body Cell', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'text' => __( 'Table Data', 'table-addons-for-elementor' ),
					],
					[
						'text' => __( 'Table Data', 'table-addons-for-elementor' ),
					],
				],
				//'title_field' => '{{{ text }}}',
				'title_field' => $table_body_tab_title,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'General Style', 'table-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'table_padding',
			[
				'label' => __( 'Inner Cell Padding', 'plugin-domain' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} table.tafe-table td,{{WRAPPER}} table.tafe-table th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'table_border',
				'label' => __( 'Border', 'table-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} table.tafe-table td,{{WRAPPER}} table.tafe-table th',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'table_header_style',
			[
				'label' => __( 'Table Header Style', 'table-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'header_align',
			[
				'label' => __( 'Alignment', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'table-addons-for-elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'table-addons-for-elementor' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'table-addons-for-elementor' ),
						'icon' => 'eicon-h-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'table-addons-for-elementor' ),
						'icon' => 'eicon-h-align-stretch',
					],
				],
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-header tr th' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'header_vertical_align',
			[
				'label' => __( 'Vertical Alignment', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => __( 'Top', 'table-addons-for-elementor' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'table-addons-for-elementor' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'table-addons-for-elementor' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-header tr th' => 'vertical-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_text_color',
			[
				'label' => __( 'Text Color', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-header tr th' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => __( 'Typography', 'table-addons-for-elementor' ),
				'name' => 'header_typography',
				'selector' => '{{WRAPPER}} table.tafe-table .tafe-table-header tr th',
			]
		);

		$this->add_control(
			'header_bg_color',
			[
				'label' => __( 'Background Color', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-header tr th' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'table_body_style',
			[
				'label' => __( 'Table Body Style', 'table-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'body_align',
			[
				'label' => __( 'Alignment', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'table-addons-for-elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'table-addons-for-elementor' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'table-addons-for-elementor' ),
						'icon' => 'eicon-h-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'table-addons-for-elementor' ),
						'icon' => 'eicon-h-align-stretch',
					],
				],
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-body tr td' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'body_vertical_align',
			[
				'label' => __( 'Vertical Alignment', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => __( 'Top', 'table-addons-for-elementor' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'table-addons-for-elementor' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'table-addons-for-elementor' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-body tr td' => 'vertical-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'body_text_color',
			[
				'label' => __( 'Text Color', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-body tr td' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'body_link_color',
			[
				'label' => __( 'Link Color', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-body tr td a:not(.table-addons-button)' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'body_link_hover_color',
			[
				'label' => __( 'Link Hover Color', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-body tr td a:not(.table-addons-button):hover' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'body_typography',
				'selector' => '{{WRAPPER}} table.tafe-table .tafe-table-body',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_control(
			'body_bg_color',
			[
				'label' => __( 'Background Color', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-body tr td' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'striped_bg', 
			[
				'label' => __( 'Striped Background', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'No', 'table-addons-for-elementor' ),
				'label_on' => __( 'Yes', 'table-addons-for-elementor' ),
			]
		);
		$this->add_control(
			'striped_bg_color', 
			[
				'label' => __( 'Secondary Background Color', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'striped_bg' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-body tr:nth-of-type(2n) td' => 'background-color: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'striped_text_color', 
			[
				'label' => __( 'Secondary Text Color', 'table-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'striped_bg' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} table.tafe-table .tafe-table-body tr:nth-of-type(2n) td' => 'color: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();

		if( !defined( 'TABLE_ADDONS_PRO_FOR_ELEMENTOR_VERSION' ) ):
			$this->start_controls_section(
				'responsive_style_pro_notice',
				[
					'label' => __( 'Responsive Style', 'table-addons-pro-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);

			if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.19.0', '>' )) :
				$this->add_control(
					'pro_version_notice_responsive',
					[
						'type' => \Elementor\Controls_Manager::NOTICE,
						'notice_type' => 'warning',
						'dismissible' => false,
						'heading' => esc_html__( 'Only available in pro version!', 'textdomain' ),
						'content' => sprintf("%1\$s <a href='%2\$s' class='table-addons-notice-button' target='_blank'>%3\$s</a>",
							__( 'Auto Responsive (Card Style) is available in pro version only.', 'table-addons-for-elementor' ),
							'https://fusionplugin.com/plugins/table-addons-for-elementor/?utm_source=activesite&utm_campaign=elementortable&utm_medium=link',
							__( 'Get Pro Version', 'table-addons-for-elementor' )
						)
					]
				);
			else:
				$this->add_control(
					'pro_version_notice_responsive_older_version',
					[
						'label'     => __('Get Pro Version to unlock this features', 'table-addons-for-elementor'),
						'type'      => Controls_Manager::HEADING,
					]
				);
			endif;

			$this->end_controls_section();
		endif;

		do_action( 'table_addons_pro_style_control', $this );
	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		$table_header_data = [];
		$auto_responsive = isset($settings['responsive_active']) && $settings['responsive_active'] == 'yes' ? 'auto-responsive-active' : '';
		?>
		<table class="tafe-table <?php echo esc_attr($auto_responsive);?>">
			<thead  class="tafe-table-header">
				<tr>
					<?php
					foreach ($settings['table_header'] as $index => $item) {
						$repeater_setting_key = $this->get_repeater_setting_key( 'text', 'table_header', $index );
						//$this->add_inline_editing_attributes( $repeater_setting_key );

						$colspan = ($item['colspan'] == 'yes' && $item['advance'] == 'yes') ? 'colSpan="'.esc_attr($item['colspannumber']).'"' : '';

						echo '<th class="elementor-inline-editing elementor-repeater-item-'.esc_attr($item['_id']).'"  '.wp_kses_post($colspan).' '.wp_kses_post($this->get_render_attribute_string( $repeater_setting_key )).'>';
						
						switch ($item['header_content_type']) {
							case 'editor':
								$this->render_editor_content( $item );
								//$table_header_data[$index] = $item['editor'];
								//escape all html tags
								$table_header_data[$index] = isset($item['editor']) && !empty($item['editor']) ? wp_strip_all_tags($item['editor']) : '';
								break;
							default:
								echo wp_kses_post($item['text']);
								$table_header_data[$index] = wp_strip_all_tags($item['text']);
								break;
						}

						echo '</th>';
					}
					?>
				</tr>
			</thead>
			<?php $data_label_index = 0;?>
			<tbody class="tafe-table-body">
				<tr>
					<?php
					foreach ($settings['table_body'] as $index => $item) {
						$table_body_key = $this->get_repeater_setting_key( 'text', 'table_body', $index );

						$this->add_render_attribute( $table_body_key, 'class', 'elementor-repeater-item-'.esc_attr($item['_id']) );
						$this->add_render_attribute( $table_body_key, 'class', 'td-content-type-'.esc_attr($item['body_content_type']) );
						//$this->add_inline_editing_attributes( $table_body_key );

						if($item['row'] == 'yes'){
							echo '</tr><tr>';
						}

						$colspan = ($item['colspan'] == 'yes' && $item['advance'] == 'yes') ? 'colSpan="'.esc_attr($item['colspannumber']).'"' : '';

						$rowspan = ($item['rowspan'] == 'yes' & $item['advance'] == 'yes') ? 'rowSpan="'.esc_attr($item['rowspannumber']).'"' : '';

						if($item['row'] == 'yes') {
							$data_label_index = 0;
						}

						$data_label = @$table_header_data[$data_label_index];
						$data_label_index++;
						if($item['colspan'] == 'yes' && $item['advance'] == 'yes') $data_label_index++;

						//echo '<td '.$colspan.' '.$rowspan.' '.$this->get_render_attribute_string( $table_body_key ).' >'.$item['text'].'</td>';
						echo '<td data-label="'.esc_attr($data_label).'" '.wp_kses_post($colspan).' '.wp_kses_post($rowspan).' '.wp_kses_post($this->get_render_attribute_string( $table_body_key )).' >';

						switch ($item['body_content_type']) {
							case 'icon':
								$this->render_icon( $item );
								break;
							case 'icon-content':
								$this->render_icon_content( $item );
								break;
							case 'button':
								$this->render_button( $item, $index );
								break;
							case 'link':
								$this->render_link( $item, $index );
								break;
							case 'image':
								$this->render_image( $item );
								break;
							case 'editor':
								$this->render_editor_content( $item );
								break;
							default:
								echo wp_kses_post($item['text']);
								break;
						}
						
						echo '</td>';
					}
					?>
				</tr>
			</tbody>
		</table>
		
		<?php

	}

	protected function content_template() {
		?>
		<#
			var autoResponsive = settings.responsive_active == 'yes' ? 'auto-responsive-active' : '';
			var tableHeaderData = [];
		#>
		<table class="tafe-table {{{autoResponsive}}}">
			<thead class="tafe-table-header">
				<tr>
					<#
					if ( settings.table_header ) {
						_.each( settings.table_header, function( item, index ) {
							var iconTextKey = view.getRepeaterSettingKey( 'text', 'table_header', index );

							if( 'yes' === item.colspan && 'yes' === item.advance){
								colSpan = 'colSpan="'+item.colspannumber+'"';
							}else{
								colSpan = '';
							}
							
							view.addRenderAttribute( iconTextKey, 'class', 'elementor-repeater-item-'+item._id );
							<!-- view.addInlineEditingAttributes( iconTextKey ); -->
							#>
							<th {{{colSpan}}} {{{ view.getRenderAttributeString( iconTextKey ) }}}>
								<?php if( defined( 'TABLE_ADDONS_PRO_FOR_ELEMENTOR_VERSION' ) ): ?>
								<#
									if( item.header_content_type == 'editor' ){
										#>
										{{{ item.editor }}}
										<#
										tableHeaderData.push(item.editor);
									} else {
										#>
										{{{ item.text }}}
										<#
										tableHeaderData.push(item.text);
									}
								#>
								<?php else: ?>
									<#
										if (['editor'].includes(item.header_content_type)) {
											#>
											<div class="table-addons-editor-mode-pro-notice">
												<strong>{{{item.header_content_type}}}</strong> is available in pro version only. Get the <a href="https://fusionplugin.com/plugins/table-addons-for-elementor/?utm_source=activesite&utm_campaign=elementortable&utm_medium=link" target="_blank">pro version</a>.
											</div>
											<#
										} else {
											#>
											{{{ item.text }}}
											<#
										}
									#>
								<?php endif; ?>
							</th>
						<#
						} );
					} #>
				</tr>
			</thead>
			<# var dataLabelIndex = 0; #>
			<tbody class="tafe-table-body">
				<tr>
					<#
					if ( settings.table_body ) {
						_.each( settings.table_body, function( item, index ) {
							if( 'yes' === item.row){
								newRow = '</tr><tr>';
							}else{
								newRow = '';
							}

							if( 'yes' === item.colspan && 'yes' === item.advance){
								colSpan = 'colSpan="'+item.colspannumber+'"';
							}else{
								colSpan = '';
							}

							if( 'yes' === item.rowspan && 'yes' === item.advance){
								rowSpan = 'rowSpan="'+item.rowspannumber+'"';
							}else{
								rowSpan = '';
							}

							if( 'yes' === item.row){
								dataLabelIndex = 0;
							}

							var dataLabel = tableHeaderData[dataLabelIndex];
							dataLabelIndex++;
							if( 'yes' === item.colspan && 'yes' === item.advance) dataLabelIndex++;

							var tdTextKey = view.getRepeaterSettingKey( 'text', 'table_body', index );
							
							view.addRenderAttribute( tdTextKey, 'class', 'elementor-repeater-item-'+item._id );
							view.addRenderAttribute( tdTextKey, 'class', 'td-content-type-'+item.body_content_type );
							<!-- view.addInlineEditingAttributes( tdTextKey ); -->

							#>
							{{{newRow}}}
							<!-- <td {{{rowSpan}}} {{{colSpan}}} {{{ view.getRenderAttributeString( tdTextKey ) }}}>{{{ item.text }}}</td> -->
							<td {{{rowSpan}}} {{{colSpan}}} {{{ view.getRenderAttributeString( tdTextKey ) }}} data-label="{{{dataLabel}}}">
								<?php if( defined( 'TABLE_ADDONS_PRO_FOR_ELEMENTOR_VERSION' ) ): ?>
								<#
									if( item.body_content_type == 'icon' ){
										if( item.selected_icon ) {
											var iconHTML = elementor.helpers.renderIcon( view, item.selected_icon, { 'aria-hidden': 'true' }, 'i' );
											#>
											<div class="table-addons-icon-wrapper">
												{{{ iconHTML }}}
											</div>
											<#
										}
									} else if( item.body_content_type == 'icon-content' ){
										#>
										<div class="table-addons-icon-content-wrapper">
											<span class="table-addons-icon-content">
												<# if ( ! _.isEmpty( item.icon_content_icon ) ) { #>
													<span class='table-addons-align-icon-{{ item.icon_content_icon_align }}'>
														{{{ elementor.helpers.renderIcon( view, item.icon_content_icon, { 'aria-hidden': 'true' } ) }}}
													</span>
												<# } #>
												<span class="table-addons-icon-content-text">{{{ item.icon_content_text }}}</span>
											</span>
										</div>
										<#
									} else if( item.body_content_type == 'button' ){

										var repeaterButtonKey = view.getRepeaterSettingKey( 'button', 'table_body', index );

										view.addRenderAttribute( repeaterButtonKey, 'class', 'table-addons-button' );

										if ( ! _.isEmpty( item.button_link.url ) ) {
											view.addRenderAttribute( repeaterButtonKey, 'href', item.button_link.url );
											view.addRenderAttribute( repeaterButtonKey, 'class', 'table-addons-button-link' );
										} else {
											view.addRenderAttribute( repeaterButtonKey, 'role', 'button' );
										}

										if ( ! _.isEmpty( item.button_css_id ) ) {
											view.addRenderAttribute( repeaterButtonKey, 'id', item.button_css_id );
										}
										#>
										<div class="table-addons-button-wrapper">
											<a {{{ view.getRenderAttributeString( repeaterButtonKey ) }}}>
												<span class="table-addons-button-content-wrapper">
													<#
													if ( ! _.isEmpty( item.button_icon ) ) {
														#>
														<span class="table-addons-align-icon-{{{ item.button_icon_align }}}">
															{{{ elementor.helpers.renderIcon( view, item.button_icon, { 'aria-hidden': 'true' } ) }}}
														</span>
														<#
													}
													#>
													<span class="table-addons-button-text"> {{{ item.button_text }}} </span>
												</span>
											</a>
										</div>
										<#
									} else if( item.body_content_type == 'link' ){
										var repeaterLinkKey = view.getRepeaterSettingKey( 'link', 'table_body', index );

										view.addRenderAttribute( repeaterLinkKey, 'class', 'table-addons-link' );

										if ( ! _.isEmpty( item.link_link.url ) ) {
											view.addRenderAttribute( repeaterLinkKey, 'href', item.link_link.url );
										}
										#>

										<a {{{ view.getRenderAttributeString( repeaterLinkKey ) }}}>{{{ item.link_text }}}</a>
										
										<#
									} else if( item.body_content_type == 'image' ){
										if ( item.image.url ) {
											var repeaterImage = {
												id: item.image.id,
												url: item.image.url,
												size: item.thumbnail_size,
												dimension: item.thumbnail_custom_dimension,
												model: view.getEditModel()
											};
											var repeater_image_url = elementor.imagesManager.getImageUrl( repeaterImage );

											if ( ! repeater_image_url ) {
												return;
											}
											#>
											<img src="{{ repeater_image_url }}" />
										<#
										}
									} else if( item.body_content_type == 'editor' ){
										#>
										{{{ item.editor }}}
										<#
									} else {
										#>
										{{{ item.text }}}
										<#
									}
								#>
								<?php else: ?>
									<#
										if (['icon', 'icon-content', 'button', 'link', 'image', 'editor'].includes(item.body_content_type)) {
											#>
											<div class="table-addons-editor-mode-pro-notice">
												<strong>{{{item.body_content_type}}}</strong> is available in pro version only. Get the <a href="https://fusionplugin.com/plugins/table-addons-for-elementor/?utm_source=activesite&utm_campaign=elementortable&utm_medium=link" target="_blank">pro version</a>.
											</div>
											<#
										} else {
											#>
											{{{ item.text }}}
											<#
										}
									#>
								<?php endif; ?>
							</td>
						<#
						} );
					} #>
				</tr>
			</tbody>
		</table>
		<?php
	}

	public function render_pro_notice($type = 'icon'){
		$is_edit_mode = \Elementor\Plugin::$instance->editor->is_edit_mode();
		if( $is_edit_mode ){
			echo '<div class="table-addons-editor-mode-pro-notice">';
			printf(
				/* translators: 1. Field type, 2. Link. */
				esc_html__( '%1$s is available in pro version only. Get the %2$spro version%3$s.', 'table-addons-for-elementor' ),
				'<strong>' . esc_html($type) . '</strong>',
				'<a href="https://fusionplugin.com/plugins/table-addons-for-elementor/?utm_source=activesite&utm_campaign=elementortable&utm_medium=link" target="_blank">',
				'</a>'
			);
			echo '</div>';
		}
	}

	public function render_icon( $icon ) {
		if( !defined( 'TABLE_ADDONS_PRO_FOR_ELEMENTOR_VERSION' ) ):
			$this->render_pro_notice('Icon');
		endif;
		
		do_action('table_addons_pro_render_icon', $icon);
	}

	public function render_icon_content( $item ){
		if( !defined( 'TABLE_ADDONS_PRO_FOR_ELEMENTOR_VERSION' ) ):
			$this->render_pro_notice('Icon Content');
		endif;

		do_action('table_addons_pro_render_icon_content', $item);
	}

	public function render_button( $item, $index ) {
		if( !defined( 'TABLE_ADDONS_PRO_FOR_ELEMENTOR_VERSION' ) ):
			$this->render_pro_notice('Button');
		endif;

		$repeater_button_key = $this->get_repeater_setting_key( 'button', 'table_body', $index );

		do_action('table_addons_pro_render_button', $item, $repeater_button_key, $this);
	}

	public function render_link($item, $index){
		if( !defined( 'TABLE_ADDONS_PRO_FOR_ELEMENTOR_VERSION' ) ):
			$this->render_pro_notice('Link');
		endif;

		$repeater_link_key = $this->get_repeater_setting_key( 'link', 'table_body', $index );

		do_action('table_addons_pro_render_link', $item, $repeater_link_key, $this);
	}

	public function render_image($item){
		if( !defined( 'TABLE_ADDONS_PRO_FOR_ELEMENTOR_VERSION' ) ):
			$this->render_pro_notice('Image');
		endif;

		do_action('table_addons_pro_render_image', $item);
	}

	public function render_editor_content($item){
		if( !defined( 'TABLE_ADDONS_PRO_FOR_ELEMENTOR_VERSION' ) ):
			$this->render_pro_notice('WYSIWYG Editor');
		endif;
		
		do_action('table_addons_pro_render_editor_content', $item);
	}

}