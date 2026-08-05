<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Customer Analytics</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-light">

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Customer Analytics Dashboard</h2>

        <a href="dashboard.php" class="btn btn-secondary">
            ← Back to Dashboard
        </a>

    </div>

    <div class="row">

        <div class="col-md-6">

            <div class="card shadow mb-4">

                <div class="card-header">
                    Customers by State
                </div>

                <div class="card-body">

                    <canvas id="stateChart"></canvas>

                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card shadow mb-4">

                <div class="card-header">
                    Monthly Registrations
                </div>

                <div class="card-body">

                    <canvas id="monthlyChart"></canvas>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

const stateLabels =
<?= json_encode(array_column($stateData,'state')); ?>;

const stateTotals =
<?= json_encode(array_column($stateData,'total')); ?>;

new Chart(document.getElementById('stateChart'), {

    type: 'bar',

    data: {

        labels: stateLabels,

        datasets: [{

            label: 'Customers',

            data: stateTotals,

            borderWidth: 1

        }]

    },

    options: {

        responsive: true,

        scales: {

            y: {

                beginAtZero: true,

                ticks: {

                    precision: 0

                }

            }

        }

    }

});
const monthLabels =
<?= json_encode(array_column($monthlyData,'month')); ?>;

const monthTotals =
<?= json_encode(array_column($monthlyData,'total')); ?>;

new Chart(document.getElementById('monthlyChart'), {

    type: 'line',

    data: {

        labels: monthLabels,

        datasets: [{

            label: 'New Customers',

            data: monthTotals,

            tension: 0.4,

            fill: false

        }]

    },

    options: {

        responsive: true,

        scales: {

            y: {

                beginAtZero: true,

                ticks: {

                    precision: 0

                }

            }

        }

    }

});

</script>

</body>
</html>