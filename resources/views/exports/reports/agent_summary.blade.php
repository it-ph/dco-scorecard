<table>
    <thead>
    <tr>
        <th style="width: 150px; text-align: center; font-weight: bold">EMPLOYEE NUMBER</th>
        <th style="width: 200px; text-align: center; font-weight: bold">NAME</th>
        @foreach ($months as $month)
            <th style="width: 85px; text-align: center; font-weight: bold">{{ $month->format('M_y') }} (mid)</th>
            <th style="width: 85px; text-align: center; font-weight: bold">{{ $month->format('M_y') }} (end)</th>
            {{-- <th style="width: 85px; text-align: center; font-weight: bold">Average</th> --}}
        @endforeach
    </tr>
    </thead>
    <tbody>
        @foreach ($agents as $agent)
            <tr>
                <td>
                    {{ $agent->emp_id }}
                </td>
                <td>
                    {{ strtoupper($agent->name) }}
                </td>
                @foreach ($months as $month)
                    <?php $mid = getAgentScore($agent->id, $month->format('M Y'),'mid'); ?>
                    <td>
                        {{ $mid }}
                    </td>
                    <?php $end = getAgentScore($agent->id, $month->format('M Y'),'end'); ?>
                    <td>
                        {{ $end }}
                    </td>
                    {{-- <php
                        $mid = $mid <> null ? $mid : 0;
                        $end = $end <> null ? $end : 0;
                        $final_score = ($mid + $end) / 2;

                        $final_score = $final_score <> 0 ? $final_score : '';
                    >
                    <td>
                        {{ $final_score }}
                    </td> --}}
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
