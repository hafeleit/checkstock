<?php

namespace App\Helpers;

class EmployeeTeamHelper
{
    const TEAMS = [
        'BKK' => [
            'Seksan Saisutthi (HTH8810)',
            'Sermpan Rungtaveesuk (HTH8807)',
        ],
        'HA&SA BKK1' => [
            'Thuleedin Phudeethpi (HTH8861)',
            'KIDCHAI TIDANG (HTH8815)',
        ],
        'HA&SA BKK2' => [
            'Thotsapon Bubpachot (HTH8941)',
            'ALONGKOT WIYO (HTH8818)',
        ],
        'HA&SA BKK3' => [
            'PREECHA VANICHCHAGRON(HTH8823)',
            'Jakapan Singthong(HTH8826)',
        ],
        'HA&SA BKK4' => [
            'THUDCHADOL PHANUKORNKHAJORNKIJ (HTH8817)',
            'WITTAYA SAEJONG (HTH8871)',
        ],
        'HA&SA BKK5' => [
            'SAKDITAS KAEWWAN (HTH8872)',
            'Charuch Koomkhet (HTH8822)',
        ],
        'HA&SA BKK6' => [
            'PORNCHAI SILASIRAPAN (HTH8811)',
        ],
        'HA&SA BKK7' => [
            'PORNSAK SAENSING (HTH8821)',
            'Suphamongkhon Diraphan(HTH8829)',
        ],
        'HW&FF BKK1' => [
            'SURACHAI CHANPLANG (HTH8828)',
        ],
        'HW&FF BKK2' => [
            'PHONGSAK SAENSING (HTH8819)',
        ],
        'HW&FF BKK3' => [
            'Prasan Hongweangchan (HTH8812)',
        ],
        'HW&FF BKK4' => [
            'SUPHAN SUTTAKHAN (HTH8825)',
        ],
        'CM' => [
            'SOMBUT CHUMPHOOSAN (HTH8851)',
        ],
        'PHK' => [
            'RITTIRONG WONGPIPAN (HTH8831)',
            'Nattakit Wattanalapcharoenkul(HTH8863)',
        ],
        'Service Consultant' => [
            'Ekkarin Rattanathammanon (HTH8805)',
            'Aphichet Juong-kapair (HTH8824)',
            'Phachara Petchsawang(HTH8835)',
            'Panuwat Kophonrat (HTH8813)',
            'Apisorn Maneerat(HTH05304)',
        ],
        'Service CM' => [
            'Porntip Inwong (HTH8841)',
        ],
        'Service PHK' => [
            'Pimchanok Sawetpattanajarat(HTH8842)',
        ],
        'Service HH' => [
            'Onrumpa Plungkoon(HTH8843)',
        ],
        'Spare Part' => [
            'Somporn Klongnoith (HTH8801)',
            'SAMIN TOADEN (HTH8816)',
            'Tuenjai Nonsuang (HTH8882)',
            'Ploypailin Nanwilai (HTH8803)',
        ],
        'Service Support' => [
            'Sarisa Soonthornkalam (HTH8802)',
            'Kanokwan Promuthai (HTH8874)',
            'Patcharanun Thiwannaluck (HTH8804)',
        ],
        'Analyst' => [
            'Atiwan Fongsuwan (HTH8876)',
        ],
        'Service Control' => [
            'Phunsa Phailek (HTH8806)',
            'Phanudet Sothornrungrangsri (HTH8862)',
        ],
        'Ticket & Outbound' => [
            'Wanna Setsathawon (HTH8889)',
            'PICHANAD KHOMTHONG(HTH8881)',
            'Warunee Duangnu (HTH8808)',
        ],
        'Contact Center' => [
            'Panisha Nichthanyakul (HTH8883)',
        ],
    ];

    public static function teams(): array
    {
        return array_keys(self::TEAMS);
    }

    public static function membersOf(string $team): array
    {
        return self::TEAMS[$team] ?? [];
    }

    public static function teamOf(string $fullName): ?string
    {
        foreach (self::TEAMS as $team => $names) {
            if (in_array($fullName, $names, true)) {
                return $team;
            }
        }

        return null;
    }

    public static function allMembers(): array
    {
        return array_merge(...array_values(self::TEAMS));
    }

    public static function sqlExpr(
        string $firstNameCol = 'first_name',
        string $lastNameCol  = 'last_name'
    ): string {
        $concatExpr = "CONCAT({$firstNameCol}, ' ', {$lastNameCol})";
        $cases = '';

        foreach (self::TEAMS as $team => $names) {
            $in = implode(',', array_map(fn($n) => "'" . addslashes($n) . "'", $names));
            $escaped = addslashes($team);
            $cases .= "\nWHEN {$concatExpr} IN ({$in}) THEN '{$escaped}'";
        }

        return "CASE{$cases}\nELSE 'Unknown' END";
    }
}
