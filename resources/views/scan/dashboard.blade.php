

<div class="container">
    <h2>Dashboard</h2>
<div class="container my-4">
    <form method="GET" action="{{ url()->current() }}" class="form-inline mb-4">
        <label for="month" class="mr-2 font-weight-bold">Select Month:</label>
        <select name="month" id="month" class="form-control mr-2">
            @foreach(range(1, 12) as $monthNumber)
                <option value="{{ $monthNumber }}" {{ $selectedMonth == $monthNumber ? 'selected' : '' }}>
                    {{ \DateTime::createFromFormat('!m', $monthNumber)->format('F') }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
</div>
    <div class="row my-4">
        <div class="col-md-6">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Instructional Employees</h5>
                    <p class="card-text display-4">{{ $instructionalCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Non-Instructional Employees</h5>
                    <p class="card-text display-4">{{ $nonInstructionalCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <h4>Top 5 Employees with Highest Undertime ({{ \DateTime::createFromFormat('!m', $selectedMonth)->format('F') }})</h4>
    <canvas id="undertimeChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('undertimeChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($topUndertime, 'name')) !!},
            datasets: [{
                label: 'Undertime (in minutes)',
                data: {!! json_encode(array_column($topUndertime, 'minutes')) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.7)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Minutes'
                    }
                }
            }
        }
    });
</script>