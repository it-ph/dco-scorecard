<table>
    <thead>
    <tr>
        <th style="width: 150px; text-align: center; font-weight: bold">EMPLOYEE NUMBER</th>
        <th style="width: 200px; text-align: center; font-weight: bold">NAME</th>
        @foreach ($months as $month)
            <th style="width: 85px; text-align: center; font-weight: bold">{{ $month->format('M_y') }}</th>
        @endforeach
    </tr>
    </thead>
    {{$tlscores}}
    <tbody>
        @foreach ($tlscores as $tlscore)
            <tr>
                <td>
                    {{ $tlscore->emp_id }}
                </td>
                <td>
                    {{ strtoupper($tlscore->name) }}
                </td>
                @foreach ($months as $month)
                    <?php $mid = getTlScore($tlscore->id, $month->format('M Y')); ?>
                    <td>
                        {{ $mid }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
