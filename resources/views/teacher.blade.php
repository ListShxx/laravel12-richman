    <x-theme title="Teacher">
        <div class="container">
            <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                <h1 class="display-4">Teacher</h1>
                <p class="lead d-none">Quickly build an effective pricing table for your potential customers with this
                    Bootstrap
                    example. It’s built with default Bootstrap components and utilities with little customization.</p>
            </div>
            <div class="text-center">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ชื่อสกุล</th>
                            <th>อีเมล์</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $teachers = json_decode(
                        file_get_contents(
                        'https://raw.githubusercontent.com/arc6828/laravel8/main/public/json/teachers.json',
                        ),
                        );
                        @endphp
                        @foreach ($teachers as $row)
                        <tr>
                            <td><img class="rounded" src="{{ $row->image }}" height="30" /></td>
                            <td>{{ $row->role }} {{ $row->name }}</td>
                            <td>{{ $row->email }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    </x-theme>