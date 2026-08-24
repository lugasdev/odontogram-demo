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
                        <div class="grid grid-cols-4 gap-10">
                            <div class="flex justify-center">
                                <x-tooth-chart
                                    :tooth="$tooth"
                                    :erupsi="$erupsi"
                                    :extra="$extra"
                                    :conditions="$conditions"
                                />
                            </div>
                            <div class="col-span-3">
                                <flux:table>
                                    <flux:table.columns>
                                        <flux:table.column>&nbsp;</flux:table.column>
                                        <flux:table.column class="text-wrap">Karies (car)</flux:table.column>
                                        <flux:table.column class="text-wrap">Amalgam (amf)</flux:table.column>
                                        <flux:table.column class="text-wrap">Composite (cof)</flux:table.column>
                                        <flux:table.column class="text-wrap">Sealant (fis)</flux:table.column>
                                    </flux:table.columns>

                                    <flux:table.rows>
                                        <flux:table.row>
                                            <flux:table.cell><b>M</b></flux:table.cell>
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
                                            <flux:table.cell><b>O</b></flux:table.cell>
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
                                            <flux:table.cell><b>D</b></flux:table.cell>
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
                                            <flux:table.cell><b>V</b></flux:table.cell>
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
                                            <flux:table.cell><b>L</b></flux:table.cell>
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