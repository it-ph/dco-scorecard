<table>
    <thead>
    <tr>
        <th style="width: 150px; text-align: center; font-weight: bold">EMPLOYEE NUMBER</th>
        <th style="width: 200px; text-align: center; font-weight: bold">NAME</th>
        @foreach ($months as $month)
            <th style="width: 70px; text-align: center; font-weight: bold">{{ $month->format('M_y') }}</th>
        @endforeach
        {{-- <th style="width: 70px; text-align: center; font-weight: bold">Average</th> --}}
    </tr>
    </thead>
    <tbody>
        @foreach ($agents as $agent)
            <tr>
                <td>
                    {{ $agent->emp_id }}
                </td>
                <td>
                    {{ $agent->name }}
                </td>
                @foreach ($months as $month)
                    <?php $agent_score = getAgentScore($agent->id, $month->format('M Y')); ?>
                    <td>
                        {{ $agent_score }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
