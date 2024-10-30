<?php
/**
 * Settings class.
 */
class EDDadv_Admin_Settings {
    /**
     * Settings constructor.
     *
     * @since 1.0.0
     */
    public function __construct() {
        $this->eddadv_settings_options();
        //$this->eddadv_font_metabox();
    }


    /**
     * Settings sections.
     *
     * @since 1.0.0
     */
    protected function eddadv_settings_sections() {
        $eddadv_settings_sections = array(
            array(
                'id'     => 'general',
                'title'  => 'Welcome',
                'icon' =>'dashicons dashicons-buddicons-groups',
                'class' =>'eddafv-col-4',
                'fields' => array(

                    array(
                        'id'         => 'eddafv_w_text',
                        'type'       => 'eddadvwelcometext',
                        'title'      => '',
                    ),

                    array(
                        'id'         => 'eddafv_m_banner',
                        'type'       => 'mayosisbanner_eddav',
                        'title'      => '',
                    ),

                )),


            array(
                'id'     => 'settings',
                'title'  => 'Settings',
                'icon' =>'dashicons dashicons-admin-generic',
                'fields' => array(

                  

                    array(
                        'id'      => 'eddadv_title',
                        'type'    => 'text',
                        'title'   => 'Time Counter Title',
                        'default' => 'End Soon'
                    ),

                  

                    array(
                        'id'          => 'eddadv_title_color',
                        'type'        => 'color',
                        'title'       => 'Title Color',
                        'default' =>'#59608e',
                        'output'      => '.mayosis-product-widget-counter .edd-advanced-sale-title',
                        'output_mode' => 'color',
                    ),

                    array(
                        'id'          => 'eddadv_title_bg_color',
                        'type'        => 'color',
                        'title'       => 'Title Background Color',
                        'default' =>'#faf9fb',
                        'output'      => '.mayosis-product-widget-counter .edd-advanced-sale-title span',
                        'output_mode' => 'background',
                    ),
                    
                    array(
                        'id'          => 'eddadv_title_border_color',
                        'type'        => 'color',
                        'title'       => 'Title Border Color',
                        'default' =>'#faf9fb',
                        'output'      => '.mayosis-product-widget-counter .edd-advanced-sale-title',
                        'output_mode' => 'border-color',
                    ),
                    
                    array(
                          'id'      => 'eddadv_title_typography',
                          'type'    => 'typography',
                          'title'   => 'Typography',
                          'output'  => '.mayosis-product-widget-counter .edd-advanced-sale-title',
                          'color' => false,
                          'text_align' => false,
                        
                        ),

                    array(
                        'id'          => 'eddadv_common_meta_text',
                        'type'        => 'color',
                        'title'       => 'Discount Box Value Color',
                        'default' =>'#59608e',
                        'output'      => '.edd-adv-perchantage-box p.edv_perch_value',
                        'output_mode' => 'color',
                    ),
                    
                    
                    array(
                        'id'          => 'eddadv_common_meta_label_text',
                        'type'        => 'color',
                        'title'       => 'Discount Box Label Color',
                        'default' =>'#59608e',
                        'output'      => '.edd-adv-perchantage-box p.edv_perch_label',
                        'output_mode' => 'color',
                    ),


        array(
                        'id'          => 'eddadv_other_border_color',
                        'type'        => 'color',
                        'title'       => 'Other Border Color',
                        'default' =>'#59608e',
                        'output'      => '.mayosis-product-widget-counter .edd-adv-perchantage-amount',
                        'output_mode' => 'border-color',
                    ),
                    
                    
                     array(
                        'id'          => 'eddadv_counter_number_color',
                        'type'        => 'color',
                        'title'       => 'Counter Number Color',
                        'default' =>'#59608e',
                        'output'      => '.mayosis-product-widget-counter .edd-advanced-sale-count-time .emerce-count-value',
                        'output_mode' => 'color',
                    ),
                    
                      array(
                        'id'          => 'eddadv_counter_label_color',
                        'type'        => 'color',
                        'title'       => 'Counter Label Color',
                        'default' =>'#59608e',
                        'output'      => '.mayosis-product-widget-counter .edd-advanced-sale-count-time .emerce-count-value .label',
                        'output_mode' => 'color',
                    ),
                    
                    array(
                          'id'      => 'eddadv_counter_typography',
                          'type'    => 'typography',
                          'title'   => 'Counter Typography',
                          'output'  => '.mayosis-product-widget-counter .edd-advanced-sale-count-time .emerce-count-value',
                          'color' => false,
                          'text_align' => false,
                        
                        ),



array(
                          'id'      => 'eddadv_counter_label_typography',
                          'type'    => 'typography',
                          'title'   => 'Counter Label Typography',
                          'output'  => '.mayosis-product-widget-counter .edd-advanced-sale-count-time .emerce-count-value .label',
                          'color' => false,
                          'text_align' => false,
                        
                        ),
                        
                        
                         array(
                        'id'          => 'eddadv_counter_number_border_color',
                        'type'        => 'color',
                        'title'       => 'Counter Number Bottom Border Color',
                        'default' =>'#59608e',
                        'output'      => '.mayosis-product-widget-counter .edd-advanced-sale-count-time',
                        'output_mode' => 'border-color',
                    ),

                    
                    


                
                )),

        );
        
        return apply_filters( 'eddadv_eddadv_settings_sections', $eddadv_settings_sections );

    }

    /**
     * Settings Options.
     *
     * @since 1.0.3
     */
    protected function eddadv_settings_options() {
        $eddadv_settings_options_slug = 'eddadv_options';

        \CSF::createOptions( $eddadv_settings_options_slug, array(
            'framework_title'         => 'EDD Advanced Sale Counter Options <small>by Teconce</small>',
            'menu_title'  => 'EDD Sale Counter',
            'menu_slug'   => 'eddadv_options',
            'menu_type'   => 'submenu',
            'menu_parent' => 'options-general.php',
            'sticky_header'           => false,
            'show_search'             => true,
            'show_reset_all'          => false,
            'show_reset_section'      => false,
            'show_footer'             => false,
            'show_all_options'        => true,
            'show_form_warning'       => true,
            'sticky_header'           => false,
            'save_defaults'           => true,
            'ajax_save'               => true,

            // admin bar menu settings
            'admin_bar_menu_icon'     => '',
            'admin_bar_menu_priority' => 80,

            // footer
            'footer_text'             => '',
            'footer_after'            => '',
            'footer_credit'           => ' Thank you for using EDDadv. Powered by <a href="https://teconce.com">Teconce</a>',

            'nav'                     => 'inline',
            'theme'                   => 'light',
            'class'                   => '',
        ) );

        $eddadv_settings_sections = $this->eddadv_settings_sections();

        if ( is_array( $eddadv_settings_sections ) && ! empty( $eddadv_settings_sections ) ) {
            foreach ( $eddadv_settings_sections as $settings_section ) {
                \CSF::createSection( $eddadv_settings_options_slug, $settings_section );
            }
        }
    }
    
    
}
