    <x-theme title="Student">
        <div class="container">
            <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                <h1 class="display-4">Student</h1>
                <p class="lead d-none">Quickly build an effective pricing table for your potential customers with this
                    Bootstrap
                    example. It’s built with default Bootstrap components and utilities with little customization.</p>
            </div>
            <div class="text-center">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>รหัสนักศึกษา</th>
                            <th>ชื่อสกุล</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $students = json_decode(
                        file_get_contents(
                        'https://raw.githubusercontent.com/arc6828/laravel8/main/public/json/students.json',
                        ),
                        );
                        @endphp
                        @foreach ($students as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-theme>