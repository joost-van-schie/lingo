@unless(empty($wonGames))
    <table class="table table-bordered mt-5">
        <thead>
            <tr>
                <th colspan="2">Scoreboard</th>
            </tr>
            <tr>
                <th>Naam</th>
                <th>Pogingen</th>
            </tr>
        </thead>
        <tbody>
        @foreach($wonGames as $game)
            <tr>
                <td>
                    {{ $game->name }}
                </td>
                <td>
                    {{ $game->attempts }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endunless
