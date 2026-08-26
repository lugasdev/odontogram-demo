<?php

use Livewire\Attributes\Computed;
use Livewire\Component;
use Flux\Flux;

new class extends Component {
    public string $conditionSelected = 'sou';
    public string $dentition = 'permanent';
    public string $tooth = '18';
    public string $erupsi = 'sou';
    public array $extra = [];
    public array $conditions = [];
    public string $note = '';
    public bool $saved = false;
    public array $toothRecords = [];

    public function mount(): void
    {
        $this->toothRecords = $this->defaultRecords();
        $this->loadTooth($this->tooth);
    }

    public function selectTooth(string $tooth): void
    {
        $this->storeCurrentTooth();
        $this->tooth = $tooth;
        $this->loadTooth($tooth);
        $this->saved = false;
    }

    public function resetTooth(): void
    {
        $this->erupsi = 'sou';
        $this->extra = [];
        $this->conditions = $this->emptyConditions();
        $this->note = '';
        $this->saved = false;
    }

    public function updated(string $property): void
    {
        if ($property === 'erupsi' && in_array($this->erupsi, ['une', 'mis', 'rrx'])) {
            $this->conditions = $this->emptyConditions();
            $this->extra = [];
        }

        if (in_array($property, ['erupsi', 'extra', 'conditions', 'note']) || str_starts_with($property, 'conditions.')) {
            $this->storeCurrentTooth();
            $this->saved = true;
        }
    }

    #[Computed]
    public function summary(): string
    {
        $items = [];

        foreach ($this->conditions as $surface => $surfaceConditions) {
            $codes = array_keys(array_filter($surfaceConditions));

            if ($codes !== []) {
                $items[] = strtoupper($surface) . ' ' . implode(', ', $codes);
            }
        }

        return $items === [] ? 'Belum ada kondisi permukaan.' : implode('; ', $items);
    }

    #[Computed]
    public function selectedToothLabel(): string
    {
        return $this->tooth . ' — ' . $this->toothName($this->tooth);
    }

    private function storeCurrentTooth(): void
    {
        $this->toothRecords[$this->tooth] = [
            'erupsi' => $this->erupsi,
            'extra' => $this->extra,
            'conditions' => $this->conditions,
            'note' => $this->note,
        ];
        // dd($this->toothRecords[$this->tooth]);
        Flux::toast('Data gigi ' . $this->selectedToothLabel() . ' berhasil disimpan.');
    }

    private function loadTooth(string $tooth): void
    {
        $record = $this->toothRecords[$tooth] ?? [
            'erupsi' => 'sou',
            'extra' => [],
            'conditions' => $this->emptyConditions(),
            'note' => '',
        ];

        $this->erupsi = $record['erupsi'];
        $this->extra = $record['extra'];
        $this->conditions = $record['conditions'];
        $this->note = $record['note'];
    }

    private function defaultRecords(): array
    {
        $records = [];

        foreach (array_merge($this->permanentTeeth(), $this->deciduousTeeth()) as $tooth) {
            $records[$tooth] = [
                'erupsi' => 'sou',
                'extra' => [],
                'conditions' => $this->emptyConditions(),
                'note' => '',
            ];
        }

        $records['16']['conditions']['o']['amf'] = true;
        $records['26']['conditions']['o']['cof'] = true;
        $records['27']['extra'] = ['rct'];
        $records['36']['conditions']['d']['cof'] = true;
        $records['38']['erupsi'] = 'mis';
        $records['46']['conditions']['m']['car'] = true;
        $records['46']['conditions']['o']['car'] = true;
        $records['46']['conditions']['d']['cof'] = true;
        $records['46']['extra'] = ['rct'];

        return $records;
    }

    private function emptyConditions(): array
    {
        return collect(['m', 'o', 'd', 'v', 'l'])->mapWithKeys(fn(string $surface): array => [
            $surface => [
                'car' => false,
                'amf' => false,
                'cof' => false,
                'fis' => false,
            ]
        ])->all();
    }

    private function permanentTeeth(): array
    {
        return ['18', '17', '16', '15', '14', '13', '12', '11', '21', '22', '23', '24', '25', '26', '27', '28', '48', '47', '46', '45', '44', '43', '42', '41', '31', '32', '33', '34', '35', '36', '37', '38'];
    }

    private function deciduousTeeth(): array
    {
        return ['55', '54', '53', '52', '51', '61', '62', '63', '64', '65', '85', '84', '83', '82', '81', '71', '72', '73', '74', '75'];
    }

    private function toothName(string $tooth): string
    {
        return str_ends_with($tooth, '6') ? 'Molar pertama' : 'Gigi ' . $tooth;
    }

    public function updateSurface(string $tooth, string $surface): void
    {
        if (! in_array($surface, ['m', 'o', 'd', 'v', 'l'])) {
            return;
        }

        if (! array_key_exists($tooth, $this->toothRecords)) {
            return;
        }

        // dd($this->conditionSelected);

        $this->selectTooth($tooth);

        // dd($this->conditions[$surface]);
        // if (! array_key_exists($this->conditionSelected, $this->conditions[$surface])) {
        //     dd('2');
        //     return;
        // }

        // if (in_array($this->conditionSelected, ['sou', 'non', 'une', 'pre'])) { // erupsi
        //     $this->erupsi = $this->conditionSelected;
        // }
        if (in_array($this->conditionSelected, ['car', 'amf', 'cof', 'fis'])) { // erupsi
            $this->conditions[$surface][$this->conditionSelected] = ! $this->conditions[$surface][$this->conditionSelected];
        } else {
            // dd(array_search($this->conditionSelected, $this->extra));
            if (array_search($this->conditionSelected, $this->extra) === false) {
                $this->extra[] = $this->conditionSelected;
            } else {
                unset($this->extra[array_search($this->conditionSelected, $this->extra)]);
            }
        }
        // dd($this->extra);

        $this->storeCurrentTooth();
        $this->saved = true;
        // dd($this->toothRecords[$this->tooth]);m

    }
}; ?>

