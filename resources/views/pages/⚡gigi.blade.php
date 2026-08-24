<?php

use Livewire\Component;

new class extends Component {
    public $tooth = 14;

    public $erupsi = 'sou';
    public $extra = [];
    public $conditions = [
        'm' => [
            'car' => false,
            'amf' => false,
            'cof' => false,
            'fis' => false,
        ],
        'o' => [
            'car' => false,
            'amf' => false,
            'cof' => false,
            'fis' => false,
        ],
        'd' => [
            'car' => false,
            'amf' => false,
            'cof' => false,
            'fis' => false,
        ],
        'v' => [
            'car' => false,
            'amf' => false,
            'cof' => false,
            'fis' => false,
        ],
        'l' => [
            'car' => false,
            'amf' => false,
            'cof' => false,
            'fis' => false,
        ],
    ];

};
?>

<div>
    <div class="grid grid-cols-3 gap-4">
        <div class="col-span-2">01</div>
        <div class="">
            <div class="grid grid-cols-1">
                <div class="flex flex-col gap-5 px-6">
                    <flux:radio.group wire:model.live="erupsi" label="1. Erupsi" variant="cards"
                        class="grid grid-cols-4 gap-2">
                        <flux:radio value="sou" label="Sou" description="Gigi Sehat, Normal" checked />
                        <flux:radio value="pre" label="Pre" description="Partial Erupted" />
                        <flux:radio value="imv" label="Imv" description="Impacted Visible" />
                        <flux:radio value="une" label="Une" description="Unerupted" />
                        <flux:radio value="mis" label="Mis" description="Gigi Hilang" />
                        <flux:radio value="rrx" label="Rrx" description="Sisa Akar" />
                    </flux:radio.group>

                    <div>
                        <flux:label>2. Kondisi Permukaan</flux:label>
                        <div class="grid grid-cols-4 gap-4">
                            <svg width="150" height="240" viewBox="0 0 100 140" fill="none"
                                xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
                                <defs>
                                    <pattern id="arsir" width="5" height="6" patternUnits="userSpaceOnUse">
                                        <line x1="3" y1="0" x2="3" y2="6" stroke="grey" stroke-width="1" />
                                    </pattern>
                                </defs>

                                <rect x="5" y="20" width="90" height="90" stroke="black" />

                                @if (in_array('poc', $extra))
                                    <rect x="5" y="20" width="90" height="90" fill="url(#arsir)" />
                                @endif

                                @if (in_array($tooth, ['13', '12', '11', '21', '22', '23', '53', '52', '51', '61', '62', '63', '83', '82', '81', '71', '72', '73', '43', '42', '41', '31', '32', '33']))
                                    <polygon points="5,20 25,65 25,65 5,110" fill="none" stroke="black" />
                                    <polygon points="95,20 75,65 75,65 95,110" fill="none" stroke="black" />
                                    <polygon points="95,20 75,65 25,65 5,20" fill="none" stroke="black" />
                                    <polygon points="95,110 75,65 25,65 5,110" fill="none" stroke="black" />

                                @else
                                    <rect x="25" y="40" width="50" height="50" stroke="black" />

                                    <polygon points="5,20 25,40 25,90 5,110" fill="none" stroke="black" />
                                    <polygon points="95,20 75,40 75,90 95,110" fill="none" stroke="black" />
                                    <polygon points="95,20 75,40 25,40 5,20" fill="none" stroke="black" />
                                    <polygon points="5,110 95,110 75,90 25,90" fill="none" stroke="black" />

                                    @if ($conditions['m']['car'] == true)
                                        <polygon points="5,20 25,40 25,90 5,110" fill="none" stroke="black" stroke-width="5" />
                                    @endif
                                    @if ($conditions['d']['car'] == true)
                                        <polygon points="95,20 75,40 75,90 95,110" fill="none" stroke="black"
                                            stroke-width="5" />
                                    @endif
                                    @if ($conditions['v']['car'] == true)
                                        <polygon points="95,20 75,40 25,40 5,20" fill="none" stroke="black" stroke-width="5" />
                                    @endif
                                    @if ($conditions['l']['car'] == true)
                                        <polygon points="5,110 95,110 75,90 25,90" fill="none" stroke="black"
                                            stroke-width="5" />
                                    @endif
                                    @if ($conditions['o']['car'] == true)
                                        <rect x="25" y="40" width="50" height="50" fill="white" stroke="black"
                                            stroke-width="5" />
                                    @endif
                                    @if ($conditions['m']['amf'] == true)
                                        <polygon points="5,20 25,40 25,90 5,110" fill="black" stroke="none" />
                                    @endif
                                    @if ($conditions['d']['amf'] == true)
                                        <polygon points="95,20 75,40 75,90 95,110" fill="black" stroke="none" />
                                    @endif
                                    @if ($conditions['v']['amf'] == true)
                                        <polygon points="95,20 75,40 25,40 5,20" fill="black" stroke="none" />
                                    @endif
                                    @if ($conditions['l']['amf'] == true)
                                        <polygon points="5,110 95,110 75,90 25,90" fill="black" stroke="none" />
                                    @endif
                                    @if ($conditions['o']['amf'] == true)
                                        <rect x="25" y="40" width="50" height="50" fill="black" stroke="none" />
                                    @endif
                                    @if ($conditions['m']['cof'] == true)
                                        <polygon points="5,20 25,40 25,90 5,110" fill="url(#arsir)" stroke="black" />
                                    @endif
                                    @if ($conditions['d']['cof'] == true)
                                        <polygon points="95,20 75,40 75,90 95,110" fill="url(#arsir)" stroke="black" />
                                    @endif
                                    @if ($conditions['v']['cof'] == true)
                                        <polygon points="95,20 75,40 25,40 5,20" fill="url(#arsir)" stroke="black" />
                                    @endif
                                    @if ($conditions['l']['cof'] == true)
                                        <polygon points="5,110 95,110 75,90 25,90" fill="url(#arsir)" stroke="black" />
                                    @endif
                                    @if ($conditions['o']['cof'] == true)
                                        <rect x="25" y="40" width="50" height="50" fill="url(#arsir)" stroke="black" />
                                    @endif
                                    @if ($conditions['m']['fis'] == true)
                                        <polygon points="5,20 25,40 25,90 5,110" fill="pink" stroke="black" />
                                    @endif
                                    @if ($conditions['d']['fis'] == true)
                                        <polygon points="95,20 75,40 75,90 95,110" fill="pink" stroke="black" />
                                    @endif
                                    @if ($conditions['v']['fis'] == true)
                                        <polygon points="95,20 75,40 25,40 5,20" fill="pink" stroke="black" />
                                    @endif
                                    @if ($conditions['l']['fis'] == true)
                                        <polygon points="5,110 95,110 75,90 25,90" fill="pink" stroke="black" />
                                    @endif
                                    @if ($conditions['o']['fis'] == true)
                                        <rect x="25" y="40" width="50" height="50" fill="pink" stroke="black" />
                                    @endif
                                @endif

                                @if ($erupsi === 'mis')
                                    <!-- mis -->
                                    <line x1="25" y1="10" x2="75" y2="120" stroke="black" stroke-width="5" />
                                    <line x1="75" y1="10" x2="25" y2="120" stroke="black" stroke-width="5" />
                                @endif
                                @if ($erupsi === 'rrx')
                                    <!-- rrx -->
                                    <line x1="20" y1="15" x2="50" y2="125" stroke="black" stroke-width="5" />
                                    <line x1="80" y1="5" x2="50" y2="125" stroke="black" stroke-width="5" />
                                @endif
                                @if ($erupsi === 'une')
                                    <!-- une -->
                                    <text x="50" y="13" dominant-baseline="middle" text-anchor="middle"
                                        fill="black">UNE</text>
                                @endif
                                @if ($erupsi === 'pre')
                                    <!-- pre -->
                                    <text x="50" y="13" dominant-baseline="middle" text-anchor="middle"
                                        fill="black">PRE</text>
                                @endif

                                @if (in_array('rct', $extra))
                                    <polygon points="30,110 50,135 70,110" stroke="none" fill="black"></polygon>
                                @endif
                                @if (in_array('nvt', $extra))
                                    <polygon points="30,110 50,135 70,110" fill="none" stroke="black"></polygon>
                                @endif
                                @if (in_array('cfr', $extra))
                                    <text x="50" y="74" font-size="100" dominant-baseline="middle" text-anchor="middle"
                                        fill="black" stroke="white"> # </text>
                                @endif
                                @if (in_array('ano', $extra))
                                    <text x="50" y="13" dominant-baseline="middle" text-anchor="middle"
                                        fill="black">ANO</text>
                                @endif
                                @if (in_array('fmc', $extra))
                                    <rect x="5" y="20" width="90" height="90" stroke="black" stroke-width="5" />
                                @endif
                            </svg>
                            <div class="col-span-3">
                                <flux:table>
                                    <flux:table.columns>
                                        <flux:table.column>Permukaan</flux:table.column>
                                        <flux:table.column>Karies (car)</flux:table.column>
                                        <flux:table.column>Amalgam (amf)</flux:table.column>
                                        <flux:table.column>Composite (cof)</flux:table.column>
                                        <flux:table.column>Sealant (fis)</flux:table.column>
                                    </flux:table.columns>

                                    <flux:table.rows>
                                        <flux:table.row>
                                            <flux:table.cell>M</flux:table.cell>
                                            <flux:table.cell>
                                                <flux:checkbox value="1" wire:model.live="conditions.m.car"
                                                    :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                                            </flux:table.cell>
                                            <flux:table.cell>
                                                <flux:checkbox value="1" wire:model.live="conditions.m.amf"
                                                    :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                                            </flux:table.cell>
                                            <flux:table.cell>
                                                <flux:checkbox value="1" wire:model.live="conditions.m.cof"
                                                    :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                                            </flux:table.cell>
                                            <flux:table.cell>
                                                <flux:checkbox value="1" wire:model.live="conditions.m.fis"
                                                    :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                                            </flux:table.cell>
                                        </flux:table.row>
                                        <flux:table.row>
                                            <flux:table.cell>O</flux:table.cell>
                                            <flux:table.cell>
                                                <flux:checkbox value="1" wire:model.live="conditions.o.car"
                                                    :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                                            </flux:table.cell>
                                            <flux:table.cell>
                                                <flux:checkbox value="1" wire:model.live="conditions.o.amf"
                                                    :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                                            </flux:table.cell>
                                            <flux:table.cell>
                                                <flux:checkbox value="1" wire:model.live="conditions.o.cof"
                                                    :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                                            </flux:table.cell>
                                            <flux:table.cell>
                                                <flux:checkbox value="1" wire:model.live="conditions.o.fis"
                                                    :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                                            </flux:table.cell>
                                        </flux:table.row>
                                        <flux:table.row>
                                            <flux:table.cell>D</flux:table.cell>
                                            <flux:table.cell>
                                                <flux:checkbox value="1" wire:model.live="conditions.d.car"
                                                    :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                                            </flux:table.cell>
                                            <flux:table.cell>
                                                <flux:checkbox value="1" wire:model.live="conditions.d.amf"
                                                    :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                                            </flux:table.cell>
                                            <flux:table.cell>
                                                <flux:checkbox value="1" wire:model.live="conditions.d.cof"
                                                    :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                                            </flux:table.cell>
                                            <flux:table.cell>
                                                <flux:checkbox value="1" wire:model.live="conditions.d.fis"
                                                    :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                                            </flux:table.cell>
                                        </flux:table.row>
                                        <flux:table.row>
                                            <flux:table.cell>V</flux:table.cell>
                                            <flux:table.cell>
                                                <flux:checkbox value="1" wire:model.live="conditions.v.car"
                                                    :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                                            </flux:table.cell>
                                            <flux:table.cell>
                                                <flux:checkbox value="1" wire:model.live="conditions.v.amf"
                                                    :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                                            </flux:table.cell>
                                            <flux:table.cell>
                                                <flux:checkbox value="1" wire:model.live="conditions.v.cof"
                                                    :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                                            </flux:table.cell>
                                            <flux:table.cell>
                                                <flux:checkbox value="1" wire:model.live="conditions.v.fis"
                                                    :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                                            </flux:table.cell>
                                        </flux:table.row>
                                        <flux:table.row>
                                            <flux:table.cell>L</flux:table.cell>
                                            <flux:table.cell>
                                                <flux:checkbox value="1" wire:model.live="conditions.l.car"
                                                    :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                                            </flux:table.cell>
                                            <flux:table.cell>
                                                <flux:checkbox value="1" wire:model.live="conditions.l.amf"
                                                    :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                                            </flux:table.cell>
                                            <flux:table.cell>
                                                <flux:checkbox value="1" wire:model.live="conditions.l.cof"
                                                    :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                                            </flux:table.cell>
                                            <flux:table.cell>
                                                <flux:checkbox value="1" wire:model.live="conditions.l.fis"
                                                    :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                                            </flux:table.cell>
                                        </flux:table.row>
                                    </flux:table.rows>
                                </flux:table>
                            </div>
                        </div>


                        <flux:card class="px-3 py-2 my-1">
                            <b>Ringkasan: </b>
                            @foreach ($conditions as $key => $values)
                                {{ ucfirst($key) }}:
                                @foreach ($values as $key => $stat)
                                    {{ $stat ? $key : '' }}
                                @endforeach
                                ;
                            @endforeach
                        </flux:card>
                    </div>

                    <div>
                        <flux:checkbox.group wire:model.live="extra" label="3. Kondisi Tambahan" variant="cards"
                            class="grid grid-cols-4 gap-2">
                            <flux:checkbox value="nvt" label="Non Vital" description="nvt"
                                :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                            <flux:checkbox value="rct" label="Root Canal Filling" description="rct"
                                :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                            <flux:checkbox value="cfr" label="Fracture" description="cfr"
                                :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                            <flux:checkbox value="ano" label="Anomali" description="ano"
                                :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                            <flux:checkbox value="fmc" label="Full metal crown" description="fmc"
                                :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                            <flux:checkbox value="poc" label="Porcelain crown" description="poc"
                                :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                            <flux:checkbox value="imp" label="Implant" description="imp"
                                :disabled="in_array($erupsi, ['une', 'mis', 'rrx'])" />
                        </flux:checkbox.group>

                        {{ json_encode($extra) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>