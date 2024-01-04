<div class="sd-menu-wrapper">
    <ul class="sd-menu-heading list-unstyled" role="menubar">
        <li id="support" class="menu-title active" role="presentation">
            <div class="menu-title-container">
                <a class="menu-title-text" role="menuitem" href="/support/">
                    <span class="menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="13" height="13" viewBox="0 0 13 13">
                            <defs>
                                <clipPath id="a">
                                    <rect width="13" height="13" fill="#8d8d8d"></rect>
                                </clipPath>
                            </defs>
                            <g transform="translate(-0.137 -0.559)">
                                <g transform="translate(0.137 0.559)" clip-path="url(#a)">
                                    <path d="M11.846,10.03a1.338,1.338,0,1,1-1.893,1.893l-2.6-2.6A2.505,2.505,0,0,1,4.432,6.075a.114.114,0,0,1,.172-.04l1.5,1.5a.522.522,0,0,0,.737,0l.621-.621a.523.523,0,0,0,0-.737l-1.5-1.5A.114.114,0,0,1,6,4.507,2.505,2.505,0,0,1,9.248,7.432Zm1.447-4.315-1.225-.191a5.387,5.387,0,0,0-.645-1.559l.76-1.041a.356.356,0,0,0-.035-.446L11.106,1.435A.356.356,0,0,0,10.66,1.4l-1.041.76A5.393,5.393,0,0,0,8.06,1.516L7.868.291A.357.357,0,0,0,7.528,0H6.055a.357.357,0,0,0-.34.291L5.524,1.516a5.392,5.392,0,0,0-1.559.645L2.923,1.4a.356.356,0,0,0-.446.035L1.436,2.477a.356.356,0,0,0-.035.446l.76,1.041a5.4,5.4,0,0,0-.645,1.559L.291,5.715A.357.357,0,0,0,0,6.055V7.528a.356.356,0,0,0,.291.34l1.224.191a5.4,5.4,0,0,0,.645,1.559L1.4,10.66a.356.356,0,0,0,.035.446l1.042,1.041a.356.356,0,0,0,.446.035l1.041-.76a5.393,5.393,0,0,0,1.56.645l.191,1.224a.357.357,0,0,0,.34.291H7.528a.357.357,0,0,0,.34-.291l.191-1.224a5.386,5.386,0,0,0,.56-.167L7.447,10.728A3.989,3.989,0,1,1,10.708,7.58l1.151,1.151a5.355,5.355,0,0,0,.208-.672l1.224-.191a.356.356,0,0,0,.291-.34V6.055a.356.356,0,0,0-.291-.34" transform="translate(-0.126 -0.431)" fill="#8d8d8d"></path>
                                </g>
                            </g>
                        </svg>
                    </span>
                    <span class="menu-text">Support</span>
                </a>
            </div>
            <?php
            $categories = get_terms(array(
                'taxonomy' => 'support-category',
                'hide_empty' => true,
            ));

            if (!empty($categories)) {
                echo '<ul class="sd-submenu-heading ml-3 list-unstyled">';

                foreach ($categories as $category) {
                    // Check if it's a parent category
                    if ($category->parent == 0) {
                        // Get the link to the parent category
                        $category_link = get_term_link($category);

                        // Check for an error in getting the link
                        if (!is_wp_error($category_link)) {
                            $submenu_title = strtolower(str_replace(' ', '-', $category->name));

                            echo '<li id="' . $submenu_title . '" class="submenu-title">
                            <div class="submenu-title-container">
                                <a class="submenu-title-text" tabindex="-1" role="menuitem" href="' . esc_url($category_link) . '">' . $category->name . '</a>
                                <span class="menu-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="6.793" height="12.172" viewBox="0 0 6.793 12.172">
                                        <path id="Path_99" data-name="Path 99" d="M-517.954-6099.389l5.379,5.379,5.379-5.379" transform="translate(6100.096 -506.489) rotate(-90)" fill="none" stroke="#787878" stroke-linecap="round" stroke-width="1"/>
                                    </svg>
                                </span>
                            </div>';

                            // Get child categories
                            $child_categories = get_terms(array(
                                'taxonomy' => 'support-category',
                                'hide_empty' => true,
                                'parent' => $category->term_id
                            ));

                            if (!empty($child_categories)) {
                                echo '<div class="sub-submenu-container"><ul class="sub-submenu-heading list-unstyled">';

                                foreach ($child_categories as $child) {
                                    $anchor_link = strtolower(str_replace(' ', '-', $child->name));
                                    echo '<li class="sub-submenu-title">
                                        <a class="sub-submenu-title-text" tabindex="-1" role="menuitem" href="' . esc_url($category_link) . '#' . $anchor_link . '">' . $child->name . '</a>
                                    </li>';
                                }

                                echo '</ul></div>';
                            }

                            echo '</li>';
                        }
                    }
                }

                echo '</ul>';
            }
            ?>
        </li>
        <li id="tech-resources" class="menu-title" role="presentation">
            <div class="menu-title-container">
                <a class="menu-title-text" tabindex="-1" role="menuitem" href="/technical-resources/" data-focus-index="1">
                    <span class="menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="17.591" viewBox="0 0 13 17.591">
                            <g transform="translate(0 0)" opacity="0.501">
                                <path d="M10.211,0,0,3.84l1.735.822L9.117,1.856V2.78l1.093-.41V0Z" transform="translate(0)" fill="#1e1e1e"></path>
                                <path d="M4.225,44.161,0,42.39V54.022l3.859,2.254L13,52.613V40.78Z" transform="translate(0 -38.685)" fill="#1e1e1e"></path>
                            </g>
                        </svg>
                    </span>
                    <span class="menu-text">Technical Resources</span>
                </a>
            </div>
        </li>
        <li id="g4-demo" class="menu-title" role="presentation">
            <div class="menu-title-container">
                <a class="menu-title-text" tabindex="-1" role="menuitem" href="#" data-focus-index="1">
                    <span class="menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="10.883" viewBox="0 0 13 10.883">
                            <g transform="translate(-272 -465)">
                                <g transform="translate(281.461 466.209)">
                                    <rect width="0.604" height="4.535" transform="translate(0 0)" fill="#8d8d8d"></rect>
                                </g>
                                <g transform="translate(281.461 472.558)">
                                    <path d="M34.414,33.039a.3.3,0,0,1-.3-.3v-.922a.3.3,0,1,1,.6,0v.922A.3.3,0,0,1,34.414,33.039Z" transform="translate(-34.112 -31.512)" fill="#8d8d8d"></path>
                                </g>
                                <g transform="translate(278.136 472.558)">
                                    <path d="M24.181,33.039a.3.3,0,0,1-.3-.3v-.922a.3.3,0,1,1,.6,0v.922A.3.3,0,0,1,24.181,33.039Z" transform="translate(-23.879 -31.512)" fill="#8d8d8d"></path>
                                </g>
                                <g transform="translate(272 473.465)">
                                    <path d="M17.887,36.72H5.113A.113.113,0,0,1,5,36.607V34.414a.113.113,0,0,1,.113-.113H17.887a.113.113,0,0,1,.113.113v2.193A.113.113,0,0,1,17.887,36.72Z" transform="translate(-5 -34.301)" fill="#8d8d8d"></path>
                                </g>
                                <g transform="translate(272 472.256)">
                                    <path d="M17.395,31.186V32.7H5.6V31.186h11.79m.485-.6H5.12A.12.12,0,0,0,5,30.7v2.482a.12.12,0,0,0,.12.12H17.88a.12.12,0,0,0,.12-.12V30.7a.12.12,0,0,0-.12-.12Z" transform="translate(-5 -30.581)" fill="#8d8d8d"></path>
                                </g>
                                <g transform="translate(272.302 465)">
                                    <path d="M16.511,8.86v6.651H6.535V8.86h9.976m.048-.6H6.486a.556.556,0,0,0-.556.556V15.56a.556.556,0,0,0,.556.556H16.559a.556.556,0,0,0,.556-.556V8.812a.556.556,0,0,0-.556-.556Z" transform="translate(-5.93 -8.256)" fill="#8d8d8d"></path>
                                </g>
                                <g transform="translate(273.512 466.209)">
                                    <g transform="translate(0 0)">
                                        <path d="M16.3,12.581v3.326H10.256V12.581H16.3m.1-.6h-6.24a.508.508,0,0,0-.508.508V16a.508.508,0,0,0,.508.508H16.4A.508.508,0,0,0,16.907,16V12.485a.508.508,0,0,0-.508-.508Z" transform="translate(-9.651 -11.977)" fill="#8d8d8d"></path>
                                    </g>
                                </g>
                                <g transform="translate(282.883 470.442)">
                                    <g transform="translate(0 0)">
                                        <path d="M40.3,27.117a.3.3,0,0,1-.271-.167l-.672-1.345H38.79a.3.3,0,0,1,0-.6h.756a.3.3,0,0,1,.27.167l.756,1.512a.3.3,0,0,1-.135.406A.305.305,0,0,1,40.3,27.117Z" transform="translate(-38.488 -25.001)" fill="#8d8d8d"></path>
                                    </g>
                                    <g transform="translate(1.814 1.813)">
                                        <rect width="0.302" height="0.302" fill="#8d8d8d"></rect>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </span>
                    <span class="menu-text">G4 Virtual Demo</span>
                </a>
            </div>
        </li>
    </ul>
</div>
<div class="sd-user-meta">
    <span class="elementor-icon-list-icon"><i aria-hidden="true" class="fas fa-user"></i></span>
    <span class="elementor-icon-list-text">ACCOUNT</span>

    <div>
        <?php do_shortcode( '[user_meta]' ); ?>
    </div>
</div>