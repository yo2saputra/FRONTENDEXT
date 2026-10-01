<?php

if (!function_exists('build_multi_level_sidebar')) {
    /**
     * Rekursif membangun sidebar multi-level
     * Mendukung:
     * - Open parent otomatis hingga level tak terbatas
     * - Garis bawah pada menu dengan reference = '#'
     */
    function build_multi_level_sidebar($menus, $parent_cd = null, $current_ref = '')
    {
        $html = '';

        foreach ($menus as $menu) {
            $is_matching = ($parent_cd === null && empty($menu['parent_cd'])) ||
                (!empty($menu['parent_cd']) && $menu['parent_cd'] === $parent_cd);

            if (!$is_matching) continue;

            // Cek apakah punya anak
            $has_children = false;
            foreach ($menus as $check) {
                if (!empty($check['parent_cd']) && $check['parent_cd'] === $menu['menu_cd']) {
                    $has_children = true;
                    break;
                }
            }

            // Tentukan link
            $link = $has_children ? '#' : base_url($menu['reference'] ?? '#');

            // Active: hanya jika reference persis sama dengan current_ref dan bukan '#'
            $is_active = !empty($menu['reference']) && $menu['reference'] === $current_ref && $menu['reference'] !== '#';

            // Cek apakah current_ref ada di dalam subtree (untuk buka parent)
            $is_in_subtree = $is_active || is_reference_in_subtree($menus, $menu['menu_cd'], $current_ref);

            // Style aktif sesuai kode Anda
            $active_class = $is_active ? 'active-submenu' : '';
            $active_style = $is_active ? 'style="color:blue;"' : '';
            $active_id    = $is_active ? 'active-menu' : '';

            // Treeview & open
            $treeview = $has_children ? 'has-treeview' : '';
            $menu_open = ($has_children && $is_in_subtree) ? 'menu-open' : '';

            // Arrow
            $arrow = $has_children ? '<i class="right fas fa-angle-left"></i>' : '';

            // Icon
            $icon = !empty($menu['menu_icon']) ? $menu['menu_icon'] : 'far fa-circle';

            // === Garis bawah diperbaiki: tebal sama rata, tanpa lengkungan ===
            $underline_style = '';
            if (!empty($menu['reference']) && $menu['reference'] === '#') {
                $underline_style = 'style="border-bottom: 2px solid #007bff; padding-bottom: 8px; margin-bottom: 5px; display: block;"';
            }

            $html .= '<li class="nav-item ' . $treeview . ' ' . $menu_open . '">';
            $html .= '<a href="' . $link . '" class="nav-link ' . $active_class . '" ' . $active_style . ' ' . $underline_style . '>';
            $html .= '<i class="nav-icon ' . $icon . '" style="font-size: 0.85rem;"></i>';
            $html .= '<p id="' . $active_id . '" style="font-size: 0.85rem; font-weight: ' . ($underline_style ? 'bold' : 'normal') . ';">' . htmlspecialchars($menu['menu_nm']) . $arrow . '</p>';
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

// Fungsi bantu untuk cek subtree (wajib ada)
if (!function_exists('is_reference_in_subtree')) {
    function is_reference_in_subtree($menus, $menu_cd, $current_ref)
    {
        foreach ($menus as $item) {
            if (!empty($item['parent_cd']) && $item['parent_cd'] === $menu_cd) {
                if (!empty($item['reference']) && $item['reference'] === $current_ref && $item['reference'] !== '#') {
                    return true;
                }
                if (is_reference_in_subtree($menus, $item['menu_cd'], $current_ref)) {
                    return true;
                }
            }
        }
        return false;
    }
}
