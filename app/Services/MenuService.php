<?php

namespace App\Services;

use App\Models\UserAkses;

class MenuService
{
    protected static array $admin_siapkerja = [
        ['route' => 'admin.dashboard', 'caption' => 'Dashboard'],
        ['route' => 'admin.user.index', 'caption' => 'Data Master', 'side_menus' => [
            ['route' => 'admin.user.index', 'caption' => 'User'],
            ['route' => 'admin.perusahaan.index', 'caption' => 'Pegawai'],
            ['route' => 'admin.sekolah.index', 'caption' => 'Pelanggan'],
        ]],
        ['route' => 'admin.perusahaan.index', 'caption' => 'Transaksi', 'side_menus' => [
            ['route' => 'admin.perusahaan.index', 'caption' => 'Penjualan'],
            ['route' => 'admin.sekolah.index', 'caption' => 'Pengeluaran'],
        ]],
        ['route' => 'admin.perusahaan.index', 'caption' => 'Laporan', 'side_menus' => [
            ['route' => 'admin.perusahaan.index', 'caption' => 'Penjualan'],
            ['route' => 'admin.sekolah.index', 'caption' => 'Pengeluaran'],
        ]],
    ];

    protected static array $admin_caker = [
        ['route' => 'cakerdashboard', 'caption' => 'Dashboard'],
        ['route' => 'cakersekolah.index', 'caption' => 'Master Data', 'side_menus' => [
            ['route' => 'cakersekolah.index', 'caption' => 'Sekolah'],
            ['route' => 'cakermasyarakat.index', 'caption' => 'Masyarakat'],
            ['route' => 'admin.lowongan.index', 'params' => ['jenis' => 'Umum'], 'caption' => 'Data Operator'],
            ['route' => 'admin.lowongan.index', 'params' => ['jenis' => 'Khusus'], 'caption' => 'Data Operator Desa'],
        ]],
        ['route' => 'cakerinformasi-geografis.index', 'caption' => 'Informasi Geografis'],
    ];

    public function list_menu($role): array
    {
        $menus = match ($role) {
            "Admin Siap Kerja" => self::$admin_siapkerja,
            "Admin Caker" => self::$admin_caker,
            default => [],
        };
        return $menus;
    }

    public static function current_menu($menus, $current_route, $role_active, $current_route_params = []) {
        unset($current_route_params['warehouse_selected']);
        unset($current_route_params['date']);

        $breadcrumbs = [['route' => head(explode('.', $current_route)), 'caption' => $role_active]];
        $current_menu = [];
        $current_sub_menu = [];
        $current_side_menu = [];
        foreach ($menus as $menu) {
            if ($menu['route'] === $current_route && ($menu['params'] ?? []) === $current_route_params) {
                $current_menu = $menu;
                $breadcrumbs[] = $menu;
            }
            foreach ($menu['sub_menus'] ?? [] as $sub_menu) {
                if ($sub_menu['route'] === $current_route && ($sub_menu['params'] ?? []) === $current_route_params) {
                    $current_menu = $menu;
                    $current_sub_menu = $sub_menu;
                    if ($sub_menu['route'] !== $menu['route']) $breadcrumbs[] = $sub_menu;
                }
                foreach ($sub_menu['side_menus'] ?? [] as $side_menu) {
                    if ($side_menu['route'] === $current_route && ($side_menu['params'] ?? []) === $current_route_params) {
                        $current_menu = $menu;
                        $current_sub_menu = $sub_menu;
                        $current_side_menu = $side_menu;
                        $breadcrumbs[] = $sub_menu;
                        $breadcrumbs[] = $side_menu;
                    }
                }
            }
            foreach ($menu['side_menus'] ?? [] as $side_menu) {
                if ($side_menu['route'] === $current_route && ($side_menu['params'] ?? []) === $current_route_params) {
                    $current_menu = $menu;
                    $current_side_menu = $side_menu;
                    if (last($breadcrumbs)['route'] !== $menu['route']) $breadcrumbs[] = $menu;
                    if ($side_menu['route'] !== $menu['route'] || ($side_menu['params'] ?? []) !== ($menu['params'] ?? [])) $breadcrumbs[] = $side_menu;
                }
            }
        }

        if (empty($current_menu)) {
            $temp = explode('.', $current_route);
            if (last($temp) === 'show' || last($temp) === 'create') {
                $temp[count($temp) - 1] = 'index';
                $current_route = join('.', $temp);
                return self::current_menu($menus, $current_route, $role_active, $current_route_params);
            } else {
                if (count($temp) > 2) {
                    array_splice($temp, count($temp) - 2, 1);
                    $current_route = join('.', $temp);
                    return self::current_menu($menus, $current_route, $role_active, $current_route_params);
                }
            }
        }

        $current = $current_side_menu ?? [];
        if (empty($current)) $current = $current_sub_menu ?? [];
        if (empty($current)) $current = $current_menu;
        $actions = $current['actions'] ?? [];

        return [
            'current_menu' => $current_menu,
            'current_sub_menu' => $current_sub_menu,
            'current_side_menu' => $current_side_menu,
            'breadcrumbs' => $breadcrumbs,
            'actions' => $actions,
        ];
    }
}
