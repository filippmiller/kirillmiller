<?php
$default_options = array(
						'pagination' => '1',
						'pagination_button_text' => 'Load more',
                        'imagesPperPage' => '10',
                        'filterTag' => '1',
                        'activColor' => '3498db',
                        'reverseColor' => 'ffffff',
                        'columns' => '4',
                        'thumbRecomendedSize'=> '150',
                        'spaceX' => '3',
                        'spaceY' => '3',
                        'thumbTitleVisibility' => '1',
                        'lightboxBGColor' => 'ffffff',
                        'socialShareEnabled' => '1',
                        'customCSS' => ''
);
$options_tree    = array(array('label'  => 'Common Settings',
                               'fields' => array(
                               					'pagination'           => array('label' => 'Pagination on/off',
                                                                                 'tag'   => 'checkbox',
                                                                                 'attr'  => 'data-watch="change"',
                                                                                 'text'  => 'Break images into pages'
																				 ),
												'pagination_button_text' => array('label' => 'Title for Pagination Button',
                                                                                 'tag'   => 'input',
                                                                                 'attr'  => 'data-pagination="is:1"',
                                                                                 'text'  => 'Pagination should be On'
                                                ),
                               					'imagesPperPage'   => array('label' => 'Images per page',
																			    'tag'   => 'input',
																			    'attr'  => 'type="number" min="1" max="50" data-pagination="is:1"',
																			    'text'  => 'Number of images to show per page.'
																			     ),
												'filterTag'           => array('label' => 'Filter show/hide',
                                                                                 'tag'   => 'checkbox',
                                                                                 'attr'  => '',
                                                                                 'text'  => 'Show/Hide Tags bar'
																				 ),
                                                'activColor'              => array('label' => 'Color 1',
                                                                                 'tag'   => 'input',
                                                                                 'attr'  => 'type="text" data-type="color"',
                                                                                 'text'  => 'Set custom color for gallery'
																				 ),
												'reverseColor'              => array('label' => 'Color 2',
                                                                                 'tag'   => 'input',
                                                                                 'attr'  => 'type="text" data-type="color"',
                                                                                 'text'  => 'Set custom color for gallery'
																				 )
												)
                         ),
                         array('label'  => 'Thumb Grid General',
                               'fields' => array('columns'     => array('label' => 'Thumbnail Columns',
                                                                          'tag'   => 'input',
                                                                          'attr'  => 'type="number" min="1" max="20"',
                                                                          'text'  => 'Number of columns in a row'
																		  ),
												'thumbRecomendedSize'     => array('label' => 'Minimum Thumbnail Size',
                                                                          'tag'   => 'input',
                                                                          'attr'  => 'type="number" min="100" max="300"',
                                                                          'text'  => 'The module will ignore the number of columns.'
																		  ),						 
												'spaceX' => array('label' => 'Gap: X',
                                                                          'tag'   => 'input',
                                                                          'attr'  => 'type="number" min="0" max="100"',
                                                                          'text'  => 'Space between columns'
																		  ),
												'spaceY' => array('label' => 'Gap: Y',
                                                                          'tag'   => 'input',
                                                                          'attr'  => 'type="number" min="0" max="100"',
                                                                          'text'  => 'Space between rows'
																		  ),
												'thumbTitleVisibility' => array('label' => 'Title on/off',
                                                             	            'tag'   => 'checkbox',
                                                                            'attr'  => '',
                                                                            'text'  => 'Show image title'
																		)
                                                 )
                         ),
                         array('label'  => 'Lightbox Settings',
                               'fields' => array('lightboxBGColor'       => array('label' => 'Lightbox Window Color',
                                                                                  'tag'   => 'input',
                                                                                  'attr'  => 'type="text" data-type="color"',
                                                                                  'text'  => 'Set the background color for the lightbox window'
                                                 ),
                                                 'socialShareEnabled'   => array('label' => 'Show Share Button',
                                                                                 'tag'   => 'checkbox',
                                                                                 'attr'  => 'data-watch="change"',
                                                                                 'text'  => ''
                                                 )
                               )
                         ),
                         array('label'  => 'Advanced Settings',
                               'fields' => array('customCSS' => array('label' => 'Custom CSS',
                                                                      'tag'   => 'textarea',
                                                                      'attr'  => 'cols="20" rows="10"',
                                                                      'text'  => 'You can enter custom style rules into this box if you\'d like. IE: <i>a{color: red !important;}</i>
                                                                      <br />This is an advanced option! This is not recommended for users not fluent in CSS... but if you do know CSS, 
                                                                      anything you add here will override the default styles'
																	  )
                                                 /*,
                                                 'loveLink' => array(
                                                     'label' => 'Display LoveLink?',
                                                     'tag' => 'checkbox',
                                                     'attr' => '',
                                                     'text' => 'Selecting "Yes" will show the lovelink icon (codeasily.com) somewhere on the gallery'
                                                 )*/
                               )
                         )
);