@php
    $anteriorTeeth = ['13', '12', '11', '21', '22', '23', '53', '52', '51', '61', '62', '63', '83', '82', '81', '71', '72', '73', '43', '42', '41', '31', '32', '33'];
    $quadrants = $dentition === 'permanent'
        ? [
            ['18', '17', '16', '15', '14', '13', '12', '11'],
            ['21', '22', '23', '24', '25', '26', '27', '28'],
            ['48', '47', '46', '45', '44', '43', '42', '41'],
            ['31', '32', '33', '34', '35', '36', '37', '38'],
        ]
        : [
            ['55', '54', '53', '52', '51'],
            ['61', '62', '63', '64', '65'],
            ['85', '84', '83', '82', '81'],
            ['71', '72', '73', '74', '75'],
        ];
    $disabled = in_array($erupsi, ['une', 'mis', 'rrx']);
    $surfaceLabels = ['m' => 'M', 'o' => 'O', 'd' => 'D', 'v' => 'V', 'l' => 'L'];
    $conditionLabels = ['car' => 'Karies', 'amf' => 'Amalgam', 'cof' => 'Composite', 'fis' => 'Sealant'];

    if (in_array($tooth, $anteriorTeeth)) {
        unset($surfaceLabels['o']);
    }
@endphp

<div class="min-h-screen bg-zinc-50 p-4 text-zinc-800 dark:bg-zinc-950 dark:text-zinc-100 sm:p-6">
    <div class="mx-auto grid gap-5 xl:grid-cols-[minmax(0,1.65fr)_minmax(24rem,1fr)]">
        <section class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <div
                class="mb-6 flex items-center justify-between gap-4 border-b border-zinc-200 pb-3 dark:border-zinc-700">
                <div class="flex gap-6">
                    <button wire:click="$set('dentition', 'permanent')"
                        class="border-b-2 pb-3 text-sm font-semibold {{ $dentition === 'permanent' ? 'border-blue-600 text-blue-700 dark:text-blue-400' : 'border-transparent text-zinc-500' }}">Permanen</button>
                    <button wire:click="$set('dentition', 'deciduous')"
                        class="border-b-2 pb-3 text-sm font-semibold {{ $dentition === 'deciduous' ? 'border-blue-600 text-blue-700 dark:text-blue-400' : 'border-transparent text-zinc-500' }}">Sulung</button>
                </div>
                <span class="text-xs text-zinc-500">Klik gigi untuk mengubah kondisi</span>
            </div>

            <div class="space-y-5">
                @foreach ([0, 2] as $row)
                <div class="grid grid-cols-2 divide-x divide-dashed divide-zinc-300 dark:divide-zinc-700">
                    @foreach ([$quadrants[$row], $quadrants[$row + 1]] as $quadrant)
                    <div class="grid grid-flow-col auto-cols-fr gap-1 px-2">
                        @foreach ($quadrant as $number)
                        @php($record = $toothRecords[$number])
                        <x-tooth-chart-two :tooth="$number" :extra="$record['extra']"
                            :conditions="$record['conditions']" class="mx-auto max-h-20 w-full" />
                        @endforeach
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>

            <div class="mt-6 ">
                {{-- <div class="rounded-lg border border-zinc-200 p-3 text-xs dark:border-zinc-700">
                    <p class="mb-2 font-semibold">Legenda Cepat</p>
                    <div class="space-y-1.5 text-zinc-600 dark:text-zinc-300">
                        <p><span class="mr-2 inline-block size-3 rounded-full bg-red-500"></span>Karies (car)</p>
                        <p><span class="mr-2 inline-block size-3 bg-zinc-700"></span>Amalgam (amf)</p>
                        <p><span class="mr-2 inline-block size-3 rounded bg-emerald-500"></span>Composite (cof)</p>
                        <p><span class="mr-2 inline-block size-3 rounded bg-pink-400"></span>Sealant (fis)</p>
                        <p>△ Root canal filling (rct)</p>
                        <p>× Gigi hilang (mis)</p>
                    </div>
                </div> --}}
                <div class="rounded-lg border border-zinc-200 p-4 dark:border-zinc-700">
                    <flux:textarea wire:model.live="note" label="Keterangan Tambahan"
                        placeholder="Tuliskan keterangan tambahan (oklusi, diastema, gigi anomali, dll)..." rows="3" />
                </div>
            </div>
            <div class="mt-6">
                <div class="rounded-lg border border-zinc-200 p-4">
                    @foreach ([0, 2] as $row)
                    <div class="grid grid-cols-2 divide-x divide-dashed divide-zinc-300 dark:divide-zinc-700">
                        @foreach ([$quadrants[$row], $quadrants[$row + 1]] as $quadrant)
                        <div class="grid grid-flow-col auto-cols-fr gap-1 px-2">
                            @foreach ($quadrant as $number)
                            @php($record = $toothRecords[$number])
                            <div
                                class="rounded-lg p-1 text-center transition {{ $tooth === $number ? 'bg-blue-50 ring-2 ring-blue-600 dark:bg-blue-950' : 'hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                <span class="block text-xs font-semibold">{{ $number }}</span>
                                <span class="block text-[10px] text-zinc-500">
                                    {{ $record['erupsi'] }}
                                    @foreach ($record['conditions'] as $conKey => $condition)
                                        @if (count(array_filter($condition)) > 0)
                                            {{ $conKey }}:{{ implode(',', array_keys(array_filter($condition))) }}
                                        @endif
                                    @endforeach
                                    {{ !empty($record['extra']) ? '-' : '' }} {{ implode(', ', $record['extra']) }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <aside
            class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <div class="space-y-5 p-5">
                <flux:radio.group wire:model="conditionSelected" label="Kondisi Gigi" variant="cards" class="grid grid-cols-3 gap-2">
                    <flux:radio value="sou" label="Sou" description="Gigi sehat normal" />
                    <flux:radio value="non" label="Non" description="Gigi tidak ada / tidak diketahui" />
                    <flux:radio value="une" label="Une" description="Un-Erupted" />
                    <flux:radio value="pre" label="Pre" description="Partial Erupted" />
                    <flux:radio value="imv" label="Imv" description="Impacted Visible" />
                    <flux:radio value="ano" label="Ano" description="Anomali" />
                    <flux:radio value="dia" label="Dia" description="Diastema" />
                    <flux:radio value="att" label="Att" description="Atrisi" />
                    <flux:radio value="abr" label="Abr" description="Abrasi" />
                    <flux:radio value="cfr" label="CFR" description="Crown Fracture" />
                    <flux:radio value="nvt" label="NVT" description="Gigi Non Vital" />
                    <flux:radio value="rrx" label="rrx" description="Sisa Akar" />
                    <flux:radio value="mis" label="Mis" description="Gigi Hilang" />
                    <flux:radio value="car" label="Car" description="Karies" />
                </flux:radio.group>
            </div>
            <div class="space-y-5 p-5">
                <flux:radio.group wire:model="conditionSelected" label="Bahan Restorasi" variant="cards" class="grid grid-cols-3 gap-2">
                    <flux:radio value="amf" label="Amf" description="Amalgam" />
                    <flux:radio value="cof" label="Cof" description="Composite" />
                    <flux:radio value="fis" label="Fis" description="Sealant" />
                    <flux:radio value="gif" label="Gif" description="GIC/Silica" />
                    <flux:radio value="inl" label="Inl" description="Inlay" />
                    <flux:radio value="onl" label="Onl" description="Onlay" />
                </flux:radio.group>
            </div>
            <div class="space-y-5 p-5">
                <flux:radio.group wire:model="conditionSelected" label="Restorasi" variant="cards" class="grid grid-cols-3 gap-2">
                    <flux:radio value="fmc" label="Fmc" description="Full Metal Crown" />
                    <flux:radio value="poc" label="Poc" description="Porcelain Crown" />
                    <flux:radio value="mpc" label="Mpc" description="Metal Porcelain Crown" />
                    <flux:radio value="gpc" label="Gpc" description="Gold Porcelain Crown" />
                    <flux:radio value="rct" label="Rct" description="Root Canal Treatment" />
                    <flux:radio value="ipx" label="Ipx" description="Implan" />
                    <flux:radio value="meb" label="Meb" description="Metal Bridge" />
                    <flux:radio value="pob" label="Pob" description="Porcelain Bridge" />
                    <flux:radio value="pon" label="Pon" description="Pontic" />
                    <flux:radio value="abu" label="Abu" description="Gigi Abutment" />
                </flux:radio.group>
            </div>
            <div class="space-y-5 p-5">
                <flux:radio.group wire:model="conditionSelected" label="Protesa" variant="cards" class="grid grid-cols-3 gap-2">
                    <flux:radio value="prd" label="Prd" description="Partial Denture" />
                    <flux:radio value="fld" label="Fld" description="Full Denture" />
                    <flux:radio value="acr" label="Acr" description="Acrylic" />
                </flux:radio.group>
            </div>
        </aside>
    </div>
</div>

<style>
    .tooth-surface {
        cursor: pointer;
    }
    .tooth-surface:hover {
        cursor: pointer;
        fill: #ffa8b81e;
    }
</style>