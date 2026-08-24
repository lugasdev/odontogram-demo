@props([
    'tooth',
    'erupsi',
    'extra' => [],
    'conditions' => [],
])

@php
    $anteriorTeeth = ['13', '12', '11', '21', '22', '23', '53', '52', '51', '61', '62', '63', '83', '82', '81', '71', '72', '73', '43', '42', '41', '31', '32', '33'];

    $topLeft = ['11', '12', '13', '14', '15', '16', '17', '18', '51', '52', '53', '54', '55'];
    $topRight = ['21', '22', '23', '24', '25', '26', '27', '28', '61', '62', '63', '64', '65'];
    $bottomLeft = ['41', '42', '43', '44', '45', '46', '47', '48', '81', '82', '83', '84', '85'];
    $bottomRight = ['31', '32', '33', '34', '35', '36', '37', '38', '71', '72', '73', '74', '75'];

    $surfaceShapes = [
        'd' => '<polygon points="5,20 25,40 25,90 5,110"',
        'm' => '<polygon points="95,20 75,40 75,90 95,110"',
        'v' => '<polygon points="95,20 75,40 25,40 5,20"',
        'l' => '<polygon points="5,110 95,110 75,90 25,90"',
        'o' => '<rect x="25" y="40" width="50" height="50"',
    ];
    $surfaceAnteriorShapes = [
        'd' => '<polygon points="5,20 25,65 25,65 5,110"',
        'm' => '<polygon points="95,20 75,65 75,65 95,110"',
        'v' => '<polygon points="95,20 75,65 25,65 5,20"',
        'l' => '<polygon points="95,110 75,65 25,65 5,110"',
    ];
    $conditionStyles = [
        'car' => 'fill="white" stroke="black" stroke-width="5"',
        'amf' => 'fill="black" stroke="none"',
        'cof' => 'fill="url(#arsir)" stroke="black"',
        'fis' => 'fill="pink" stroke="black"',
    ];

    $svgStyles = "";
    if (in_array($tooth, $topRight)) {
        $svgStyles = 'transform="translate(100,0) scale(-1,1)"';
    } elseif (in_array($tooth, $bottomLeft)) {
        $svgStyles = 'transform="translate(0,130) scale(1,-1)"';
    } elseif (in_array($tooth, $bottomRight)) {
        $svgStyles = 'transform="translate(100,130) scale(-1,-1)"';
    }
@endphp

<svg width="100" height="140" viewBox="0 0 100 140" fill="none" xmlns="http://www.w3.org/2000/svg" {{ $attributes }} >
    <defs>
        <pattern id="arsir" width="5" height="6" patternUnits="userSpaceOnUse">
            <line x1="3" y1="0" x2="3" y2="6" stroke="grey" stroke-width="1" fill="none" />
        </pattern>
    </defs>

    <rect x="5" y="20" width="90" height="90" stroke="black" />

    @if (in_array('poc', $extra))
        <rect x="5" y="20" width="90" height="90" fill="url(#arsir)" stroke="black" stroke-width="4" />
    @endif

    <g {!! $svgStyles !!}>
        @if (in_array((string) $tooth, $anteriorTeeth))
            @foreach ($surfaceAnteriorShapes as $shape)
                {!! $shape !!} fill="none" stroke="black" />
            @endforeach

            @foreach ($conditionStyles as $condition => $style)
                @foreach ($surfaceAnteriorShapes as $surface => $shape)
                    @if ($conditions[$surface][$condition] ?? false)
                        {!! $shape !!} {!! $style !!} />
                    @endif
                @endforeach
            @endforeach
        @else
            @foreach ($surfaceShapes as $shape)
                {!! $shape !!} fill="none" stroke="black" />
            @endforeach

            @foreach ($conditionStyles as $condition => $style)
                @foreach ($surfaceShapes as $surface => $shape)
                    @if ($conditions[$surface][$condition] ?? false)
                        {!! $shape !!} {!! $style !!} />
                    @endif
                @endforeach
            @endforeach
        @endif
    </g>

    @if ($erupsi === 'mis')
        <line x1="25" y1="10" x2="75" y2="120" stroke="black" stroke-width="5" />
        <line x1="75" y1="10" x2="25" y2="120" stroke="black" stroke-width="5" />
    @endif
    @if ($erupsi === 'rrx')
        <line x1="20" y1="15" x2="50" y2="125" stroke="black" stroke-width="5" />
        <line x1="80" y1="5" x2="50" y2="125" stroke="black" stroke-width="5" />
    @endif
    @if ($erupsi === 'une')
        <text x="50" y="13" dominant-baseline="middle" text-anchor="middle" fill="black">UNE</text>
    @endif
    @if ($erupsi === 'pre')
        <text x="50" y="13" dominant-baseline="middle" text-anchor="middle" fill="black">PRE</text>
    @endif

    @if (in_array('ipx', $extra))
        <text x="50" y="120" dominant-baseline="middle" text-anchor="middle" fill="black">IPX</text>
    @endif
    @if (in_array('rct', $extra))
        <polygon points="30,110 50,135 70,110" stroke="none" fill="black" />
    @endif
    @if (in_array('nvt', $extra))
        <polygon points="30,110 50,135 70,110" fill="none" stroke="black" />
    @endif
    @if (in_array('cfr', $extra))
        <text x="50" y="74" font-size="100" dominant-baseline="middle" text-anchor="middle" fill="black" stroke="white"> # </text>
    @endif
    @if (in_array('ano', $extra))
        <text x="50" y="13" dominant-baseline="middle" text-anchor="middle" fill="black">ANO</text>
    @endif
    @if (in_array('fmc', $extra))
        <rect x="5" y="20" width="90" height="90" stroke="black" stroke-width="5" />
    @endif
</svg>
