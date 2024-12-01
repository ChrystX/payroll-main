@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')

<div class="row">
    <!-- Left Section with Pie Chart -->
    <div class="col-md-6">
        <div id="myPlot" style="width:100%; max-width:500px;"></div>
    </div>

    <!-- Right Section with Monthly Payment Status -->
    <div class="col-md-6">
        <h2>Monthly Payment Status</h2>
        <p>Transaction Summary</p>
        <ul>
            <li>Successful: 8</li>
            <li>Failed: 3</li>
        </ul>
    </div>
</div>

<!-- Total Payment Sum below both the left and right sections -->
<div class="row mt-4">
    <div class="col-md-6">
        <h3>Total Payment Sum</h3>
        <form>
            <label for="month">Select Month:</label>
            <input type="text" id="month" class="form-control" placeholder="November 2024">
            <p>Total Payment for November 2024: Rp2.700.000,00</p>
        </form>
    </div>
</div>

<!-- Unpaid Workers Section -->
<div class="mt-4">
    <h3>Unpaid Workers</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Worker ID</th>
                <th>Name</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>101</td>
                <td>John Doe</td>
                <td><span class="status-badge status-failed">Failed</span></td>
            </tr>
            <tr>
                <td>102</td>
                <td>Jane Smith</td>
                <td><span class="status-badge status-failed">Failed</span></td>
            </tr>
            <tr>
                <td>103</td>
                <td>Bob Johnson</td>
                <td><span class="status-badge status-failed">Failed</span></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Plotly Pie Chart Script -->
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script>
    const xArray = ["Success","Failed"];
    const yArray = [8,2];

    const layout = {title: "This month payment status"};
    const data = [{labels: xArray, values: yArray, type: "pie"}];

    Plotly.newPlot("myPlot", data, layout);
</script>

@endsection
