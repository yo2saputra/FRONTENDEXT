<?php

if (!function_exists('build_multi_level_sidebar')) {
    function build_multi_level_sidebar($menus, $parent_cd = null, $current_ref = '')
    {
        $html = '';

        foreach ($menus as $menu) {
            $is_matching = ($parent_cd === null && empty($menu['parent_cd'])) ||
                (!empty($menu['parent_cd']) && $menu['parent_cd'] === $parent_cd);

            if (!$is_matching) continue;

            // Cek apakah punya anak
            $has_children = false;
            $child_references = [];
            foreach ($menus as $check) {
                if (!empty($check['parent_cd']) && $check['parent_cd'] === $menu['menu_cd']) {
                    $has_children = true;
                    if (!empty($check['reference']) && $check['reference'] !== '#') {
                        $child_references[] = $check['reference'];
                    }
                    // Rekursif cek anak dari anak
                    foreach ($menus as $grandchild) {
                        if (!empty($grandchild['parent_cd']) && $grandchild['parent_cd'] === $check['menu_cd']) {
                            if (!empty($grandchild['reference']) && $grandchild['reference'] !== '#') {
                                $child_references[] = $grandchild['reference'];
                            }
                        }
                    }
                }
            }

            // Tentukan link
            $link = '#';
            if (!$has_children && !empty($menu['reference']) && $menu['reference'] !== '#') {
                $link = base_url($menu['reference']);
            }

            // Active: jika reference persis sama dengan current
            $is_active = !empty($menu['reference']) && $menu['reference'] === $current_ref;

            // Open parent jika current_ref adalah anak/sub-anak dari menu ini
            $is_in_subtree = $is_active || in_array($current_ref, $child_references);

            $active_class = $is_active ? 'active-submenu' : '';
            $active_style = $is_active ? 'style="color:blue;"' : '';
            $active_id = $is_active ? 'active-menu' : '';

            $treeview = $has_children ? 'has-treeview' : '';
            $menu_open = ($has_children && $is_in_subtree) ? 'menu-open' : '';

            $arrow = $has_children ? '<i class="right fas fa-angle-left"></i>' : '';

            $icon = !empty($menu['menu_icon']) ? $menu['menu_icon'] : 'far fa-circle';

            $html .= '<li class="nav-item ' . $treeview . ' ' . $menu_open . '">';
            $html .= '<a href="' . $link . '" class="nav-link ' . $active_class . '" ' . $active_style . '>';
            $html .= '<i class="nav-icon ' . $icon . '" style="font-size: 0.85rem;"></i>';
            $html .= '<p id="' . $active_id . '" style="font-size: 0.85rem;">' . htmlspecialchars($menu['menu_nm']) . $arrow . '</p>';
            $html .= '</a>';

            if ($has_children) {
                $html .= '<ul class="nav nav-treeview">';
                $html .= build_multi_level_sidebar($menus, $menu['menu_cd'], $current_ref);
                $html .= '</ul>';
            }

            $html .= '</li>';
        }

        return $html;
    }
}
