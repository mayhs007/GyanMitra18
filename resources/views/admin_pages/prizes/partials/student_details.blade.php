<ul class="collection with-header">
    <li class="collection-item">
        <table>
            <tbody>
                <tr>
                    <th>GyanMitra ID</th>
                    <td>{{ $user->GMId() }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $user->full_name }}</td>
                </tr>
            </tbody>
        </table>
    </li>
</ul>