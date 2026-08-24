<?php

use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
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
                        <button wire:click="selectTooth('{{ $number }}')" wire:key="tooth-{{ $number }}"
                            class="rounded-lg p-1 text-center transition {{ $tooth === $number ? 'bg-blue-50 ring-2 ring-blue-600 dark:bg-blue-950' : 'hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                            <span class="block text-xs font-semibold">{{ $number }}</span>
                            <x-tooth-chart :tooth="$number" :erupsi="$record['erupsi']" :extra="$record['extra']"
                                :conditions="$record['conditions']" class="mx-auto h-12 w-9" />
                            {{-- <span class="block truncate text-[10px] text-zinc-500">{{ $record['erupsi'] }}</span>
                            --}}
                        </button>
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
                                <div class="rounded-lg p-1 text-center transition {{ $tooth === $number ? 'bg-blue-50 ring-2 ring-blue-600 dark:bg-blue-950' : 'hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
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
            <div class="border-b border-zinc-200 p-5 dark:border-zinc-700">
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-xl font-bold text-blue-700 dark:text-blue-400">Gigi {{ $tooth }}</h1>
                        <p class="text-sm text-zinc-500">{{ $this->selectedToothLabel }}</p>
                    </div>
                    <button wire:click="resetTooth"
                        class="rounded-md border border-zinc-300 px-3 py-1.5 text-xs font-medium dark:border-zinc-600">Reset
                        Gigi</button>
                </div>
            </div>

            <div class="space-y-5 p-5">
                <section>
                    <h2 class="mb-3 text-sm font-bold text-blue-700 dark:text-blue-400">1. Status Erupsi</h2>
                    <flux:radio.group wire:model.live="erupsi" class="grid grid-cols-2 gap-2 sm:grid-cols-3">
                        <flux:radio value="sou" label="Sou" description="Normal" />
                        <flux:radio value="pre" label="Pre" description="Sebagian" />
                        <flux:radio value="une" label="Une" description="Belum erupsi" />
                        <flux:radio value="imv" label="Imv" description="Impaksi" />
                        <flux:radio value="mis" label="Mis" description="Hilang" />
                        <flux:radio value="rrx" label="Rrx" description="Sisa akar" />
                    </flux:radio.group>
                </section>

                <section class="border-t border-zinc-200 pt-5 dark:border-zinc-700">
                    <h2 class="mb-3 text-sm font-bold text-blue-700 dark:text-blue-400">2. Kondisi Permukaan</h2>
                    <div class="grid grid-cols-[7rem_1fr] items-center gap-3">
                        <x-tooth-chart :tooth="$tooth" :erupsi="$erupsi" :extra="$extra" :conditions="$conditions"
                            class="h-36 w-28" />
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-72 border-collapse text-center text-xs">
                                <thead>
                                    <tr class="bg-zinc-50 dark:bg-zinc-800">
                                        <th class="border border-zinc-200 p-2 dark:border-zinc-700">Permukaan</th>
                                        @foreach ($conditionLabels as $surface => $label)
                                            <th class="border border-zinc-200 p-2 dark:border-zinc-700">
                                                {{ $label }}<br>({{ $surface }})</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($surfaceLabels as $surface => $label)
                                        <tr wire:key="surface-{{ $surface }}">
                                            <th class="border border-zinc-200 p-2 dark:border-zinc-700">{{ $label }}</th>
                                            @foreach ($conditionLabels as $condition => $conditionLabel)
                                                <td class="border border-zinc-200 p-1 dark:border-zinc-700 " align="center">
                                                    <flux:checkbox wire:model.live="conditions.{{ $surface }}.{{ $condition }}"
                                                        :disabled="$disabled" />
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-3 rounded-md bg-blue-50 px-3 py-2 text-xs dark:bg-blue-950">
                        <strong>Ringkasan:</strong> {{ $this->summary }}</div>
                </section>

                <section class="border-t border-zinc-200 pt-5 dark:border-zinc-700">
                    <h2 class="mb-3 text-sm font-bold text-blue-700 dark:text-blue-400">3. Kondisi Tambahan</h2>
                    <flux:checkbox.group wire:model.live="extra" class="grid grid-cols-4 gap-2" :disabled="$disabled">
                        <flux:checkbox value="nvt" label="Non Vital" description="nvt" />
                        <flux:checkbox value="rct" label="Rct" description="rct" />
                        <flux:checkbox value="cfr" label="Fraktur" description="cfr" />
                        <flux:checkbox value="ano" label="Anomali" description="ano" />
                        <flux:checkbox value="fmc" label="Fmc" description="fmc" />
                        <flux:checkbox value="poc" label="Poc" description="poc" />
                        <flux:checkbox value="ipx" label="Implant" description="ipx" />
                        <flux:checkbox value="abu" label="Abutment" description="abu" />
                    </flux:checkbox.group>
                </section>

                <section class="border-t border-zinc-200 pt-5 dark:border-zinc-700">
                    <flux:textarea wire:model.live="note" label="Catatan Tambahan (opsional)"
                        placeholder="Tuliskan catatan tambahan untuk gigi {{ $tooth }}..." rows="3" />
                </section>
            </div>

            <div class="flex items-center justify-between border-t border-zinc-200 p-5 dark:border-zinc-700">
                <span class="text-sm font-medium text-emerald-600" wire:loading.remove>Tersimpan otomatis dalam
                    simulasi.</span>
                <span class="text-sm text-zinc-500" wire:loading>Menyimpan perubahan...</span>
                <flux:button wire:click="resetTooth" variant="filled">Reset Gigi</flux:button>
            </div>
        </aside>
    </div>
</div>